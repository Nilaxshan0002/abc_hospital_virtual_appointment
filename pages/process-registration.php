<?php
session_start();
require_once '../config/database.php'; // Use the SAME database config as registration

$pageTitle = "Welcome to ABC Virtual - Healthcare Management System";
$base_url = '/abc_hospital_virtual_appointment';

// Initialize variables
$success_message = '';
$error_message = '';
$form_data = [];

// Check if contact form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    
    try {
        // Get database connection using PDO (SAME as registration)
        $database = new Database();
        $db = $database->getConnection();
        
        if(!$db) {
            throw new Exception("Database connection failed. Please try again later.");
        }
        
        // Get and sanitize form data
        $name = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING));
        $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim(filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_STRING));
        $message = trim(filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING));
        
        // Store submitted data to repopulate form if error occurs
        $form_data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message
        ];
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            throw new Exception("Please fill in all required fields.");
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please enter a valid email address.");
        }
        
        // Begin transaction (same pattern as registration)
        $db->beginTransaction();
        
        // INSERT INTO send_us_a_message table - using PDO prepared statement
        $insert_query = "INSERT INTO send_us_a_message (name, email_address, phone_number, subject, message, created_at) 
                         VALUES (:name, :email, :phone, :subject, :message, NOW())";
        
        $insert_stmt = $db->prepare($insert_query);
        $insert_stmt->bindParam(':name', $name);
        $insert_stmt->bindParam(':email', $email);
        $insert_stmt->bindParam(':phone', $phone);
        $insert_stmt->bindParam(':subject', $subject);
        $insert_stmt->bindParam(':message', $message);
        
        if(!$insert_stmt->execute()) {
            $error_info = $insert_stmt->errorInfo();
            throw new Exception("Failed to send message: " . $error_info[2]);
        }
        
        // Commit transaction
        $db->commit();
        
        $success_message = "Thank you! Your message has been sent successfully. We'll get back to you soon.";
        $form_data = []; // Clear form
        
    } catch(Exception $e) {
        // Rollback transaction if active
        if(isset($db) && $db->inTransaction()) {
            $db->rollBack();
        }
        
        $error_message = $e->getMessage();
    }
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="ABC Hospital Virtual Healthcare System - Book appointments with top doctors online">
    <meta name="keywords" content="hospital, healthcare, doctor appointment, online consultation, Sri Lanka">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/ABC logo.webp">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Flatpickr for Date Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    <style>
        .hero-image {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            min-height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .hero-image .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.85;
            z-index: 1;
        }
        .experience-badge {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            border-radius: 60px;
            padding: 15px 30px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            margin: 30px;
        }
        .hero-image .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .btn-login, .btn-register {
            padding: 8px 20px !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            margin-left: 5px !important;
        }
        .btn-login {
            background: transparent !important;
            border: 2px solid #ff6b6b !important;
            color: #ff6b6b !important;
        }
        .btn-login:hover {
            background: #ff6b6b !important;
            color: #fff !important;
            border-color: #ff6b6b !important;
        }
        .btn-register {
            background: #ff6b6b !important;
            border: 2px solid #ff6b6b !important;
            color: #fff !important;
        }
        .btn-register:hover {
            background: #ff5252 !important;
            border-color: #ff5252 !important;
        }
        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-links li {
            margin: 0 10px;
        }
        .nav-links li:last-child {
            margin-right: 0;
        }
        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 40px;
        }
        .quick-action-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
        }
        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .quick-action-card i {
            font-size: 40px;
            color: #4f46e5;
            margin-bottom: 15px;
        }
        .quick-action-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        .quick-action-card p {
            font-size: 14px;
            color: #666;
        }
        @media (max-width: 968px) {
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 576px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
        .dark-text {
            color: #000000 !important;
            font-weight: 500;
        }
        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        .department-card {
            background: white;
            padding: 35px 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .department-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #000000;
        }
        .department-card i {
            font-size: 40px;
            color: #000000;
            margin-bottom: 15px;
        }
        .department-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .department-card p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
        .department-link {
            display: inline-block;
            margin-top: 15px;
            color: #000000;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        .department-link i {
            font-size: 12px;
            margin-left: 5px;
            transition: transform 0.3s;
        }
        .department-card:hover .department-link i {
            transform: translateX(5px);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease;
        }
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert i {
            font-size: 20px;
        }
        .alert .close-btn {
            margin-left: auto;
            cursor: pointer;
            font-size: 18px;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .alert .close-btn:hover {
            opacity: 1;
        }
        .contact-form form {
            position: relative;
            z-index: 10;
        }
        .contact-form button[type="submit"] {
            cursor: pointer;
            position: relative;
            z-index: 20;
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
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
                </a>
                
                <ul class="nav-links" id="navMenu">
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
                
                <div class="nav-toggle" id="navToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-wrapper">
                <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                    <span class="hero-badge">Est. 1959 | Trusted by Generations</span>
                    <h1>Welcome to <span class="text-gradient">ABC Virtual</span></h1>
                    <p class="hero-subtitle"><span class="dark-text">Your Health, Our Priority</span> - Connect with top doctors from the comfort of your home</p>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number" data-count="50000">0</span>
                            <span class="stat-label"><span class="dark-text">Happy Patients</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-count="150">0</span>
                            <span class="stat-label"><span class="dark-text">Expert Doctors</span></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number" data-count="25">0</span>
                            <span class="stat-label"><span class="dark-text">Years Digital</span></span>
                        </div>
                    </div>
                    
                    <div class="hero-cta">
                        <a href="<?php echo $base_url; ?>/appointments.php" class="btn btn-primary">
                            Book Appointment <i class="fas fa-calendar-check"></i>
                        </a>
                        <a href="<?php echo $base_url; ?>/services.php" class="btn btn-outline">
                            Learn More <i class="fas fa-play"></i>
                        </a>
                    </div>
                </div>
                
                <div class="hero-image" data-aos="fade-left" data-aos-duration="1000">
                    <img src="<?php echo $base_url; ?>/images/hero-doctor.avif" alt="Doctor illustration" class="bg-image" onerror="this.style.display='none'; this.parentNode.style.background='linear-gradient(135deg, #667eea 0%, #764ba2 100%)';">
                    <div class="experience-badge floating">
                        <span class="years">64+</span>
                        <span class="text">Years of Excellence</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-wave">
            <svg viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Portal Selection Section -->
    <section class="portals" id="portals">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Choose Your Portal</span>
                <h2 class="section-title">Select Your <span class="text-gradient">Access Point</span></h2>
                <p class="section-description">Tailored portals for every role in your healthcare journey</p>
            </div>
            
            <div class="portal-grid">
                <div class="portal-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="portal-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3>Patient Portal</h3>
                    <p>Book appointments, view your schedule, and manage your health records</p>
                    <ul class="portal-features">
                        <li><i class="fas fa-check-circle"></i> 24/7 Appointment Booking</li>
                        <li><i class="fas fa-check-circle"></i> View Medical History</li>
                        <li><i class="fas fa-check-circle"></i> Prescription Access</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/pages/login.php?type=patient" class="portal-btn patient-btn">
                        Enter Patient Portal <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="portal-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="portal-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3>Doctor Portal</h3>
                    <p>View appointments, manage schedules, and update availability</p>
                    <ul class="portal-features">
                        <li><i class="fas fa-check-circle"></i> Appointment Calendar</li>
                        <li><i class="fas fa-check-circle"></i> Patient Records</li>
                        <li><i class="fas fa-check-circle"></i> Prescription Management</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/pages/login.php?type=doctor" class="portal-btn doctor-btn">
                        Enter Doctor Portal <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="portal-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="portal-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Admin Portal</h3>
                    <p>Manage doctors, receptionists, and system settings</p>
                    <ul class="portal-features">
                        <li><i class="fas fa-check-circle"></i> Staff Management</li>
                        <li><i class="fas fa-check-circle"></i> System Configuration</li>
                        <li><i class="fas fa-check-circle"></i> Analytics Dashboard</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/pages/login.php?type=admin" class="portal-btn admin-btn">
                        Enter Admin Portal <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="portal-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="portal-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Receptionist Portal</h3>
                    <p>View and manage all hospital appointments</p>
                    <ul class="portal-features">
                        <li><i class="fas fa-check-circle"></i> Appointment Management</li>
                        <li><i class="fas fa-check-circle"></i> Patient Check-in</li>
                        <li><i class="fas fa-check-circle"></i> Schedule Viewing</li>
                    </ul>
                    <a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist" class="portal-btn receptionist-btn">
                        Enter Receptionist Portal <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Services</span>
                <h2 class="section-title">Comprehensive <span class="text-gradient">Healthcare Solutions</span></h2>
                <p class="section-description">Experience healthcare reimagined with our digital services</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="service-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Online Appointments</h3>
                    <p>Book appointments with specialists 24/7 from anywhere</p>
                    <a href="<?php echo $base_url; ?>/appointments.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3>Expert Doctors</h3>
                    <p>Access to Sri Lanka's top medical professionals</p>
                    <a href="<?php echo $base_url; ?>/doctors.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="service-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Secure & Private</h3>
                    <p>Your medical data is protected and confidential</p>
                    <a href="<?php echo $base_url; ?>/about.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="service-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Easy Access</h3>
                    <p>Manage your health from any device, anywhere</p>
                    <a href="<?php echo $base_url; ?>/contact.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="zoom-in" data-aos-delay="500">
                    <div class="service-icon">
                        <i class="fas fa-file-prescription"></i>
                    </div>
                    <h3>Digital Prescriptions</h3>
                    <p>Get e-prescriptions directly to your phone</p>
                    <a href="<?php echo $base_url; ?>/services.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="zoom-in" data-aos-delay="600">
                    <div class="service-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>Video Consultations</h3>
                    <p>Consult with doctors face-to-face online</p>
                    <a href="<?php echo $base_url; ?>/doctors.php" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section class="doctors" id="doctors" style="padding: 80px 0; background: #f9f9ff;">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Medical Team</span>
                <h2 class="section-title">Meet Our <span class="text-gradient">Expert Doctors</span></h2>
                <p class="section-description">Highly qualified specialists committed to your well-being</p>
            </div>
            <div style="text-align: center; padding: 40px; background: white; border-radius: 20px;">
                <i class="fas fa-user-md" style="font-size: 60px; color: #4f46e5; margin-bottom: 20px;"></i>
                <h3>Our doctors are ready to serve you</h3>
                <p>Browse specialities and book appointments through our portals.</p>
                <a href="<?php echo $base_url; ?>/doctors.php" class="btn btn-primary" style="margin-top: 20px;">View All Doctors</a>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="departments" id="departments" style="padding: 80px 0;">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Our Departments</span>
                <h2 class="section-title">Comprehensive <span class="text-gradient">Medical Specialities</span></h2>
                <p class="section-description"><span class="dark-text">Over 30 departments</span> covering all your healthcare needs</p>
            </div>
            
            <div class="departments-grid">
                <div class="department-card" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-heartbeat"></i>
                    <h3>Cardiology</h3>
                    <p>Heart care and cardiovascular treatments</p>
                    <a href="<?php echo $base_url; ?>/cardiology.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="department-card" data-aos="zoom-in" data-aos-delay="150">
                    <i class="fas fa-brain"></i>
                    <h3>Neurology</h3>
                    <p>Brain and nervous system disorders</p>
                    <a href="<?php echo $base_url; ?>/neurology.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="department-card" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-bone"></i>
                    <h3>Orthopedics</h3>
                    <p>Bone, joint, and muscle care</p>
                    <a href="<?php echo $base_url; ?>/orthopedics.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="department-card" data-aos="zoom-in" data-aos-delay="250">
                    <i class="fas fa-child"></i>
                    <h3>Pediatrics</h3>
                    <p>Child healthcare and development</p>
                    <a href="<?php echo $base_url; ?>/pediatrics.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="department-card" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-ribbon"></i>
                    <h3>Oncology</h3>
                    <p>Cancer diagnosis and treatment</p>
                    <a href="<?php echo $base_url; ?>/oncology.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="department-card" data-aos="zoom-in" data-aos-delay="350">
                    <i class="fas fa-allergies"></i>
                    <h3>Dermatology</h3>
                    <p>Skin, hair, and nail care</p>
                    <a href="<?php echo $base_url; ?>/dermatology.php" class="department-link">
                        Learn More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo $base_url; ?>/departments.php" class="btn btn-primary">View All Departments</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-image" data-aos="fade-right">
                    <img src="<?php echo $base_url; ?>/images/hospital-building.webp" alt="ABC Hospital Building" onerror="this.src='https://via.placeholder.com/600x400/4f46e5/ffffff?text=ABC+Hospital';">
                    <div class="experience-box">
                        <span class="years">64+</span>
                        <span class="text">Years of Excellence in Healthcare</span>
                    </div>
                </div>
                
                <div class="about-content" data-aos="fade-left">
                    <span class="section-subtitle">About Us</span>
                    <h2 class="section-title">Leading Healthcare Since <span class="text-gradient">1959</span></h2>
                    
                    <p class="about-text">
                        ABC Hospital has been at the forefront of private healthcare in Sri Lanka for over six decades. 
                        We've evolved from a small clinic to a premier medical institution, adapting to technological 
                        changes while maintaining our core values of compassion and excellence.
                    </p>
                    
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>JCI Accredited</h4>
                                <p>International gold standard in healthcare</p>
                            </div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Multi-Speciality</h4>
                                <p>Over 30 medical specialities under one roof</p>
                            </div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>24/7 Emergency</h4>
                                <p>Round-the-clock emergency services</p>
                            </div>
                        </div>
                        
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Digital Pioneer</h4>
                                <p>First private hospital with fully digital records</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/about.php" class="btn btn-primary">Learn More About Us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">Testimonials</span>
                <h2 class="section-title">What Our <span class="text-gradient">Patients Say</span></h2>
            </div>
            
            <div class="testimonial-slider" data-aos="fade-up">
                <div class="testimonial-card active">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>The online appointment system is a game-changer. I can book appointments with my favorite doctor without waiting on phone calls. ABC Virtual has made healthcare so convenient!</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="<?php echo $base_url; ?>/images/Mrs. Priyani Silva.jpg" alt="Patient" onerror="this.src='https://via.placeholder.com/60x60/4f46e5/ffffff?text=P';">
                        <div>
                            <h4>Mrs. Priyani Silva</h4>
                            <p>Patient since 2015</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>As a doctor, the portal helps me manage my appointments efficiently. I can see my entire schedule at a glance and access patient records securely. Excellent system!</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="<?php echo $base_url; ?>/images/Dr. Kamal Perera.jpg" alt="Doctor" onerror="this.src='https://via.placeholder.com/60x60/4f46e5/ffffff?text=K';">
                        <div>
                            <h4>Dr. Kamal Perera</h4>
                            <p>Consultant Cardiologist</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Managing appointments for hundreds of patients daily was chaotic. Now with the receptionist portal, everything is organized and digital. It's transformed our workflow.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="<?php echo $base_url; ?>/images/Ms. Nadeeka Fernando.jpg" alt="Receptionist" onerror="this.src='https://via.placeholder.com/60x60/4f46e5/ffffff?text=N';">
                        <div>
                            <h4>Ms. Nadeeka Fernando</h4>
                            <p>Head Receptionist</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="slider-controls">
                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2>Ready to Experience Modern Healthcare?</h2>
                <p>Join thousands of patients who've embraced digital healthcare with ABC Virtual</p>
                <div class="cta-buttons">
                    <a href="<?php echo $base_url; ?>/pages/register.php" class="btn btn-primary btn-large">
                        <i class="fas fa-user-plus"></i> Register Now
                    </a>
                    <a href="<?php echo $base_url; ?>/contact.php" class="btn btn-outline-light btn-large">
                        <i class="fas fa-headset"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info" data-aos="fade-right">
                    <span class="section-subtitle">Get in Touch</span>
                    <h2 class="section-title">We're Here to <span class="text-gradient">Help You</span></h2>
                    
                    <div class="info-items">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Visit Us</h4>
                                <p>123 Hospital Road, Colombo 05, Sri Lanka</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h4>Call Us</h4>
                                <p>+94 11 234 5678</p>
                                <p>Emergency: +94 11 234 5679</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email Us</h4>
                                <p>info@abchospital.lk</p>
                                <p>support@abcvirtual.lk</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Working Hours</h4>
                                <p>Mon - Fri: 8:00 AM - 8:00 PM</p>
                                <p>Sat - Sun: 9:00 AM - 5:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="contact-form" data-aos="fade-left">
                    <?php if ($success_message): ?>
                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success_message; ?>
                        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                    <div class="alert alert-error" id="errorAlert">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error_message; ?>
                        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="" id="contactForm">
                        <h3>Send us a Message</h3>
                        
                        <div class="form-group">
                            <input type="text" name="name" required 
                                value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>"
                                placeholder="Your Name *">
                        </div>
                        
                        <div class="form-group">
                            <input type="email" name="email" required 
                                value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                                placeholder="Email Address *">
                        </div>
                        
                        <div class="form-group">
                            <input type="text" name="phone" 
                                value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>"
                                placeholder="Phone Number (Optional)">
                        </div>
                        
                        <div class="form-group">
                            <select name="subject" required>
                                <option value="">Select Subject *</option>
                                <option value="Appointment Query" <?php echo (isset($form_data['subject']) && $form_data['subject'] == 'Appointment Query') ? 'selected' : ''; ?>>Appointment Query</option>
                                <option value="Billing Issue" <?php echo (isset($form_data['subject']) && $form_data['subject'] == 'Billing Issue') ? 'selected' : ''; ?>>Billing Issue</option>
                                <option value="Technical Support" <?php echo (isset($form_data['subject']) && $form_data['subject'] == 'Technical Support') ? 'selected' : ''; ?>>Technical Support</option>
                                <option value="General Inquiry" <?php echo (isset($form_data['subject']) && $form_data['subject'] == 'General Inquiry') ? 'selected' : ''; ?>>General Inquiry</option>
                                <option value="Feedback" <?php echo (isset($form_data['subject']) && $form_data['subject'] == 'Feedback') ? 'selected' : ''; ?>>Feedback</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="message" rows="5" required placeholder="Your Message *"><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" name="submit_message" value="1" class="btn btn-primary btn-block" id="submitBtn">
                            Send Message <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/40x40/4f46e5/ffffff?text=ABC';">
                        <span>ABC VIRTUAL</span>
                    </div>
                    <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="<?php echo $base_url; ?>/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                        <li><a href="<?php echo $base_url; ?>/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="<?php echo $base_url; ?>/departments.php"><i class="fas fa-chevron-right"></i> Departments</a></li>
                        <li><a href="<?php echo $base_url; ?>/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                        <li><a href="<?php echo $base_url; ?>/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="<?php echo $base_url; ?>/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Our Portals</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=patient"><i class="fas fa-chevron-right"></i> Patient Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=doctor"><i class="fas fa-chevron-right"></i> Doctor Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=admin"><i class="fas fa-chevron-right"></i> Admin Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist"><i class="fas fa-chevron-right"></i> Receptionist Portal</a></li>
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
                <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> for better healthcare</p>
                <div class="footer-bottom-links">
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo $base_url; ?>/js/main.js"></script>
    
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        document.querySelectorAll('a[href^="#"]:not([href="#"]):not([href="#contact"])').forEach(anchor => {
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

        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

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

        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        counters.forEach(counter => {
            const updateCount = () => {
                const target = parseInt(counter.getAttribute('data-count'));
                const count = parseInt(counter.innerText);
                const increment = Math.trunc(target / speed);

                if (count < target) {
                    counter.innerText = count + increment;
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            });

            if (counter) {
                observer.observe(counter);
            }
        });

        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 1000);
            });
        }, 5000);

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