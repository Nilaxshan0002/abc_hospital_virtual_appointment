<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Right to Access";
$pageCSS = "rights-pages";
$pageJS = "rights-pages";

// Include header
include_once 'includes/header02.php';
?>

<!-- Simple Page Header -->
<header class="page-header">
    <div class="container">
        <h1><i class="fas fa-eye"></i> Right to Access</h1>
        <p>Request a copy of your personal data</p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <h2>What is the Right to Access?</h2>
        <p>Under the Sri Lanka Personal Data Protection Act No. 9 of 2022, you have the right to obtain confirmation about whether we are processing your personal data.</p>

        <!-- Request Form -->
        <div class="request-form">
            <h3>Request Your Data</h3>
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
                    <label>What information would you like to access?</label>
                    <select name="data_scope">
                        <option>Complete Medical Records</option>
                        <option>Personal Information Only</option>
                        <option>Medical History Only</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary">Submit Request</button>
            </form>
        </div>
    </div>
</div>

<?php
// Simple footer
include_once 'includes/footer02.php';
?>