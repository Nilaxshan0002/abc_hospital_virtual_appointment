<?php
// pages/reset-password.php
session_start();
$pageTitle = "Reset Password - ABC Virtual Healthcare System";

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../config/database.php';

$token = $_GET['token'] ?? ''; 
$userId = $_GET['user'] ?? '';
$validToken = false;
$userName = '';
$userEmail = '';

// Validate token if provided
if(!empty($token) && !empty($userId)) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if($db) {
            // Check if token exists and is valid
            $query = "SELECT pr.*, u.username, u.email, u.full_name 
                      FROM password_resets pr
                      JOIN users u ON pr.user_id = u.user_id
                      WHERE pr.token = :token 
                      AND pr.user_id = :user_id 
                      AND pr.expires_at > NOW()
                      AND (pr.used = 0 OR pr.used IS NULL)
                      LIMIT 1";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            if($stmt->rowCount() > 0) {
                $validToken = true;
                $resetData = $stmt->fetch(PDO::FETCH_ASSOC);
                $userName = $resetData['full_name'] ?? $resetData['username'];
                $userEmail = $resetData['email'];
            } else {
                // Check if token exists but is expired or used
                $checkQuery = "SELECT * FROM password_resets 
                              WHERE token = :token AND user_id = :user_id";
                $checkStmt = $db->prepare($checkQuery);
                $checkStmt->bindParam(':token', $token, PDO::PARAM_STR);
                $checkStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $checkStmt->execute();
                
                if($checkStmt->rowCount() > 0) {
                    $tokenData = $checkStmt->fetch();
                    if(strtotime($tokenData['expires_at']) < time()) {
                        $error = "This reset link has expired. Please request a new one.";
                    } elseif($tokenData['used'] == 1) {
                        $error = "This reset link has already been used. Please request a new one.";
                    }
                } else {
                    $error = "Invalid reset link. Please request a new one.";
                }
            }
        }
    } catch(Exception $e) {
        error_log("Token validation error: " . $e->getMessage());
        $error = "System error. Please try again later.";
    }
} else {
    $error = "Invalid reset link. Please request a new one.";
}

