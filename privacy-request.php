<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Submit Privacy Request";
$pageCSS = "rights-pages";
$pageJS = "rights-pages";

include_once 'includes/header02.php';
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <h1><i class="fas fa-shield-halved"></i> Submit Privacy Request</h1>
        <p>Exercise your data protection rights</p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <!-- Quick Contact -->
        <div class="quick-contact">
            <h3>Need Help?</h3>
            <p>Contact our Data Protection Team</p>
            <div class="quick-contact-grid">
                <div class="quick-contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:dpo@abchospital.lk">dpo@abchospital.lk</a>
                </div>
                <div class="quick-contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+94112345678">+94 11 234 5678</a>
                </div>
            </div>
        </div>
        
        <div class="rights-grid">
            <a href="right-to-access.php" class="rights-card">
                <i class="fas fa-eye"></i>
                <h4>Right to Access</h4>
                <p>Request a copy of your personal data</p>
            </a>
            
            <a href="right-to-rectification.php" class="rights-card">
                <i class="fas fa-pen"></i>
                <h4>Right to Rectification</h4>
                <p>Correct inaccurate information</p>
            </a>
            
            <a href="right-to-erasure.php" class="rights-card">
                <i class="fas fa-trash"></i>
                <h4>Right to Erasure</h4>
                <p>Request data deletion</p>
            </a>
            
            <a href="right-to-portability.php" class="rights-card">
                <i class="fas fa-download"></i>
                <h4>Right to Portability</h4>
                <p>Receive data in portable format</p>
            </a>
        </div>
    </div>
</div>

<?php include_once 'includes/footer02.php'; ?>