<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Right to Rectification";
$pageCSS = "rights-pages";
$pageJS = "rights-pages";

include_once 'includes/header02.php';
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <h1><i class="fas fa-pen"></i> Right to Rectification</h1>
        <p>Correct inaccurate or incomplete information</p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <h2>Request Correction</h2>
        
        <div class="request-form">
            <form method="POST" class="privacy-form">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="fullname" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>NIC/Passport Number *</label>
                    <input type="text" name="nic" required>
                </div>
                
                <div class="form-group">
                    <label>Data Requiring Correction *</label>
                    <textarea name="data_description" rows="3" required placeholder="Describe what information is incorrect..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Corrected Information *</label>
                    <textarea name="corrected_data" rows="3" required placeholder="Provide the correct information..."></textarea>
                </div>
                
                <button type="submit" class="btn-primary">Submit Correction</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'includes/footer02.php'; ?>