<?php
// pages/logout-confirm.php
session_start();
$pageTitle = "Logout - ABC Virtual Healthcare System";

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    
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

        .logout-container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-header {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .logout-header i {
            font-size: 60px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .logout-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .logout-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .logout-content {
            padding: 40px 30px;
            text-align: center;
        }

        .user-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: left;
        }

        .user-info p {
            margin: 10px 0;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info i {
            width: 25px;
            color: #2A5C7D;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-logout {
            background: #dc3545;
            color: white;
            flex: 1;
            justify-content: center;
        }

        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220,53,69,0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            flex: 1;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(108,117,125,0.3);
        }

        .btn-home {
            background: #2A5C7D;
            color: white;
            width: 100%;
            margin-top: 15px;
            justify-content: center;
        }

        .btn-home:hover {
            background: #1E4560;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(42,92,125,0.3);
        }

        @media (max-width: 480px) {
            .logout-content {
                padding: 30px 20px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-header">
            <i class="fas fa-sign-out-alt"></i>
            <h1>Ready to Leave?</h1>
            <p>We hope to see you again soon!</p>
        </div>
        
        <div class="logout-content">
            <div class="user-info">
                <p><i class="fas fa-user"></i> <strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username'] ?? 'N/A'); ?></p>
                <p><i class="fas fa-tag"></i> <strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($_SESSION['user_role'] ?? 'N/A')); ?></p>
                <p><i class="fas fa-clock"></i> <strong>Logged in since:</strong> <?php echo isset($_SESSION['login_time']) ? date('H:i:s', $_SESSION['login_time']) : 'N/A'; ?></p>
            </div>
            
            <p style="color: #6c757d; margin-bottom: 25px;">Are you sure you want to logout?</p>
            
            <div class="button-group">
                <a href="logout.php" class="btn btn-logout">
                    <i class="fas fa-check-circle"></i> Yes, Logout
                </a>
                <button onclick="history.back()" class="btn btn-cancel">
                    <i class="fas fa-times-circle"></i> Cancel
                </button>
            </div>
            
            <a href="../index.php" class="btn btn-home">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>