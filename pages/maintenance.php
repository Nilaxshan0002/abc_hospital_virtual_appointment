<?php
// pages/maintenance.php
$pageTitle = "Under Maintenance - ABC Virtual Healthcare System";
$estimatedTime = isset($_GET['time']) ? $_GET['time'] : '30 minutes';
$maintenanceMessage = isset($_GET['message']) ? $_GET['message'] : 'We are performing scheduled maintenance to improve your experience.';
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

        .maintenance-wrapper {
            max-width: 650px;
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
        .maintenance-header {
            background: linear-gradient(135deg, #6c757d, #495057);
            padding: 50px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .maintenance-header::before {
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

        .maintenance-header i {
            font-size: 70px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.2);
            width: 120px;
            height: 120px;
            line-height: 120px;
            border-radius: 50%;
            display: inline-block;
            animation: wrench 2s ease-in-out infinite;
        }

        @keyframes wrench {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-15deg); }
        }

        .maintenance-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .maintenance-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        /* Content */
        .maintenance-content {
            padding: 40px 35px;
            text-align: center;
        }

        .tools-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 20px 0 30px;
        }

        .tools-icon i {
            font-size: 50px;
            color: #6c757d;
            animation: bounce 2s ease-in-out infinite;
        }

        .tools-icon i:nth-child(2) {
            animation-delay: 0.3s;
            color: #2A5C7D;
        }

        .tools-icon i:nth-child(3) {
            animation-delay: 0.6s;
            color: #4ECDC4;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .maintenance-message h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .maintenance-message p {
            color: #6c757d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* Progress Bar */
        .progress-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 20px;
            margin: 30px 0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .progress-fill {
            height: 100%;
            width: 65%;
            background: linear-gradient(90deg, #2A5C7D, #4ECDC4);
            border-radius: 6px;
            animation: progress 2s ease-in-out infinite;
            background-size: 200% 100%;
        }

        @keyframes progress {
            0% { background-position: 0% 0; }
            100% { background-position: 200% 0; }
        }

        .estimated-time {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #2A5C7D;
            font-weight: 500;
        }

        .estimated-time i {
            font-size: 20px;
        }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 30px 0;
        }

        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .info-card i {
            font-size: 30px;
            color: #2A5C7D;
            margin-bottom: 10px;
        }

        .info-card h4 {
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .info-card p {
            color: #6c757d;
            font-size: 13px;
            margin: 0;
        }

        /* Social Connect */
        .social-connect {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }

        .social-connect p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2A5C7D;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .social-icons a:hover {
            background: #2A5C7D;
            color: white;
            transform: translateY(-3px);
        }

        .refresh-btn {
            margin-top: 25px;
        }

        .btn-refresh {
            padding: 12px 30px;
            background: transparent;
            border: 2px solid #2A5C7D;
            color: #2A5C7D;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-refresh:hover {
            background: #2A5C7D;
            color: white;
            transform: rotate(180deg);
        }

        /* Footer */
        .maintenance-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            font-size: 12px;
            color: #6c757d;
        }

        .maintenance-footer a {
            color: #2A5C7D;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .maintenance-wrapper {
                margin: 10px;
            }

            .maintenance-header {
                padding: 40px 20px;
            }

            .maintenance-header h1 {
                font-size: 26px;
            }

            .maintenance-content {
                padding: 30px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .tools-icon i {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-wrapper" data-aos="fade-up">
        <div class="maintenance-header">
            <i class="fas fa-tools"></i>
            <h1>Under Maintenance</h1>
            <p>We'll be back shortly</p>
        </div>

        <div class="maintenance-content">
            <div class="tools-icon">
                <i class="fas fa-wrench"></i>
                <i class="fas fa-cog"></i>
                <i class="fas fa-hammer"></i>
            </div>

            <div class="maintenance-message">
                <h2>Improving Your Experience</h2>
                <p><?php echo htmlspecialchars($maintenanceMessage); ?></p>
            </div>

            <!-- Progress Bar -->
            <div class="progress-section">
                <div class="progress-label">
                    <span>Maintenance Progress</span>
                    <span>65%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="estimated-time">
                    <i class="fas fa-clock"></i>
                    <span>Estimated completion: <strong><?php echo htmlspecialchars($estimatedTime); ?></strong></span>
                </div>
            </div>

            <!-- Information Cards -->
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-rocket"></i>
                    <h4>Faster Performance</h4>
                    <p>Optimizing system speed</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Enhanced Security</h4>
                    <p>Updating security protocols</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h4>Better Mobile Experience</h4>
                    <p>Improving mobile interface</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-database"></i>
                    <h4>Database Optimization</h4>
                    <p>Streamlining data access</p>
                </div>
            </div>

            <!-- Social Media Connect -->
            <div class="social-connect">
                <p>Follow us for updates:</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/abchospital" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.twitter.com/abchospital" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/company/abchospital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/abchospital" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Refresh Button -->
            <div class="refresh-btn">
                <button onclick="location.reload()" class="btn-refresh">
                    <i class="fas fa-sync-alt"></i> Check Status
                </button>
            </div>

            <!-- Footer -->
            <div class="maintenance-footer">
                <p>For urgent assistance: <a href="mailto:support@abchospital.lk">support@abchospital.lk</a> | +94 11 234 5678</p>
                <p style="margin-top: 10px;">&copy; 2026 ABC Virtual Healthcare. All rights reserved.</p>
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

        // Auto refresh every 30 seconds to check if maintenance is complete
        setTimeout(function() {
            location.reload();
        }, 30000); // 30 seconds

        // Animated counter for progress
        let progress = 65;
        const progressBar = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-label span:last-child');
        
        setInterval(() => {
            progress = Math.min(99, progress + Math.floor(Math.random() * 3));
            progressBar.style.width = progress + '%';
            progressText.textContent = progress + '%';
        }, 5000);
    </script>
</body>
</html>