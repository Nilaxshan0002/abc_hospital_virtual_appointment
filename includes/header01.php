<?php
// includes/header01.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set base_url - EMPTY for localhost
$base_url = '';

// Set default values if not set
$pageTitle = isset($pageTitle) ? $pageTitle : 'ABC Virtual Healthcare';
$pageDescription = isset($pageDescription) ? $pageDescription : 'Welcome to ABC Virtual Healthcare';

// Get current page for active menu
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/abc_hospital_virtual_appointment/images/ABC logo.webp">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/abc_hospital_virtual_appointment/css/cookie.css">
    
    <style>
        /* Fallback styles in case CSS doesn't load */
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background: #f9f9ff; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
        
        /* Navbar styles */
        .navbar { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1); 
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
            gap: 10px; 
        }
        
        .logo img { 
            width: 50px; 
            height: 50px; 
            border-radius: 10px; 
            object-fit: cover; 
        }
        
        .logo-text { 
            font-size: 24px; 
            font-weight: 700; 
            color: white; 
        }
        
        .text-highlight { 
            color: #ffd700; 
        }
        
        .nav-links { 
            display: flex; 
            list-style: none; 
            gap: 20px; 
            align-items: center; 
            margin: 0; 
            padding: 0; 
        }
        
        .nav-links a { 
            text-decoration: none; 
            color: white; 
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
            color: white !important;
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
            color: white !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }
        
        .btn-register:hover { 
            background: #ff5252 !important;
            transform: translateY(-2px) !important;
        }
        
        .btn-profile { 
            background: #3b82f6 !important;
            color: white !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }
        
        .btn-logout { 
            background: #ef4444 !important;
            color: white !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }
        
        .mobile-menu-btn { 
            display: none; 
            background: transparent; 
            border: none; 
            font-size: 24px; 
            cursor: pointer; 
            color: white;
            padding: 8px;
        }
        
        .preloader { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            z-index: 9999; 
        }
        
        .loader { 
            border: 4px solid #f3f3f3; 
            border-top: 4px solid #4f46e5; 
            border-radius: 50%; 
            width: 50px; 
            height: 50px; 
            animation: spin 1s linear infinite; 
        }
        
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
        
        /* Active link style */
        .nav-links a.active {
            background: rgba(255,255,255,0.2);
            font-weight: 600;
        }
        
        @media (max-width: 992px) {
            .mobile-menu-btn { 
                display: block; 
            }
            
            .nav-links { 
                display: none; 
                position: absolute; 
                top: 100%; 
                left: 0; 
                width: 100%; 
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                flex-direction: column; 
                padding: 20px; 
                box-shadow: 0 10px 20px rgba(0,0,0,0.2);
                z-index: 999;
            }
            
            .nav-links.show,
            .nav-links.active { 
                display: flex; 
            }
            
            .nav-links li {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
            
            .btn-login, 
            .btn-register,
            .btn-profile,
            .btn-logout {
                display: inline-block !important;
                width: auto !important;
                min-width: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Logo -->
                <a href="/abc_hospital_virtual_appointment/index.php" class="logo">
                    <img src="/abc_hospital_virtual_appointment/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
                </a>
                
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Navigation Links -->
                <ul class="nav-links" id="navLinks">
                    <li><a href="/abc_hospital_virtual_appointment/index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/doctors.php" class="<?php echo ($current_page == 'doctors.php') ? 'active' : ''; ?>">Doctors</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Services</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/departments.php" class="<?php echo ($current_page == 'departments.php') ? 'active' : ''; ?>">Departments</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/appointments.php" class="<?php echo ($current_page == 'appointments.php') ? 'active' : ''; ?>">Appointments</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="/abc_hospital_virtual_appointment/contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/abc_hospital_virtual_appointment/dashboard.php" class="btn-profile">
                            <i class="fas fa-user-circle"></i> Dashboard
                        </a></li>
                        <li><a href="/abc_hospital_virtual_appointment/logout.php" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a></li>
                    <?php else: ?>
                        <li><a href="/abc_hospital_virtual_appointment/pages/login.php" class="btn-login">Login</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/pages/register.php" class="btn-register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 500);
            }
        });

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const navLinks = document.getElementById('navLinks');
            
            if (mobileBtn && navLinks) {
                mobileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    navLinks.classList.toggle('show');
                    navLinks.classList.toggle('active');
                    
                    // Toggle icon
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (icon.classList.contains('fa-bars')) {
                            icon.classList.remove('fa-bars');
                            icon.classList.add('fa-times');
                        } else {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileBtn.contains(e.target) && !navLinks.contains(e.target)) {
                        navLinks.classList.remove('show', 'active');
                        const icon = mobileBtn.querySelector('i');
                        if (icon && icon.classList.contains('fa-times')) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
                
                // Close menu when window resizes above mobile breakpoint
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 992) {
                        navLinks.classList.remove('show', 'active');
                        const icon = mobileBtn.querySelector('i');
                        if (icon && icon.classList.contains('fa-times')) {
                            icon.classList.remove('fa-times');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
            }
        });
    </script>