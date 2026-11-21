<?php
// pages/send-reset-link.php
session_start();
require_once __DIR__ . '/../config/database.php';

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: forgot-password.php?error=" . urlencode("Invalid request method"));
    exit();
}

// Get and sanitize form data
$username = htmlspecialchars(trim($_POST['username'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$userType = htmlspecialchars(trim($_POST['user_type'] ?? ''));

// Validate input
if(empty($username) || empty($email) || empty($userType)) {
    header("Location: forgot-password.php?error=" . urlencode("Username, email and account type are required") . "&type=" . urlencode($userType));
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: forgot-password.php?error=" . urlencode("Please enter a valid email address") . "&type=" . urlencode($userType));
    exit();
}

// Validate user type
$validTypes = ['patient', 'doctor', 'admin', 'receptionist'];
if(!in_array($userType, $validTypes)) {
    header("Location: forgot-password.php?error=" . urlencode("Invalid user type"));
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();

    if(!$db) {
        throw new Exception("Database connection failed");
    }

    // Query to find user - MATCHES YOUR TABLE STRUCTURE
    $query = "SELECT user_id, username, email, full_name, user_role, status 
              FROM users 
              WHERE username = :username 
              AND email = :email
              AND user_role = :role 
              AND status = 'active'
              LIMIT 1";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':role', $userType, PDO::PARAM_STR);
    $stmt->execute();
    
    if($stmt->rowCount() === 0) {
        // For security, don't reveal if user exists
        error_log("Password reset attempted - User not found: " . $username . ", Email: " . $email . ", Role: " . $userType . " from IP: " . $_SERVER['REMOTE_ADDR']);
        header("Location: forgot-password.php?success=1&type=" . urlencode($userType));
        exit();
    }
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $userId = $user['user_id'];
    $userEmail = $user['email'];
    $userName = $user['full_name'] ?? $user['username'];
    $userRole = $user['user_role'];
    
    // Generate reset token
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    // Begin transaction
    $db->beginTransaction();
    
    try {
        // Check if password_resets table exists
        $checkTableQuery = "SHOW TABLES LIKE 'password_resets'";
        $checkTableStmt = $db->prepare($checkTableQuery);
        $checkTableStmt->execute();
        
        if($checkTableStmt->rowCount() == 0) {
            // Create password_resets table
            $createTableQuery = "CREATE TABLE IF NOT EXISTS `password_resets` (
                `reset_id` INT PRIMARY KEY AUTO_INCREMENT,
                `user_id` INT NOT NULL,
                `token` VARCHAR(64) NOT NULL,
                `expires_at` DATETIME NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `used_at` TIMESTAMP NULL,
                `used` TINYINT(1) DEFAULT 0,
                INDEX idx_token (`token`),
                INDEX idx_expires (`expires_at`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            
            $db->exec($createTableQuery);
        }
        
        // Delete any existing unused tokens for this user
        $deleteQuery = "DELETE FROM password_resets WHERE user_id = :user_id AND (used = 0 OR used IS NULL)";
        $deleteStmt = $db->prepare($deleteQuery);
        $deleteStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $deleteStmt->execute();
        
        // Insert new token
        $insertQuery = "INSERT INTO password_resets (user_id, token, expires_at, created_at) 
                        VALUES (:user_id, :token, :expires, NOW())";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $insertStmt->bindParam(':token', $token, PDO::PARAM_STR);
        $insertStmt->bindParam(':expires', $expires, PDO::PARAM_STR);
        $insertStmt->execute();
        
        // Log the reset request in password_reset_logs
        $logQuery = "INSERT INTO password_reset_logs (user_id, ip_address, user_agent, requested_at, status) 
                     VALUES (:user_id, :ip, :agent, NOW(), 'requested')";
        $logStmt = $db->prepare($logQuery);
        $logStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $logStmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
        $logStmt->bindParam(':agent', $_SERVER['HTTP_USER_AGENT'] ?? '', PDO::PARAM_STR);
        $logStmt->execute();
        
        // Commit transaction
        $db->commit();
        
    } catch(Exception $e) {
        $db->rollBack();
        throw $e;
    }
    
    // Send email with reset link
    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/abc_hospital_virtual_appointment/pages/reset-password.php?token=" . $token . "&user=" . $userId;
    
    // Email content
    $to = $userEmail;
    $subject = "Password Reset Request - ABC Virtual Healthcare";
    
    // HTML email template
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: 'Poppins', Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f6f9; padding: 20px; }
            .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #2A5C7D, #4ECDC4); color: white; padding: 40px 30px; text-align: center; }
            .header h1 { font-size: 28px; margin-bottom: 10px; }
            .content { padding: 40px 30px; }
            .button { display: inline-block; padding: 15px 35px; background: linear-gradient(135deg, #2A5C7D, #4ECDC4); color: white; text-decoration: none; border-radius: 50px; margin: 25px 0; }
            .info-box { background: #f8f9fa; padding: 20px; border-radius: 15px; margin: 25px 0; border-left: 5px solid #2A5C7D; }
            .warning { background: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 20px; border-radius: 15px; margin: 25px 0; }
            .footer { background: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #dee2e6; font-size: 13px; color: #6c757d; }
            .highlight { background: #e8f4f8; padding: 15px; border-radius: 10px; word-break: break-all; font-size: 13px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🔐 ABC Virtual Healthcare</h1>
                <p>Password Reset Request</p>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($userName) . ",</h2>
                <p>We received a request to reset your password.</p>
                <div style='text-align: center;'>
                    <a href='" . $resetLink . "' class='button'>Reset Your Password</a>
                </div>
                <p>If the button doesn't work, copy this link:</p>
                <div class='highlight'>" . $resetLink . "</div>
                <div class='info-box'>
                    <p><strong>Account Details:</strong></p>
                    <p>👤 Username: " . htmlspecialchars($user['username']) . "</p>
                    <p>📧 Email: " . htmlspecialchars($userEmail) . "</p>
                    <p>🏷️ Account Type: " . ucfirst($userRole) . "</p>
                </div>
                <div class='warning'>
                    <strong>⚠️ Important:</strong> This link will expire in 1 hour.
                </div>
            </div>
            <div class='footer'>
                <p>This is an automated message, please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Plain text version
    $plainMessage = "Password Reset Request\n\n";
    $plainMessage .= "Hello " . $userName . ",\n\n";
    $plainMessage .= "Click this link to reset your password:\n";
    $plainMessage .= $resetLink . "\n\n";
    $plainMessage .= "This link will expire in 1 hour.\n";
    
    // Email headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: ABC Virtual Healthcare <noreply@abchospital.lk>\r\n";
    $headers .= "Reply-To: support@abchospital.lk\r\n";
    
    // Send email
    $mailSent = mail($to, $subject, $message, $headers);
    
    if(!$mailSent) {
        error_log("Failed to send password reset email to: " . $userEmail);
        error_log("Password reset link: " . $resetLink);
    }
    
    // Redirect with success
    header("Location: forgot-password.php?success=1&type=" . urlencode($userType));
    exit();
    
} catch(PDOException $e) {
    error_log("Database error in send-reset-link.php: " . $e->getMessage());
    header("Location: forgot-password.php?error=" . urlencode("System error. Please try again later.") . "&type=" . urlencode($userType));
    exit();
} catch(Exception $e) {
    error_log("General error in send-reset-link.php: " . $e->getMessage());
    header("Location: forgot-password.php?error=" . urlencode("An error occurred. Please try again.") . "&type=" . urlencode($userType));
    exit();
}
?>