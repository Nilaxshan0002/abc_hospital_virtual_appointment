<?php
// pages/update-password.php
session_start();

// Include database connection
require_once __DIR__ . '/../config/database.php';

// Function to redirect with error
function redirectWithError($error, $type = '') {
    $url = "forgot-password.php?error=" . urlencode($error);
    if ($type) {
        $url .= "&type=" . urlencode($type);
    }
    header("Location: " . $url);
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: forgot-password.php");
    exit();
}

// Get form data
$token = isset($_POST['token']) ? $_POST['token'] : '';
$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate input
if (empty($token) || empty($userId)) {
    redirectWithError("Invalid reset link");
}

if (empty($newPassword) || empty($confirmPassword)) {
    redirectWithError("All fields are required");
}

if ($newPassword !== $confirmPassword) {
    redirectWithError("Passwords do not match");
}

// Validate password strength
if (strlen($newPassword) < 8) {
    redirectWithError("Password must be at least 8 characters long");
}

if (!preg_match("/[A-Z]/", $newPassword)) {
    redirectWithError("Password must contain at least one uppercase letter");
}

if (!preg_match("/[a-z]/", $newPassword)) {
    redirectWithError("Password must contain at least one lowercase letter");
}

if (!preg_match("/[0-9]/", $newPassword)) {
    redirectWithError("Password must contain at least one number");
}

if (!preg_match("/[^a-zA-Z0-9]/", $newPassword)) {
    redirectWithError("Password must contain at least one special character");
}

try {
    // Create database connection
    $database = new Database();
    $pdo = $database->getConnection();

    if (!$pdo) {
        throw new Exception("Database connection failed");
    }

    // Verify token is still valid
    $query = "SELECT * FROM password_resets 
              WHERE token = :token 
              AND user_id = :user_id 
              AND expires_at > NOW() 
              AND (used = 0 OR used IS NULL)
              AND used_at IS NULL";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':token' => $token,
        ':user_id' => $userId
    ]);

    if ($stmt->rowCount() == 0) {
        // Check if token exists but is expired or used
        $checkQuery = "SELECT * FROM password_resets 
                      WHERE token = :token AND user_id = :user_id";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([
            ':token' => $token,
            ':user_id' => $userId
        ]);
        
        if ($checkStmt->rowCount() > 0) {
            $tokenData = $checkStmt->fetch();
            if (strtotime($tokenData['expires_at']) < time()) {
                redirectWithError("This reset link has expired. Please request a new one.");
            } elseif ($tokenData['used'] == 1 || $tokenData['used_at'] !== null) {
                redirectWithError("This reset link has already been used. Please request a new one.");
            }
        } else {
            redirectWithError("Invalid reset link. Please request a new one.");
        }
    }

    // Begin transaction
    $pdo->beginTransaction();

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update user's password
    $updateQuery = "UPDATE users SET password = :password WHERE user_id = :user_id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([
        ':password' => $hashedPassword,
        ':user_id' => $userId
    ]);

    // Mark token as used
    $useTokenQuery = "UPDATE password_resets SET used = 1, used_at = NOW() WHERE token = :token";
    $useTokenStmt = $pdo->prepare($useTokenQuery);
    $useTokenStmt->execute([':token' => $token]);

    // Update password reset log if exists
    try {
        $logQuery = "UPDATE password_reset_logs SET status = 'success', reset_at = NOW() 
                    WHERE user_id = :user_id AND status = 'requested' 
                    ORDER BY log_id DESC LIMIT 1";
        $logStmt = $pdo->prepare($logQuery);
        $logStmt->execute([':user_id' => $userId]);
    } catch (Exception $e) {
        // Log table might not exist - ignore
        error_log("Failed to update reset log: " . $e->getMessage());
    }

    // Commit transaction
    $pdo->commit();

    // Log the password reset
    error_log("Password reset successful for user ID: " . $userId . " from IP: " . $_SERVER['REMOTE_ADDR']);

    // Clear any remember me tokens for this user
    try {
        $clearTokensQuery = "DELETE FROM remember_tokens WHERE user_id = :user_id";
        $clearTokensStmt = $pdo->prepare($clearTokensQuery);
        $clearTokensStmt->execute([':user_id' => $userId]);
    } catch (Exception $e) {
        // Table might not exist - ignore
    }

    // Redirect to login with success message
    header("Location: login.php?reset=1");
    exit();

} catch(PDOException $e) {
    // Rollback transaction if started
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Database error in update-password.php: " . $e->getMessage() . " - Line: " . $e->getLine());
    redirectWithError("System error occurred. Please try again later.");
} catch(Exception $e) {
    // Rollback transaction if started
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("General error in update-password.php: " . $e->getMessage() . " - Line: " . $e->getLine());
    redirectWithError("An error occurred. Please try again.");
}
?>