<?php
// pages/account-locked.php
session_start();
$pageTitle = "Account Locked - ABC Virtual Healthcare System";

// Clear any partial session
if(isset($_SESSION['user_id'])) {
    session_destroy();
}

// Get lockout time from URL (optional)
$lockoutMinutes = isset($_GET['minutes']) ? (int)$_GET['minutes'] : 15;
$lockoutTime = date('h:i A', strtotime("+$lockoutMinutes minutes"));
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

        .lock-wrapper {
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
        .lock-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            padding: 50px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .lock-header::before {
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

        .lock-header i {
            font-size: 70px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.2);
            width: 120px;
            height: 120px;
            line-height: 120px;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .lock-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .lock-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        /* Content */
        .lock-content {
            padding: 40px 35px;
            text-align: center;
        }

        .lock-icon {
            width: 100px;
            height: 100px;
            background: #f8d7da;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            border: 3px solid #dc3545;
        }

        .lock-icon i {
            font-size: 50px;
            color: #dc3545;
        }

        .lock-message {
            margin-bottom: 30px;
        }

        .lock-message h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .lock-message p {
            color: #6c757d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .timer-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 20px;
            margin: 30px 0;
            border: 1px solid #e9ecef;
        }

        .timer-box h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .timer-display {
            font-size: 48px;
            font-weight: 700;
            color: #dc3545;
            font-family: monospace;
            letter-spacing: 5px;
            margin-bottom: 10px;
        }

        .timer-text {
            color: #6c757d;
            font-size: 14px;
        }

        .unlock-time {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 12px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-left: 5px solid #2A5C7D;
        }

        .unlock-time i {
            font-size: 24px;
            color: #2A5C7D;
        }

        .unlock-time span {
            font-size: 18px;
            font-weight: 600;
            color: #2A5C7D;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
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

        .help-text {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
            font-size: 14px;
            color: #6c757d;
        }

        .help-text a {
            color: #2A5C7D;
            text-decoration: none;
            font-weight: 500;
        }

        .help-text a:hover {
            text-decoration: underline;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #6c757d;
        }

        .security-badge i {
            color: #28a745;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .lock-wrapper {
                margin: 10px;
            }

            .lock-header {
                padding: 40px 20px;
            }

            .lock-header h1 {
                font-size: 26px;
            }

            .lock-content {
                padding: 30px 20px;
            }

            .timer-display {
                font-size: 36px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="lock-wrapper" data-aos="fade-up">
        <div class="lock-header">
            <i class="fas fa-lock"></i>
            <h1>Account Locked</h1>
            <p>Temporary security measure</p>
        </div>

        <div class="lock-content">
            <div class="lock-icon">
                <i class="fas fa-shield-alt"></i>
            </div>

            <div class="lock-message">
                <h2>Too Many Failed Attempts</h2>
                <p>For your security, we've temporarily locked your account after multiple unsuccessful login attempts.</p>
                <p>This is a standard security measure to protect your account from unauthorized access.</p>
            </div>

            <div class="timer-box">
                <h3><i class="fas fa-hourglass-half"></i> Account Unlocks In:</h3>
                <div class="timer-display" id="timer">15:00</div>
                <div class="timer-text">minutes : seconds</div>
            </div>

            <div class="unlock-time">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Expected unlock time:</strong> 
                    <span id="unlockTime"><?php echo $lockoutTime; ?></span>
                </div>
            </div>

            <div class="button-group">
                <a href="forgot-password.php" class="btn btn-primary">
                    <i class="fas fa-key"></i> Reset Password
                </a>
                <a href="login.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>

            <div class="help-text">
                <p>Need immediate assistance? <a href="contact.php">Contact Support</a></p>
            </div>

            <div class="security-badge">
                <i class="fas fa-check-circle"></i>
                <span>Your account security is our priority</span>
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

        // Countdown Timer
        let minutes = <?php echo $lockoutMinutes; ?>;
        let seconds = 0;
        const timerDisplay = document.getElementById('timer');

        function updateTimer() {
            if (seconds === 0) {
                if (minutes === 0) {
                    // Timer complete - redirect to login
                    window.location.href = 'login.php?message=' + encodeURIComponent('Your account is now unlocked. Please try again.');
                    return;
                }
                minutes--;
                seconds = 59;
            } else {
                seconds--;
            }

            // Format display
            const minsStr = minutes.toString().padStart(2, '0');
            const secsStr = seconds.toString().padStart(2, '0');
            timerDisplay.textContent = `${minsStr}:${secsStr}`;

            // Update unlock time display
            const unlockTime = new Date();
            unlockTime.setMinutes(unlockTime.getMinutes() + minutes);
            unlockTime.setSeconds(unlockTime.getSeconds() + seconds);
            document.getElementById('unlockTime').textContent = 
                unlockTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        // Update timer every second
        setInterval(updateTimer, 1000);

        // Prevent back button after logout
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>