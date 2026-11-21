<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritional Support - ABC Hospital | Cancer Nutrition</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/dept/Oncology.avif">
    
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
            background: linear-gradient(135deg, #6a3093 0%, #a044ff 100%);
            color: white;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 4px solid #c39bd3;
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
            color: #c39bd3;
        }
        
        .contact-info i {
            color: #c39bd3;
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
            background: #c39bd3;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(195, 155, 211, 0.4);
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
            color: #a044ff;
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
            color: #a044ff;
            background: rgba(160, 68, 255, 0.1);
        }
        
        .nav-links .btn-login {
            background: transparent;
            border: 2px solid #a044ff;
            color: #a044ff;
            padding: 8px 20px;
        }
        
        .nav-links .btn-login:hover {
            background: #a044ff;
            color: white;
        }
        
        .nav-links .btn-register {
            background: #a044ff;
            color: white;
            padding: 8px 20px;
            border: 2px solid #a044ff;
        }
        
        .nav-links .btn-register:hover {
            background: #6a3093;
            border-color: #6a3093;
        }
        
        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, #a044ff 0%, #6a3093 100%);
            padding: 60px 0;
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
            background: url('https://www.transparenttextures.com/patterns/ribbon.png');
            opacity: 0.1;
        }
        
        .header-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }
        
        .header-content h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .header-content h1 i {
            color: #f0e68c;
            margin-right: 15px;
        }
        
        .header-content p {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.95;
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
            color: #6a3093;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #a044ff;
        }
        
        .breadcrumb .separator {
            color: #95a5a6;
        }
        
        .breadcrumb .current {
            color: #7f8c8d;
            font-weight: 400;
        }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            padding: 60px 0;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
        }
        
        .content-left h2 {
            font-size: 32px;
            color: #6a3093;
            margin-bottom: 25px;
        }
        
        .content-left h2 span {
            color: #a044ff;
        }
        
        .content-left h3 {
            font-size: 24px;
            color: #6a3093;
            margin: 30px 0 20px;
        }
        
        .content-left p {
            color: #5a6a7a;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .content-left ul {
            list-style: none;
            margin-bottom: 30px;
        }
        
        .content-left ul li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .content-left ul li i {
            color: #a044ff;
            font-size: 18px;
            margin-top: 3px;
        }
        
        .info-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .info-card h3 {
            color: #6a3093;
            font-size: 22px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-card h3 i {
            color: #a044ff;
        }
        
        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .nutrition-item {
            background: linear-gradient(135deg, #f9f0ff, #f5e6ff);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid #e0c0ff;
        }
        
        .nutrition-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(160, 68, 255, 0.15);
        }
        
        .nutrition-item i {
            font-size: 40px;
            color: #a044ff;
            margin-bottom: 15px;
        }
        
        .nutrition-item h4 {
            color: #6a3093;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .nutrition-item p {
            color: #5a6a7a;
            font-size: 14px;
        }
        
        .dietitian-list {
            display: grid;
            gap: 20px;
        }
        
        .dietitian-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s;
        }
        
        .dietitian-item:hover {
            background: linear-gradient(135deg, #f9f0ff, #f5e6ff);
            transform: translateX(5px);
        }
        
        .dietitian-item i {
            font-size: 30px;
            color: #a044ff;
        }
        
        .dietitian-info h4 {
            font-size: 18px;
            color: #6a3093;
            margin-bottom: 5px;
        }
        
        .dietitian-info p {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .tips-list {
            list-style: none;
        }
        
        .tips-list li {
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 15px;
            border-left: 4px solid #a044ff;
            transition: all 0.3s;
        }
        
        .tips-list li:hover {
            background: white;
            box-shadow: 0 10px 25px rgba(160, 68, 255, 0.1);
        }
        
        .tips-list li strong {
            color: #6a3093;
            display: block;
            margin-bottom: 8px;
            font-size: 18px;
        }
        
        .tips-list li strong i {
            color: #a044ff;
            margin-right: 8px;
        }
        
        .recipe-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid #eef2f6;
        }
        
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(160, 68, 255, 0.15);
            border-color: #a044ff;
        }
        
        .recipe-card h4 {
            color: #6a3093;
            font-size: 20px;
            margin-bottom: 15px;
        }
        
        .recipe-meta {
            display: flex;
            gap: 25px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #a044ff;
        }
        
        .recipe-meta i {
            margin-right: 5px;
        }
        
        .recipe-card p {
            color: #5a6a7a;
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.8;
        }
        
        .btn-recipe {
            background: transparent;
            border: 2px solid #a044ff;
            color: #a044ff;
            padding: 10px 25px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-recipe:hover {
            background: #a044ff;
            color: white;
            transform: translateY(-2px);
        }
        
        .handout-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 40px 0;
        }
        
        .handout-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #eef2f6;
            text-decoration: none;
            color: inherit;
        }
        
        .handout-item:hover {
            background: linear-gradient(135deg, #f9f0ff, #f5e6ff);
            transform: translateX(5px);
            border-color: #a044ff;
        }
        
        .handout-item i {
            font-size: 30px;
            color: #a044ff;
        }
        
        .handout-info h4 {
            font-size: 16px;
            color: #6a3093;
            margin-bottom: 3px;
        }
        
        .handout-info p {
            font-size: 12px;
            color: #95a5a6;
            margin-bottom: 0;
        }
        
        .sidebar-card {
            background: linear-gradient(135deg, #6a3093, #a044ff);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(160, 68, 255, 0.2);
        }
        
        .sidebar-card h3 {
            font-size: 22px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-card h3 i {
            color: #f0e68c;
        }
        
        .sidebar-card p {
            margin-bottom: 15px;
            opacity: 0.95;
        }
        
        .sidebar-card .contact-info {
            margin-top: 20px;
        }
        
        .sidebar-card .contact-info div {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-card .contact-info i {
            color: #f0e68c;
            width: 20px;
        }
        
        .btn-consult {
            background: white;
            color: #6a3093;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            width: 100%;
            justify-content: center;
            margin-top: 20px;
            border: 2px solid white;
        }
        
        .btn-consult:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.3);
        }
        
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .testimonial-card i {
            color: #a044ff;
            font-size: 30px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .testimonial-card p {
            font-style: italic;
            color: #5a6a7a;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-info h4 {
            color: #6a3093;
            font-size: 16px;
            margin-bottom: 3px;
        }
        
        .author-info p {
            color: #95a5a6;
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .faq-section {
            margin-top: 50px;
        }
        
        .faq-item {
            background: white;
            border-radius: 15px;
            margin-bottom: 15px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid #eef2f6;
        }
        
        .faq-item:hover {
            box-shadow: 0 10px 25px rgba(160, 68, 255, 0.1);
            border-color: #a044ff;
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-question h4 {
            color: #6a3093;
            font-size: 18px;
            font-weight: 600;
        }
        
        .faq-question i {
            color: #a044ff;
            transition: transform 0.3s;
        }
        
        .faq-answer {
            display: none;
            padding-top: 20px;
            color: #5a6a7a;
            line-height: 1.8;
        }
        
        .faq-item.active .faq-answer {
            display: block;
        }
        
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        
        .insurance-list {
            list-style: none;
        }
        
        .insurance-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .insurance-list li i {
            color: #f0e68c;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #0b1a2a;
            color: #a0b8cc;
            padding: 60px 0 0;
            margin-top: 60px;
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
            background: #a044ff;
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
            color: #a044ff;
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
            padding: 12px 15px;
            border: none;
            border-radius: 30px 0 0 30px;
            outline: none;
            font-family: 'Poppins', sans-serif;
        }
        
        .newsletter-form button {
            background: #a044ff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #6a3093;
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
            color: #a044ff;
        }
        
        /* ===== BACK TO TOP ===== */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #a044ff;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 20px rgba(160, 68, 255, 0.4);
            transition: all 0.3s;
            z-index: 999;
        }
        
        #backToTop:hover {
            background: #6a3093;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(160, 68, 255, 0.5);
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .nutrition-grid {
                grid-template-columns: 1fr;
            }
            
            .handout-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .header-content h1 {
                font-size: 36px;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .footer-bottom-links a {
                margin: 0 10px;
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
            <span><i class="fas fa-clock"></i> 24/7 Cancer Support</span>
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
                <span class="logo-text">ABC <span>ONCOLOGY</span></span>
            </a>
            
            <ul class="nav-links">
                <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
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
            <h1><i class="fas fa-utensils"></i> Nutritional Support</h1>
            <p>Specialized dietary guidance to maintain strength and well-being during cancer treatment</p>
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
        <a href="<?php echo $base_url; ?>/oncology.php">Oncology</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">Nutritional Support</span>
    </div>
</div>

<!-- MAIN CONTENT -->
<section class="main-content">
    <div class="container">
        <div class="content-grid">
            <!-- LEFT COLUMN -->
            <div class="content-left">
                <div data-aos="fade-up">
                    <h2>Nutrition <span>Matters</span> in Cancer Care</h2>
                    <p>Good nutrition is essential during cancer treatment. Our specialized dietitians work with patients to develop personalized nutrition plans that help maintain strength, manage treatment side effects, and improve quality of life.</p>
                    
                    <p>Whether you're facing appetite loss, taste changes, or digestive issues, our team provides practical solutions to ensure you get the nutrients your body needs to heal and stay strong. We take a holistic approach that considers your specific cancer type, treatment plan, and personal preferences.</p>
                </div>
                
                <div class="info-card" data-aos="fade-up">
                    <h3><i class="fas fa-star"></i> Our Nutrition Services Include:</h3>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> <strong>Personalized Nutrition Plans:</strong> Tailored to your specific cancer type and treatment</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Side Effect Management:</strong> Dietary strategies for nausea, taste changes, and appetite loss</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Weight Management:</strong> Help with weight gain or loss during treatment</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Supplement Guidance:</strong> Evidence-based recommendations for nutritional supplements</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Post-Treatment Nutrition:</strong> Guidance for recovery and survivorship</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Family Education:</strong> Training for caregivers on meal preparation and nutrition</li>
                    </ul>
                </div>
                
                <h3 data-aos="fade-up">Key Nutrition Areas</h3>
                <div class="nutrition-grid" data-aos="fade-up">
                    <div class="nutrition-item">
                        <i class="fas fa-apple-alt"></i>
                        <h4>Immune Support</h4>
                        <p>Foods that boost immune function during treatment</p>
                    </div>
                    
                    <div class="nutrition-item">
                        <i class="fas fa-dumbbell"></i>
                        <h4>Protein Intake</h4>
                        <p>Maintaining muscle mass and strength</p>
                    </div>
                    
                    <div class="nutrition-item">
                        <i class="fas fa-tint"></i>
                        <h4>Hydration</h4>
                        <p>Managing fluid intake and preventing dehydration</p>
                    </div>
                    
                    <div class="nutrition-item">
                        <i class="fas fa-carrot"></i>
                        <h4>Antioxidants</h4>
                        <p>Foods rich in cancer-fighting nutrients</p>
                    </div>
                    
                    <div class="nutrition-item">
                        <i class="fas fa-bread-slice"></i>
                        <h4>Digestive Health</h4>
                        <p>Managing digestive issues during treatment</p>
                    </div>
                    
                    <div class="nutrition-item">
                        <i class="fas fa-heartbeat"></i>
                        <h4>Heart Health</h4>
                        <p>Nutrition for cardiovascular wellness</p>
                    </div>
                </div>
                
                <h3 data-aos="fade-up">Meet Our Dietitians</h3>
                <div class="dietitian-list" data-aos="fade-up">
                    <div class="dietitian-item">
                        <i class="fas fa-user-md"></i>
                        <div class="dietitian-info">
                            <h4>Ms. Thilini Weerasinghe</h4>
                            <p>Senior Clinical Dietitian, MSc in Nutrition, 12+ years in oncology nutrition</p>
                        </div>
                    </div>
                    
                    <div class="dietitian-item">
                        <i class="fas fa-user-md"></i>
                        <div class="dietitian-info">
                            <h4>Mr. Nuwan Perera</h4>
                            <p>Clinical Dietitian, BSc Nutrition, Specialized in GI cancer nutrition</p>
                        </div>
                    </div>
                    
                    <div class="dietitian-item">
                        <i class="fas fa-user-md"></i>
                        <div class="dietitian-info">
                            <h4>Dr. Chathuri Silva</h4>
                            <p>Nutrition Biochemist, PhD, Research in cancer nutrition</p>
                        </div>
                    </div>
                    
                    <div class="dietitian-item">
                        <i class="fas fa-user-md"></i>
                        <div class="dietitian-info">
                            <h4>Ms. Kumari Jayawardena</h4>
                            <p>Pediatric Oncology Dietitian, Specialized in childhood cancer nutrition</p>
                        </div>
                    </div>
                </div>
                
                <h3 data-aos="fade-up">Nutrition Tips During Treatment</h3>
                <ul class="tips-list" data-aos="fade-up">
                    <li>
                        <strong><i class="fas fa-utensils"></i> Managing Appetite Loss:</strong>
                        Eat small, frequent meals every 2-3 hours. Keep nutritious snacks nearby. Try liquid nutrition supplements if solid food is difficult. Set reminders to eat even when not hungry.
                    </li>
                    <li>
                        <strong><i class="fas fa-tint"></i> Dealing with Taste Changes:</strong>
                        Use herbs and spices to enhance flavor. Try marinating meats in sweet or savory sauces. Cold foods may taste better than hot ones. Experiment with new foods you haven't tried before.
                    </li>
                    <li>
                        <strong><i class="fas fa-stomach"></i> Managing Nausea:</strong>
                        Eat bland, dry foods like crackers or toast. Avoid strong smells. Ginger tea or peppermint can help settle the stomach. Eat slowly and rest after meals.
                    </li>
                    <li>
                        <strong><i class="fas fa-weight"></i> Maintaining Weight:</strong>
                        Add healthy fats like olive oil, avocado, and nut butters. Choose high-protein foods like eggs, fish, and legumes. Drink calories through smoothies and soups.
                    </li>
                    <li>
                        <strong><i class="fas fa-mouth"></i> Managing Mouth Sores:</strong>
                        Choose soft, moist foods. Avoid acidic, spicy, or rough-textured foods. Use a straw to bypass sore areas. Try cold foods like yogurt and smoothies.
                    </li>
                </ul>
                
                <h3 data-aos="fade-up">Sample Nutritious Recipes</h3>
                
                <div class="recipe-card" data-aos="fade-up">
                    <h4>High-Protein Berry Smoothie</h4>
                    <div class="recipe-meta">
                        <span><i class="fas fa-clock"></i> 5 minutes</span>
                        <span><i class="fas fa-chart-line"></i> 25g protein</span>
                        <span><i class="fas fa-fire"></i> 350 calories</span>
                    </div>
                    <p>A nourishing, easy-to-digest smoothie perfect when appetite is low or mouth sores make eating difficult.</p>
                    <p><strong>Ingredients:</strong> 1 banana, 1 cup milk (or almond milk), 2 tbsp peanut butter, 1 scoop vanilla protein powder, 1/2 cup mixed berries, 1 tbsp honey</p>
                    <a href="#" class="btn-recipe" onclick="downloadRecipe('berry-smoothie'); return false;">Get Full Recipe</a>
                </div>
                
                <div class="recipe-card" data-aos="fade-up">
                    <h4>Immune-Boosting Vegetable Soup</h4>
                    <div class="recipe-meta">
                        <span><i class="fas fa-clock"></i> 30 minutes</span>
                        <span><i class="fas fa-chart-line"></i> Rich in antioxidants</span>
                        <span><i class="fas fa-fire"></i> 180 calories per serving</span>
                    </div>
                    <p>Warm, soothing soup packed with vegetables and immune-supporting nutrients. Easy to digest and full of flavor.</p>
                    <p><strong>Ingredients:</strong> Carrots, celery, onions, garlic, ginger, turmeric, chicken or vegetable broth, spinach, lemon juice</p>
                    <a href="#" class="btn-recipe" onclick="downloadRecipe('vegetable-soup'); return false;">Get Full Recipe</a>
                </div>
                
                <div class="recipe-card" data-aos="fade-up">
                    <h4>Protein-Packed Energy Balls</h4>
                    <div class="recipe-meta">
                        <span><i class="fas fa-clock"></i> 15 minutes</span>
                        <span><i class="fas fa-chart-line"></i> 8g protein per ball</span>
                        <span><i class="fas fa-fire"></i> 120 calories each</span>
                    </div>
                    <p>No-bake energy balls perfect for snacking when you need quick, nutritious energy between meals.</p>
                    <p><strong>Ingredients:</strong> 1 cup oats, 1/2 cup peanut butter, 1/3 cup honey, 1/4 cup ground flaxseed, 1/4 cup chocolate chips, 1 tsp vanilla</p>
                    <a href="#" class="btn-recipe" onclick="downloadRecipe('energy-balls'); return false;">Get Full Recipe</a>
                </div>
                
                <h3 data-aos="fade-up">Downloadable Resources</h3>
                <div class="handout-grid" data-aos="fade-up">
                    <a href="#" class="handout-item" onclick="downloadHandout('nutrition-guide'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Nutrition Guide</h4>
                            <p>Complete guide, 25 pages</p>
                        </div>
                    </a>
                    
                    <a href="#" class="handout-item" onclick="downloadHandout('recipe-collection'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Recipe Collection</h4>
                            <p>50+ recipes, 40 pages</p>
                        </div>
                    </a>
                    
                    <a href="#" class="handout-item" onclick="downloadHandout('side-effect-guide'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Side Effect Guide</h4>
                            <p>Tips for common issues, 15 pages</p>
                        </div>
                    </a>
                    
                    <a href="#" class="handout-item" onclick="downloadHandout('meal-planner'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Meal Planner</h4>
                            <p>Printable template, 5 pages</p>
                        </div>
                    </a>
                    
                    <a href="#" class="handout-item" onclick="downloadHandout('shopping-list'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Shopping List</h4>
                            <p>Healthy foods checklist</p>
                        </div>
                    </a>
                    
                    <a href="#" class="handout-item" onclick="downloadHandout('hydration-tracker'); return false;">
                        <i class="fas fa-file-pdf"></i>
                        <div class="handout-info">
                            <h4>Hydration Tracker</h4>
                            <p>Daily water intake log</p>
                        </div>
                    </a>
                </div>
                
                <div class="faq-section" data-aos="fade-up">
                    <h3>Frequently Asked Questions</h3>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Should I take vitamin supplements during treatment?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Always consult with your oncologist and dietitian before taking any supplements. Some vitamins can interfere with chemotherapy or radiation. We'll help you determine what's safe and beneficial for your specific situation. In general, getting nutrients from food is preferred over supplements.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>What if I can't eat due to nausea or mouth sores?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Our dietitians can recommend liquid nutrition supplements, soft foods, and specific recipes that are gentle on the mouth and stomach. We also work with your doctor to manage these side effects medically. Cold foods like smoothies, yogurt, and popsicles can be easier to tolerate.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Are there foods I should avoid during treatment?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            During chemotherapy, when white blood cell counts may be low, we recommend avoiding raw or undercooked foods, unpasteurized dairy, and unwashed produce to reduce infection risk. Your dietitian will provide specific guidelines based on your treatment and blood counts.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>How can I help a loved one who has lost interest in eating?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Offer small, appealing portions. Try different textures and temperatures. Make mealtime social and relaxed. Avoid pressure. Our dietitians can provide personalized strategies for your loved one's specific situation. Sometimes liquid nutrition or favorite comfort foods can help.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Do I need to follow a special diet after treatment ends?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, nutrition remains important for recovery and long-term health. We'll help you transition to a healthy, balanced diet that supports healing and may help reduce the risk of recurrence. Focus on plant-based foods, lean proteins, and healthy fats.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>How often should I see a dietitian during treatment?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            We typically recommend an initial consultation, then follow-up every 2-4 weeks during active treatment, or more frequently if you're experiencing significant side effects. Your dietitian will work with you to determine the best schedule for your needs.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT COLUMN -->
            <div class="content-right">
                <div class="sidebar-card" data-aos="fade-left">
                    <h3><i class="fas fa-utensils"></i> Schedule a Consultation</h3>
                    <p>Meet with our dietitians for personalized nutrition guidance during your cancer journey.</p>
                    <div class="contact-info">
                        <div><i class="fas fa-phone"></i> <strong>Nutrition Helpline:</strong> +94 11 234 5682</div>
                        <div><i class="fas fa-envelope"></i> <strong>Email:</strong> nutrition@abchospital.lk</div>
                        <div><i class="fas fa-clock"></i> <strong>Hours:</strong> Mon-Fri 8:00 AM - 5:00 PM</div>
                        <div><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> Oncology Center, 3rd Floor</div>
                    </div>
                    <a href="<?php echo $base_url; ?>/appointments.php?service=nutrition" class="btn-consult">
                        <i class="fas fa-calendar-check"></i> Book a Consultation
                    </a>
                </div>
                
                <div class="testimonial-card" data-aos="fade-left">
                    <i class="fas fa-quote-left"></i>
                    <p>"The nutrition team helped me manage my weight and energy levels during chemotherapy. I learned so much about eating well and actually enjoyed the recipes they shared. I feel stronger and more in control of my health. The smoothie recipes were a lifesaver when I couldn't eat solid food."</p>
                    <div class="testimonial-author">
                        <img src="images/dept/Ruwan Dissanayake.jpg" alt="Patient" onerror="this.src='https://via.placeholder.com/60x60'">
                        <div class="author-info">
                            <h4>Ruwan Dissanayake</h4>
                            <p>Colon Cancer Patient</p>
                        </div>
                    </div>
                </div>
                
                <div class="info-card" data-aos="fade-left">
                    <h3><i class="fas fa-clock"></i> Clinic Hours</h3>
                    <ul style="list-style: none;">
                        <li style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Monday - Friday:</span>
                            <span>8:00 AM - 5:00 PM</span>
                        </li>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Saturday:</span>
                            <span>9:00 AM - 12:00 PM</span>
                        </li>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Sunday:</span>
                            <span>Closed</span>
                        </li>
                    </ul>
                </div>
                
                <div class="info-card" data-aos="fade-left">
                    <h3><i class="fas fa-hand-holding-heart"></i> Insurance Coverage</h3>
                    <p>Most insurance plans cover nutrition consultations. We accept:</p>
                    <ul class="insurance-list" style="margin-top: 15px;">
                        <li><i class="fas fa-check-circle"></i> Sri Lankan Insurance</li>
                        <li><i class="fas fa-check-circle"></i> Cargills Insurance</li>
                        <li><i class="fas fa-check-circle"></i> AIA Insurance</li>
                        <li><i class="fas fa-check-circle"></i> Union Assurance</li>
                        <li><i class="fas fa-check-circle"></i> Ceylinco Insurance</li>
                        <li><i class="fas fa-check-circle"></i> Softlogic Life</li>
                    </ul>
                    <p style="margin-top: 15px; font-size: 14px;">Please check with your provider for specific coverage details.</p>
                </div>
                
                <div class="info-card" data-aos="fade-left">
                    <h3><i class="fas fa-tips"></i> Quick Tips</h3>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 12px;"><i class="fas fa-lightbulb" style="color: #a044ff; margin-right: 8px;"></i> Eat small meals every 2-3 hours</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-lightbulb" style="color: #a044ff; margin-right: 8px;"></i> Stay hydrated - aim for 8-10 cups daily</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-lightbulb" style="color: #a044ff; margin-right: 8px;"></i> Choose protein with every meal</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-lightbulb" style="color: #a044ff; margin-right: 8px;"></i> Add healthy fats for calories</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-lightbulb" style="color: #a044ff; margin-right: 8px;"></i> Keep nutritious snacks nearby</li>
                    </ul>
                </div>
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
                    <span>ABC Oncology</span>
                </div>
                <p>Providing compassionate cancer care since 1959. You're not alone in this journey.</p>
                <div class="social-icons" style="margin-top: 20px;">
                    <a href="https://facebook.com/abchospital" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/abchospital" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://linkedin.com/company/abchospital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://instagram.com/abchospital" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com/abchospital" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/oncology.php"><i class="fas fa-chevron-right"></i> Oncology</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Support Services</h3>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/counseling-services.php"><i class="fas fa-chevron-right"></i> Counseling</a></li>
                    <li><a href="<?php echo $base_url; ?>/support-groups.php"><i class="fas fa-chevron-right"></i> Support Groups</a></li>
                    <li><a href="<?php echo $base_url; ?>/nutritional-support.php"><i class="fas fa-chevron-right"></i> Nutritional Support</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Subscribe for cancer awareness and updates</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing to our nutrition newsletter!');">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital - Oncology Department. All rights reserved.</p>
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

    // FAQ Accordion
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });

    // Consultation Button
    document.querySelectorAll('.btn-consult').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?php echo $base_url; ?>/appointments.php?service=nutrition';
        });
    });

    // Download Handouts Function
    function downloadHandout(type) {
        let content = '';
        let filename = '';
        let title = '';
        
        switch(type) {
            case 'nutrition-guide':
                filename = 'ABC_Hospital_Nutrition_Guide.pdf';
                title = 'Complete Nutrition Guide for Cancer Patients';
                content = `ABC HOSPITAL - COMPLETE NUTRITION GUIDE FOR CANCER PATIENTS
                
Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 25

TABLE OF CONTENTS

1. Introduction to Nutrition in Cancer Care
   - Why nutrition matters during treatment
   - The role of a clinical dietitian
   - Working with your healthcare team

2. Understanding Your Nutritional Needs
   - Calorie requirements during treatment
   - Protein needs for healing
   - Fluid requirements
   - Vitamin and mineral considerations

3. Managing Treatment Side Effects Through Nutrition
   - Appetite loss: Strategies and recipes
   - Nausea and vomiting: Foods that help
   - Taste changes: Making food appealing
   - Mouth sores: Soft food ideas
   - Constipation and diarrhea: Dietary adjustments
   - Fatigue: Energy-boosting foods

4. Food Safety During Treatment
   - When to be extra careful
   - Foods to avoid
   - Safe food handling practices
   - Eating out safely

5. Special Diets for Specific Cancer Types
   - Breast cancer nutrition
   - Colon cancer nutrition
   - Lung cancer nutrition
   - Pancreatic cancer nutrition
   - Head and neck cancer nutrition

6. Nutritional Supplements
   - When supplements are needed
   - Types of supplements
   - Talking to your doctor about supplements

7. Recipes for Every Side Effect
   - High-protein smoothies
   - Soft and moist meals
   - Nutrient-dense snacks
   - Hydrating foods and drinks

8. Meal Planning and Preparation
   - Weekly meal planning templates
   - Batch cooking tips
   - Involving caregivers

9. Nutrition After Treatment
   - Transitioning to maintenance diet
   - Long-term healthy eating
   - Weight management after treatment

10. Resources and References
    - Helpful websites
    - Support groups
    - Further reading

APPENDICES
A. Daily Food Diary
B. Symptom Tracker
C. Contact Information

This guide was prepared by:
Ms. Thilini Weerasinghe (Senior Clinical Dietitian)
Mr. Nuwan Perera (Clinical Dietitian)
Dr. Chathuri Silva (Nutrition Biochemist)

For personal consultations, please contact:
Nutrition Helpline: +94 11 234 5682
Email: nutrition@abchospital.lk

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'recipe-collection':
                filename = 'ABC_Hospital_Recipe_Collection.pdf';
                title = 'Cancer-Friendly Recipe Collection';
                content = `ABC HOSPITAL - CANCER-FRIENDLY RECIPE COLLECTION

Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 40
Recipes: 50+

INTRODUCTION
This collection features recipes specifically developed for cancer patients. Each recipe considers common treatment side effects and nutritional needs. All recipes have been tested by our clinical dietitians and approved by patients.

SECTION 1: HIGH-PROTEIN SMOOTHIES (10 recipes)

1.1 Berry Protein Blast
Ingredients:
- 1 banana
- 1 cup milk or almond milk
- 2 tbsp peanut butter
- 1 scoop vanilla protein powder
- 1/2 cup mixed berries
- 1 tbsp honey

Instructions:
1. Combine all ingredients in a blender
2. Blend until smooth
3. Add ice if desired
4. Serve immediately

Nutrition: 350 calories, 25g protein

1.2 Tropical Immune Booster
[... Additional recipes ...]

SECTION 2: SOFT AND MOIST MEALS (15 recipes)

2.1 Creamy Pumpkin Soup
[...]

2.2 Mashed Sweet Potatoes with Ginger
[...]

SECTION 3: NUTRIENT-DENSE SNACKS (10 recipes)

3.1 Energy Balls
Ingredients:
- 1 cup oats
- 1/2 cup peanut butter
- 1/3 cup honey
- 1/4 cup ground flaxseed
- 1/4 cup chocolate chips
- 1 tsp vanilla

Instructions:
1. Mix all ingredients in a bowl
2. Roll into small balls
3. Refrigerate for 30 minutes
4. Store in airtight container

Nutrition: 120 calories per ball, 8g protein

SECTION 4: HYDRATING FOODS AND DRINKS (8 recipes)

SECTION 5: HIGH-CALORIE MEALS (7 recipes)

NUTRITIONAL INFORMATION FOR ALL RECIPES
- Calories
- Protein content
- Fat content
- Carbohydrates
- Key nutrients

TIPS FOR SUCCESS
- Adapting recipes to your tastes
- Making recipes in advance
- Freezing and storing
- Involving family members

INDEX
- Recipes by main ingredient
- Recipes by side effect managed
- Recipes by preparation time

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'side-effect-guide':
                filename = 'ABC_Hospital_Side_Effect_Guide.pdf';
                title = 'Managing Treatment Side Effects Through Nutrition';
                content = `ABC HOSPITAL - MANAGING TREATMENT SIDE EFFECTS THROUGH NUTRITION

Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 15

INTRODUCTION
Cancer treatments can cause various side effects that affect your ability to eat and maintain good nutrition. This guide provides practical strategies to manage these side effects through dietary adjustments.

SIDE EFFECT 1: APPETITE LOSS

What happens:
- Decreased desire to eat
- Early satiety (feeling full quickly)
- Lack of interest in food

Nutritional strategies:
✓ Eat small, frequent meals (every 2-3 hours)
✓ Keep nutritious snacks readily available
✓ Make meals visually appealing
✓ Try liquid nutrition supplements
✓ Eat your favorite foods any time of day
✓ Set reminders to eat even when not hungry

Foods to try:
- Smoothies and milkshakes
- Nuts and nut butters
- Cheese and crackers
- Yogurt with fruit
- Hard-boiled eggs
- Trail mix

SIDE EFFECT 2: TASTE CHANGES

What happens:
- Foods taste metallic, too sweet, or too bitter
- Loss of taste for certain foods
- Heightened sensitivity to smells

Nutritional strategies:
✓ Use herbs and spices for flavor
✓ Try marinades with sweet or savory sauces
✓ Cold foods may taste better than hot
✓ Experiment with new foods
✓ Rinse mouth before eating
✓ Use plastic utensils if metal taste is an issue

Foods to try:
- Citrus fruits (if not causing mouth sores)
- Flavored yogurts
- Marinated meats
- Cold pasta salads
- Fresh fruits
- Flavored waters

SIDE EFFECT 3: NAUSEA

[... Continue with detailed strategies for each side effect ...]

SIDE EFFECT 4: MOUTH SORES

SIDE EFFECT 5: CONSTIPATION

SIDE EFFECT 6: DIARRHEA

SIDE EFFECT 7: FATIGUE

SIDE EFFECT 8: WEIGHT CHANGES

WHEN TO CALL YOUR DOCTOR
- Unable to eat for 24 hours
- Significant weight loss
- Severe nausea or vomiting
- Signs of dehydration
- Severe mouth sores preventing eating

QUICK REFERENCE CHART
Side Effect | Foods to Choose | Foods to Avoid | Tips
------------|-----------------|----------------|-----
Appetite Loss | Smoothies, nuts, cheese | Large meals | Eat small, often
Taste Changes | Cold foods, flavored foods | Metallic-tasting foods | Use plastic utensils
[...] | [...] | [...] | [...]

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'meal-planner':
                filename = 'ABC_Hospital_Meal_Planner.pdf';
                title = 'Weekly Meal Planner Template';
                content = `ABC HOSPITAL - WEEKLY MEAL PLANNER TEMPLATE

Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 5

WEEKLY MEAL PLANNER FOR CANCER PATIENTS

Patient Name: _____________________
Week of: _____________________
Dietitian: _____________________

INSTRUCTIONS
1. Plan meals for the week ahead
2. Include 3 main meals and 2-3 snacks daily
3. Focus on high-protein and high-calorie options
4. Prepare a shopping list from your plan
5. Note any side effects and adjust accordingly

DAILY MEAL PLANNER TEMPLATE

DAY: MONDAY

Breakfast:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Morning Snack:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Lunch:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Afternoon Snack:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Dinner:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Evening Snack:
Time: ________
Foods: ______________________________
Liquid: ______________________________

Daily Fluid Intake Goal: ___ cups
Actual: ___ cups

Notes for today:
_____________________________
_____________________________

[Similar templates for Tuesday through Sunday]

SHOPPING LIST TEMPLATE

Produce:
□ ______________________________
□ ______________________________
□ ______________________________

Protein:
□ ______________________________
□ ______________________________
□ ______________________________

Dairy:
□ ______________________________
□ ______________________________

Grains:
□ ______________________________
□ ______________________________

Canned/Frozen:
□ ______________________________
□ ______________________________

Snacks:
□ ______________________________
□ ______________________________

Beverages:
□ ______________________________
□ ______________________________

Other:
□ ______________________________
□ ______________________________

MEAL PREP CHECKLIST
□ Wash and cut vegetables
□ Cook grains in bulk
□ Portion out snacks
□ Prepare smoothie ingredients
□ Cook proteins for the week

NOTES
_____________________________
_____________________________
_____________________________

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'shopping-list':
                filename = 'ABC_Hospital_Shopping_List.pdf';
                title = 'Healthy Foods Shopping Checklist';
                content = `ABC HOSPITAL - HEALTHY FOODS SHOPPING CHECKLIST

Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 5

CANCER-FRIENDLY GROCERY SHOPPING LIST

Patient Name: _____________________
Date: _____________________

GENERAL TIPS
✓ Shop when you're not tired or hungry
✓ Bring your list and stick to it
✓ Read labels for protein and calorie content
✓ Ask for help if you need it
✓ Consider online delivery if going out is difficult

PRODUCE SECTION

Fruits (choose variety):
□ Bananas (great for smoothies)
□ Berries (fresh or frozen)
□ Avocados (healthy fats)
□ Apples
□ Oranges and citrus
□ Melons
□ Mangoes
□ Peaches
□ Frozen fruit blends for smoothies

Vegetables:
□ Spinach and leafy greens
□ Carrots
□ Sweet potatoes
□ Broccoli
□ Cauliflower
□ Butternut squash
□ Peas (fresh or frozen)
□ Green beans
□ Bell peppers
□ Onions
□ Garlic
□ Ginger
□ Mushrooms

PROTEIN SECTION

Meat and Poultry:
□ Chicken (breasts, thighs)
□ Ground turkey
□ Lean beef
□ Eggs (excellent protein source)

Fish:
□ Salmon (omega-3 rich)
□ Tuna (canned in water)
□ White fish
□ Sardines

Plant-based:
□ Tofu
□ Tempeh
□ Edamame
□ Beans (canned or dried)
□ Lentils
□ Chickpeas

DAIRY AND ALTERNATIVES

□ Milk (regular or plant-based)
□ Yogurt (Greek for extra protein)
□ Cheese (variety)
□ Cottage cheese
□ Kefir
□ Almond milk
□ Soy milk
□ Oat milk

GRAINS

□ Oats (rolled or quick)
□ Quinoa
□ Brown rice
□ White rice (if needed for soft diet)
□ Pasta (regular or protein-enriched)
□ Whole grain bread
□ Crackers (plain)
□ Rice cakes
□ Cereal (low sugar)

HEALTHY FATS

□ Olive oil
□ Coconut oil
□ Nut butters (peanut, almond)
□ Nuts (almonds, walnuts, cashews)
□ Seeds (chia, flax, pumpkin)
□ Hummus

CANNED AND JARRED FOODS

□ Soups (low sodium)
□ Broth (chicken, vegetable)
□ Canned fruits (in juice, not syrup)
□ Canned vegetables
□ Tomato sauce
□ Coconut milk
□ Nut butters
□ Jam or honey

SNACKS AND EXTRAS

□ Protein bars
□ Granola
□ Trail mix
□ Dried fruit
□ Pudding cups
□ Applesauce
□ Gelatin
□ Crackers
□ Rice cakes

BEVERAGES

□ Water
□ Herbal teas (ginger, peppermint)
□ 100% fruit juices
□ Vegetable juices
□ Sports drinks (if needed)
□ Protein shakes

SUPPLEMENTS (if recommended)

□ Protein powder
□ Meal replacement shakes
□ Multivitamin
□ Specific supplements as prescribed

SPECIALTY ITEMS

□ Thickening products (if needed)
□ Pureed foods
□ Tube feeding supplies (if applicable)

NOTES
_____________________________
_____________________________
_____________________________

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'hydration-tracker':
                filename = 'ABC_Hospital_Hydration_Tracker.pdf';
                title = 'Daily Hydration Tracker';
                content = `ABC HOSPITAL - DAILY HYDRATION TRACKER

Published by: ABC Hospital Oncology Department
Date: 2026
Pages: 5

DAILY WATER INTAKE LOG FOR CANCER PATIENTS

Patient Name: _____________________
Month: _____________________

WHY HYDRATION MATTERS DURING CANCER TREATMENT
- Prevents dehydration from treatment side effects
- Helps manage constipation
- Supports kidney function
- Maintains energy levels
- Helps with medication processing

DAILY HYDRATION GOAL: _____ cups (typically 8-10 cups)

HOW TO TRACK
• 1 cup = 8 ounces
• Mark each cup as you drink
• Track all fluids: water, juice, milk, soup, etc.
• Note any symptoms that affect drinking

WEEK 1

MONDAY
Goal: ___ cups
☐ 8 am: ___
☐ 10 am: ___
☐ 12 pm: ___
☐ 2 pm: ___
☐ 4 pm: ___
☐ 6 pm: ___
☐ 8 pm: ___
Total: ___ cups
Notes: ________________

TUESDAY
Goal: ___ cups
☐ 8 am: ___
☐ 10 am: ___
☐ 12 pm: ___
☐ 2 pm: ___
☐ 4 pm: ___
☐ 6 pm: ___
☐ 8 pm: ___
Total: ___ cups
Notes: ________________

[Similar templates for Wednesday through Sunday]

WEEKLY SUMMARY - WEEK 1

Total cups this week: _____
Average per day: _____
Best day: _____
Worst day: _____

How I felt this week:
☐ Well hydrated - good energy
☐ Sometimes thirsty
☐ Often thirsty
☐ Signs of dehydration (dark urine, dizziness)

Notes:
_____________________________
_____________________________

[Similar templates for Weeks 2-4]

MONTHLY SUMMARY

Month: _____________________

Total cups this month: _____
Daily average: _____
Days met goal: _____ out of 30

Progress:
☐ Increased hydration
☐ Maintained good hydration
☐ Need to improve

How hydration affected:
Energy levels: ☐ Improved ☐ Same ☐ Worse
Constipation: ☐ Improved ☐ Same ☐ Worse
Overall well-being: ☐ Improved ☐ Same ☐ Worse

HYDRATION TIPS
✓ Keep water within reach at all times
✓ Set hourly reminders on your phone
✓ Try different temperatures (cold, room temp)
✓ Add flavor with lemon, cucumber, or berries
✓ Eat hydrating foods (watermelon, cucumber, soup)
✓ Use a marked water bottle to track intake
✓ Drink between meals, not with meals if full easily

SIGNS OF DEHYDRATION
- Dark yellow urine
- Dry mouth and lips
- Dizziness or lightheadedness
- Headache
- Fatigue
- Confusion
- Decreased urination

WHEN TO CALL YOUR DOCTOR
- Unable to keep fluids down
- Signs of severe dehydration
- Dizziness when standing
- No urination for 8+ hours

MY HYDRATION GOALS FOR NEXT MONTH
1. _____________________________
2. _____________________________
3. _____________________________

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            default:
                return;
        }
        
        // Create and download the file
        const blob = new Blob([content], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Show confirmation
        alert(`Downloading ${title}...`);
    }

    // Download Recipe Function
    function downloadRecipe(type) {
        let content = '';
        let filename = '';
        let title = '';
        
        switch(type) {
            case 'berry-smoothie':
                filename = 'ABC_High_Protein_Berry_Smoothie.pdf';
                title = 'High-Protein Berry Smoothie Recipe';
                content = `ABC HOSPITAL - HIGH-PROTEIN BERRY SMOOTHIE RECIPE

Published by: ABC Hospital Oncology Department

RECIPE NAME: High-Protein Berry Smoothie
Preparation Time: 5 minutes
Servings: 1
Calories: 350
Protein: 25g

DESCRIPTION
A nourishing, easy-to-digest smoothie perfect when appetite is low or mouth sores make eating difficult. Packed with protein and antioxidants.

INGREDIENTS
- 1 ripe banana
- 1 cup milk (dairy or almond milk)
- 2 tablespoons peanut butter
- 1 scoop vanilla protein powder (whey or plant-based)
- 1/2 cup mixed berries (fresh or frozen)
- 1 tablespoon honey (optional)

EQUIPMENT NEEDED
- Blender
- Measuring cups and spoons
- Glass

INSTRUCTIONS
1. Peel the banana and break into chunks
2. Add all ingredients to the blender
3. Blend on high until smooth (about 30-45 seconds)
4. If too thick, add more milk 1 tablespoon at a time
5. If too thin, add ice cubes and blend again
6. Pour into a glass
7. Serve immediately

VARIATIONS
- Use different fruits: mango, peach, strawberry
- Add spinach for extra nutrients
- Use different nut butters: almond, cashew
- Add flax seeds or chia seeds for fiber
- Use Greek yogurt instead of protein powder

NUTRITION INFORMATION
Calories: 350
Protein: 25g
Carbohydrates: 45g
Fiber: 8g
Fat: 12g
Key nutrients: Vitamin C, B vitamins, Iron, Calcium

STORAGE
Best consumed immediately. Can be refrigerated for up to 24 hours - shake well before drinking.

TIPS FOR CANCER PATIENTS
- If mouth sores are an issue, serve cold or at room temperature
- If taste changes occur, try adding cinnamon or vanilla extract
- If nausea is a concern, sip slowly throughout the day
- For extra calories, add a tablespoon of coconut oil

WHEN TO USE
- When appetite is low
- When chewing is difficult
- When you need quick protein
- As a meal replacement
- As a snack between meals

This recipe was developed by:
Ms. Thilini Weerasinghe
Senior Clinical Dietitian
ABC Hospital Oncology Department

For more recipes and nutrition advice:
nutrition@abchospital.lk
+94 11 234 5682

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'vegetable-soup':
                filename = 'ABC_Immune_Boosting_Soup.pdf';
                title = 'Immune-Boosting Vegetable Soup Recipe';
                content = `ABC HOSPITAL - IMMUNE-BOOSTING VEGETABLE SOUP RECIPE

Published by: ABC Hospital Oncology Department

RECIPE NAME: Immune-Boosting Vegetable Soup
Preparation Time: 15 minutes
Cooking Time: 30 minutes
Servings: 4
Calories: 180 per serving

DESCRIPTION
Warm, soothing soup packed with vegetables and immune-supporting nutrients. Easy to digest and full of flavor. Perfect for when you need extra nutrition but have a sensitive stomach.

INGREDIENTS
- 2 carrots, diced
- 2 celery stalks, diced
- 1 onion, diced
- 3 cloves garlic, minced
- 1 tablespoon fresh ginger, grated
- 1 teaspoon turmeric powder
- 4 cups chicken or vegetable broth (low sodium)
- 2 cups spinach, chopped
- 2 tablespoons lemon juice
- 2 tablespoons olive oil
- Salt and pepper to taste (optional)

EQUIPMENT NEEDED
- Large pot
- Cutting board and knife
- Measuring cups and spoons
- Wooden spoon
- Ladle

INSTRUCTIONS
1. Heat olive oil in a large pot over medium heat
2. Add onion, carrots, and celery. Cook until softened (5-7 minutes)
3. Add garlic, ginger, and turmeric. Cook for 1 minute until fragrant
4. Pour in broth and bring to a boil
5. Reduce heat and simmer for 20 minutes until vegetables are tender
6. Stir in spinach and cook for 2-3 minutes until wilted
7. Remove from heat and stir in lemon juice
8. Season with salt and pepper if desired
9. Serve warm

VARIATIONS
- Add cooked chicken or tofu for protein
- Add cooked quinoa or rice for extra calories
- Use different vegetables: sweet potato, zucchini, peas
- Make it creamy by adding coconut milk
- Add noodles for a heartier meal

NUTRITION INFORMATION (per serving)
Calories: 180
Protein: 6g
Carbohydrates: 22g
Fiber: 5g
Fat: 8g
Key nutrients: Vitamin A, Vitamin C, Iron, Zinc, Antioxidants

STORAGE
- Refrigerate in airtight container for up to 5 days
- Freeze for up to 3 months
- Reheat gently on stove or microwave

TIPS FOR CANCER PATIENTS
- If swallowing is difficult, blend soup until smooth
- If taste changes occur, adjust seasonings to preference
- If mouth sores are present, serve at room temperature
- Add protein powder for extra nutrition
- Serve with crackers or bread if able to eat solids

WHEN TO USE
- When you need immune support
- When appetite is low
- When you want a warm, comforting meal
- As a light meal or starter
- When you need extra vegetables

This recipe was developed by:
Mr. Nuwan Perera
Clinical Dietitian
ABC Hospital Oncology Department

For more recipes and nutrition advice:
nutrition@abchospital.lk
+94 11 234 5682

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            case 'energy-balls':
                filename = 'ABC_Protein_Energy_Balls.pdf';
                title = 'Protein-Packed Energy Balls Recipe';
                content = `ABC HOSPITAL - PROTEIN-PACKED ENERGY BALLS RECIPE

Published by: ABC Hospital Oncology Department

RECIPE NAME: No-Bake Protein Energy Balls
Preparation Time: 15 minutes
Chilling Time: 30 minutes
Servings: 12 balls
Calories: 120 per ball
Protein: 8g per ball

DESCRIPTION
No-bake energy balls perfect for snacking when you need quick, nutritious energy between meals. Easy to make and portable.

INGREDIENTS
- 1 cup rolled oats
- 1/2 cup peanut butter (or any nut butter)
- 1/3 cup honey or maple syrup
- 1/4 cup ground flaxseed
- 1/4 cup chocolate chips (optional)
- 1 teaspoon vanilla extract
- Pinch of salt (optional)

EQUIPMENT NEEDED
- Large mixing bowl
- Measuring cups and spoons
- Spoon or spatula
- Baking sheet
- Parchment paper
- Airtight container for storage

INSTRUCTIONS
1. Line a baking sheet with parchment paper
2. In a large bowl, combine all ingredients
3. Mix thoroughly until well combined
4. If mixture is too dry, add more honey 1 teaspoon at a time
5. If mixture is too wet, add more oats 1 tablespoon at a time
6. Roll into 1-inch balls using your hands
7. Place on prepared baking sheet
8. Refrigerate for at least 30 minutes to firm up
9. Transfer to an airtight container

FLAVOR VARIATIONS
- Add 2 tablespoons cocoa powder for chocolate version
- Add 1/4 cup dried cranberries or raisins
- Add 2 tablespoons chia seeds
- Add 1/4 cup shredded coconut
- Use almond butter and add 1/4 cup chopped almonds
- Add 1 tablespoon orange zest
- Use different extracts: almond, coconut, maple

NUTRITION INFORMATION (per ball)
Calories: 120
Protein: 8g
Carbohydrates: 15g
Fiber: 3g
Fat: 5g
Key nutrients: Protein, Healthy fats, Fiber, Iron

STORAGE
- Refrigerate in airtight container for up to 2 weeks
- Freeze for up to 3 months
- Thaw in refrigerator before eating

TIPS FOR CANCER PATIENTS
- Keep in refrigerator for easy snacking
- Take with you to appointments for quick energy
- If mouth sores are an issue, let soften at room temperature
- If taste changes occur, try different flavor variations
- Great for when you need protein but have low appetite

WHEN TO USE
- As a between-meal snack
- Before or after treatment
- When you need quick energy
- When you can't eat a full meal
- For travel or appointments

This recipe was developed by:
Dr. Chathuri Silva
Nutrition Biochemist
ABC Hospital Oncology Department

For more recipes and nutrition advice:
nutrition@abchospital.lk
+94 11 234 5682

© 2026 ABC Hospital. All rights reserved.`;
                break;
                
            default:
                return;
        }
        
        // Create and download the file
        const blob = new Blob([content], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Show confirmation
        alert(`Downloading ${title}...`);
    }

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