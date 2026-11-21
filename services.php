<?php
session_start();
$pageTitle = "Our Services - ABC Virtual Healthcare";
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Comprehensive healthcare services at ABC Hospital - Online appointments, expert doctors, and more">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/service.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    
    <style>
        /* Navigation - Fixed positioning with colored line on top */
        .navbar {
            background: #1a237e;  /* Dark blue background for better contrast */
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-top: 5px solid #ff6b6b;  /* Red line on top of navbar */
            padding: 10px 0;
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
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #ff6b6b;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: white;  /* White text for logo */
        }
        
        .text-highlight {
            color: #ff6b6b;  /* Red highlight for VIRTUAL */
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        
        .nav-links li {
            margin: 0 8px;
        }
        
        .nav-links li a {
            color: white;  /* White text for nav links */
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-links li a:hover {
            background: rgba(255, 107, 107, 0.2);  /* Light red background on hover */
            color: #ff6b6b;  /* Red text on hover */
        }
        
        .nav-links li a.active {
            color: #ff6b6b;  /* Red text for active link */
            font-weight: 600;
        }
        
        /* Login and Register buttons - Exactly the same design */
        .nav-links li a.btn-login,
        .nav-links li a.btn-register {
            background: transparent;
            border: 2px solid #ff6b6b;
            color: #ff6b6b;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
            text-transform: none;
        }
        
        .nav-links li a.btn-login:hover,
        .nav-links li a.btn-register:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }
        
        body {
            padding-top: 90px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Page Header with straight line design */
        .page-header {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            padding: 60px 0;
            text-align: center;
            color: white;
            position: relative;
            border-bottom: 5px solid #ff6b6b;
        }
        
        .page-header h1 {
            font-size: 48px;
            margin-bottom: 15px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .page-header p {
            font-size: 18px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
            color: white;
            padding: 10px 20px;
            display: inline-block;
        }
        
        /* Services Grid */
        .services-grid {
            padding: 80px 0;
            background: #f5f5f9;
        }
        
        .service-category {
            margin-bottom: 70px;
        }
        
        .service-category h2 {
            font-size: 36px;
            color: #1a237e;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
            font-weight: 600;
        }
        
        .service-category h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: #ff6b6b;
            border-radius: 2px;
        }
        
        .service-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
        
        .service-item {
            background: white;
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(26, 35, 126, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 107, 107, 0.1);
        }
        
        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.2);
            border-color: #ff6b6b;
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }
        
        .service-icon i {
            font-size: 35px;
            color: white;
        }
        
        .service-item h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #1a237e;
            font-weight: 600;
        }
        
        .service-item p {
            color: #333;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .service-features {
            list-style: none;
            padding: 0;
        }
        
        .service-features li {
            margin-bottom: 12px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .service-features li i {
            color: #ff6b6b;
            font-size: 16px;
        }
        
        .service-link {
            display: inline-block;
            margin-top: 20px;
            color: #1a237e;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .service-link:hover {
            color: #ff6b6b;
        }
        
        .service-link i {
            transition: transform 0.3s;
        }
        
        .service-link:hover i {
            transform: translateX(8px);
        }
        
        /* Pricing Section */
        .pricing-section {
            padding: 80px 0;
            background: white;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-subtitle {
            color: #ff6b6b;
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .section-title {
            font-size: 42px;
            color: #1a237e;
            margin: 15px 0;
            font-weight: 700;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .section-description {
            color: #333;
            font-size: 18px;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .pricing-card {
            background: #f8f9ff;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
            border: 1px solid rgba(255, 107, 107, 0.2);
        }
        
        .pricing-card:hover {
            transform: translateY(-10px) scale(105%);
            box-shadow: 0 30px 60px rgba(255, 107, 107, 0.15);
            border-color: #ff6b6b;
        }
        
        .pricing-card h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #1a237e;
        }
        
        .price {
            font-size: 36px;
            font-weight: 700;
            color: #ff6b6b;
            margin-bottom: 20px;
        }
        
        .price span {
            font-size: 16px;
            color: #666;
            font-weight: 400;
        }
        
        .btn-book {
            display: inline-block;
            padding: 12px 30px;
            background: #ff6b6b;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
            border: 2px solid #ff6b6b;
        }
        
        .btn-book:hover {
            background: transparent;
            color: #ff6b6b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
        }
        
        /* Footer */
        .footer {
            background: #0a0e27;
            color: #fff;
            padding: 60px 0 20px;
            border-top: 5px solid #ff6b6b;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col p {
            color: #b3b3b3;
            line-height: 1.8;
            margin: 15px 0;
        }
        
        .footer-col h4 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .footer-col ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-col ul li {
            margin-bottom: 10px;
        }
        
        .footer-col ul li a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-col ul li a:hover {
            color: #ff6b6b;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 20px;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        
        .newsletter-form button {
            padding: 10px 15px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #1a237e;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .footer-bottom p {
            color: #b3b3b3;
            margin: 0;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .footer-links a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: #ff6b6b;
        }
        
        /* Back to Top Button */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            transition: all 0.3s;
            z-index: 999;
        }
        
        #backToTop:hover {
            background: #1a237e;
            transform: translateY(-3px);
        }
        
        /* Mobile Menu Toggle */
        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }
        
        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: white;
            margin: 2px 0;
            transition: all 0.3s;
        }
        
        @media (max-width: 768px) {
            .nav-toggle {
                display: flex;
            }
            
            .nav-links {
                display: none !important;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #1a237e;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            }
            
            .nav-links.active {
                display: flex !important;
            }
            
            .nav-links li {
                margin: 10px 0;
                width: 100%;
                text-align: center;
            }
            
            .nav-links li a {
                display: block;
                padding: 12px;
            }
            
            /* Mobile menu buttons */
            .nav-links li a.btn-login,
            .nav-links li a.btn-register {
                display: inline-block;
                width: auto;
                padding: 8px 30px;
            }
            
            .page-header h1 {
                font-size: 36px;
            }
            
            .service-category h2 {
                font-size: 30px;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-fixed">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo $base_url; ?>/index.php" class="logo">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/ff6b6b/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
                </a>
                
                <ul class="nav-links" id="navMenu">
                    <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php" class="active">Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php" class="btn-login">Login</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/register.php" class="btn-register">Register</a></li>
                </ul>
                
                <div class="nav-toggle" id="navToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header with straight line design -->
    <section class="page-header">
        <div class="container">
            <h1 data-aos="fade-up">Our Healthcare Services</h1>
            <p data-aos="fade-up" data-aos-delay="100">Comprehensive medical services tailored to your needs</p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="services-grid">
        <div class="container">
            <!-- Digital Services -->
            <div class="service-category" data-aos="fade-up">
                <h2>Digital Health Services</h2>
                <div class="service-items">
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3>Online Appointments</h3>
                        <p>Book appointments with specialists 24/7 from anywhere in the world.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Real-time availability</li>
                            <li><i class="fas fa-check-circle"></i> Instant confirmation</li>
                            <li><i class="fas fa-check-circle"></i> SMS & Email reminders</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/appointments.php" class="service-link">Book Now <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h3>Video Consultations</h3>
                        <p>Consult with doctors face-to-face from the comfort of your home.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> HD video quality</li>
                            <li><i class="fas fa-check-circle"></i> Secure connection</li>
                            <li><i class="fas fa-check-circle"></i> Digital prescriptions</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/appointments.php" class="service-link">Consult Now <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-file-prescription"></i>
                        </div>
                        <h3>Digital Prescriptions</h3>
                        <p>Get e-prescriptions directly to your phone after consultation.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Instant delivery</li>
                            <li><i class="fas fa-check-circle"></i> Pharmacy integration</li>
                            <li><i class="fas fa-check-circle"></i> Digital records</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/services.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Clinical Services -->
            <div class="service-category" data-aos="fade-up">
                <h2>Clinical Services</h2>
                <div class="service-items">
                    <!-- Cardiology -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Cardiology</h3>
                        <p>Complete heart care with advanced diagnostic and treatment facilities.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> ECG & Echo</li>
                            <li><i class="fas fa-check-circle"></i> Stress tests</li>
                            <li><i class="fas fa-check-circle"></i> Angiography</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=cardiology" class="service-link">Find Cardiologist <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Neurology -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Neurology</h3>
                        <p>Expert care for neurological disorders with modern technology.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> EEG & EMG</li>
                            <li><i class="fas fa-check-circle"></i> Stroke care</li>
                            <li><i class="fas fa-check-circle"></i> Headache clinic</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=neurology" class="service-link">Find Neurologist <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Orthopedics -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-bone"></i>
                        </div>
                        <h3>Orthopedics</h3>
                        <p>Comprehensive treatment for bone and joint problems.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Joint replacement</li>
                            <li><i class="fas fa-check-circle"></i> Sports injuries</li>
                            <li><i class="fas fa-check-circle"></i> Spine surgery</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=orthopedics" class="service-link">Find Orthopedic <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Pediatrics -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-child"></i>
                        </div>
                        <h3>Pediatrics</h3>
                        <p>Specialized healthcare for children from birth to adolescence.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Vaccinations</li>
                            <li><i class="fas fa-check-circle"></i> Growth monitoring</li>
                            <li><i class="fas fa-check-circle"></i> Developmental screening</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=pediatrics" class="service-link">Find Pediatrician <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Oncology -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-ribbon"></i>
                        </div>
                        <h3>Oncology</h3>
                        <p>Comprehensive cancer care with advanced treatment options.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Chemotherapy</li>
                            <li><i class="fas fa-check-circle"></i> Radiation therapy</li>
                            <li><i class="fas fa-check-circle"></i> Immunotherapy</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=oncology" class="service-link">Find Oncologist <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <!-- Dermatology -->
                    <div class="service-item">
                        <div class="service-icon">
                            <i class="fas fa-allergies"></i>
                        </div>
                        <h3>Dermatology</h3>
                        <p>Expert care for skin, hair, and nail conditions.</p>
                        <ul class="service-features">
                            <li><i class="fas fa-check-circle"></i> Skin treatments</li>
                            <li><i class="fas fa-check-circle"></i> Laser therapy</li>
                            <li><i class="fas fa-check-circle"></i> Cosmetic dermatology</li>
                        </ul>
                        <a href="<?php echo $base_url; ?>/doctors.php?specialty=dermatology" class="service-link">Find Dermatologist <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Pricing</span>
                <h2 class="section-title">Simple & <span class="text-gradient">Transparent Pricing</span></h2>
                <p class="section-description">Quality healthcare at affordable prices</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card" data-aos="fade-up">
                    <h3>General Consultation</h3>
                    <div class="price">LKR 1,500 <span>/ visit</span></div>
                    <ul class="service-features" style="text-align: left; margin-bottom: 25px;">
                        <li><i class="fas fa-check-circle"></i> 30 min consultation</li>
                        <li><i class="fas fa-check-circle"></i> Basic examination</li>
                        <li><i class="fas fa-check-circle"></i> Prescription</li>
                        <li><i class="fas fa-check-circle"></i> Follow-up in 2 weeks</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/appointments.php" class="btn-book">Book Now</a>
                </div>

                <div class="pricing-card" data-aos="fade-up" data-aos-delay="100">
                    <h3>Specialist Consultation</h3>
                    <div class="price">LKR 2,500 <span>/ visit</span></div>
                    <ul class="service-features" style="text-align: left; margin-bottom: 25px;">
                        <li><i class="fas fa-check-circle"></i> 45 min consultation</li>
                        <li><i class="fas fa-check-circle"></i> Specialist examination</li>
                        <li><i class="fas fa-check-circle"></i> Digital prescription</li>
                        <li><i class="fas fa-check-circle"></i> Follow-up included</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/appointments.php" class="btn-book">Book Now</a>
                </div>

                <div class="pricing-card" data-aos="fade-up" data-aos-delay="200">
                    <h3>Video Consultation</h3>
                    <div class="price">LKR 1,000 <span>/ session</span></div>
                    <ul class="service-features" style="text-align: left; margin-bottom: 25px;">
                        <li><i class="fas fa-check-circle"></i> 20 min video call</li>
                        <li><i class="fas fa-check-circle"></i> Digital prescription</li>
                        <li><i class="fas fa-check-circle"></i> Medicine delivery</li>
                        <li><i class="fas fa-check-circle"></i> Online follow-up</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/appointments.php" class="btn-book">Book Now</a>
                </div>

                <div class="pricing-card" data-aos="fade-up" data-aos-delay="300">
                    <h3>Health Package</h3>
                    <div class="price">LKR 5,000 <span>/ year</span></div>
                    <ul class="service-features" style="text-align: left; margin-bottom: 25px;">
                        <li><i class="fas fa-check-circle"></i> 4 consultations/year</li>
                        <li><i class="fas fa-check-circle"></i> Basic health checkup</li>
                        <li><i class="fas fa-check-circle"></i> 20% off on tests</li>
                        <li><i class="fas fa-check-circle"></i> Priority booking</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/pages/register.php" class="btn-book">Join Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer with all links -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" style="width: 60px; height: 60px; margin-bottom: 15px; border-radius: 50%; border: 2px solid #ff6b6b;">
                    <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/abchospital" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/abchospital" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/abchospital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/abchospital" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/abchospital" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                        <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                        <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                        <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
                        <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                        <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                        <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Our Portals</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=patient">Patient Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=doctor">Doctor Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=admin">Admin Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist">Receptionist Portal</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Subscribe for health tips and updates</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                        <input type="email" placeholder="Your Email" required>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 ABC Hospital. All rights reserved.</p>
                <div class="footer-links">
                    <a href="<?php echo $base_url; ?>/terms-of-use.php">Terms of Use</a>
                    <a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a>
                    <a href="<?php echo $base_url; ?>/cookie-policy.php">Cookie Policy</a>
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

        // Mobile menu toggle
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        // Back to top button
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

        if (backToTop) {
            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Preloader hide
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }
        });
    </script>
</body>
</html>