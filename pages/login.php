<?php
session_start();
$pageTitle = "Login - ABC Virtual Healthcare System";

// Set base URL
$base_url = '/abc_hospital_virtual_appointment';

// Redirect if already logged in - CHECK FOR USER TYPE SPECIFIC SESSION VARIABLES
if(isset($_SESSION['user_type'])) {
    $userRole = $_SESSION['user_type'];
    
    switch($userRole) { 
        case 'admin':
            header("Location: admin/dashboard.php");
            exit();
        case 'doctor':
            header("Location: doctor/dashboard.php");
            exit();
        case 'patient':
            header("Location: patient/dashboard.php");
            exit();
        case 'receptionist':
            header("Location: receptionist/dashboard.php");
            exit();
        default:
            // If role is not recognized, just continue to login
            break;
    }
}

// Get user type from URL parameter
$userType = isset($_GET['type']) ? $_GET['type'] : '';
$validTypes = ['patient', 'doctor', 'admin', 'receptionist'];
if(!in_array($userType, $validTypes)) {
    $userType = 'patient'; // Default to patient
}

// Include database connection
require_once __DIR__ . '/../config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/login.jpg">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: url('../images/hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(42,92,125,0.85) 0%, rgba(78,205,196,0.85) 100%);
            z-index: 0;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-wrapper {
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease;
            border: 1px solid rgba(255,255,255,0.2);
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

        .login-header {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 30px;
            background: rgba(255,255,255,0.1);
            filter: blur(10px);
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hospital-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid rgba(255,255,255,0.5);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .hospital-logo:hover {
            transform: scale(1.05);
        }

        .hospital-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .login-header p {
            font-size: 16px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }

        .user-type-selector {
            display: flex;
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            gap: 5px;
        }

        .user-type-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            color: #6c757d;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            position: relative;
            overflow: hidden;
        }

        .user-type-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(42,92,125,0.1);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
            z-index: 0;
        }

        .user-type-btn:hover::before {
            width: 150px;
            height: 150px;
        }

        .user-type-btn i, .user-type-btn span {
            position: relative;
            z-index: 1;
        }

        .user-type-btn i {
            font-size: 24px;
        }

        .user-type-btn.active {
            background: white;
            color: #2A5C7D;
            box-shadow: 0 10px 20px rgba(42,92,125,0.15);
        }

        .user-type-btn.patient.active { color: #4ECDC4; }
        .user-type-btn.doctor.active { color: #2A5C7D; }
        .user-type-btn.admin.active { color: #FF6B6B; }
        .user-type-btn.receptionist.active { color: #FFD700; }

        .login-form {
            padding: 40px 35px;
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
            color: #adb5bd;
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
            background: white;
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

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 8px;
            padding-left: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            position: static;
            transform: none;
            color: #dc3545;
            font-size: 14px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #6c757d;
            font-size: 14px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2A5C7D;
        }

        .forgot-password {
            color: #2A5C7D;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .forgot-password i {
            font-size: 12px;
        }

        .forgot-password:hover {
            color: #1E4560;
            gap: 8px;
        }

        .login-btn {
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

        .login-btn::before {
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

        .login-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(42,92,125,0.4);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }

        .register-link p {
            color: #6c757d;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #2A5C7D;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 25px;
            background: rgba(42,92,125,0.1);
            border-radius: 50px;
        }

        .register-link a:hover {
            background: #2A5C7D;
            color: white;
            gap: 12px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.4s ease;
            font-size: 14px;
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

        .alert i {
            font-size: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #155724;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 5px solid #0c5460;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-left: 5px solid #ffc107;
        }

        .spinner {
            width: 22px;
            height: 22px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .back-home {
            text-align: center;
            margin-top: 25px;
            position: relative;
            z-index: 1;
        }

        .back-home a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 25px;
            background: rgba(255,255,255,0.15);
            border-radius: 50px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .back-home a:hover {
            background: rgba(255,255,255,0.25);
            transform: translateX(-5px);
            gap: 12px;
        }

        .floating-shape {
            position: fixed;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
            background: rgba(78,205,196,0.2);
            animation: float1 15s ease-in-out infinite;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -100px;
            background: rgba(42,92,125,0.2);
            animation: float2 12s ease-in-out infinite;
        }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(50px, 50px) rotate(120deg); }
            66% { transform: translate(-20px, 30px) rotate(240deg); }
        }

        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(-40px, -40px) rotate(90deg); }
            66% { transform: translate(30px, -20px) rotate(180deg); }
        }

        @media (max-width: 480px) {
            .login-wrapper {
                margin: 10px;
            }
            .login-header {
                padding: 30px 20px;
            }
            .login-header h1 {
                font-size: 26px;
            }
            .login-form {
                padding: 30px 20px;
            }
            .user-type-selector {
                padding: 15px;
            }
            .user-type-btn span {
                display: none;
            }
            .user-type-btn i {
                font-size: 26px;
            }
            .form-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }

        @media (max-width: 360px) {
            .user-type-selector {
                flex-wrap: wrap;
            }
            .user-type-btn {
                min-width: 45%;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shape shape1"></div>
    <div class="floating-shape shape2"></div>

    <div class="login-container">
        <div class="login-wrapper" data-aos="fade-up" data-aos-duration="800">
            <div class="login-header">
                <div class="hospital-logo">
                    <img src="../images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/100x100/2A5C7D/ffffff?text=ABC';">
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to continue to ABC Virtual</p>
            </div>

            <div class="user-type-selector">
                <button class="user-type-btn patient <?php echo $userType == 'patient' ? 'active' : ''; ?>" onclick="window.location.href='?type=patient'">
                    <i class="fas fa-user"></i>
                    <span>Patient</span>
                </button>
                <button class="user-type-btn doctor <?php echo $userType == 'doctor' ? 'active' : ''; ?>" onclick="window.location.href='?type=doctor'">
                    <i class="fas fa-user-md"></i>
                    <span>Doctor</span>
                </button>
                <button class="user-type-btn admin <?php echo $userType == 'admin' ? 'active' : ''; ?>" onclick="window.location.href='?type=admin'">
                    <i class="fas fa-cogs"></i>
                    <span>Admin</span>
                </button>
                <button class="user-type-btn receptionist <?php echo $userType == 'receptionist' ? 'active' : ''; ?>" onclick="window.location.href='?type=receptionist'">
                    <i class="fas fa-briefcase"></i>
                    <span>Receptionist</span>
                </button>
            </div>

            <div class="login-form">
                <?php if(isset($_GET['registered'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <div><strong>Registration successful!</strong><br>Please login with your credentials.</div>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): 
                    $errorMessage = $_GET['error'];
                    if($errorMessage == 'unauthorized'): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div><strong>Session Expired!</strong><br>Please login again to continue.</div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <div><strong>Login Failed!</strong><br><?php echo htmlspecialchars($errorMessage); ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if(isset($_GET['message'])): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <div><strong>Notice</strong><br><?php echo htmlspecialchars($_GET['message']); ?></div>
                    </div>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="authenticate.php">
                    <input type="hidden" name="user_type" value="<?php echo $userType; ?>">

                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your email" required autocomplete="username" value="<?php echo isset($_COOKIE['remember_username']) ? htmlspecialchars($_COOKIE['remember_username']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" <?php echo isset($_COOKIE['remember_username']) ? 'checked' : ''; ?>>
                            <span>Remember me</span>
                        </label>
                        <a href="forgot-password.php" class="forgot-password">
                            <span>Forgot Password?</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <button type="submit" class="login-btn" id="loginBtn">
                        <span>Login as <?php echo ucfirst($userType); ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <?php if($userType == 'patient'): ?>
                    <div class="register-link">
                        <p>Don't have an account?</p>
                        <a href="register.php">
                            <i class="fas fa-user-plus"></i>
                            <span>Register as Patient</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="back-home">
        <a href="../index.php">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });

        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            username.focus();

            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                removeExistingErrors();
                
                let isValid = true;
                if(!username.value.trim()) {
                    showFieldError(username, 'Email is required');
                    isValid = false;
                }
                if(!password.value) {
                    showFieldError(password, 'Password is required');
                    isValid = false;
                }
                if(!isValid) return;
                
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<span class="spinner"></span> Logging in...';
                this.submit();
            });

            username.addEventListener('input', function() { removeFieldError(this); });
            password.addEventListener('input', function() { removeFieldError(this); });

            function showFieldError(field, message) {
                field.classList.add('error');
                removeFieldError(field);
                const error = document.createElement('div');
                error.className = 'error-message';
                error.innerHTML = '<i class="fas fa-exclamation-circle"></i>' + message;
                field.parentElement.appendChild(error);
                field.style.animation = 'shake 0.5s ease';
                setTimeout(() => { field.style.animation = ''; }, 500);
            }

            function removeFieldError(field) {
                field.classList.remove('error');
                const existingError = field.parentElement.querySelector('.error-message');
                if(existingError) existingError.remove();
            }

            function removeExistingErrors() {
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
            }

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

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
</body>
</html>