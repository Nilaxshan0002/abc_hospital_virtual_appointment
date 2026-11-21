<?php
// config/constants-doctors.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL - CHANGE THIS TO MATCH YOUR SETUP
define('BASE_URL', '/abc_hospital_virtual_appointment');

// Site Configuration
define('SITE_NAME', 'ABC Virtual Healthcare');
define('SITE_DESCRIPTION', 'Leading virtual healthcare provider in Sri Lanka');

// Paths
define('CSS_PATH', BASE_URL . '/css/');
define('JS_PATH', BASE_URL . '/js/');
define('IMAGES_PATH', BASE_URL . '/images/');

// Contact Information
define('CONTACT_EMAIL', 'info@abchospital.com');
define('CONTACT_PHONE', '+94 11 234 5678');
define('ADDRESS', '123 Health Avenue, Colombo, Sri Lanka');

// Social Media URLs (WORKING LINKS)
define('FACEBOOK_URL', 'https://facebook.com/abchospital');
define('TWITTER_URL', 'https://twitter.com/abchospital');
define('LINKEDIN_URL', 'https://linkedin.com/company/abchospital');
define('INSTAGRAM_URL', 'https://instagram.com/abchospital');
define('YOUTUBE_URL', 'https://youtube.com/abchospital');

// Company Information
define('COMPANY_NAME', 'ABC Virtual Healthcare');
define('ESTABLISHED_YEAR', '1959');

// Emergency Contact
define('EMERGENCY_PHONE', '+94 11 234 5679');
define('AMBULANCE_PHONE', '+94 11 234 5680');

// Doctor Specialties - FOR FILTERS
$specialties = [
    'cardiology' => 'Cardiology',
    'neurology' => 'Neurology',
    'orthopedics' => 'Orthopedics',
    'pediatrics' => 'Pediatrics',
    'dermatology' => 'Dermatology',
    'general' => 'General Medicine'
];

// Experience Levels - FOR FILTERS
$experience_levels = [
    '5' => '5+ Years',
    '10' => '10+ Years',
    '15' => '15+ Years',
    '20' => '20+ Years'
];
?>