<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment'; // ADD THIS LINE
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Hospital - Virtual Appointment System</title>
    
    <!-- Font Awesome (ADD THIS for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS - FIXED path -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-fixed">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo $base_url; ?>/index.php" class="logo">
                    <!-- FIXED: Image path -->
                    <img src="<?php echo $base_url; ?>/assets/images/hospital-logo.svg" alt="ABC Hospital Logo" class="logo-img" onerror="this.src='https://via.placeholder.com/50x50/2A5C7D/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">HOSPITAL</span></span>
                </a>
                
                <div class="nav-menu" id="navMenu">
                    <ul class="nav-links">
                        <!-- FIXED: All links with base_url and active class -->
                        <li><a href="<?php echo $base_url; ?>/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                        <li><a href="<?php echo $base_url; ?>/services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">Services</a></li>
                        <li><a href="<?php echo $base_url; ?>/about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About Us</a></li>
                        <li><a href="<?php echo $base_url; ?>/contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                        <li><a href="<?php echo $base_url; ?>/doctors.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'doctors.php' ? 'active' : ''; ?>">Doctors</a></li>
                        <li><a href="<?php echo $base_url; ?>/appointments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">Appointments</a></li>
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li><a href="#" onclick="logout()" class="btn-logout">Logout (<?php echo $_SESSION['user_name']; ?>)</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo $base_url; ?>/pages/login.php" class="btn-login">Login</a></li>
                            <li><a href="<?php echo $base_url; ?>/pages/register.php" class="btn-register">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="nav-toggle" id="navToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Add this script for mobile menu -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('navToggle');
            const navMenu = document.getElementById('navMenu');
            
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navMenu.classList.toggle('active');
                });
            }
        });
    </script>