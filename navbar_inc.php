<?php
// navbar_inc.php
// Navigation bar include file for ABC Virtual Healthcare System

// Get current page filename to set active class
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Navigation -->
<nav class="navbar navbar-fixed">
    <div class="container">
        <div class="nav-wrapper">
            <a href="index.php" class="logo">
                <img src="images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC'; this.onerror=null;">
                <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
            </a>
            
            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="index.php#home" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="index.php#doctors">Doctors</a></li>
                    <li><a href="index.php#services">Services</a></li>
                    <li><a href="index.php#departments">Departments</a></li>
                    <li><a href="index.php#appointments">Appointments</a></li>
                    <li><a href="index.php#about">About</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <!-- User is logged in -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <i class="fas fa-user-circle"></i> 
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'My Account'); ?>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if($_SESSION['user_type'] == 'patient'): ?>
                                    <li><a href="pages/patient/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a href="pages/patient/my-appointments.php"><i class="fas fa-calendar-check"></i> My Appointments</a></li>
                                    <li><a href="pages/patient/medical-records.php"><i class="fas fa-notes-medical"></i> Medical Records</a></li>
                                    <li><a href="pages/patient/prescriptions.php"><i class="fas fa-prescription"></i> Prescriptions</a></li>
                                    <li><a href="pages/patient/profile.php"><i class="fas fa-id-card"></i> Profile</a></li>
                                <?php elseif($_SESSION['user_type'] == 'doctor'): ?>
                                    <li><a href="pages/doctor/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a href="pages/doctor/my-schedule.php"><i class="fas fa-clock"></i> My Schedule</a></li>
                                    <li><a href="pages/doctor/appointments.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                                    <li><a href="pages/doctor/patients.php"><i class="fas fa-users"></i> My Patients</a></li>
                                    <li><a href="pages/doctor/prescriptions.php"><i class="fas fa-prescription-bottle"></i> Prescriptions</a></li>
                                    <li><a href="pages/doctor/profile.php"><i class="fas fa-id-card"></i> Profile</a></li>
                                <?php elseif($_SESSION['user_type'] == 'admin'): ?>
                                    <li><a href="pages/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a href="pages/admin/doctors.php"><i class="fas fa-user-md"></i> Manage Doctors</a></li>
                                    <li><a href="pages/admin/patients.php"><i class="fas fa-users"></i> Manage Patients</a></li>
                                    <li><a href="pages/admin/receptionists.php"><i class="fas fa-user-tie"></i> Receptionists</a></li>
                                    <li><a href="pages/admin/appointments.php"><i class="fas fa-calendar-alt"></i> All Appointments</a></li>
                                    <li><a href="pages/admin/departments.php"><i class="fas fa-building"></i> Departments</a></li>
                                    <li><a href="pages/admin/reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                                    <li><a href="pages/admin/settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                                <?php elseif($_SESSION['user_type'] == 'receptionist'): ?>
                                    <li><a href="pages/receptionist/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a href="pages/receptionist/appointments.php"><i class="fas fa-calendar-alt"></i> Manage Appointments</a></li>
                                    <li><a href="pages/receptionist/check-in.php"><i class="fas fa-sign-in-alt"></i> Patient Check-in</a></li>
                                    <li><a href="pages/receptionist/schedule.php"><i class="fas fa-clock"></i> Doctor Schedule</a></li>
                                    <li><a href="pages/receptionist/register-patient.php"><i class="fas fa-user-plus"></i> Register Patient</a></li>
                                <?php endif; ?>
                                <li class="divider"></li>
                                <li><a href="pages/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- User is not logged in -->
                        <li><a href="pages/login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="pages/register.php" class="btn-register"><i class="fas fa-user-plus"></i> Register</a></li>
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

<!-- Add this CSS to your main style.css file or keep it here -->
<style>
    /* Dropdown Menu Styles */
    .dropdown {
        position: relative;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        min-width: 220px;
        display: none;
        z-index: 1000;
        padding: 10px 0;
        margin-top: 10px;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu li {
        list-style: none;
    }

    .dropdown-menu a {
        padding: 10px 20px !important;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333 !important;
        font-size: 14px;
        transition: all 0.3s;
    }

    .dropdown-menu a:hover {
        background: #f5f5f5;
        color: #4f46e5 !important;
        padding-left: 25px !important;
    }

    .dropdown-menu a i {
        width: 20px;
        color: #4f46e5;
    }

    .divider {
        height: 1px;
        background: #e0e0e0;
        margin: 10px 0;
    }

    /* Mobile Responsive */
    @media (max-width: 968px) {
        .nav-menu {
            position: fixed;
            top: 80px;
            left: -100%;
            width: 100%;
            height: calc(100vh - 80px);
            background: white;
            transition: 0.3s;
            overflow-y: auto;
        }

        .nav-menu.active {
            left: 0;
        }

        .nav-links {
            flex-direction: column;
            padding: 40px 20px;
            gap: 20px;
        }

        .dropdown-menu {
            position: static;
            box-shadow: none;
            display: none;
            background: #f9f9f9;
            margin-top: 10px;
        }

        .dropdown.active .dropdown-menu {
            display: block;
        }

        .dropdown-toggle {
            justify-content: space-between;
            width: 100%;
        }
    }

    /* Active link style */
    .nav-links a.active {
        color: #4f46e5;
        font-weight: 600;
    }

    .nav-links a.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #4f46e5;
    }
</style>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    // Toggle mobile menu
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            // Toggle hamburger animation
            this.classList.toggle('active');
        });
    }

    // Handle dropdowns on mobile
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 968) {
                e.preventDefault();
                const dropdown = this.parentElement;
                dropdown.classList.toggle('active');
            }
        });
    });

    // Close menu when clicking on a link (for mobile)
    const navLinks = document.querySelectorAll('.nav-links a:not(.dropdown-toggle)');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 968) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
            }
        });
    });

    // Set active class based on current page and hash
    function setActiveLink() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        
        document.querySelectorAll('.nav-links > li > a').forEach(link => {
            link.classList.remove('active');
            
            const href = link.getAttribute('href');
            
            // Handle index.php links with hash
            if (currentPath.includes('index.php') || currentPath === '/' || currentPath.endsWith('/')) {
                if (href.includes('#') && currentHash) {
                    if (href.split('#')[1] === currentHash.substring(1)) {
                        link.classList.add('active');
                    }
                } else if (!currentHash && href === 'index.php#home') {
                    link.classList.add('active');
                }
            }
            
            // Handle exact page matches
            if (href === currentPath.substring(currentPath.lastIndexOf('/') + 1)) {
                link.classList.add('active');
            }
        });
    }

    setActiveLink();

    // Update active class on scroll for hash links
    const sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', function() {
        let current = '';
        const scrollY = window.pageYOffset;

        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href.includes('#') && href.split('#')[1] === current) {
                link.classList.add('active');
            }
        });
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        // Only handle internal hash links
        if (href.startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});
</script>