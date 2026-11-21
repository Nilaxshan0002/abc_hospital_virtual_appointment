<?php
// pages/logout.php
session_start();

// Include database connection if needed for logging
require_once '../config/database.php';

// Function to log logout activity
function logLogoutActivity($userId, $username) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if($db) {
            // Check if login_logs table exists, if not create it
            $checkTableQuery = "SHOW TABLES LIKE 'login_logs'";
            $checkStmt = $db->prepare($checkTableQuery);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() == 0) {
                $createTableQuery = "CREATE TABLE IF NOT EXISTS `login_logs` (
                    `log_id` INT PRIMARY KEY AUTO_INCREMENT,
                    `user_id` INT NULL,
                    `username` VARCHAR(100) NOT NULL,
                    `user_type` VARCHAR(50) NULL,
                    `ip_address` VARCHAR(45) NOT NULL,
                    `user_agent` TEXT,
                    `status` VARCHAR(20) NOT NULL,
                    `login_time` DATETIME NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_username (`username`),
                    INDEX idx_status (`status`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $db->exec($createTableQuery);
            }
            
            // Log logout activity
            $query = "INSERT INTO login_logs (user_id, username, user_type, ip_address, user_agent, status, login_time) 
                      VALUES (:user_id, :username, :user_type, :ip, :agent, 'logout', NOW())";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':username', $username);
            
            // Get user type from session if available
            $userType = $_SESSION['user_type'] ?? 'unknown';
            $stmt->bindParam(':user_type', $userType);
            $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
            $stmt->bindParam(':agent', $_SERVER['HTTP_USER_AGENT'] ?? '');
            $stmt->execute();
        }
    } catch(Exception $e) {
        error_log("Logout logging error: " . $e->getMessage());
    }
}

// Store user info before destroying session for logging
$userId = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? $_SESSION['user_name'] ?? $_SESSION['user_email'] ?? null;
$userType = $_SESSION['user_type'] ?? null;

// Log the logout activity if user was logged in
if($userId && $username) {
    logLogoutActivity($userId, $username);
}

// Clear remember me tokens from database
if(isset($_COOKIE['remember_token'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if($db) {
            // Check if remember_tokens table exists
            $checkTableQuery = "SHOW TABLES LIKE 'remember_tokens'";
            $checkStmt = $db->prepare($checkTableQuery);
            $checkStmt->execute();
            
            if($checkStmt->rowCount() > 0) {
                $token = $_COOKIE['remember_token'];
                $query = "DELETE FROM remember_tokens WHERE token = :token";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
            }
        }
    } catch(Exception $e) {
        error_log("Token deletion error: " . $e->getMessage());
    }
}

// Clear all session variables
$_SESSION = array();

// Delete session cookie
if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Clear remember me cookies
setcookie('remember_token', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

setcookie('remember_username', '', [
    'expires' => time() - 3600,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Clear any other custom cookies
setcookie('PHPSESSID', '', time() - 3600, '/');

// Determine redirect URL
$redirect_url = "../index.php?message=" . urlencode("You have been successfully logged out");

// If there's a specific user type from URL, use it for login page redirect
if(isset($_GET['type']) && in_array($_GET['type'], ['patient', 'doctor', 'admin', 'receptionist'])) {
    $redirect_url = "login.php?type=" . $_GET['type'] . "&message=" . urlencode("You have been successfully logged out");
} elseif($userType) {
    // Use the user's previous type
    $redirect_url = "login.php?type=" . $userType . "&message=" . urlencode("You have been successfully logged out");
}

// Start a new session to prevent session fixation
session_start();
session_regenerate_id(true);

// Redirect to the appropriate page
header("Location: " . $redirect_url);
exit();
?>