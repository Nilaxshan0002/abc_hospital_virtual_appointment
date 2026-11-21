<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dermatology Department - ABC Hospital | Skin & Hair Care</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/dept/Dermatology.webp">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            background: #f0f5fa;
            color: #2c3e50;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 30px;
        }
        
        /* ===== TOP BAR ===== */
        .top-bar {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 4px solid #f1c40f;
            position: relative;
            z-index: 1001;
        }
        
        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .contact-info span {
            margin-right: 30px;
            display: inline-flex;
            align-items: center;
        }
        
        .contact-info a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .contact-info a:hover {
            color: #f1c40f;
        }
        
        .contact-info i {
            color: #f1c40f;
            margin-right: 8px;
            font-size: 16px;
        }
        
        .social-icons a {
            color: white;
            margin-left: 12px;
            font-size: 16px;
            transition: all 0.3s;
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
        }
        
        .social-icons a:hover {
            background: #f1c40f;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(241, 196, 15, 0.4);
        }
        
        /* ===== NAVIGATION ===== */
        .navbar {
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: sticky;
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
            width: 50px;
            height: 50px;
            margin-right: 12px;
            border-radius: 10px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #0b2a3e;
        }
        
        .logo-text span {
            color: #e67e22;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 25px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s;
            padding: 8px 15px;
            border-radius: 30px;
        }
        
        .nav-links a:hover,
        .nav-links a.active {
            color: #e67e22;
            background: rgba(230, 126, 34, 0.1);
        }
        
        .nav-links .btn-login {
            background: transparent;
            border: 2px solid #e67e22;
            color: #e67e22;
            padding: 8px 20px;
        }
        
        .nav-links .btn-login:hover {
            background: #e67e22;
            color: white;
        }
        
        .nav-links .btn-register {
            background: #e67e22;
            color: white;
            padding: 8px 20px;
            border: 2px solid #e67e22;
        }
        
        .nav-links .btn-register:hover {
            background: #d35400;
            border-color: #d35400;
        }
        
        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
            padding: 80px 0;
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
            background: url('https://www.transparenttextures.com/patterns/circles.png');
            opacity: 0.1;
        }
        
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top right, transparent 49%, #f0f5fa 50%);
        }
        
        .header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }
        
        .header-content h1 {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header-content h1 i {
            color: #f1c40f;
            margin-right: 15px;
            animation: glow 2s ease infinite;
        }
        
        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 2px rgba(255,255,255,0.5)); }
            50% { filter: drop-shadow(0 0 10px rgba(255,255,255,0.8)); }
        }
        
        .header-content p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 30px;
            opacity: 0.95;
        }
        
        .header-stats {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 40px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-item .number {
            font-size: 36px;
            font-weight: 800;
            display: block;
            color: #f1c40f;
        }
        
        .stat-item .label {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }
        
        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            background: white;
            padding: 20px 0;
            border-bottom: 1px solid #eef2f6;
        }
        
        .breadcrumb .container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .breadcrumb a {
            color: #e67e22;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #f39c12;
        }
        
        .breadcrumb .separator {
            color: #95a5a6;
        }
        
        .breadcrumb .current {
            color: #7f8c8d;
            font-weight: 400;
        }
        
        /* ===== DEPARTMENT INTRO ===== */
        .dept-intro {
            padding: 60px 0;
        }
        
        .dept-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .dept-info h2 {
            font-size: 36px;
            font-weight: 700;
            color: #e67e22;
            margin-bottom: 20px;
        }
        
        .dept-info h2 span {
            color: #f39c12;
            position: relative;
        }
        
        .dept-info h2 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #f39c12;
            border-radius: 2px;
        }
        
        .dept-info p {
            color: #5a6a7a;
            margin-bottom: 25px;
            font-size: 16px;
            line-height: 1.8;
        }
        
        .dept-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .feature-item i {
            color: #f39c12;
            font-size: 20px;
        }
        
        .dept-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .dept-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .dept-image:hover img {
            transform: scale(1.05);
        }
        
        .image-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 30px 20px 20px;
            text-align: center;
        }
        
        /* ===== DOCTORS SECTION ===== */
        .doctors-section {
            padding: 60px 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 42px;
            color: #e67e22;
            margin-bottom: 15px;
        }
        
        .section-title h2 span {
            color: #f39c12;
        }
        
        .section-title p {
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .doctor-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.4s;
            position: relative;
            border: 1px solid #eef2f6;
        }
        
        .doctor-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 50px rgba(243, 156, 18, 0.2);
            border-color: #f39c12;
        }
        
        .doctor-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .doctor-card:hover .doctor-img {
            transform: scale(1.05);
        }
        
        .doctor-overlay {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(243, 156, 18, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            backdrop-filter: blur(5px);
        }
        
        .doctor-info {
            padding: 25px;
            text-align: center;
        }
        
        .doctor-info h3 {
            font-size: 22px;
            font-weight: 700;
            color: #e67e22;
            margin-bottom: 5px;
        }
        
        .doctor-specialty {
            color: #f39c12;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 10px;
        }
        
        .doctor-qualification {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .doctor-exp {
            background: #f8f9fa;
            display: inline-block;
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 13px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .doctor-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .btn-book {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
        }
        
        .btn-book i {
            font-size: 14px;
        }
        
        /* ===== SERVICES SECTION ===== */
        .services-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #eef2f6 100%);
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: 40px;
        }
        
        .service-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid transparent;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            border-color: #f39c12;
            box-shadow: 0 20px 40px rgba(243, 156, 18, 0.15);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f39c12, #f1c40f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .service-icon i {
            font-size: 35px;
            color: white;
        }
        
        .service-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #e67e22;
            margin-bottom: 10px;
        }
        
        .service-card p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        /* ===== TREATMENTS SECTION ===== */
        .treatments-section {
            padding: 60px 0;
            background: white;
        }
        
        .treatments-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-top: 40px;
        }
        
        .treatment-card {
            display: flex;
            gap: 20px;
            background: #fef9e7;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border-left: 5px solid #f39c12;
        }
        
        .treatment-card:hover {
            transform: translateX(-5px);
            box-shadow: 0 15px 35px rgba(243, 156, 18, 0.1);
        }
        
        .treatment-icon {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .treatment-icon i {
            font-size: 28px;
            color: white;
        }
        
        .treatment-content h3 {
            font-size: 20px;
            color: #e67e22;
            margin-bottom: 10px;
        }
        
        .treatment-content p {
            color: #5a6a7a;
            line-height: 1.6;
        }
        
        /* ===== CTA SECTION ===== */
        .cta-section {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/circles.png');
            opacity: 0.1;
        }
        
        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }
        
        .cta-content h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 20px;
        }
        
        .cta-content p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.95;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-emergency {
            background: #f1c40f;
            color: #e67e22;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(241, 196, 15, 0.4);
            border: 2px solid #f1c40f;
        }
        
        .btn-emergency:hover {
            background: transparent;
            color: #f1c40f;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(241, 196, 15, 0.5);
        }
        
        .btn-appointment {
            background: white;
            color: #e67e22;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border: 2px solid white;
        }
        
        .btn-appointment:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #0b1a2a;
            color: #a0b8cc;
            padding: 60px 0 0;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col h3 {
            color: white;
            font-size: 20px;
            margin-bottom: 25px;
            position: relative;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #f39c12;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .footer-logo img {
            width: 60px;
            height: 60px;
            border-radius: 12px;
        }
        
        .footer-logo span {
            color: white;
            font-size: 24px;
            font-weight: 700;
        }
        
        .footer-col p {
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .footer-col ul {
            list-style: none;
        }
        
        .footer-col ul li {
            margin-bottom: 12px;
        }
        
        .footer-col ul li a {
            color: #a0b8cc;
            text-decoration: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-col ul li a:hover {
            color: #f39c12;
        }
        
        .footer-col ul li i {
            font-size: 12px;
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 20px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 30px 0 0 30px;
            outline: none;
        }
        
        .newsletter-form button {
            background: #f39c12;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #e67e22;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 25px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .footer-bottom p {
            color: #a0b8cc;
        }
        
        .footer-bottom-links a {
            color: #a0b8cc;
            text-decoration: none;
            margin-left: 25px;
            transition: color 0.3s;
        }
        
        .footer-bottom-links a:hover {
            color: #f39c12;
        }
        
        /* ===== BACK TO TOP ===== */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #f39c12;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 20px rgba(243, 156, 18, 0.4);
            transition: all 0.3s;
            z-index: 999;
        }
        
        #backToTop:hover {
            background: #e67e22;
            transform: translateY(-5px);
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .dept-grid,
            .footer-grid,
            .treatments-grid {
                grid-template-columns: 1fr;
            }
            
            .doctors-grid,
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .doctors-grid,
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .header-content h1 {
                font-size: 36px;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="container">
        <div class="contact-info">
            <span><i class="fas fa-phone-alt"></i> <a href="tel:+94112345679">Emergency: +94 11 234 5679</a></span>
            <span><i class="fas fa-clock"></i> Mon-Sat: 9am - 7pm</span>
            <span><i class="fas fa-map-marker-alt"></i> <a href="https://maps.google.com/?q=Colombo+05+Sri+Lanka" target="_blank">Colombo 05, Sri Lanka</a></span>
        </div>
        <div class="social-icons">
            <a href="https://facebook.com/abchospital" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/abchospital" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com/company/abchospital" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://instagram.com/abchospital" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com/abchospital" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>

<!-- NAVIGATION -->
<nav class="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="<?php echo $base_url; ?>/index.php" class="logo">
                <img src="images/ABC logo.webp" alt="ABC Hospital">
                <span class="logo-text">ABC <span>DERMATOLOGY</span></span>
            </a>
            
            <ul class="nav-links">
                <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                <li><a href="<?php echo $base_url; ?>/departments.php" class="active">Departments</a></li>
                <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                <li><a href="<?php echo $base_url; ?>/pages/login.php" class="btn-login">Login</a></li>
                <li><a href="<?php echo $base_url; ?>/pages/register.php" class="btn-register">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <div class="header-content" data-aos="fade-up">
            <h1><i class="fas fa-hand-sparkles"></i> Dermatology Department</h1>
            <p>Expert Skin, Hair & Nail Care with Advanced Cosmetic & Medical Treatments</p>
            <div class="header-stats">
                <div class="stat-item">
                    <span class="number">12+</span>
                    <span class="label">Skin Specialists</span>
                </div>
                <div class="stat-item">
                    <span class="number">15000+</span>
                    <span class="label">Patients Treated</span>
                </div>
                <div class="stat-item">
                    <span class="number">98%</span>
                    <span class="label">Satisfaction Rate</span>
                </div>
                <div class="stat-item">
                    <span class="number">20+</span>
                    <span class="label">Advanced Treatments</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <div class="container">
        <a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-home"></i> Home</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="<?php echo $base_url; ?>/departments.php">Departments</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Dermatology</span>
    </div>
</div>

<!-- DEPARTMENT INTRO -->
<section class="dept-intro">
    <div class="container">
        <div class="dept-grid">
            <div class="dept-info" data-aos="fade-right">
                <h2>Leading <span>Skin & Hair</span> Care Center</h2>
                <p>The Dermatology Department at ABC Hospital offers comprehensive medical and cosmetic dermatology services. With advanced technology and a team of experienced dermatologists, we provide expert care for all skin, hair, and nail conditions in a comfortable, modern environment.</p>
                <p>Our department features state-of-the-art laser treatments, advanced diagnostic equipment, and a fully equipped cosmetic procedure suite. We combine medical expertise with aesthetic excellence to help you look and feel your best.</p>
                
                <div class="dept-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>JCI Accredited</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Advanced Laser Technology</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Cosmetic Dermatology</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Insurance Accepted</span>
                    </div>
                </div>
            </div>
            
            <div class="dept-image" data-aos="fade-left">
                <img src="images/dept/clinic.avif" alt="Dermatology Department">
                <div class="image-caption">
                    <h3>Modern Dermatology Clinic</h3>
                    <p>Advanced care for healthy, beautiful skin</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DOCTORS SECTION -->
<section class="doctors-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Our <span>Dermatology</span> Specialists</h2>
            <p>Meet our team of experienced skin and hair care experts</p>
        </div>
        
        <div class="doctors-grid">
            <!-- Doctor 1 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="100">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Nirmala Weerasinghe.jpg" alt="Dr. Nirmala Weerasinghe" class="doctor-img">
                    <div class="doctor-overlay">Senior Consultant</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Nirmala Weerasinghe</h3>
                    <p class="doctor-specialty">Senior Dermatologist</p>
                    <p class="doctor-qualification">MBBS, MD (Derm), FRCP</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 25+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=nirmala-weerasinghe" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Doctor 2 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="200">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Sanjaya Rathnayake.jpg" alt="Dr. Sanjaya Rathnayake" class="doctor-img">
                    <div class="doctor-overlay">Cosmetic Dermatologist</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Sanjaya Rathnayake</h3>
                    <p class="doctor-specialty">Cosmetic Dermatologist</p>
                    <p class="doctor-qualification">MBBS, DDV, Fellowship in Cosmetic Derm</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 15+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=sanjaya-rathnayake" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Doctor 3 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="300">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Kumudini Silva.jpg" alt="Dr. Kumudini Silva" class="doctor-img">
                    <div class="doctor-overlay">Pediatric Dermatologist</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Kumudini Silva</h3>
                    <p class="doctor-specialty">Pediatric Dermatologist</p>
                    <p class="doctor-qualification">MBBS, MD, Fellowship Pediatric Derm</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 12+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=kumudini-silva" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section class="services-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Our <span>Dermatology</span> Services</h2>
            <p>Comprehensive skin, hair and nail care services</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-allergies"></i>
                </div>
                <h3>Medical Dermatology</h3>
                <p>Acne, Eczema, Psoriasis, Rashes</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="150">
                <div class="service-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <h3>Cosmetic Dermatology</h3>
                <p>Botox, Fillers, Chemical Peels</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-cut"></i>
                </div>
                <h3>Laser Treatments</h3>
                <p>Hair removal, Scar revision, Tattoo removal</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="250">
                <div class="service-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3>Skin Cancer Screening</h3>
                <p>Early detection and treatment</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Anti-Aging</h3>
                <p>Wrinkle treatment, Skin tightening</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="350">
                <div class="service-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3>Hair Disorders</h3>
                <p>Hair loss, PRP, Hair transplant</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-hand-paper"></i>
                </div>
                <h3>Nail Disorders</h3>
                <p>Fungal infections, Nail surgery</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="450">
                <div class="service-icon">
                    <i class="fas fa-child"></i>
                </div>
                <h3>Pediatric Dermatology</h3>
                <p>Children's skin conditions</p>
            </div>
        </div>
    </div>
</section>

<!-- ADVANCED TREATMENTS SECTION -->
<section class="treatments-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Advanced <span>Cosmetic</span> Treatments</h2>
            <p>State-of-the-art aesthetic procedures for radiant skin</p>
        </div>
        
        <div class="treatments-grid">
            <div class="treatment-card" data-aos="fade-right" data-aos-delay="100">
                <div class="treatment-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="treatment-content">
                    <h3>Laser Skin Resurfacing</h3>
                    <p>Advanced laser technology to reduce wrinkles, scars, and pigmentation for smoother, younger-looking skin.</p>
                </div>
            </div>
            
            <div class="treatment-card" data-aos="fade-left" data-aos-delay="150">
                <div class="treatment-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="treatment-content">
                    <h3>Chemical Peels</h3>
                    <p>Customized peels to improve skin texture, reduce acne, and treat pigmentation with minimal downtime.</p>
                </div>
            </div>
            
            <div class="treatment-card" data-aos="fade-right" data-aos-delay="200">
                <div class="treatment-icon">
                    <i class="fas fa-syringe"></i>
                </div>
                <div class="treatment-content">
                    <h3>Botox & Fillers</h3>
                    <p>Non-surgical wrinkle reduction and volume restoration for a refreshed, natural appearance.</p>
                </div>
            </div>
            
            <div class="treatment-card" data-aos="fade-left" data-aos-delay="250">
                <div class="treatment-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="treatment-content">
                    <h3>PRP Therapy</h3>
                    <p>Platelet-Rich Plasma treatment for hair restoration and skin rejuvenation using your own growth factors.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Ready for Healthy, Radiant Skin?</h2>
            <p>Consult our dermatology experts for personalized skin, hair, and nail care</p>
            <div class="cta-buttons">
                <a href="tel:+94112345679" class="btn-emergency">
                    <i class="fas fa-phone-alt"></i> Call Us: +94 11 234 5679
                </a>
                <a href="<?php echo $base_url; ?>/appointments.php?dept=dermatology" class="btn-appointment">
                    <i class="fas fa-calendar-check"></i> Book Appointment
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="images/ABC logo.webp" alt="ABC Hospital">
                    <span>ABC Dermatology</span>
                </div>
                <p>Expert skin, hair and nail care since 1959. Your beauty and health are our passion.</p>
                <div class="social-icons" style="margin-top: 20px;">
                    <a href="https://facebook.com/abchospital" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/abchospital" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://linkedin.com/company/abchospital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://instagram.com/abchospital" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Other Departments</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/cardiology.php"><i class="fas fa-chevron-right"></i> Cardiology</a></li>
                    <li><a href="<?php echo $base_url; ?>/neurology.php"><i class="fas fa-chevron-right"></i> Neurology</a></li>
                    <li><a href="<?php echo $base_url; ?>/orthopedics.php"><i class="fas fa-chevron-right"></i> Orthopedics</a></li>
                    <li><a href="<?php echo $base_url; ?>/pediatrics.php"><i class="fas fa-chevron-right"></i> Pediatrics</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Subscribe for skin care tips and updates</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Dermatology newsletter!');">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital - Dermatology Department. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="<?php echo $base_url; ?>/terms-of-use.php">Terms of Use</a>
                <a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a>
                <a href="<?php echo $base_url; ?>/cookie-policy.php">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- BACK TO TOP BUTTON -->
<button id="backToTop" title="Back to Top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Back to Top Button
    const backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Working Buttons
    document.querySelectorAll('.btn-book, .btn-appointment').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?php echo $base_url; ?>/appointments.php';
        });
    });

    document.querySelectorAll('.btn-emergency').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'tel:+94112345679';
        });
    });

    // Newsletter form
    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        if(email) {
            alert('Thank you for subscribing to our Dermatology newsletter!');
            this.querySelector('input[type="email"]').value = '';
        } else {
            alert('Please enter your email address');
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>