// Handle password reset form submission
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? '';
    $userId = $_POST['user_id'] ?? '';
    
    $errors = [];
    
    // Validate passwords
    if(empty($newPassword)) {
        $errors[] = "New password is required";
    } elseif(strlen($newPassword) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    } elseif(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $newPassword)) {
        $errors[] = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&)";
    }
    
    if($newPassword !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    
    if(empty($errors)) {
        try {
            $database = new Database();
            $db = $database->getConnection();
            
            if($db) {
                // Verify token again
                $query = "SELECT * FROM password_resets 
                          WHERE token = :token 
                          AND user_id = :user_id 
                          AND expires_at > NOW() 
                          AND (used = 0 OR used IS NULL)
                          LIMIT 1";
                
                $stmt = $db->prepare($query);
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                
                if($stmt->rowCount() > 0) {
                    // Begin transaction
                    $db->beginTransaction();
                    
                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    
                    // Update user password
                    $updateQuery = "UPDATE users SET password = :password WHERE user_id = :id";
                    $updateStmt = $db->prepare($updateQuery);
                    $updateStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                    $updateStmt->bindParam(':id', $userId, PDO::PARAM_INT);
                    $updateStmt->execute();
                    
                    // Mark token as used
                    $useQuery = "UPDATE password_resets SET used = 1, used_at = NOW() WHERE token = :token";
                    $useStmt = $db->prepare($useQuery);
                    $useStmt->bindParam(':token', $token, PDO::PARAM_STR);
                    $useStmt->execute();
                    
                    // Update reset log
                    $logQuery = "UPDATE password_reset_logs SET status = 'success', reset_at = NOW() 
                                WHERE user_id = :user_id ORDER BY log_id DESC LIMIT 1";
                    $logStmt = $db->prepare($logQuery);
                    $logStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                    $logStmt->execute();
                    
                    // Commit transaction
                    $db->commit();
                    
                    // Redirect to login with success
                    header("Location: login.php?reset=1");
                    exit();
                } else {
                    $errors[] = "Invalid or expired reset token";
                }
            }
        } catch(Exception $e) {
            if(isset($db)) {
                $db->rollBack();
            }
            error_log("Password reset error: " . $e->getMessage());
            $errors[] = "An error occurred. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/reset password.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* Your existing CSS remains exactly the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-wrapper {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .reset-header {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .reset-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .reset-header i {
            font-size: 50px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.2);
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            display: inline-block;
        }

        .reset-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .reset-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        /* Content */
        .reset-content {
            padding: 40px 35px;
        }

        /* Invalid Token Message */
        .invalid-token {
            text-align: center;
        }

        .invalid-token i {
            font-size: 70px;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .invalid-token h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .invalid-token p {
            color: #6c757d;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(42,92,125,0.3);
        }

        .btn i {
            margin-right: 8px;
        }

        /* Reset Form */
        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-left: 5px solid #2A5C7D;
        }

        .user-info i {
            font-size: 40px;
            color: #2A5C7D;
        }

        .user-info h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .user-info p {
            color: #6c757d;
            font-size: 13px;
        }

        .user-info .email {
            font-size: 12px;
            color: #2A5C7D;
            word-break: break-all;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            transition: all 0.3s ease;
            z-index: 1;
            font-size: 18px;
        }

        .form-group .toggle-password {
            left: auto;
            right: 15px;
            cursor: pointer;
            z-index: 2;
        }

        .form-group .toggle-password:hover {
            color: #2A5C7D;
        }

        .form-group input {
            width: 100%;
            padding: 16px 50px;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #2A5C7D;
            box-shadow: 0 0 0 5px rgba(42,92,125,0.1);
            outline: none;
        }

        .form-group input:focus + i {
            color: #2A5C7D;
        }

        .form-group input.error {
            border-color: #dc3545;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Password Strength */
        .password-strength {
            margin-bottom: 20px;
        }

        .strength-bars {
            display: flex;
            gap: 5px;
            margin-bottom: 5px;
        }

        .strength-bar {
            flex: 1;
            height: 5px;
            background: #e9ecef;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 12px;
            color: #6c757d;
        }

        /* Password Requirements */
        .password-requirements {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
        }

        .password-requirements h4 {
            color: #333;
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .password-requirements h4 i {
            color: #2A5C7D;
            font-size: 16px;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #6c757d;
            margin: 8px 0;
            transition: all 0.3s ease;
        }

        .requirement i {
            font-size: 12px;
            width: 16px;
        }

        .requirement.valid {
            color: #28a745;
        }

        .requirement.valid i {
            color: #28a745;
        }

        .btn-reset {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-reset::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-reset:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(42,92,125,0.4);
        }

        .btn-reset:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #721c24;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #155724;
        }

        .alert i {
            font-size: 20px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            padding-left: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            font-size: 14px;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Links */
        .links {
            text-align: center;
            margin-top: 25px;
        }

        .links a {
            color: #2A5C7D;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .links a:hover {
            color: #1E4560;
            gap: 12px;
        }

        /* Security Note */
        .security-note {
            margin-top: 20px;
            padding: 12px;
            background: #fff3cd;
            border-radius: 10px;
            font-size: 12px;
            color: #856404;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #ffc107;
        }

        .security-note i {
            font-size: 16px;
            color: #ffc107;
        }

        @media (max-width: 480px) {
            .reset-header {
                padding: 30px 20px;
            }

            .reset-header h1 {
                font-size: 24px;
            }

            .reset-content {
                padding: 30px 20px;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="reset-wrapper" data-aos="fade-up">
        <div class="reset-header">
            <i class="fas fa-key"></i>
            <h1>Reset Password</h1>
            <p>Create a new password for your account</p>
        </div>

        <div class="reset-content">
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><?php echo htmlspecialchars($error); ?></div>
                </div>
            <?php endif; ?>

            <?php if(!empty($errors)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if($validToken): ?>
                <!-- Valid Token - Show Reset Form -->
                <div class="user-info" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <h3>Hello, <?php echo htmlspecialchars($userName); ?>!</h3>
                        <p>Please enter your new password below.</p>
                        <?php if($userEmail): ?>
                            <p class="email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($userEmail); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <form method="POST" action="reset-password.php?token=<?php echo urlencode($token); ?>&user=<?php echo urlencode($userId); ?>" id="resetForm" data-aos="fade-up" data-aos-delay="200">
                    <input type="hidden" name="reset_password" value="1">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">

                    <!-- New Password -->
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="new_password" 
                               id="newPassword"
                               placeholder="Enter new password"
                               required 
                               minlength="8">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('newPassword', this)"></i>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="confirm_password" 
                               id="confirmPassword"
                               placeholder="Confirm new password"
                               required 
                               minlength="8">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmPassword', this)"></i>
                    </div>

                    <!-- Password Strength Meter -->
                    <div class="password-strength">
                        <div class="strength-bars">
                            <div class="strength-bar" id="strength1"></div>
                            <div class="strength-bar" id="strength2"></div>
                            <div class="strength-bar" id="strength3"></div>
                            <div class="strength-bar" id="strength4"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Enter password</div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="password-requirements">
                        <h4><i class="fas fa-shield-alt"></i> Password must contain:</h4>
                        <div class="requirement" id="reqLength">
                            <i class="fas fa-circle"></i> At least 8 characters
                        </div>
                        <div class="requirement" id="reqUppercase">
                            <i class="fas fa-circle"></i> At least one uppercase letter (A-Z)
                        </div>
                        <div class="requirement" id="reqLowercase">
                            <i class="fas fa-circle"></i> At least one lowercase letter (a-z)
                        </div>
                        <div class="requirement" id="reqNumber">
                            <i class="fas fa-circle"></i> At least one number (0-9)
                        </div>
                        <div class="requirement" id="reqSpecial">
                            <i class="fas fa-circle"></i> At least one special character (@$!%*?&)
                        </div>
                    </div>

                    <button type="submit" class="btn-reset" id="resetBtn">
                        <span>Reset Password</span>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </form>

                <!-- Security Note -->
                <div class="security-note" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>Security Tip:</strong> Use a strong, unique password.
                    </div>
                </div>

            <?php else: ?>
                <!-- Invalid or Expired Token -->
                <div class="invalid-token" data-aos="fade-up">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h2>Invalid or Expired Link</h2>
                    <p>The password reset link is invalid or has expired.</p>
                    <a href="forgot-password.php" class="btn">
                        <i class="fas fa-redo-alt"></i> Request New Reset Link
                    </a>
                </div>
            <?php endif; ?>

            <!-- Links -->
            <div class="links">
                <a href="login.php">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        <?php if($validToken): ?>
        window.togglePassword = function(inputId, icon) {
            const input = document.getElementById(inputId);
            if(input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };

        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const resetBtn = document.getElementById('resetBtn');
        
        const strengthBars = {
            1: document.getElementById('strength1'),
            2: document.getElementById('strength2'),
            3: document.getElementById('strength3'),
            4: document.getElementById('strength4')
        };
        const strengthText = document.getElementById('strengthText');
        
        const reqLength = document.getElementById('reqLength');
        const reqUppercase = document.getElementById('reqUppercase');
        const reqLowercase = document.getElementById('reqLowercase');
        const reqNumber = document.getElementById('reqNumber');
        const reqSpecial = document.getElementById('reqSpecial');

        function checkPasswordStrength() {
            const password = newPassword.value;
            
            for(let i = 1; i <= 4; i++) {
                strengthBars[i].style.background = '#e9ecef';
            }
            
            if(!password) {
                strengthText.textContent = 'Enter password';
                strengthText.style.color = '#6c757d';
                return;
            }
            
            let strength = 0;
            
            if(password.length >= 8) strength++;
            if(password.length >= 12) strength++;
            if(/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if(/[0-9]/.test(password)) strength++;
            if(/[^a-zA-Z0-9]/.test(password)) strength++;
            
            strength = Math.min(strength, 4);
            
            for(let i = 1; i <= strength; i++) {
                if(strength <= 2) strengthBars[i].style.background = '#dc3545';
                else if(strength === 3) strengthBars[i].style.background = '#ffc107';
                else strengthBars[i].style.background = '#28a745';
            }
            
            if(strength <= 2) {
                strengthText.textContent = 'Weak password';
                strengthText.style.color = '#dc3545';
            } else if(strength === 3) {
                strengthText.textContent = 'Medium password';
                strengthText.style.color = '#ffc107';
            } else {
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#28a745';
            }
        }

        function checkRequirements() {
            const password = newPassword.value;
            
            if(password.length >= 8) {
                reqLength.innerHTML = '<i class="fas fa-check-circle"></i> At least 8 characters';
                reqLength.classList.add('valid');
            } else {
                reqLength.innerHTML = '<i class="fas fa-circle"></i> At least 8 characters';
                reqLength.classList.remove('valid');
            }
            
            if(/[A-Z]/.test(password)) {
                reqUppercase.innerHTML = '<i class="fas fa-check-circle"></i> At least one uppercase letter (A-Z)';
                reqUppercase.classList.add('valid');
            } else {
                reqUppercase.innerHTML = '<i class="fas fa-circle"></i> At least one uppercase letter (A-Z)';
                reqUppercase.classList.remove('valid');
            }
            
            if(/[a-z]/.test(password)) {
                reqLowercase.innerHTML = '<i class="fas fa-check-circle"></i> At least one lowercase letter (a-z)';
                reqLowercase.classList.add('valid');
            } else {
                reqLowercase.innerHTML = '<i class="fas fa-circle"></i> At least one lowercase letter (a-z)';
                reqLowercase.classList.remove('valid');
            }
            
            if(/[0-9]/.test(password)) {
                reqNumber.innerHTML = '<i class="fas fa-check-circle"></i> At least one number (0-9)';
                reqNumber.classList.add('valid');
            } else {
                reqNumber.innerHTML = '<i class="fas fa-circle"></i> At least one number (0-9)';
                reqNumber.classList.remove('valid');
            }
            
            if(/[@$!%*?&]/.test(password)) {
                reqSpecial.innerHTML = '<i class="fas fa-check-circle"></i> At least one special character (@$!%*?&)';
                reqSpecial.classList.add('valid');
            } else {
                reqSpecial.innerHTML = '<i class="fas fa-circle"></i> At least one special character (@$!%*?&)';
                reqSpecial.classList.remove('valid');
            }
        }

        newPassword.addEventListener('input', function() {
            checkPasswordStrength();
            checkRequirements();
        });

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = newPassword.value;
            const confirm = confirmPassword.value;
            
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
            
            let isValid = true;
            
            if(password.length < 8) {
                showError(newPassword, 'Password must be at least 8 characters');
                isValid = false;
            } else if(!/[A-Z]/.test(password)) {
                showError(newPassword, 'Password must contain at least one uppercase letter');
                isValid = false;
            } else if(!/[a-z]/.test(password)) {
                showError(newPassword, 'Password must contain at least one lowercase letter');
                isValid = false;
            } else if(!/[0-9]/.test(password)) {
                showError(newPassword, 'Password must contain at least one number');
                isValid = false;
            } else if(!/[@$!%*?&]/.test(password)) {
                showError(newPassword, 'Password must contain at least one special character (@$!%*?&)');
                isValid = false;
            }
            
            if(password !== confirm) {
                showError(confirmPassword, 'Passwords do not match');
                isValid = false;
            }
            
            if(!isValid) return;
            
            resetBtn.disabled = true;
            resetBtn.innerHTML = '<span class="spinner"></span> Resetting Password...';
            
            this.submit();
        });

        function showError(field, message) {
            field.classList.add('error');
            
            const error = document.createElement('div');
            error.className = 'error-message';
            error.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
            field.parentElement.appendChild(error);
            
            field.style.animation = 'shake 0.5s ease';
            setTimeout(() => {
                field.style.animation = '';
            }, 500);
        }

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        <?php endif; ?>
    </script>
</body>
</html>