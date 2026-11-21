<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Right to Erasure";
$pageCSS = "rights-pages";
$pageJS = "rights-pages";

include_once 'includes/header02.php';
?>

<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <h1><i class="fas fa-trash"></i> Right to Erasure</h1>
        <p>Request deletion of your personal data</p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <div class="warning-box">
            <i class="fas fa-exclamation-triangle"></i>
            <p><strong>Note:</strong> Medical records may be retained for 10 years as required by Sri Lankan law.</p>
        </div>
        
        <div class="request-form">
            <h3>Request Data Deletion</h3>
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
                    <label>Reason for Erasure</label>
                    <select name="reason">
                        <option>Data no longer necessary</option>
                        <option>Withdraw consent</option>
                        <option>Object to processing</option>
                        <option>Other</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary btn-danger">Request Erasure</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'includes/footer02.php'; ?>