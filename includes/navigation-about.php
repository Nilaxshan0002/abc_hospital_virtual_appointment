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
                <li><a href="<?php echo $base_url; ?>/about.php" class="active">About</a></li>
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