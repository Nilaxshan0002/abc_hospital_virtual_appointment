<?php
// authenticate.php
session_start();

// Include database connection - FIXED PATH
require_once __DIR__ . '/../config/database.php';

// Function to redirect with error
function redirectWithError($type, $error, $message = '') {
    $url = "login.php?type=" . urlencode($type) . "&error=" . urlencode($error);
    if ($message) {
        $url .= "&message=" . urlencode($message);
    }
    header("Location: " . $url);
    exit();
}

// Function to log login attempts
function logLoginAttempt($db, $userId, $username, $status, $userType = '') {
    try {
        // Check if login_logs table exists
        $checkTableQuery = "SHOW TABLES LIKE 'login_logs'";
        $checkStmt = $db->prepare($checkTableQuery);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() == 0) {
            $createTableQuery = "CREATE TABLE IF NOT EXISTS `login_logs` (
                `log_id` INT PRIMARY KEY AUTO_INCREMENT,
                `user_id` INT NULL,
                `username` VARCHAR(100) NOT NULL,
                `user_type` VARCHAR(50) NULL,
                `ip_address` VARCHAR(45) NOT NULL,
                `user_agent` TEXT,
                `status` VARCHAR(20) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_username (`username`),
                INDEX idx_status (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $db->exec($createTableQuery);
        }
        
        $query = "INSERT INTO login_logs (user_id, username, user_type, ip_address, user_agent, status) 
                  VALUES (:user_id, :username, :user_type, :ip, :agent, :status)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':user_id' => $userId,
            ':username' => $username,
            ':user_type' => $userType,
            ':ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            ':agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            ':status' => $status
        ]);
    } catch(Exception $e) {
        error_log("Failed to log login attempt: " . $e->getMessage());
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

// Get and sanitize form data
$userType = isset($_POST['user_type']) ? trim($_POST['user_type']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember = isset($_POST['remember']) ? true : false;

// Validate input
if (empty($username) || empty($password)) {
    redirectWithError($userType, "Username and password are required");
}

// Validate user type
$validTypes = ['patient', 'doctor', 'admin', 'receptionist'];
if (!in_array($userType, $validTypes)) {
    redirectWithError('patient', "Invalid user type");
}

// DEMO USERS - For testing when database doesn't have users
$demoUsers = [
    'patient' => [
        'username' => 'patient@example.com', 
        'password' => 'patient123', 
        'user_id' => 1, 
        'full_name' => 'Miss. Malini',
        'email' => 'patient@example.com',
        'user_role' => 'patient',
        'status' => 'active'
    ],
    'receptionist' => [
        'username' => 'reception@example.com', 
        'password' => 'reception123', 
        'user_id' => 1, 
        'full_name' => 'Receptionist 1',
        'email' => 'reception@example.com',
        'user_role' => 'receptionist',
        'status' => 'active'
    ],
    'doctor' => [
        'username' => 'doctor@example.com', 
        'password' => 'doctor123', 
        'user_id' => 1, 
        'full_name' => 'Dr. Sarah Johnson',
        'email' => 'doctor@example.com',
        'user_role' => 'doctor',
        'status' => 'active'
    ],
    'admin' => [
        'username' => 'admin@example.com', 
        'password' => 'admin123', 
        'user_id' => 1, 
        'full_name' => 'Admin User',
        'email' => 'admin@example.com',
        'user_role' => 'admin',
        'status' => 'active'
    ]
];

$authenticated = false;
$user = null;

try {
    // Create database connection
    $database = new Database();
    $pdo = $database->getConnection();

    if ($pdo) {
        // Try to authenticate from database first
        // Determine which table to query based on user type
        $tableName = '';
        $idField = '';
        $nameField = '';
        $emailField = '';
        
        switch($userType) {
            case 'patient':
                $tableName = 'patients';
                $idField = 'id';
                $nameField = 'patient_name';
                $emailField = 'email';
                break;
            case 'doctor':
                $tableName = 'doctors';
                $idField = 'doctor_id';
                $nameField = 'doctor_name';
                $emailField = 'doctor_email';
                break;
            case 'receptionist':
                $tableName = 'receptionists';
                $idField = 'receptionist_id';
                $nameField = 'receptionist_name';
                $emailField = 'receptionist_email';
                break;
            case 'admin':
                $tableName = 'admins';
                $idField = 'admin_id';
                $nameField = 'admin_name';
                $emailField = 'admin_email';
                break;
        }
        
        if ($tableName) {
            $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
            $checkStmt = $pdo->prepare($checkTableQuery);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                $query = "SELECT * FROM $tableName WHERE $emailField = :username";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Check password if it exists
                    if (isset($dbUser['password'])) {
                        if (password_verify($password, $dbUser['password'])) {
                            $authenticated = true;
                            $user = [
                                'user_id' => $dbUser[$idField],
                                'username' => $username,
                                'full_name' => $dbUser[$nameField],
                                'email' => $dbUser[$emailField],
                                'user_role' => $userType,
                                'status' => 'active'
                            ];
                        }
                    } elseif ($password == 'password123') {
                        // For existing data without hashed passwords
                        $authenticated = true;
                        $user = [
                            'user_id' => $dbUser[$idField],
                            'username' => $username,
                            'full_name' => $dbUser[$nameField],
                            'email' => $dbUser[$emailField],
                            'user_role' => $userType,
                            'status' => 'active'
                        ];
                    }
                }
            }
        }
    }
    
    // If database authentication failed, try demo users
    if (!$authenticated && isset($demoUsers[$userType]) && 
        $demoUsers[$userType]['username'] === $username && 
        $demoUsers[$userType]['password'] === $password) {
        $authenticated = true;
        $user = $demoUsers[$userType];
    }
    
    // Check authentication result
    if (!$authenticated || !$user) {
        logLoginAttempt($pdo ?? null, null, $username, 'failed', $userType);
        error_log("Failed login attempt - Invalid credentials: " . $username . " as " . $userType);
        redirectWithError($userType, "Invalid email or password");
    }
    
    // Check if account is active
    if ($user['status'] !== 'active') {
        logLoginAttempt($pdo ?? null, $user['user_id'], $username, 'failed', $userType);
        redirectWithError($userType, "Your account is not active. Please contact support.");
    }
    
    // Log successful login
    logLoginAttempt($pdo ?? null, $user['user_id'], $username, 'success', $userType);
    
    // Regenerate session ID for security
    session_regenerate_id(true);
    
    // Set session variables (MATCHING WHAT YOUR DASHBOARD EXPECTS)
    $_SESSION['user_type'] = $user['user_role'];
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['login_time'] = time();
    
    // Set type-specific session variables (CRITICAL FOR YOUR DASHBOARD)
    $_SESSION[$userType . '_id'] = $user['user_id'];
    $_SESSION[$userType . '_name'] = $user['full_name'];
    $_SESSION[$userType . '_email'] = $user['email'];
    
    // For patient specifically, also set patient_name
    if ($userType == 'patient') {
        $_SESSION['patient_name'] = $user['full_name'];
    }
    
    // For receptionist specifically
    if ($userType == 'receptionist') {
        $_SESSION['receptionist_name'] = $user['full_name'];
    }
    
    // Set remember me cookie
    if ($remember) {
        setcookie('remember_username', $username, time() + (86400 * 30), "/");
        
        // Generate remember token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + (86400 * 30));
        
        if ($pdo) {
            try {
                // Create remember_tokens table if it doesn't exist
                $createTableQuery = "CREATE TABLE IF NOT EXISTS `remember_tokens` (
                    `token_id` INT PRIMARY KEY AUTO_INCREMENT,
                    `user_id` INT NOT NULL,
                    `user_type` VARCHAR(50) NOT NULL,
                    `token` VARCHAR(64) NOT NULL,
                    `expires_at` DATETIME NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_token (`token`),
                    INDEX idx_expires (`expires_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $pdo->exec($createTableQuery);
                
                // Delete any existing tokens for this user
                $deleteQuery = "DELETE FROM remember_tokens WHERE user_id = :user_id AND user_type = :user_type";
                $deleteStmt = $pdo->prepare($deleteQuery);
                $deleteStmt->execute([
                    ':user_id' => $user['user_id'],
                    ':user_type' => $userType
                ]);
                
                // Insert new token
                $insertQuery = "INSERT INTO remember_tokens (user_id, user_type, token, expires_at) VALUES (:user_id, :user_type, :token, :expires)";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->execute([
                    ':user_id' => $user['user_id'],
                    ':user_type' => $userType,
                    ':token' => $token,
                    ':expires' => $expires
                ]);
                
                setcookie('remember_token', $token, time() + (86400 * 30), "/", "", isset($_SERVER['HTTPS']), true);
            } catch (Exception $e) {
                error_log("Remember token error: " . $e->getMessage());
            }
        }
    } else {
        setcookie('remember_username', '', time() - 3600, "/");
        setcookie('remember_token', '', time() - 3600, "/");
    }
    
    // Redirect based on user role
    switch($user['user_role']) {
        case 'admin':
            header("Location: admin/dashboard.php");
            break;
        case 'doctor':
            header("Location: doctor/dashboard.php");
            break;
        case 'patient':
            header("Location: patient/dashboard.php");
            break;
        case 'receptionist':
            header("Location: receptionist/dashboard.php");
            break;
        default:
            header("Location: ../index.php");
    }
    exit();

} catch(PDOException $e) {
    error_log("Database error in authenticate.php: " . $e->getMessage());
    redirectWithError($userType, "System error occurred. Please try again later.");
} catch(Exception $e) {
    error_log("General error in authenticate.php: " . $e->getMessage());
    redirectWithError($userType, "An unexpected error occurred. Please try again.");
}
?>