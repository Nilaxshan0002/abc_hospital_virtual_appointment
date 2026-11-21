<?php
// includes/navigation-doctors.php
$current_page = basename($_SERVER['PHP_SELF']);

// Define BASE_URL if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/abc_hospital_virtual_appointment');
}
?>
<!-- Navigation - MATCHING INDEX.PHP EXACTLY -->
<nav class="navbar navbar-fixed">
    <div class="container">
        <div class="nav-wrapper">
            <a href="<?php echo BASE_URL; ?>/index.php" class="logo">
                <img src="<?php echo BASE_URL; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
            </a>
            
            <ul class="nav-links" id="navMenu" style="display: flex; list-style: none; margin: 0; padding: 0;">
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/index.php" <?php echo $current_page == 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/doctors.php" <?php echo $current_page == 'doctors.php' ? 'class="active"' : ''; ?>>Doctors</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/services.php" <?php echo $current_page == 'services.php' ? 'class="active"' : ''; ?>>Services</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/departments.php" <?php echo $current_page == 'departments.php' ? 'class="active"' : ''; ?>>Departments</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/appointments.php" <?php echo $current_page == 'appointments.php' ? 'class="active"' : ''; ?>>Appointments</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/about.php" <?php echo $current_page == 'about.php' ? 'class="active"' : ''; ?>>About</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/contact.php" <?php echo $current_page == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/pages/login.php" class="btn-login">Login</a></li>
                <li style="margin: 0 10px;"><a href="<?php echo BASE_URL; ?>/pages/register.php" class="btn-register">Register</a></li>
            </ul>
            
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>

<!-- Add these styles to match index.php exactly -->
<style>
/* Button styles matching index.php */
.btn-login, .btn-register {
    padding: 8px 20px !important;
    border-radius: 50px !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    margin-left: 5px !important;
    text-decoration: none !important;
    display: inline-block !important;
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

/* Nav wrapper styling */
.nav-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
}

/* Nav links styling */
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

.nav-links li a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    font-size: 14px;
    transition: color 0.3s;
}

.nav-links li a:hover {
    color: #4f46e5;
}

.nav-links li a.active {
    color: #4f46e5;
    font-weight: 600;
}

/* Mobile menu toggle */
.nav-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.nav-toggle span {
    width: 25px;
    height: 3px;
    background: #333;
    margin: 2px 0;
    transition: 0.3s;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .nav-links {
        display: none !important;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        background: white;
        flex-direction: column;
        padding: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        gap: 15px;
        z-index: 1000;
    }
    
    .nav-links.active {
        display: flex !important;
    }
    
    .nav-links li {
        margin: 5px 0 !important;
        width: 100%;
        text-align: center;
    }
    
    .nav-links li a {
        display: block;
        width: 100%;
        padding: 10px;
    }
    
    .btn-login, .btn-register {
        margin-left: 0 !important;
        width: 100%;
        text-align: center;
    }
    
    .nav-toggle {
        display: flex;
    }
}
</style>

<!-- Mobile Menu Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }
});
</script>