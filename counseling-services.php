<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counseling Services - ABC Hospital | Cancer Support</title>

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
        
        .counselor-list {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .counselor-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s;
        }
        
        .counselor-item:hover {
            background: linear-gradient(135deg, #f9f0ff, #f5e6ff);
            transform: translateX(5px);
        }
        
        .counselor-item i {
            font-size: 30px;
            color: #a044ff;
        }
        
        .counselor-info h4 {
            font-size: 18px;
            color: #6a3093;
            margin-bottom: 5px;
        }
        
        .counselor-info p {
            color: #7f8c8d;
            font-size: 14px;
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
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-card .contact-info i {
            color: #f0e68c;
        }
        
        .btn-appointment {
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
        
        .btn-appointment:hover {
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
            margin-bottom: 30px;
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
            <h1><i class="fas fa-hand-holding-heart"></i> Counseling Services</h1>
            <p>Professional emotional and psychological support for cancer patients and their families</p>
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
        <span class="current">Counseling Services</span>
    </div>
</div>

<!-- MAIN CONTENT -->
<section class="main-content">
    <div class="container">
        <div class="content-grid">
            <div class="content-left">
                <div data-aos="fade-up">
                    <h2>Professional <span>Counseling Support</span> for Your Journey</h2>
                    <p>A cancer diagnosis affects not just the body, but also the mind and spirit. At ABC Hospital, our counseling services provide compassionate professional support to help patients and their families navigate the emotional challenges of cancer.</p>
                    
                    <p>Our team of licensed psychologists and counselors specialize in oncology counseling, offering evidence-based therapeutic approaches tailored to the unique needs of cancer patients and their loved ones.</p>
                </div>
                
                <div class="info-card" data-aos="fade-up">
                    <h3><i class="fas fa-star"></i> Our Counseling Services Include:</h3>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> <strong>Individual Counseling:</strong> One-on-one sessions to address anxiety, depression, and emotional distress</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Family Counseling:</strong> Support for families navigating the challenges of a loved one's cancer diagnosis</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Coping Strategies:</strong> Techniques to manage stress, fear, and uncertainty</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Grief Counseling:</strong> Support for processing loss and bereavement</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Body Image Counseling:</strong> Help with physical changes from treatment</li>
                        <li><i class="fas fa-check-circle"></i> <strong>Mindfulness & Relaxation:</strong> Stress reduction techniques</li>
                    </ul>
                </div>
                
                <h3 data-aos="fade-up">Meet Our Counselors</h3>
                <div class="counselor-list" data-aos="fade-up">
                    <div class="counselor-item">
                        <i class="fas fa-user-md"></i>
                        <div class="counselor-info">
                            <h4>Dr. Priyani Jayawardena</h4>
                            <p>Clinical Psychologist, PhD in Oncology Psychology, 15+ years experience</p>
                        </div>
                    </div>
                    
                    <div class="counselor-item">
                        <i class="fas fa-user-md"></i>
                        <div class="counselor-info">
                            <h4>Ms. Kamini Perera</h4>
                            <p>Licensed Counselor, MSc in Counseling Psychology, Specialized in Cancer Care</p>
                        </div>
                    </div>
                    
                    <div class="counselor-item">
                        <i class="fas fa-user-md"></i>
                        <div class="counselor-info">
                            <h4>Dr. Nuwan Silva</h4>
                            <p>Psychiatrist, MD, Specialized in Psycho-oncology</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-section" data-aos="fade-up">
                    <h3>Frequently Asked Questions</h3>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>When should I seek counseling?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            It's normal to experience emotional distress after a cancer diagnosis. Consider counseling if you're experiencing persistent sadness, anxiety, difficulty sleeping, loss of interest in activities, or difficulty coping with treatment.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>Are counseling sessions confidential?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, all counseling sessions are strictly confidential. Our counselors follow professional ethics and legal requirements regarding patient privacy.
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <h4>How long are counseling sessions?</h4>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Individual counseling sessions typically last 50 minutes. The frequency and duration of counseling depend on your individual needs and treatment plan.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-right">
                <div class="sidebar-card" data-aos="fade-left">
                    <h3><i class="fas fa-phone-alt"></i> Need Immediate Support?</h3>
                    <p>Our counselors are available 24/7 for urgent emotional support.</p>
                    <div class="contact-info">
                        <div><i class="fas fa-phone"></i> <strong>Counseling Helpline:</strong> +94 11 234 5680</div>
                        <div><i class="fas fa-envelope"></i> <strong>Email:</strong> counseling@abchospital.lk</div>
                        <div><i class="fas fa-clock"></i> <strong>Hours:</strong> 24/7 Emergency Support</div>
                        <div><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> Cancer Support Center, 3rd Floor</div>
                    </div>
                    <a href="<?php echo $base_url; ?>/appointments.php?service=counseling" class="btn-appointment">
                        <i class="fas fa-calendar-check"></i> Schedule Session
                    </a>
                </div>
                
                <div class="testimonial-card" data-aos="fade-left" data-aos-delay="100">
                    <i class="fas fa-quote-left"></i>
                    <p>"The counseling sessions at ABC Hospital helped me find strength I didn't know I had. My counselor understood my fears and gave me tools to cope with treatment. I'm forever grateful."</p>
                    <div class="testimonial-author">
                        <img src="images/dept/Sunethra Weerasinghe.jpg" alt="Patient" onerror="this.src='https://via.placeholder.com/60x60'">
                        <div class="author-info">
                            <h4>Sunethra Weerasinghe</h4>
                            <p>Breast Cancer Survivor</p>
                        </div>
                    </div>
                </div>
                
                <div class="info-card" data-aos="fade-left" data-aos-delay="200">
                    <h3><i class="fas fa-clock"></i> Session Hours</h3>
                    <ul style="list-style: none;">
                        <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span>Monday - Friday:</span>
                            <span>8:00 AM - 8:00 PM</span>
                        </li>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span>Saturday:</span>
                            <span>9:00 AM - 5:00 PM</span>
                        </li>
                        <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span>Sunday:</span>
                            <span>Emergency Only</span>
                        </li>
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
    
    window.addEventListener('scroll', function() {
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        }
    });

    if (backToTop) {
        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // FAQ Accordion
    document.querySelectorAll('.faq-item').forEach(function(item) {
        item.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    });

    // Appointment Button
    const appointmentBtn = document.querySelector('.btn-appointment');
    if (appointmentBtn) {
        appointmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '<?php echo $base_url; ?>/appointments.php';
        });
    }

    console.log('Counseling Services page loaded successfully');
</script>

</body>
</html>