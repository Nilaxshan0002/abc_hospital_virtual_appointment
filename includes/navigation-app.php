<!-- Navigation - Matching index.php with improved visibility -->
<nav class="navbar navbar-fixed">
    <div class="container">
        <div class="nav-wrapper">
            <a href="<?php echo $base_url; ?>/index.php" class="logo">
                <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/1e3c72/ffffff?text=ABC';">
                <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
            </a>
            
            <ul class="nav-links" id="navMenu">
                <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
                <li><a href="<?php echo $base_url; ?>/appointment.php" class="active">Appointments</a></li>
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

<style>
/* Navigation visibility fixes */
.navbar {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.logo img {
    width: 50px;
    height: 50px;
    border-radius: 10px;
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
    color: #000000 !important; /* Black color for ABC */
}

.text-highlight {
    color: #90EE90 !important; /* Light green color for VIRTUAL */
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

.nav-links a {
    color: #333 !important;
    font-weight: 500;
    transition: color 0.3s;
    text-decoration: none;
}

.nav-links a:hover {
    color: #1e3c72 !important;
}

.nav-links a.active {
    color: #1e3c72 !important;
    font-weight: 600;
}

/* Orange buttons for Login and Register */
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
    background: linear-gradient(135deg, #ff8c42, #ff6b6b) !important;
    border: none !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(255,140,66,0.3) !important;
}

.btn-login:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(255,140,66,0.4) !important;
}

.btn-register {
    background: linear-gradient(135deg, #ff8c42, #ff6b6b) !important;
    border: none !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(255,140,66,0.3) !important;
}

.btn-register:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(255,140,66,0.4) !important;
}

/* Mobile menu styles */
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

@media (max-width: 768px) {
    .nav-toggle {
        display: flex;
    }
    
    .nav-menu {
        position: fixed;
        top: 80px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 80px);
        background: white;
        transition: 0.3s;
        padding: 20px;
    }
    
    .nav-menu.active {
        left: 0;
    }
    
    .nav-links {
        flex-direction: column;
        align-items: flex-start;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }
    
    .nav-links a {
        color: #333 !important;
    }
}
</style>