<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Groups - ABC Hospital | Cancer Support Community</title>

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
        
        .groups-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .group-card {
            background: linear-gradient(135deg, #f9f0ff, #f5e6ff);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s;
            border: 1px solid #e0c0ff;
        }
        
        .group-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(160, 68, 255, 0.15);
        }
        
        .group-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #a044ff, #6a3093);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .group-icon i {
            font-size: 30px;
            color: white;
        }
        
        .group-card h4 {
            font-size: 18px;
            color: #6a3093;
            margin-bottom: 10px;
        }
        
        .group-card p {
            color: #5a6a7a;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .group-schedule {
            background: white;
            padding: 10px;
            border-radius: 10px;
            font-size: 13px;
            color: #a044ff;
            font-weight: 600;
        }
        
        .group-schedule i {
            margin-right: 5px;
        }
        
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .schedule-table th {
            background: #6a3093;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 500;
        }
        
        .schedule-table td {
            padding: 12px;
            border-bottom: 1px solid #eef2f6;
        }
        
        .schedule-table tr:hover {
            background: #f9f0ff;
        }
        
        .benefits-list {
            list-style: none;
        }
        
        .benefits-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .benefits-list li i {
            color: #a044ff;
            font-size: 18px;
            margin-top: 3px;
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
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-card .contact-info i {
            color: #f0e68c;
        }
        
        .btn-register-group {
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
        
        .btn-register-group:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.3);
        }
        
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
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
        }
        
        .faq-item:hover {
            box-shadow: 0 10px 25px rgba(160, 68, 255, 0.1);
        }
        
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-question h4 {
            color: #6a3093;
            font-size: 18px;
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
        
        .resources-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 40px 0;
        }
        
        .resource-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        
        .resource-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(160, 68, 255, 0.15);
        }
        
        .resource-item i {
            font-size: 30px;
            color: #a044ff;
            margin-bottom: 15px;
        }
        
        .resource-item h4 {
            color: #6a3093;
            font-size: 16px;
        }
        
        /* ===== MODAL STYLES ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            animation: slideUp 0.3s;
        }
        
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f5fa;
        }
        
        .modal-header h2 {
            color: #6a3093;
            font-size: 24px;
        }
        
        .modal-header h2 i {
            color: #a044ff;
            margin-right: 10px;
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            color: #95a5a6;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .close-modal:hover {
            color: #a044ff;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #eef2f6;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #a044ff;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .checkbox-group input {
            width: auto;
            margin-top: 3px;
        }
        
        .checkbox-group label {
            font-size: 14px;
            color: #5a6a7a;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #a044ff, #6a3093);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            font-size: 16px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(160, 68, 255, 0.3);
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
            padding: 12px;
            border: none;
            border-radius: 30px 0 0 30px;
            outline: none;
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
        }
        
        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .groups-grid {
                grid-template-columns: 1fr;
            }
            
            .resources-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
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
            <h1><i class="fas fa-users"></i> Support Groups</h1>
            <p>Connect with others who understand your journey in a safe, supportive environment</p>
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
        <span class="current">Support Groups</span>
    </div>
</div>

<!-- MAIN CONTENT -->
<section class="main-content">
    <div class="container">
        <div class="content-grid">
            <div class="content-left">
                <div data-aos="fade-up">
                    <h2>You Are <span>Not Alone</span></h2>
                    <p>Our support groups bring together patients, survivors, and caregivers who share similar experiences. In these safe, confidential meetings, you'll find understanding, encouragement, and practical advice from people who truly understand what you're going through.</p>
                    
                    <p>Facilitated by trained professionals, our support groups provide a space to share feelings, learn coping strategies, and build meaningful connections with others on a similar journey.</p>
                </div>
                
                <div class="info-card" data-aos="fade-up">
                    <h3><i class="fas fa-hand-holding-heart"></i> Benefits of Support Groups</h3>
                    <ul class="benefits-list">
                        <li><i class="fas fa-check-circle"></i> <strong>Emotional Support:</strong> Share feelings with people who truly understand</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Practical Advice:</strong> Learn tips and strategies from others' experiences</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Reduced Isolation:</strong> Connect with others facing similar challenges</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Hope and Inspiration:</strong> See how others are coping and thriving</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Educational Resources:</strong> Access information about treatments and services</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Family Support:</strong> Special groups for caregivers and family members</li>
                    </ul>
                </div>
                
                <h3 data-aos="fade-up">Available Support Groups</h3>
                <div class="groups-grid" data-aos="fade-up">
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <h4>Breast Cancer Support</h4>
                        <p>For women at any stage of breast cancer diagnosis and treatment</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Tuesdays, 3:00 PM
                        </div>
                    </div>
                    
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-lungs"></i>
                        </div>
                        <h4>Lung Cancer Support</h4>
                        <p>For patients and families affected by lung cancer</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Wednesdays, 2:00 PM
                        </div>
                    </div>
                    
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4>GI Cancer Support</h4>
                        <p>For colorectal, stomach, pancreatic, and liver cancer patients</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Thursdays, 4:00 PM
                        </div>
                    </div>
                    
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Caregivers Support</h4>
                        <p>For family members and friends caring for cancer patients</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Mondays, 6:00 PM
                        </div>
                    </div>
                    
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4>Young Adult Cancer</h4>
                        <p>For patients and survivors ages 18-40</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Fridays, 5:30 PM
                        </div>
                    </div>
                    
                    <div class="group-card">
                        <div class="group-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4>Survivors Circle</h4>
                        <p>For those who have completed treatment</p>
                        <div class="group-schedule">
                            <i class="fas fa-calendar"></i> Saturdays, 10:00 AM
                        </div>
                    </div>
                </div>
                
                <h3 data-aos="fade-up">Weekly Schedule</h3>
                <table class="schedule-table" data-aos="fade-up">
                    <tr>
                        <th>Day</th>
                        <th>Group</th>
                        <th>Time</th>
                        <th>Facilitator</th>
                    </tr>
                    <tr>
                        <td>Monday</td>
                        <td>Caregivers Support</td>
                        <td>6:00 PM - 7:30 PM</td>
                        <td>Ms. Kamini Perera</td>
                    </tr>
                    <tr>
                        <td>Tuesday</td>
                        <td>Breast Cancer Support</td>
                        <td>3:00 PM - 4:30 PM</td>
                        <td>Dr. Priyani Jayawardena</td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>Lung Cancer Support</td>
                        <td>2:00 PM - 3:30 PM</td>
                        <td>Dr. Nuwan Silva</td>
                    </tr>
                    <tr>
                        <td>Thursday</td>
                        <td>GI Cancer Support</td>
                        <td>4:00 PM - 5:30 PM</td>
                        <td>Ms. Kamini Perera</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>Young Adult Cancer</td>
                        <td>5:30 PM - 7:00 PM</td>
                        <td>Dr. Priyani Jayawardena</td>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td>Survivors Circle</td>
                        <td>10:00 AM - 11:30 AM</td>
                        <td>Dr. Nuwan Silva</td>
                    </tr>
                </table>
                
                <div class="resources-grid" data-aos="fade-up">
                    <div class="resource-item">
                        <i class="fas fa-book-open"></i>
                        <h4>Resource Library</h4>
                    </div>
                    <div class="resource-item">
                        <i class="fas fa-video"></i>
                        <h4>Virtual Meetings</h4>
                    </div>
                    <div class="resource-item">
                        <i class="fas fa-phone"></i>
                        <h4>Phone Support</h4>
                    </div>
                </div>
                
                <div class="faq-section" data-aos="fade-up">
                    <h3>Frequently Asked Questions</h3>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Are support groups confidential?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, all support groups are strictly confidential. What is shared in the group stays in the group, creating a safe space for everyone.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Do I need to register in advance?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            While walk-ins are welcome, we recommend registering in advance to ensure we have enough space and resources for everyone.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Can family members attend?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we have specific groups for family members and caregivers. Please check the schedule for appropriate groups.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Is there a cost to join?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            All support groups are free of charge for ABC Hospital patients and their families.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-right">
                <div class="sidebar-card" data-aos="fade-left">
                    <h3><i class="fas fa-users"></i> Join a Support Group</h3>
                    <p>Connect with others who understand your journey. All groups are free and confidential.</p>
                    <div class="contact-info">
                        <div><i class="fas fa-phone"></i> <strong>Group Coordinator:</strong> +94 11 234 5681</div>
                        <div><i class="fas fa-envelope"></i> <strong>Email:</strong> supportgroups@abchospital.lk</div>
                        <div><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> Cancer Support Center, 2nd Floor</div>
                    </div>
                    <a href="#" class="btn-register-group" onclick="openRegistrationModal(); return false;">
                        <i class="fas fa-user-plus"></i> Register for a Group
                    </a>
                </div>
                
                <div class="testimonial-card" data-aos="fade-left" data-aos-delay="100">
                    <i class="fas fa-quote-left"></i>
                    <p>"The support group gave me a place where I could be honest about my fears and frustrations. The women in my breast cancer group became my second family. I don't know how I would have gotten through treatment without them."</p>
                    <div class="testimonial-author">
                        <img src="images/dept/Malini Fernando.jpg" alt="Patient" onerror="this.src='https://via.placeholder.com/60x60'">
                        <div class="author-info">
                            <h4>Malini Fernando</h4>
                            <p>Breast Cancer Survivor</p>
                        </div>
                    </div>
                </div>
                
                <div class="info-card" data-aos="fade-left" data-aos-delay="200">
                    <h3><i class="fas fa-clock"></i> Group Guidelines</h3>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #a044ff; margin-right: 8px;"></i> Confidentiality is respected</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #a044ff; margin-right: 8px;"></i> No medical advice, only shared experiences</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #a044ff; margin-right: 8px;"></i> Respectful listening to all members</li>
                        <li style="margin-bottom: 12px;"><i class="fas fa-check-circle" style="color: #a044ff; margin-right: 8px;"></i> Come as you are - no pressure to share</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- REGISTRATION MODAL -->
<div id="registrationModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-users"></i> Support Group Registration</h2>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        
        <form id="groupRegistrationForm" onsubmit="submitRegistration(event)">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" id="firstName" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" id="lastName" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" id="email" required>
            </div>
            
            <div class="form-group">
                <label>Phone Number *</label>
                <input type="tel" id="phone" required>
            </div>
            
            <div class="form-group">
                <label>Select Support Group *</label>
                <select id="groupType" required>
                    <option value="">Choose a group...</option>
                    <option value="breast-cancer">Breast Cancer Support (Tuesdays 3:00 PM)</option>
                    <option value="lung-cancer">Lung Cancer Support (Wednesdays 2:00 PM)</option>
                    <option value="gi-cancer">GI Cancer Support (Thursdays 4:00 PM)</option>
                    <option value="caregivers">Caregivers Support (Mondays 6:00 PM)</option>
                    <option value="young-adult">Young Adult Cancer (Fridays 5:30 PM)</option>
                    <option value="survivors">Survivors Circle (Saturdays 10:00 AM)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>How did you hear about us?</label>
                <input type="text" id="referral" placeholder="e.g., Doctor referral, Website, Friend">
            </div>
            
            <div class="form-group">
                <label>Any specific concerns or questions?</label>
                <textarea id="questions" rows="3" placeholder="Tell us anything you'd like us to know..."></textarea>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="consent" required>
                <label for="consent">I agree to the <a href="#" style="color: #a044ff;">terms and conditions</a> and confirm that the information provided is accurate. I understand that all group discussions are confidential.</label>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Submit Registration
            </button>
        </form>
    </div>
</div>

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
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
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

    // Modal Functions
    const modal = document.getElementById('registrationModal');

    function openRegistrationModal() {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scrolling
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Handle form submission
    function submitRegistration(event) {
        event.preventDefault();
        
        // Get form values
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const groupType = document.getElementById('groupType');
        const selectedGroup = groupType.options[groupType.selectedIndex].text;
        
        // Show success message
        alert(`Thank you ${firstName} ${lastName} for registering!\n\nWe have received your registration for: ${selectedGroup}\nA confirmation email will be sent to: ${email}\n\nOur group coordinator will contact you at ${phone} within 24 hours to provide more details about the group meeting.`);
        
        // Reset form and close modal
        document.getElementById('groupRegistrationForm').reset();
        closeModal();
    }

    // Escape key to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });
</script>

</body> 
</html>