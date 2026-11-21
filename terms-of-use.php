<?php
session_start();
$pageTitle = "ABC Virtual Healthcare | Terms of Use";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Clear, patient-friendly terms for using ABC Hospital's virtual care platform.">
    <meta name="keywords" content="terms of use, healthcare terms, telemedicine terms, ABC Hospital">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/ABC logo.webp">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts: Poppins (matching index.php) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9ff; /* Matching homepage background */
            color: #1c2e4a;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* Navigation - Matching index.php */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }

        .text-highlight {
            color: #ffd700;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 12px;
            border-radius: 8px;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .btn-login {
            background: transparent !important;
            border: 2px solid #ff6b6b !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }

        .btn-login:hover {
            background: #ff6b6b !important;
            color: white !important;
        }

        .btn-register {
            background: #ff6b6b !important;
            border: 2px solid #ff6b6b !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }

        .btn-register:hover {
            background: #ff5252 !important;
            transform: translateY(-2px) !important;
        }

        /* Header with gradient matching index */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" opacity="0.1"><path d="M40 50 L80 30 L120 50 L160 30 L180 50" stroke="white" fill="none" stroke-width="3"/><circle cx="80" cy="120" r="12" fill="white"/><circle cx="140" cy="150" r="20" fill="white"/></svg>');
            background-size: 400px;
            pointer-events: none;
        }

        .page-header .container {
            position: relative;
            z-index: 2;
        }

        .page-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .page-header h1 i {
            background: rgba(255,255,255,0.15);
            padding: 15px 25px;
            border-radius: 60px;
            margin-right: 20px;
            backdrop-filter: blur(5px);
        }

        .header-tagline {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 700px;
            margin-bottom: 30px;
        }

        .header-image {
            position: absolute;
            right: 5%;
            bottom: 0;
            width: 300px;
            height: auto;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 900px) {
            .header-image { opacity: 0.2; right: -20px; }
        }

        /* Breadcrumb */
        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .breadcrumb a:hover {
            color: #ffd700;
        }

        /* Main Content Card */
        .content-card {
            background: white;
            border-radius: 50px;
            box-shadow: 0 30px 60px -20px rgba(102, 126, 234, 0.3);
            padding: 60px;
            margin: -40px auto 60px;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255,255,255,0.5);
        }

        /* Last Updated Badge */
        .last-updated {
            background: linear-gradient(135deg, #667eea20, #764ba220);
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            font-weight: 500;
            color: #4f46e5;
            border-left: 6px solid #4f46e5;
            margin-bottom: 40px;
        }

        /* Image Grid */
        .img-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin: 40px 0;
            justify-content: center;
        }

        .img-card {
            background: white;
            border-radius: 30px;
            padding: 30px 20px 25px;
            text-align: center;
            flex: 1 1 200px;
            max-width: 240px;
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.15);
            border: 1px solid #f0f0ff;
            transition: all 0.3s;
        }

        .img-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 40px rgba(102, 126, 234, 0.25);
        }

        .img-card img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.2);
            background: #f0f3ff;
        }

        .img-card p {
            margin-top: 20px;
            font-weight: 600;
            color: #4f46e5;
        }

        /* Table of Contents */
        .toc {
            background: linear-gradient(135deg, #f5f7ff, #f0f3ff);
            border-radius: 30px;
            padding: 40px;
            margin: 40px 0;
            border: 1px solid #ffffff;
        }

        .toc h3 {
            font-size: 2rem;
            color: #4f46e5;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .toc-item {
            background: white;
            padding: 12px 20px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.1);
            transition: all 0.3s;
        }

        .toc-item:hover {
            transform: translateX(8px);
            background: #4f46e5;
        }

        .toc-item:hover a {
            color: white;
        }

        .toc-item a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 500;
            display: block;
        }

        /* Section Headers */
        h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 60px 0 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #e2e8f0;
            scroll-margin-top: 100px;
        }

        h2 i {
            color: #4f46e5;
            margin-right: 15px;
            background: #eef2ff;
            padding: 10px;
            border-radius: 15px;
        }

        h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3a5e;
            margin: 30px 0 15px;
            padding-left: 20px;
            border-left: 5px solid #4f46e5;
        }

        /* Highlight Box */
        .alert-box {
            background: linear-gradient(135deg, #fff3cd, #ffe69b);
            border-radius: 20px;
            padding: 25px 35px;
            margin: 30px 0;
            border-left: 8px solid #ffc107;
            font-size: 1.1rem;
        }

        .alert-box i {
            color: #dc3545;
            margin-right: 15px;
            font-size: 1.5rem;
        }

        /* Lists */
        ul, ol {
            margin: 20px 0;
            padding-left: 30px;
        }

        li {
            margin-bottom: 12px;
            color: #475569;
        }

        li i {
            color: #4f46e5;
            margin-right: 10px;
        }

        /* Contact Info */
        .contact-info {
            background: linear-gradient(135deg, #667eea10, #764ba210);
            border-radius: 30px;
            padding: 40px;
            margin-top: 40px;
        }

        .contact-info ul {
            list-style: none;
            padding: 0;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .contact-info i {
            font-size: 1.3rem;
            color: #4f46e5;
        }

        /* Social Media Section - Enhanced */
        .social-connect {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 40px;
            padding: 50px;
            margin: 50px 0;
            text-align: center;
            color: white;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }

        .social-connect h3 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            border-left: none;
            color: white;
        }

        .social-connect p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .social-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .social-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255,255,255,0.3);
        }

        .social-circle:hover {
            transform: translateY(-10px) scale(1.1);
            background: white;
        }

        .social-circle:hover i {
            color: #4f46e5;
        }

        .social-circle i {
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s;
        }

        /* Footer - Matching index.php exactly */
        .footer {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 60px 0 30px;
            margin-top: 60px;
            border-radius: 50px 50px 0 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-logo img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        .footer-logo span {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .footer h4 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #ffd700;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 12px;
        }

        .footer ul li a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer ul li a:hover {
            color: #ffd700;
            transform: translateX(5px);
        }

        /* Footer Social Links - Fixed with working URLs */
        .footer-social {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .footer-social a {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .footer-social a:hover {
            background: #ffd700;
            color: #1e293b;
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom-links a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 25px;
            transition: color 0.3s;
        }

        .footer-bottom-links a:hover {
            color: #ffd700;
        }

        .text-danger {
            color: #ff6b6b;
        }

        /* Back to Top Button */
        #backToTop {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background: #4f46e5;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 5px 20px rgba(79, 70, 229, 0.4);
            transition: all 0.3s;
            z-index: 100;
        }

        #backToTop:hover {
            background: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .content-card { padding: 30px; }
            h2 { font-size: 1.8rem; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .footer-bottom-links a { margin: 0 10px; }
            .social-circle { width: 60px; height: 60px; }
            .social-circle i { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" style="position: fixed; top:0; left:0; right:0; bottom:0; background:white; z-index:9999; display:flex; justify-content:center; align-items:center;">
        <div class="loader" style="width:50px; height:50px; border:5px solid #f3f3f3; border-top:5px solid #4f46e5; border-radius:50%; animation:spin 1s linear infinite;"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="index.php" class="logo">
                    <img src="images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
                </a>
                
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="doctors.php">Doctors</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="departments.php">Departments</a></li>
                    <li><a href="appointments.php">Appointments</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="pages/login.php" class="btn-login">Login</a></li>
                    <li><a href="pages/register.php" class="btn-register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="page-header">
        <img class="header-image" src="images/legal-healthcare.jpg" alt="Legal Healthcare" onerror="this.style.display='none'">
        <div class="container">
            <div class="breadcrumb" data-aos="fade-up">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Terms of Use</span>
            </div>
            
            <h1 data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-file-contract"></i> 
                Terms of Use
            </h1>
            
            <p class="header-tagline" data-aos="fade-up" data-aos-delay="200">
                Clear, fair, and designed with your well‑being in mind
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="content-card" data-aos="fade-up">
            <div class="last-updated">
                <i class="fas fa-calendar-check"></i> 
                Last Revised: 22 February 2026 · Colombo, Sri Lanka
            </div>

            <!-- Image Cards -->
            <div class="img-grid">
                <div class="img-card" data-aos="zoom-in" data-aos-delay="100">
                    <img src="images/consent.jpg" alt="Informed Consent" onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Consent';">
                    <p><i class="fas fa-hand-holding-heart"></i> Informed Consent</p>
                </div>
                <div class="img-card" data-aos="zoom-in" data-aos-delay="200">
                    <img src="images/privacy.webp" alt="Privacy Shield" onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Privacy';">
                    <p><i class="fas fa-shield-alt"></i> Data Protection</p>
                </div>
                <div class="img-card" data-aos="zoom-in" data-aos-delay="300">
                    <img src="images/telehealth.jpg" alt="Telemedicine" onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Telehealth';">
                    <p><i class="fas fa-video"></i> Telemedicine</p>
                </div>
            </div>

            <!-- Table of Contents -->
            <div class="toc" data-aos="fade-up">
                <h3><i class="fas fa-list-ul"></i> On This Page</h3>
                <div class="toc-grid">
                    <div class="toc-item"><a href="#agreement"><i class="fas fa-chevron-right"></i> 1. Agreement</a></div>
                    <div class="toc-item"><a href="#services"><i class="fas fa-chevron-right"></i> 2. Services</a></div>
                    <div class="toc-item"><a href="#accounts"><i class="fas fa-chevron-right"></i> 3. Accounts</a></div>
                    <div class="toc-item"><a href="#appointments"><i class="fas fa-chevron-right"></i> 4. Appointments</a></div>
                    <div class="toc-item"><a href="#conduct"><i class="fas fa-chevron-right"></i> 5. Conduct</a></div>
                    <div class="toc-item"><a href="#privacy"><i class="fas fa-chevron-right"></i> 6. Privacy</a></div>
                    <div class="toc-item"><a href="#telemedicine"><i class="fas fa-chevron-right"></i> 7. Telemedicine</a></div>
                    <div class="toc-item"><a href="#payments"><i class="fas fa-chevron-right"></i> 8. Payments</a></div>
                    <div class="toc-item"><a href="#liability"><i class="fas fa-chevron-right"></i> 9. Liability</a></div>
                    <div class="toc-item"><a href="#termination"><i class="fas fa-chevron-right"></i> 10. Termination</a></div>
                    <div class="toc-item"><a href="#changes"><i class="fas fa-chevron-right"></i> 11. Changes</a></div>
                    <div class="toc-item"><a href="#contact"><i class="fas fa-chevron-right"></i> 12. Contact</a></div>
                </div>
            </div>

            <p style="font-size: 1.2rem; color: #2d3a5e; margin-bottom: 30px;">
                These Terms of Use form a transparent agreement between you and ABC Hospital. 
                Please read them carefully; they protect both your rights and our ability to provide safe care.
            </p>

            <!-- Agreement Section -->
            <h2 id="agreement"><i class="fas fa-hand-peace"></i> 1. Agreement to Terms</h2>
            <p>By accessing or using ABC Virtual Healthcare, you agree to be bound by these Terms of Use and our Privacy Policy. If you do not agree to all these terms, please do not use our services. These terms constitute a legally binding agreement between you and ABC Hospital (PVT) Ltd, a company registered in Sri Lanka (Registration No: PVT123456).</p>

            <!-- Services Section -->
            <h2 id="services"><i class="fas fa-stethoscope"></i> 2. Description of Services</h2>
            <p>ABC Virtual Healthcare provides a digital platform that enables:</p>
            <ul>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Scheduling appointments with healthcare practitioners</li>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Telemedicine consultations via secure video/audio</li>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Access to medical records and prescriptions</li>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Secure messaging with clinical staff</li>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Billing and payment management</li>
                <li><i class="fas fa-check-circle" style="color:#4f46e5;"></i> Health education resources and reminders</li>
            </ul>

            <div class="alert-box">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>IMPORTANT MEDICAL DISCLAIMER:</strong> ABC Virtual is NOT for medical emergencies. 
                If you have a life-threatening condition, call Sri Lanka Emergency Services immediately at <strong>1990</strong> 
                or visit the nearest hospital emergency room.
            </div>

            <!-- Accounts Section -->
            <h2 id="accounts"><i class="fas fa-id-card"></i> 3. User Accounts & Registration</h2>
            <p>To access certain features, you must register for an account. You represent and warrant that:</p>
            <ul>
                <li><i class="fas fa-check"></i> You are at least 18 years of age. If you are under 18, a parent or guardian must create and manage the account on your behalf.</li>
                <li><i class="fas fa-check"></i> All registration information you provide is true, accurate, current, and complete.</li>
                <li><i class="fas fa-check"></i> You will maintain the security of your account credentials and promptly notify us of any unauthorized use.</li>
                <li><i class="fas fa-check"></i> You are responsible for all activities that occur under your account.</li>
            </ul>

            <!-- Appointments Section -->
            <h2 id="appointments"><i class="fas fa-calendar-alt"></i> 4. Appointments & Cancellations</h2>
            
            <h3>4.1 Booking Appointments</h3>
            <p>Appointments can be booked through our platform up to 30 days in advance. You will receive confirmation via email and SMS. Please arrive (or log in) at least 10 minutes before your scheduled time.</p>
            
            <h3>4.2 Cancellation and Rescheduling</h3>
            <ul>
                <li><i class="fas fa-clock"></i> <strong>Free cancellation:</strong> Up to 4 hours before the appointment time.</li>
                <li><i class="fas fa-exclamation-circle"></i> <strong>Late cancellation (less than 4 hours):</strong> A fee of LKR 500 may be charged.</li>
                <li><i class="fas fa-times-circle"></i> <strong>No-show:</strong> Failure to attend without cancellation will incur the full consultation fee.</li>
                <li><i class="fas fa-repeat"></i> <strong>Repeated no-shows:</strong> May result in restrictions on future bookings.</li>
                <li><i class="fas fa-hospital"></i> <strong>Doctor cancellations:</strong> If your doctor cancels, you will receive full refund or priority rescheduling.</li>
            </ul>

            <!-- Conduct Section -->
            <h2 id="conduct"><i class="fas fa-gavel"></i> 5. User Conduct</h2>
            <p>You agree not to engage in any of the following prohibited activities:</p>
            <ul>
                <li><i class="fas fa-ban"></i> Using the service for any unlawful purpose or to violate any laws</li>
                <li><i class="fas fa-ban"></i> Harassing, abusing, or threatening healthcare providers or staff</li>
                <li><i class="fas fa-ban"></i> Impersonating any person or entity</li>
                <li><i class="fas fa-ban"></i> Attempting to bypass security measures or scrape data</li>
                <li><i class="fas fa-ban"></i> Sharing false or misleading medical information</li>
                <li><i class="fas fa-ban"></i> Recording consultations without explicit consent from all parties</li>
                <li><i class="fas fa-ban"></i> Using the platform for commercial purposes without authorization</li>
            </ul>

            <!-- Privacy Section -->
            <h2 id="privacy"><i class="fas fa-shield-alt"></i> 6. Privacy & Data Protection</h2>
            <p>Your privacy is paramount. We handle your information in accordance with our <a href="privacy-policy.html" style="color:#4f46e5;">Privacy Policy</a> and the Sri Lanka Personal Data Protection Act No. 9 of 2022. Key points:</p>
            <ul>
                <li><i class="fas fa-lock"></i> We never sell your personal data</li>
                <li><i class="fas fa-video"></i> Video consultations may be recorded for quality assurance and training (with prior notice)</li>
                <li><i class="fas fa-file"></i> You have the right to access, correct, and request deletion of your data</li>
                <li><i class="fas fa-shield"></i> All data is encrypted both in transit and at rest</li>
            </ul>

            <!-- Telemedicine Section -->
            <h2 id="telemedicine"><i class="fas fa-video"></i> 7. Telemedicine Services</h2>
            <ul>
                <li><i class="fas fa-check"></i> Telemedicine consultations are not a substitute for in-person medical exams when physically necessary.</li>
                <li><i class="fas fa-check"></i> Your doctor may recommend an in-person follow-up if clinically indicated.</li>
                <li><i class="fas fa-check"></i> You must be in a private, confidential setting during the consultation.</li>
                <li><i class="fas fa-check"></i> Technical issues may occasionally occur; we will reschedule if connectivity problems disrupt your appointment.</li>
                <li><i class="fas fa-check"></i> Not all conditions can be diagnosed or treated via telemedicine.</li>
            </ul>

            <!-- Payments Section -->
            <h2 id="payments"><i class="fas fa-credit-card"></i> 8. Payments & Billing</h2>
            <ul>
                <li><i class="fas fa-money-bill"></i> All consultation fees are clearly displayed before booking confirmation.</li>
                <li><i class="fas fa-credit-card"></i> We accept Visa, Mastercard, American Express, and local digital wallets.</li>
                <li><i class="fas fa-undo"></i> Refunds are processed within 5-7 business days to the original payment method.</li>
                <li><i class="fas fa-file-invoice"></i> Insurance claims and reimbursements are the patient's responsibility.</li>
                <li><i class="fas fa-receipt"></i> Digital receipts are available in your account dashboard.</li>
            </ul>

            <!-- Liability Section -->
            <h2 id="liability"><i class="fas fa-scale-balanced"></i> 9. Limitation of Liability</h2>
            <p>To the maximum extent permitted by Sri Lankan law:</p>
            <ul>
                <li>ABC Hospital shall not be liable for indirect, incidental, special, consequential, or punitive damages.</li>
                <li>We are not liable for any loss of data, profits, or business opportunities.</li>
                <li>Our total liability shall not exceed the amount you paid for the specific service giving rise to the claim.</li>
                <li>We do not guarantee uninterrupted or error-free service.</li>
            </ul>

            <!-- Termination Section -->
            <h2 id="termination"><i class="fas fa-stop-circle"></i> 10. Termination</h2>
            <p>We may suspend or terminate your account if you violate these terms. You may terminate your account at any time by:</p>
            <ul>
                <li>Contacting support at <a href="mailto:support@abchospital.lk" style="color:#4f46e5;">support@abchospital.lk</a></li>
                <li>Using the account deletion feature in your settings</li>
            </ul>
            <p>Certain provisions (including privacy, liability, and dispute resolution) survive termination.</p>

            <!-- Changes Section -->
            <h2 id="changes"><i class="fas fa-pen"></i> 11. Changes to Terms</h2>
            <p>We may update these Terms of Use from time to time. Material changes will be communicated via email at least 30 days in advance. Your continued use of the platform after changes constitutes acceptance of the revised terms.</p>

            <!-- Contact Section -->
            <h2 id="contact"><i class="fas fa-address-card"></i> 12. Contact Information</h2>
            
            <div class="contact-info">
                <p>For questions about these Terms or any other inquiries:</p>
                <ul>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email:</strong><br>
                            <a href="mailto:legal@abchospital.lk" style="color:#4f46e5;">legal@abchospital.lk</a>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <div>
                            <strong>Phone:</strong><br>
                            +94 11 234 5678 (Mon-Fri, 9am-5pm)
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Address:</strong><br>
                            ABC Hospital, 123 Hospital Road,<br>
                            Colombo 05, Sri Lanka
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Social Media Connect Section - Enhanced -->
            <div class="social-connect" data-aos="zoom-in">
                <h3><i class="fas fa-share-alt"></i> Connect With Us</h3>
                <p>Follow us on social media for health tips, updates, and community news</p>
                <div class="social-grid">
                    <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Trust Badge -->
            <div style="text-align: center; margin-top: 30px;">
                <img src="images/ABC+trust+badge.jpg" alt="ABC Hospital Trust Badge" style="max-width: 200px; border-radius: 20px;" onerror="this.style.display='none'">
                <p style="margin-top: 15px; color: #94a3b8;">
                    <i class="fas fa-check-circle" style="color:#4f46e5;"></i> 
                    Last Updated: February 22, 2026
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                        <span>ABC VIRTUAL</span>
                    </div>
                    <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                    <!-- Footer Social Links with working URLs -->
                    <div class="footer-social">
                        <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                        <li><a href="services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="departments.php"><i class="fas fa-chevron-right"></i> Departments</a></li>
                        <li><a href="appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                        <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Our Portals</h4>
                    <ul>
                        <li><a href="pages/login.php?type=patient"><i class="fas fa-chevron-right"></i> Patient Portal</a></li>
                        <li><a href="pages/login.php?type=doctor"><i class="fas fa-chevron-right"></i> Doctor Portal</a></li>
                        <li><a href="pages/login.php?type=admin"><i class="fas fa-chevron-right"></i> Admin Portal</a></li>
                        <li><a href="pages/login.php?type=receptionist"><i class="fas fa-chevron-right"></i> Receptionist Portal</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="terms-of-use.php"><i class="fas fa-chevron-right"></i> Terms of Use</a></li>
                        <li><a href="privacy-policy.php"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                        <li><a href="cookie-policy.php"><i class="fas fa-chevron-right"></i> Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 ABC Virtual Healthcare – Clarity & Care. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> for better healthcare</p>
                <div class="footer-bottom-links">
                    <a href="index.php">Home</a>
                    <a href="privacy-policy.php">Privacy</a>
                    <a href="cookie-policy.php">Cookies</a>
                    <a href="contact.php">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Preloader
        window.addEventListener('load', function() {
            document.querySelector('.preloader').style.display = 'none';
        });

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
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

        // Make all external links open in new tab with security attributes
        document.querySelectorAll('a[href^="http"]').forEach(link => {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        });
    </script>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</body>
</html>