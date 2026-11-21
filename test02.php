<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Test Page";
$metaDescription = "Test page";
$metaKeywords = "test";
$pageCSS = "test";
$pageJS = "test";

include_once 'includes/header02.php';
?>

<!-- Simple Test Content -->
<div class="container">
    <div class="content-card" style="margin-top: 50px;">
        <h1 style="color: #4f46e5; font-size: 2rem;">Test Page</h1>
        <p>If you can see this, the header and footer are working!</p>
        
        <h2 style="margin-top: 30px;">Debug Information:</h2>
        <ul style="list-style: none; padding: 0;">
            <li style="margin: 10px 0;"><strong>Base URL:</strong> <?php echo $base_url; ?></li>
            <li style="margin: 10px 0;"><strong>Current File:</strong> <?php echo __FILE__; ?></li>
            <li style="margin: 10px 0;"><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
            <li style="margin: 10px 0;"><strong>Request URI:</strong> <?php echo $_SERVER['REQUEST_URI']; ?></li>
        </ul>
        
        <div style="margin-top: 30px; padding: 20px; background: #f0f3ff; border-radius: 15px;">
            <h3>Links to Test:</h3>
            <p><a href="<?php echo $base_url; ?>/right-to-access.php" style="color: #4f46e5;">Right to Access</a></p>
            <p><a href="<?php echo $base_url; ?>/right-to-rectification.php" style="color: #4f46e5;">Right to Rectification</a></p>
            <p><a href="<?php echo $base_url; ?>/right-to-erasure.php" style="color: #4f46e5;">Right to Erasure</a></p>
            <p><a href="<?php echo $base_url; ?>/right-to-portability.php" style="color: #4f46e5;">Right to Portability</a></p>
            <p><a href="<?php echo $base_url; ?>/privacy-request.php" style="color: #4f46e5;">Privacy Request</a></p>
        </div>
    </div>
</div>

<?php include_once 'includes/footer02.php'; ?>