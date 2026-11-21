<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "ABC Virtual Healthcare"; ?></title>
    <meta name="description" content="<?php echo isset($metaDescription) ? $metaDescription : 'ABC Hospital Virtual Healthcare Platform'; ?>">
    <meta name="keywords" content="<?php echo isset($metaKeywords) ? $metaKeywords : 'healthcare, telemedicine, ABC Hospital'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="images/webp" href="images/ABC logo.webp">
    
    <!-- Font Awesome 6 - Multiple CDNs for fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Page Specific CSS with Cache Busting -->
    <?php if (isset($pageCSS) && !empty($pageCSS)): ?>
        <link rel="stylesheet" href="<?php echo $base_url; ?>/css/<?php echo $pageCSS; ?>.css?v=<?php echo time(); ?>">
    <?php endif; ?>
    
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9ff;
            color: #1c2e4a;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }

        .text-highlight {
            color: #ffd700;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
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
            padding: 8px 20px !important;
            border-radius: 50px !important;
        }

        .btn-register:hover {
            background: #ff5252 !important;
            transform: translateY(-2px) !important;
        }

        /* Preloader Animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Font Awesome Fallback - Only used if CDN fails */
        .fa-fallback {
            display: none;
        }
    </style>
    
    <!-- Font Awesome Fallback with Emoji Icons if CDN fails -->
    <style class="fa-fallback">
        /* This will only be used if Font Awesome doesn't load */
        .fa-shield-halved:before { content: "🛡️"; font-family: sans-serif; }
        .fa-eye:before { content: "👁️"; font-family: sans-serif; }
        .fa-pen:before { content: "✏️"; font-family: sans-serif; }
        .fa-trash:before { content: "🗑️"; font-family: sans-serif; }
        .fa-download:before { content: "📥"; font-family: sans-serif; }
        .fa-check-circle:before { content: "✓"; font-family: sans-serif; }
        .fa-exclamation-triangle:before { content: "⚠️"; font-family: sans-serif; }
        .fa-lock:before { content: "🔒"; font-family: sans-serif; }
        .fa-eye-slash:before { content: "👁️‍🗨️"; font-family: sans-serif; }
        .fa-globe:before { content: "🌐"; font-family: sans-serif; }
        .fa-shield-check:before { content: "✅"; font-family: sans-serif; }
        .fa-list-ul:before { content: "📋"; font-family: sans-serif; }
        .fa-chevron-right:before { content: "›"; font-family: sans-serif; }
        .fa-home:before { content: "🏠"; font-family: sans-serif; }
        .fa-calendar-check:before { content: "📅"; font-family: sans-serif; }
        .fa-hospital:before { content: "🏥"; font-family: sans-serif; }
        .fa-layer-group:before { content: "📁"; font-family: sans-serif; }
        .fa-file-lines:before { content: "📄"; font-family: sans-serif; }
        .fa-user-check:before { content: "👤✅"; font-family: sans-serif; }
        .fa-phone-alt:before { content: "📞"; font-family: sans-serif; }
        .fa-shield-alt:before { content: "🛡️"; font-family: sans-serif; }
        .fa-envelope:before { content: "✉️"; font-family: sans-serif; }
        .fa-map-marker-alt:before { content: "📍"; font-family: sans-serif; }
        .fa-clock:before { content: "🕐"; font-family: sans-serif; }
        .fa-fax:before { content: "📠"; font-family: sans-serif; }
        .fa-globe:before { content: "🌐"; font-family: sans-serif; }
        .fa-share-alt:before { content: "📤"; font-family: sans-serif; }
        .fa-arrow-right:before { content: "→"; font-family: sans-serif; }
        .fa-download:before { content: "📥"; font-family: sans-serif; }
        .fa-trash:before { content: "🗑️"; font-family: sans-serif; }
        .fa-pen:before { content: "✏️"; font-family: sans-serif; }
        .fa-eye:before { content: "👁️"; font-family: sans-serif; }
    </style>
    
    <!-- Debug script to check if Font Awesome loaded -->
    <script>
    window.addEventListener('load', function() {
        var testIcon = document.createElement('i');
        testIcon.className = 'fas fa-shield-halved';
        testIcon.style.position = 'absolute';
        testIcon.style.left = '-9999px';
        document.body.appendChild(testIcon);
        var styles = window.getComputedStyle(testIcon);
        var isFontAwesomeLoaded = styles.fontFamily.includes('Font Awesome');
        console.log('Font Awesome loaded:', isFontAwesomeLoaded);
        
        // If Font Awesome didn't load, enable fallback icons
        if (!isFontAwesomeLoaded) {
            document.querySelector('.fa-fallback').style.display = 'block';
        }
        
        testIcon.remove();
    });
    </script>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" style="position: fixed; top:0; left:0; right:0; bottom:0; background:white; z-index:9999; display:flex; justify-content:center; align-items:center;">
        <div class="loader" style="width:50px; height:50px; border:5px solid #f3f3f3; border-top:5px solid #4f46e5; border-radius:50%; animation:spin 1s linear infinite;"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo $base_url; ?>/index.php" class="logo">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
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

    <script>
    // Hide preloader when page is loaded
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.querySelector('.preloader').style.display = 'none';
        }, 500);
    });
    </script>