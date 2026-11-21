<?php
// pages/session-expired.php
session_start();
session_destroy(); // Destroy any remaining session
$pageTitle = "Session Expired - ABC Virtual Healthcare System";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
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
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .expired-wrapper {
            max-width: 550px;
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
        .expired-header {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            padding: 50px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .expired-header::before {
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

        .expired-header i {
            font-size: 70px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.2);
            width: 120px;
            height: 120px;
            line-height: 120px;
            border-radius: 50%;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .expired-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .expired-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        /* Content */
        .expired-content {
            padding: 40px 35px;
            text-align: center;
        }

        .clock-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 25px;
            position: relative;
        }

        .clock-icon i {
            font-size: 80px;
            color: #ffc107;
            animation: spin 20s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .expired-message h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .expired-message p {
            color: #6c757d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 20px;
            margin: 30px 0;
            text-align: left;
            border: 1px solid #e9ecef;
        }

        .info-box h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box h3 i {
            color: #2A5C7D;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            width: 25px;
            color: #2A5C7D;
            font-size: 18px;
        }

        .info-item span {
            color: #6c757d;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 30px 0 20px;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(42,92,125,0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #2A5C7D;
            color: #2A5C7D;
            flex: 1;
        }

        .btn-outline:hover {
            background: #2A5C7D;
            color: white;
            transform: translateY(-3px);
        }

        .home-link {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .home-link a {
            color: #2A5C7D;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .home-link a:hover {
            text-decoration: underline;
        }

        .auto-redirect {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 12px;
            margin-top: 25px;
            font-size: 14px;
            color: #2A5C7D;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .auto-redirect i {
            animation: spin 1s linear infinite;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .expired-wrapper {
                margin: 10px;
            }

            .expired-header {
                padding: 40px 20px;
            }

            .expired-header h1 {
                font-size: 26px;
            }

            .expired-content {
                padding: 30px 20px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="expired-wrapper" data-aos="fade-up">
        <div class="expired-header">
            <i class="fas fa-hourglass-end"></i>
            <h1>Session Expired</h1>
            <p>Your session has timed out</p>
        </div>

        <div class="expired-content">
            <div class="clock-icon">
                <i class="fas fa-clock"></i>
            </div>

            <div class="expired-message">
                <h2>For Your Security</h2>
                <p>Your session has expired due to inactivity. This is a security measure to protect your account when you're away.</p>
            </div>

            <div class="info-box">
                <h3><i class="fas fa-shield-alt"></i> Why does this happen?</h3>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <span>Session timeout after 30 minutes of inactivity</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-lock"></i>
                    <span>Automatic logout protects your information</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-sync-alt"></i>
                    <span>Simply log in again to continue</span>
                </div>
            </div>

            <div class="button-group">
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login Again
                </a>
                <a href="../index.php" class="btn btn-outline">
                    <i class="fas fa-home"></i> Go to Home
                </a>
            </div>

            <div class="auto-redirect" id="autoRedirect">
                <i class="fas fa-spinner"></i>
                <span>Auto-redirecting to login in <span id="countdown">10</span> seconds...</span>
            </div>

            <div class="home-link">
                <a href="forgot-password.php">
                    <i class="fas fa-key"></i> Forgot Password?
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Auto redirect countdown
        let seconds = 10;
        const countdownSpan = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            seconds--;
            countdownSpan.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = 'login.php?message=' + encodeURIComponent('Please login to continue');
            }
        }, 1000);

        // Prevent back button to protected pages
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>