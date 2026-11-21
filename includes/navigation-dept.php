<?php
$base_url = '/abc_hospital_virtual_appointment';
?>

<!-- Preloader -->
<div class="preloader">
    <div class="loader"></div>
</div>

<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="<?php echo $base_url; ?>/index.php" class="logo">
                <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" 
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                <span class="logo-text">ABC <span class="text-gradient">VIRTUAL</span></span>
            </a>
            
            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/departments.php" class="active">Departments</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="nav-buttons">
                <a href="<?php echo $base_url; ?>/pages/login.php" class="btn-login">Login</a>
                <a href="<?php echo $base_url; ?>/pages/register.php" class="btn-register">Register</a>
            </div>
            
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>