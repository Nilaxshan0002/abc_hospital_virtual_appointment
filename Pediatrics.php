<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pediatrics Department - ABC Hospital | Child Healthcare</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/dept/Pediatrics.jpg">
    
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
            background: linear-gradient(135deg, #c44569 0%, #e66767 100%);
            color: white;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 4px solid #f8a5c2;
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
            color: #f8a5c2;
        }
        
        .contact-info i {
            color: #f8a5c2;
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
            background: #f8a5c2;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(248, 165, 194, 0.4);
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
            color: #e66767;
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
            color: #e66767;
            background: rgba(230, 103, 103, 0.1);
        }
        
        .nav-links .btn-login {
            background: transparent;
            border: 2px solid #e66767;
            color: #e66767;
            padding: 8px 20px;
        }
        
        .nav-links .btn-login:hover {
            background: #e66767;
            color: white;
        }
        
        .nav-links .btn-register {
            background: #e66767;
            color: white;
            padding: 8px 20px;
            border: 2px solid #e66767;
        }
        
        .nav-links .btn-register:hover {
            background: #c44569;
            border-color: #c44569;
        }
        
        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, #e66767 0%, #c44569 100%);
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
            background: url('https://www.transparenttextures.com/patterns/candy.png');
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
            color: #f8a5c2;
            margin-right: 15px;
            animation: bounce 2s ease infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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
            color: #f8a5c2;
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
            color: #c44569;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #e66767;
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
            color: #c44569;
            margin-bottom: 20px;
        }
        
        .dept-info h2 span {
            color: #e66767;
            position: relative;
        }
        
        .dept-info h2 span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #e66767;
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
            color: #e66767;
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
            color: #c44569;
            margin-bottom: 15px;
        }
        
        .section-title h2 span {
            color: #e66767;
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
            box-shadow: 0 30px 50px rgba(230, 103, 103, 0.2);
            border-color: #e66767;
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
            background: rgba(230, 103, 103, 0.9);
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
            color: #c44569;
            margin-bottom: 5px;
        }
        
        .doctor-specialty {
            color: #e66767;
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
            background: linear-gradient(135deg, #e66767, #c44569);
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
            box-shadow: 0 5px 15px rgba(230, 103, 103, 0.3);
        }
        
        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 103, 103, 0.4);
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
            border-color: #e66767;
            box-shadow: 0 20px 40px rgba(230, 103, 103, 0.15);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e66767, #f8a5c2);
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
            color: #c44569;
            margin-bottom: 10px;
        }
        
        .service-card p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        /* ===== CTA SECTION ===== */
        .cta-section {
            background: linear-gradient(135deg, #c44569 0%, #e66767 100%);
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
            background: url('https://www.transparenttextures.com/patterns/candy.png');
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
            background: #f8a5c2;
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(248, 165, 194, 0.4);
            border: 2px solid #f8a5c2;
        }
        
        .btn-emergency:hover {
            background: transparent;
            color: #f8a5c2;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(248, 165, 194, 0.5);
        }
        
        .btn-appointment {
            background: white;
            color: #c44569;
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
            background: #e66767;
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
            color: #e66767;
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
            background: #e66767;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #c44569;
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
            color: #e66767;
        }
        
        /* ===== BACK TO TOP ===== */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #e66767;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 20px rgba(230, 103, 103, 0.4);
            transition: all 0.3s;
            z-index: 999;
        }
        
        #backToTop:hover {
            background: #c44569;
            transform: translateY(-5px);
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .dept-grid,
            .footer-grid {
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
            <span><i class="fas fa-clock"></i> 24/7 Pediatric Emergency</span>
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
                <span class="logo-text">ABC <span>PEDIATRICS</span></span>
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
            <h1><i class="fas fa-child"></i> Pediatrics Department</h1>
            <p>Comprehensive Healthcare for Infants, Children & Adolescents with Love & Care</p>
            <div class="header-stats">
                <div class="stat-item">
                    <span class="number">16+</span>
                    <span class="label">Pediatric Specialists</span>
                </div>
                <div class="stat-item">
                    <span class="number">25000+</span>
                    <span class="label">Happy Children</span>
                </div>
                <div class="stat-item">
                    <span class="number">99%</span>
                    <span class="label">Parent Satisfaction</span>
                </div>
                <div class="stat-item">
                    <span class="number">24/7</span>
                    <span class="label">Child Emergency</span>
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
        <span class="current">Pediatrics</span>
    </div>
</div>

<!-- DEPARTMENT INTRO -->
<section class="dept-intro">
    <div class="container">
        <div class="dept-grid">
            <div class="dept-info" data-aos="fade-right">
                <h2>Leading <span>Child Healthcare</span> Center</h2>
                <p>The Pediatrics Department at ABC Hospital is dedicated to providing comprehensive medical care for infants, children, and adolescents. Our child-friendly environment and team of experienced pediatricians ensure that your little ones receive the best possible care with compassion and expertise.</p>
                <p>Our department features a dedicated pediatric emergency unit, child-friendly inpatient wards, specialized pediatric ICU, and development assessment clinics. We offer a full range of services from newborn care to adolescent medicine in a warm, welcoming environment.</p>
                
                <div class="dept-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>JCI Accredited</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Child-Friendly Environment</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>24/7 Pediatric Emergency</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Insurance Accepted</span>
                    </div>
                </div>
            </div>
            
            <div class="dept-image" data-aos="fade-left">
                <img src="images/dept/Pediatrics Department.jpg" alt="Pediatrics Department">
                <div class="image-caption">
                    <h3>Child-Friendly Care</h3>
                    <p>Warm, welcoming environment for your little ones</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DOCTORS SECTION -->
<section class="doctors-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Our <span>Pediatric</span> Specialists</h2>
            <p>Meet our team of caring and experienced child healthcare experts</p>
        </div>
        
        <div class="doctors-grid">
            <!-- Doctor 1 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="100">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Shanthi Kumarasinghe.jpg" alt="Dr. Shanthi Kumarasinghe" class="doctor-img">
                    <div class="doctor-overlay">Senior Consultant</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Shanthi Kumarasinghe</h3>
                    <p class="doctor-specialty">Senior Pediatrician</p>
                    <p class="doctor-qualification">MBBS, MD (Pediatrics), FRCPCH</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 30+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=shanthi-kumarasinghe" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Doctor 2 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="200">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Nimal Perera.webp" alt="Dr. Nimal Perera" class="doctor-img">
                    <div class="doctor-overlay">Neonatologist</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Nimal Perera</h3>
                    <p class="doctor-specialty">Consultant Neonatologist</p>
                    <p class="doctor-qualification">MBBS, MD, Fellowship Neonatology</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 18+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=nimal-perera" class="btn-book">
                            <i class="fas fa-calendar-check"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Doctor 3 -->
            <div class="doctor-card" data-aos="fade-up" data-aos-delay="300">
                <div class="doctor-img-wrapper">
                    <img src="images/dept/Dr. Priyani Jayawardena.jpg" alt="Dr. Priyani Jayawardena" class="doctor-img">
                    <div class="doctor-overlay">Child Specialist</div>
                </div>
                <div class="doctor-info">
                    <h3>Dr. Priyani Jayawardena</h3>
                    <p class="doctor-specialty">Consultant Pediatrician</p>
                    <p class="doctor-qualification">MBBS, DCH, MD (Pediatrics)</p>
                    <span class="doctor-exp"><i class="fas fa-star"></i> 15+ Years Experience</span>
                    <div class="doctor-actions">
                        <a href="<?php echo $base_url; ?>/appointments.php?doctor=priyani-jayawardena" class="btn-book">
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
            <h2>Our <span>Pediatric</span> Services</h2>
            <p>Complete healthcare services for children of all ages</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-baby"></i>
                </div>
                <h3>Newborn Care</h3>
                <p>Comprehensive care for newborns and premature babies</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="150">
                <div class="service-icon">
                    <i class="fas fa-syringe"></i>
                </div>
                <h3>Vaccinations</h3>
                <p>Complete immunization programs for children</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-lungs"></i>
                </div>
                <h3>Pediatric Respiratory</h3>
                <p>Asthma, allergies, and breathing problems</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="250">
                <div class="service-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Pediatric Cardiology</h3>
                <p>Child heart conditions and treatments</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3>Developmental Pediatrics</h3>
                <p>Growth, development, and behavioral issues</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="350">
                <div class="service-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <h3>Pediatric Dentistry</h3>
                <p>Child dental care and oral health</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Nutrition & Growth</h3>
                <p>Nutritional counseling and growth monitoring</p>
            </div>
            
            <div class="service-card" data-aos="zoom-in" data-aos-delay="450">
                <div class="service-icon">
                    <i class="fas fa-baby-carriage"></i>
                </div>
                <h3>Adolescent Health</h3>
                <p>Healthcare for teenagers and young adults</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Your Child Needs Emergency Care?</h2>
            <p>Our pediatric emergency team is available 24/7 with child-friendly emergency services</p>
            <div class="cta-buttons">
                <a href="tel:+94112345679" class="btn-emergency">
                    <i class="fas fa-ambulance"></i> Emergency: +94 11 234 5679
                </a>
                <a href="<?php echo $base_url; ?>/appointments.php?dept=pediatrics" class="btn-appointment">
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
                    <span>ABC Pediatrics</span>
                </div>
                <p>Caring for your little ones since 1959. Your child's health is our happiness.</p>
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
                    <li><a href="<?php echo $base_url; ?>/oncology.php"><i class="fas fa-chevron-right"></i> Oncology</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Subscribe for child health tips and updates</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Pediatrics newsletter!');">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital - Pediatrics Department. All rights reserved.</p>
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
            alert('Thank you for subscribing to our Pediatrics newsletter!');
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