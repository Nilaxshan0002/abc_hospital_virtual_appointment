<?php
// includes/header-doctors.php

// Set default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = 'Our Doctors';
}

// Define BASE_URL if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/abc_hospital_virtual_appointment');
}

// Define SITE_NAME if not defined
if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'ABC Virtual Healthcare');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle . ' | ' . SITE_NAME; ?></title>
    <meta name="description" content="Meet our team of expert doctors at ABC Virtual Healthcare">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/images/doctor.avif">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    
    <style>
        /* ===== COMPLETE STYLES MATCHING INDEX.PHP ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background: #fff;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== NAVBAR STYLES (MATCHING INDEX.PHP) ===== */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo img {
            height: 50px;
            width: 50px;
            object-fit: contain;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .text-highlight {
            color: #4f46e5;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            font-size: 16px;
        }

        .nav-links a:hover {
            color: #4f46e5;
        }

        .nav-links a.active {
            color: #4f46e5;
            font-weight: 600;
        }

        /* ===== BOX STYLE BUTTONS FOR LOGIN & REGISTER ===== */
        .nav-buttons {
            display: flex;
            gap: 15px;
            margin-left: 20px;
        }

        .btn-login-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #ff6b6b;
            background: transparent;
            color: #ff6b6b;
        }

        .btn-login-box:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-register-box {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            background: #ff6b6b;
            border: 2px solid #ff6b6b;
            color: white;
        }

        .btn-register-box:hover {
            background: #ff5252;
            border-color: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-login-box i,
        .btn-register-box i {
            font-size: 14px;
        }

        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 2px 0;
            transition: 0.3s;
        }

        /* ===== PAGE HEADER WITH GRADIENT ===== */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 150px 0 80px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
            opacity: 0.1;
        }

        .page-header h1 {
            font-size: 48px;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .page-header p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* ===== FILTER SECTION ===== */
        .filter-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin: 40px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-filter {
            width: 100%;
            padding: 12px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-filter:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-reset {
            padding: 12px 20px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-reset:hover {
            background: #4b5563;
        }

        .filter-results {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            color: #666;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-results span {
            background: #f8fafc;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .filter-results strong {
            color: #4f46e5;
        }

        /* ===== DOCTORS GRID ===== */
        .doctors-grid {
            padding: 40px 0 80px;
            background: #f8fafc;
        }

        .doctors-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        /* ===== DOCTOR CARD ===== */
        .doctor-profile-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .doctor-profile-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .doctor-image {
            height: 250px;
            position: relative;
            overflow: hidden;
        }

        .doctor-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .doctor-profile-card:hover .doctor-image img {
            transform: scale(1.1);
        }

        .doctor-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            transition: bottom 0.3s;
            z-index: 2;
        }

        .doctor-profile-card:hover .doctor-social {
            bottom: 0;
        }

        .doctor-social a {
            width: 35px;
            height: 35px;
            background: white;
            color: #4f46e5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .doctor-social a:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-3px);
        }

        .doctor-info {
            padding: 25px;
        }

        .doctor-info h3 {
            font-size: 22px;
            margin-bottom: 5px;
            color: #333;
        }

        .doctor-specialty {
            color: #4f46e5;
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doctor-qualifications {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .doctor-stats {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            padding: 15px 0;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
        }

        .stat {
            text-align: center;
            flex: 1;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doctor-languages {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .language-badge {
            background: #f0f0f0;
            color: #4f46e5;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .doctor-actions {
            display: flex;
            gap: 10px;
        }

        .btn-book {
            flex: 2;
            padding: 12px;
            background: #4f46e5;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-book:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-profile {
            flex: 1;
            padding: 12px;
            background: #f0f0f0;
            color: #333;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-profile:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        /* ===== STATS SECTION (WHITE TEXT) ===== */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-position: bottom;
            background-size: cover;
            opacity: 0.1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .stat-item .stat-number {
            font-size: 48px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }

        .stat-item .stat-label {
            font-size: 16px;
            color: rgba(255,255,255,0.9);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== LOADING SPINNER ===== */
        .loading-spinner {
            text-align: center;
            padding: 60px;
            grid-column: 1 / -1;
        }

        .loading-spinner i {
            font-size: 50px;
            color: #4f46e5;
            animation: spin 1s linear infinite;
        }

        .loading-spinner p {
            margin-top: 15px;
            color: #666;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== NO RESULTS ===== */
        .no-results {
            text-align: center;
            padding: 60px;
            grid-column: 1 / -1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .no-results i {
            font-size: 60px;
            color: #4f46e5;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-results h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .no-results p {
            color: #666;
            margin-bottom: 25px;
        }

        .no-results .btn-reset {
            display: inline-flex;
            width: auto;
            padding: 12px 30px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .doctors-container {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 80px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                gap: 15px;
            }
            
            .nav-links.active {
                display: flex;
            }
            
            .nav-toggle {
                display: flex;
            }
            
            .nav-buttons {
                flex-direction: column;
                width: 100%;
                margin-left: 0;
            }
            
            .btn-login-box,
            .btn-register-box {
                width: 100%;
                justify-content: center;
                text-align: center;
            }
            
            .doctors-container {
                grid-template-columns: 1fr;
            }
            
            .filter-form {
                grid-template-columns: 1fr;
            }
            
            .doctor-actions {
                flex-direction: column;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .page-header h1 {
                font-size: 32px;
            }
            
            .filter-results {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-item .stat-number {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <!-- ===== NAVBAR SECTION ===== -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo BASE_URL; ?>/index.php" class="logo">
                    <img src="<?php echo BASE_URL; ?>/images/logo.png" alt="<?php echo SITE_NAME; ?>">
                    <span class="logo-text"><span class="text-highlight">ABC</span> Virtual Healthcare</span>
                </a>
                
                <div class="nav-toggle" id="navToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                
                <ul class="nav-links" id="navLinks">
                    <li><a href="<?php echo BASE_URL; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/about.php">About Us</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/doctors.php" class="active">Doctors</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/services.php">Services</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/contact.php">Contact</a></li>
                    <li class="nav-buttons">
                        <a href="<?php echo BASE_URL; ?>/login.php" class="btn-login-box">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="<?php echo BASE_URL; ?>/register.php" class="btn-register-box">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>