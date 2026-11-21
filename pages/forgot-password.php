<?php
// pages/forgot-password.php
session_start();
$pageTitle = "Forgot Password - ABC Virtual Healthcare System";

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Get user type from URL (optional)
$userType = isset($_GET['type']) && in_array($_GET['type'], ['patient', 'doctor', 'admin', 'receptionist']) 
            ? $_GET['type'] 
            : 'patient';

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
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/forgot password.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
        /* Your existing CSS remains the same */
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
            background: linear-gradient(135deg, rgba(42,92,125,0.9) 0%, rgba(78,205,196,0.9) 100%);
            z-index: 0;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .forgot-wrapper {
            max-width: 500px;
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

        /* Header */
        .forgot-header {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .forgot-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .forgot-header::after {
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

        .forgot-header i {
            font-size: 60px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.2);
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .forgot-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .forgot-header p {
            font-size: 16px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            font-weight: 300;
        }

        /* User Type Selector */
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
            text-decoration: none;
        }

        .user-type-btn i {
            font-size: 24px;
        }

        .user-type-btn span {
            font-size: 12px;
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

        /* Content */
        .forgot-content {
            padding: 40px 35px;
        }

        .info-text {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            border-left: 5px solid #2A5C7D;
            animation: fadeIn 0.5s ease;
        }

        .info-text i {
            font-size: 30px;
            color: #2A5C7D;
        }

        .info-text p {
            color: #1E4560;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
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

        /* Button */
        .btn {
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

        .btn::before {
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

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(42,92,125,0.4);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Links */
        .links {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }

        .links a {
            color: #2A5C7D;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 50px;
            background: rgba(42,92,125,0.1);
        }

        .links a:hover {
            background: #2A5C7D;
            color: white;
            gap: 12px;
        }

        /* Alert Messages */
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
            border-left: 5px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 5px solid #17a2b8;
        }

        /* Loading Spinner */
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

        /* Back to Home */
        .back-home {
            text-align: center;
            margin-top: 25px;
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

        /* Info Note */
        .info-note {
            margin-top: 20px;
            padding: 12px;
            background: #e3f2fd;
            border-radius: 10px;
            font-size: 12px;
            color: #1E4560;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #2A5C7D;
        }

        .info-note i {
            font-size: 16px;
            color: #2A5C7D;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .forgot-wrapper {
                margin: 10px;
            }

            .forgot-header {
                padding: 30px 20px;
            }

            .forgot-header h1 {
                font-size: 26px;
            }

            .forgot-content {
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

            .info-text {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="forgot-wrapper" data-aos="fade-up" data-aos-duration="800">
            <!-- Header -->
            <div class="forgot-header">
                <i class="fas fa-lock"></i>
                <h1>Forgot Password?</h1>
                <p>Don't worry, we'll help you reset it</p>
            </div>

            <!-- User Type Selector -->
            <div class="user-type-selector">
                <a href="?type=patient" class="user-type-btn patient <?php echo $userType == 'patient' ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i>
                    <span>Patient</span>
                </a>
                <a href="?type=doctor" class="user-type-btn doctor <?php echo $userType == 'doctor' ? 'active' : ''; ?>">
                    <i class="fas fa-user-md"></i>
                    <span>Doctor</span>
                </a>
                <a href="?type=admin" class="user-type-btn admin <?php echo $userType == 'admin' ? 'active' : ''; ?>">
                    <i class="fas fa-cogs"></i>
                    <span>Admin</span>
                </a>
                <a href="?type=receptionist" class="user-type-btn receptionist <?php echo $userType == 'receptionist' ? 'active' : ''; ?>">
                    <i class="fas fa-briefcase"></i>
                    <span>Receptionist</span>
                </a>
            </div>

            <!-- Content Area -->
            <div class="forgot-content">
                <!-- Alert Messages -->
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Reset link sent!</strong><br>
                            Please check your email for instructions to reset your password.
                        </div>
                    </div>
                    
                    <script>
                        setTimeout(function() {
                            var alert = document.getElementById('successAlert');
                            if(alert) {
                                alert.style.transition = 'opacity 0.5s ease';
                                alert.style.opacity = '0';
                                setTimeout(function() {
                                    alert.style.display = 'none';
                                }, 500);
                            }
                        }, 5000);
                    </script>
                <?php endif; ?>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Error!</strong><br>
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(isset($_GET['message'])): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Notice</strong><br>
                            <?php echo htmlspecialchars($_GET['message']); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Info Text -->
                <div class="info-text">
                    <i class="fas fa-info-circle"></i>
                    <p>Enter your username and email address. We'll send a password reset link to your registered email.</p>
                </div>

                <!-- Reset Form -->
                <form method="POST" action="send-reset-link.php" id="forgotForm">
                    <input type="hidden" name="user_type" value="<?php echo $userType; ?>">

                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" 
                               name="username" 
                               id="username"
                               placeholder="Enter your username"
                               required 
                               autocomplete="off"
                               value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               name="email" 
                               id="email"
                               placeholder="Enter your registered email address"
                               required 
                               autocomplete="off"
                               value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                    </div>

                    <button type="submit" class="btn" id="submitBtn">
                        <span>Send Reset Link</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <!-- Info Note -->
                <div class="info-note">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Note:</strong> A password reset link will be sent to your registered email address. The link will expire in 1 hour.
                    </div>
                </div>

                <!-- Links -->
                <div class="links">
                    <a href="login.php<?php echo $userType ? '?type=' . $userType : ''; ?>">
                        <i class="fas fa-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Home -->
    <div class="back-home">
        <a href="../index.php">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Home</span>
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../js/main.js"></script>
    
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        document.addEventListener('DOMContentLoaded', function() {
            const forgotForm = document.getElementById('forgotForm');
            const submitBtn = document.getElementById('submitBtn');
            const username = document.getElementById('username');
            const email = document.getElementById('email');

            if(username) {
                username.focus();
            }

            if(forgotForm) {
                forgotForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    removeExistingErrors();
                    
                    let isValid = true;
                    
                    if(!username.value.trim()) {
                        showFieldError(username, 'Username is required');
                        isValid = false;
                    }
                    
                    if(!email.value.trim()) {
                        showFieldError(email, 'Email address is required');
                        isValid = false;
                    } else if(!isValidEmail(email.value.trim())) {
                        showFieldError(email, 'Please enter a valid email address');
                        isValid = false;
                    }
                    
                    if(!isValid) return;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner"></span> Sending...';
                    
                    this.submit();
                });

                username.addEventListener('input', function() {
                    removeFieldError(this);
                });

                email.addEventListener('input', function() {
                    removeFieldError(this);
                });
            }

            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function showFieldError(field, message) {
                field.classList.add('error');
                
                removeFieldError(field);
                
                const error = document.createElement('div');
                error.className = 'error-message';
                error.innerHTML = '<i class="fas fa-exclamation-circle"></i>' + message;
                field.parentElement.appendChild(error);
                
                field.style.animation = 'shake 0.5s ease';
                setTimeout(() => {
                    field.style.animation = '';
                }, 500);
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

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
</body>
</html>