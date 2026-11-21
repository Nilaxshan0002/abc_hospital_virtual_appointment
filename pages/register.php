<?php
session_start();
$pageTitle = "Register - ABC Virtual Healthcare System";

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: patient/dashboard.php");
    exit();
}

// Get any error messages from session 
$error = '';
$form_data = [];
if(isset($_SESSION['registration_errors'])) {
    $error = $_SESSION['registration_errors']['message'] ?? '';
    $form_data = $_SESSION['registration_errors']['data'] ?? [];
    unset($_SESSION['registration_errors']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="<?php echo $base_url; ?>/images/register.jpg">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            padding: 0;
            background: url('../assets/images/medical-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(42, 92, 125, 0.95) 0%, rgba(78, 205, 196, 0.9) 100%);
            z-index: -1;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            position: relative;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header with Logo */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container {
            display: inline-block;
            background: white;
            padding: 20px 40px;
            border-radius: 60px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: transform 0.3s ease;
        }

        .logo-container:hover {
            transform: translateY(-5px);
        }

        .logo-img {
            height: 60px;
            width: auto;
        }

        .header h1 {
            color: white;
            font-size: 36px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            margin-bottom: 10px;
        }

        .header p {
            color: rgba(255,255,255,0.9);
            font-size: 18px;
            font-weight: 300;
        }

        /* Main Register Card */
        .register-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .register-card:hover {
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
        }

        /* Progress Bar */
        .progress-section {
            padding: 30px 40px 0;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #e9ecef 0%, #e9ecef 100%);
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            background: white;
            text-align: center;
            flex: 1;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
            position: relative;
        }

        .step.active .step-icon {
            border-color: #2A5C7D;
            background: #2A5C7D;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(42,92,125,0.3);
        }

        .step.completed .step-icon {
            border-color: #4CAF50;
            background: #4CAF50;
            color: white;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step.active .step-label {
            color: #2A5C7D;
            font-weight: 600;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin: 0 40px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Container */
        .form-container {
            padding: 0 40px 30px;
        }

        .form-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .section-title {
            font-size: 24px;
            color: #2C3E50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: #2A5C7D;
            font-size: 28px;
            background: rgba(42,92,125,0.1);
            padding: 10px;
            border-radius: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2C3E50;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group label i {
            color: #2A5C7D;
            margin-right: 8px;
            width: 20px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #2A5C7D;
            box-shadow: 0 0 0 4px rgba(42,92,125,0.1);
            outline: none;
        }

        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #dc3545;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .input-with-icon input {
            padding-left: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            cursor: pointer;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #2A5C7D;
        }

        /* Phone Format Toggle */
        .phone-format-toggle {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .format-option {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #6c757d;
            cursor: pointer;
        }

        .format-option input[type="radio"] {
            width: 14px;
            height: 14px;
            accent-color: #2A5C7D;
        }

        .format-option.active {
            color: #2A5C7D;
            font-weight: 500;
        }

        /* Radio Group */
        .radio-group {
            display: flex;
            gap: 20px;
            padding: 8px 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .radio-option:hover {
            border-color: #2A5C7D;
            background: rgba(42,92,125,0.05);
        }

        .radio-option input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #2A5C7D;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }

        .password-strength-text {
            font-size: 12px;
            margin-top: 5px;
            text-align: right;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #ffc107; width: 50%; }
        .strength-good { background: #17a2b8; width: 75%; }
        .strength-strong { background: #28a745; width: 100%; }

        /* Validation Icons */
        .validation-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
        }

        .validation-icon.valid {
            color: #28a745;
        }

        .validation-icon.invalid {
            color: #dc3545;
        }

        /* File Upload */
        .file-upload {
            border: 2px dashed #e9ecef;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload:hover {
            border-color: #2A5C7D;
            background: rgba(42,92,125,0.05);
        }

        .file-upload i {
            font-size: 32px;
            color: #2A5C7D;
            margin-bottom: 10px;
        }

        .file-upload p {
            color: #6c757d;
            font-size: 14px;
        }

        /* Terms Section */
        .terms-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .terms-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            accent-color: #2A5C7D;
        }

        .terms-checkbox label {
            font-size: 14px;
            color: #2C3E50;
            margin: 0;
        }

        .terms-checkbox a {
            color: #2A5C7D;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        /* Navigation Buttons */
        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .nav-btn {
            padding: 14px 30px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn.prev {
            background: #6c757d;
            color: white;
        }

        .nav-btn.next {
            background: linear-gradient(135deg, #2A5C7D, #4ECDC4);
            color: white;
            box-shadow: 0 5px 15px rgba(42,92,125,0.3);
        }

        .nav-btn.submit {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            box-shadow: 0 5px 15px rgba(76,175,80,0.3);
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 30px;
        }

        .login-link p {
            color: white;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .login-link a {
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* Tooltip */
        .tooltip {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #6c757d;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            font-size: 12px;
            margin-left: 5px;
            cursor: help;
            position: relative;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2C3E50;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 5px;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
            }

            .header h1 {
                font-size: 28px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .progress-section,
            .form-container {
                padding: 20px;
            }

            .alert {
                margin: 0 20px 20px;
            }

            .nav-btn {
                padding: 12px 20px;
                font-size: 14px;
            }

            .phone-format-toggle {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Field Error Message */
        .field-error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            padding-left: 5px;
        }

        /* Helper Text */
        .helper-text {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }

        /* Success Animation */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
        }

        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4CAF50;
        }

        .success-checkmark .check-icon::before {
            top: 3px;
            left: -2px;
            width: 30px;
            transform-origin: 100% 50%;
            border-radius: 100px 0 0 100px;
        }

        .success-checkmark .check-icon::after {
            top: 0;
            left: 30px;
            width: 60px;
            transform-origin: 0 50%;
            border-radius: 0 100px 100px 0;
            animation: rotate-circle 4.25s ease-in;
        }

        .success-checkmark .check-icon .icon-line {
            height: 5px;
            background-color: #4CAF50;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }

        .success-checkmark .check-icon .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s;
        }

        .success-checkmark .check-icon .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s;
        }

        @keyframes rotate-circle {
            0% { transform: rotate(-45deg); }
            5% { transform: rotate(-45deg); }
            12% { transform: rotate(-405deg); }
            100% { transform: rotate(-405deg); }
        }

        @keyframes icon-line-tip {
            0% { width: 0; left: 1px; top: 19px; }
            54% { width: 0; left: 1px; top: 19px; }
            70% { width: 50px; left: -8px; top: 37px; }
            84% { width: 17px; left: 21px; top: 48px; }
            100% { width: 25px; left: 14px; top: 45px; }
        }

        @keyframes icon-line-long {
            0% { width: 0; right: 46px; top: 54px; }
            65% { width: 0; right: 46px; top: 54px; }
            84% { width: 55px; right: 0px; top: 35px; }
            100% { width: 47px; right: 8px; top: 38px; }
        }
    </style>
</head>
<body>
    <div class="container">
    <!-- Header with Logo -->
    <div class="header">
        <div class="logo-container">
            <img src="../images/ABC logo.webp" 
                 alt="ABC Hospital Logo" 
                 class="logo-img" 
                 onerror="console.log('Image failed to load: ' + this.src); this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMDAgMjAwIj48cGF0aCBmaWxsPSIjMkE1QzdEIiBkPSJNMTAwIDEwTDEwIDEwMEwxMDAgMTkwTDE5MCAxMDBMMTAwIDEweiIvPjxjaXJjbGUgZmlsbD0iI0ZGRkZGRiIgY3g9IjEwMCIgY3k9IjEwMCIgcj0iNDAiLz48dGV4dCB4PSIxMDAiIHk9IjExMCIgZm9udC1zaXplPSI1MCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iIzJBNUM3RCIgZm9udC1mYW1pbHk9IkFyaWwiPkFCQzwvdGV4dD48L3N2Zz4=';">
        </div>
        <h1>Create Patient Account</h1>
        <p>Join ABC Virtual Healthcare System for Quality Medical Care</p>
    </div>

        <!-- Main Register Card -->
        <div class="register-card">
            <!-- Progress Bar -->
            <div class="progress-section">
                <div class="progress-steps">
                    <div class="step active" data-step="1">
                        <div class="step-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="step-label">Personal</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <div class="step-label">Contact</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-icon">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <div class="step-label">Medical</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-icon">
                            <i class="fas fa-user-lock"></i>
                        </div>
                        <div class="step-label">Account</div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Registration successful! Please check your email to verify your account.
                </div>
            <?php endif; ?>

            <?php if(!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <div class="form-container">
                <form id="registrationForm" method="POST" action="process-registration.php" enctype="multipart/form-data" novalidate>
                    <!-- Section 1: Personal Information -->
                    <div class="form-section active" id="section1">
                        <h3 class="section-title">
                            <i class="fas fa-user-circle"></i>
                            Personal Information
                        </h3>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-user"></i>
                                    Full Name *
                                </label>
                                <input type="text" 
                                       name="full_name" 
                                       id="full_name" 
                                       placeholder="Enter your full name"
                                       value="<?php echo htmlspecialchars($form_data['full_name'] ?? ''); ?>"
                                       required
                                       pattern="[A-Za-z\s]+"
                                       title="Name should contain only letters and spaces">
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-calendar-alt"></i>
                                    Date of Birth *
                                </label>
                                <input type="date" 
                                       name="dob" 
                                       id="dob" 
                                       value="<?php echo htmlspecialchars($form_data['dob'] ?? ''); ?>"
                                       required
                                       max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                                <small class="helper-text">Format: YYYY-MM-DD</small>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-venus-mars"></i>
                                    Gender *
                                </label>
                                <div class="radio-group">
                                    <label class="radio-option">
                                        <input type="radio" name="gender" value="Male" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Male') ? 'checked' : ''; ?> required>
                                        <i class="fas fa-mars"></i> Male
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="gender" value="Female" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Female') ? 'checked' : ''; ?> required>
                                        <i class="fas fa-venus"></i> Female
                                    </label>
                                    <label class="radio-option">
                                        <input type="radio" name="gender" value="Other" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Other') ? 'checked' : ''; ?> required>
                                        <i class="fas fa-genderless"></i> Other
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-tint"></i>
                                    Blood Group
                                    <span class="tooltip" data-tooltip="Optional, but helpful for emergencies">?</span>
                                </label>
                                <select name="blood_group" id="blood_group">
                                    <option value="">Select Blood Group</option>
                                    <?php
                                    $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                                    foreach($blood_groups as $bg) {
                                        $selected = (isset($form_data['blood_group']) && $form_data['blood_group'] == $bg) ? 'selected' : '';
                                        echo "<option value=\"$bg\" $selected>$bg</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contact Information -->
                    <div class="form-section" id="section2">
                        <h3 class="section-title">
                            <i class="fas fa-address-book"></i>
                            Contact Information
                        </h3>

                        <!-- Phone Format Toggle -->
                        <div class="phone-format-toggle">
                            <label class="format-option">
                                <input type="radio" name="phone_format" value="local" checked onclick="togglePhoneFormat('local')">
                                <span>Local Format (077 123 4567)</span>
                            </label>
                            <label class="format-option">
                                <input type="radio" name="phone_format" value="international" onclick="togglePhoneFormat('international')">
                                <span>International Format (+94 77 123 4567)</span>
                            </label>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-phone"></i>
                                    Phone Number *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone-alt"></i>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           class="phone-input"
                                           placeholder="077 123 4567"
                                           value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>"
                                           required
                                           data-local-pattern="[0-9\s]{10,12}"
                                           data-intl-pattern="^\+94[0-9]{9}$"
                                           pattern="[0-9\s]{10,12}"
                                           title="Please enter a valid Sri Lankan phone number (10 digits starting with 07)">
                                    <span class="validation-icon"></span>
                                </div>
                                <small class="helper-text">Enter 10-digit number starting with 07 (e.g., 077 123 4567)</small>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-ambulance"></i>
                                    Emergency Contact *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-phone-alt"></i>
                                    <input type="tel" 
                                           name="emergency_contact" 
                                           id="emergency_contact" 
                                           class="phone-input"
                                           placeholder="077 123 4567"
                                           value="<?php echo htmlspecialchars($form_data['emergency_contact'] ?? ''); ?>"
                                           required
                                           data-local-pattern="[0-9\s]{10,12}"
                                           data-intl-pattern="^\+94[0-9]{9}$"
                                           pattern="[0-9\s]{10,12}"
                                           title="Please enter a valid Sri Lankan phone number (10 digits starting with 07)">
                                </div>
                                <small class="helper-text">Enter 10-digit number starting with 07 (e.g., 077 123 4567)</small>
                            </div>

                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-map-marker-alt"></i>
                                    Address *
                                </label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3" 
                                          placeholder="Enter your complete address"
                                          required><?php echo htmlspecialchars($form_data['address'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-city"></i>
                                    City *
                                </label>
                                <input type="text" 
                                       name="city" 
                                       id="city" 
                                       value="<?php echo htmlspecialchars($form_data['city'] ?? ''); ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-mail-bulk"></i>
                                    Postal Code
                                </label>
                                <input type="text" 
                                       name="postal_code" 
                                       id="postal_code"
                                       value="<?php echo htmlspecialchars($form_data['postal_code'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Medical Information -->
                    <div class="form-section" id="section3">
                        <h3 class="section-title">
                            <i class="fas fa-notes-medical"></i>
                            Medical Information
                        </h3>

                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-allergies"></i>
                                    Allergies
                                    <span class="tooltip" data-tooltip="List any allergies to medications, foods, or other substances">?</span>
                                </label>
                                <textarea name="allergies" 
                                          id="allergies" 
                                          rows="2" 
                                          placeholder="E.g., Penicillin, Peanuts, Latex (leave blank if none)"><?php echo htmlspecialchars($form_data['allergies'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-pills"></i>
                                    Current Medications
                                </label>
                                <textarea name="medications" 
                                          id="medications" 
                                          rows="2" 
                                          placeholder="List any medications you are currently taking"><?php echo htmlspecialchars($form_data['medications'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-history"></i>
                                    Medical History
                                </label>
                                <textarea name="medical_history" 
                                          id="medical_history" 
                                          rows="3" 
                                          placeholder="Previous surgeries, chronic conditions, etc."><?php echo htmlspecialchars($form_data['medical_history'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-user-md"></i>
                                    Primary Care Physician
                                </label>
                                <input type="text" 
                                       name="primary_physician" 
                                       id="primary_physician" 
                                       value="<?php echo htmlspecialchars($form_data['primary_physician'] ?? ''); ?>"
                                       placeholder="Doctor's name (optional)">
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Account Setup -->
                    <div class="form-section" id="section4">
                        <h3 class="section-title">
                            <i class="fas fa-user-lock"></i>
                            Account Setup
                        </h3>

                        <div class="form-grid">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-envelope"></i>
                                    Email Address *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           placeholder="your@email.com"
                                           value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-user"></i>
                                    Username *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" 
                                           name="username" 
                                           id="username" 
                                           placeholder="Choose a username"
                                           value="<?php echo htmlspecialchars($form_data['username'] ?? ''); ?>"
                                           required
                                           pattern="[a-zA-Z0-9_]{4,20}"
                                           title="Username must be 4-20 characters and can contain letters, numbers, and underscore">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-lock"></i>
                                    Password *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           placeholder="Create a password"
                                           required
                                           minlength="8">
                                    <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                                </div>
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="passwordStrength"></div>
                                </div>
                                <div class="password-strength-text" id="passwordStrengthText"></div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <i class="fas fa-lock"></i>
                                    Confirm Password *
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" 
                                           name="confirm_password" 
                                           id="confirm_password" 
                                           placeholder="Confirm your password"
                                           required>
                                    <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label>
                                    <i class="fas fa-camera"></i>
                                    Profile Picture (Optional)
                                </label>
                                <div class="file-upload" onclick="document.getElementById('profile_picture').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click to upload or drag and drop</p>
                                    <small style="color: #6c757d;">Max size: 2MB (JPG, PNG, GIF)</small>
                                </div>
                                <input type="file" 
                                       name="profile_picture" 
                                       id="profile_picture" 
                                       accept="image/*"
                                       style="display: none;">
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="terms-section">
                            <div class="terms-checkbox">
                                <input type="checkbox" name="terms" id="terms" required>
                                <label for="terms">
                                    I agree to the <a href="#" onclick="showTermsModal(); return false;">Terms and Conditions</a> 
                                    and <a href="#" onclick="showPrivacyModal(); return false;">Privacy Policy</a> *
                                </label>
                            </div>
                            <div style="margin-top: 15px; padding: 15px; background: white; border-radius: 8px; font-size: 13px; color: #6c757d;">
                                <strong>By registering, you confirm that:</strong>
                                <ul style="margin-top: 10px; margin-left: 20px;">
                                    <li>All information provided is accurate and complete</li>
                                    <li>You agree to receive appointment notifications via SMS/Email</li>
                                    <li>Your medical records will be kept confidential</li>
                                    <li>You consent to telemedicine consultations when applicable</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="form-navigation">
                        <button type="button" class="nav-btn prev" id="prevBtn" disabled>
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <button type="button" class="nav-btn next" id="nextBtn">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" class="nav-btn submit" id="submitBtn" style="display: none;">
                            <i class="fas fa-check-circle"></i> Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Login Link -->
        <div class="login-link">
            <p>Already have an account?</p>
            <a href="login.php?type=patient">
                <i class="fas fa-sign-in-alt"></i> Sign In to Your Account
            </a>
        </div>
    </div>

    <!-- Terms Modal -->
    <div id="termsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: white; max-width: 700px; max-height: 80vh; overflow-y: auto; border-radius: 20px; padding: 30px; position: relative;">
            <button onclick="closeTermsModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #6c757d;">&times;</button>
            <h2 style="color: #2A5C7D; margin-bottom: 20px;">Terms and Conditions</h2>
            <div style="line-height: 1.8; color: #2C3E50;">
                <h4>1. Acceptance of Terms</h4>
                <p>By accessing and using the ABC Virtual Healthcare System, you agree to be bound by these Terms and Conditions.</p>
                
                <h4>2. Medical Services</h4>
                <p>Our virtual healthcare platform provides access to medical consultations, appointment scheduling, and health records management. All medical services are provided by licensed healthcare professionals.</p>
                
                <h4>3. Privacy and Data Protection</h4>
                <p>We are committed to protecting your privacy. All personal and medical information is handled in accordance with applicable data protection laws and our Privacy Policy.</p>
                
                <h4>4. User Responsibilities</h4>
                <p>You are responsible for providing accurate information and maintaining the confidentiality of your account credentials.</p>
                
                <h4>5. Telemedicine Consent</h4>
                <p>Telemedicine consultations involve the use of electronic communications to enable healthcare providers to deliver services. While there are potential benefits, there are also risks such as technical failures.</p>
                
                <h4>6. Appointment Policies</h4>
                <p>Cancellations must be made at least 24 hours in advance. Late cancellations may be subject to fees.</p>
                
                <h4>7. Emergency Situations</h4>
                <p>This platform is not for emergency situations. If you are experiencing a medical emergency, please call emergency services immediately.</p>
            </div>
            <button onclick="closeTermsModal()" style="margin-top: 20px; padding: 12px 30px; background: #2A5C7D; color: white; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px;">I Understand</button>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: white; max-width: 700px; max-height: 80vh; overflow-y: auto; border-radius: 20px; padding: 30px; position: relative;">
            <button onclick="closePrivacyModal()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: #6c757d;">&times;</button>
            <h2 style="color: #2A5C7D; margin-bottom: 20px;">Privacy Policy</h2>
            <div style="line-height: 1.8; color: #2C3E50;">
                <h4>Information We Collect</h4>
                <p>We collect personal information including name, contact details, medical history, and payment information necessary for providing healthcare services.</p>
                
                <h4>How We Use Your Information</h4>
                <p>Your information is used to provide medical services, process appointments, communicate with you, and improve our services.</p>
                
                <h4>Data Security</h4>
                <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access.</p>
                
                <h4>Your Rights</h4>
                <p>You have the right to access, correct, or delete your personal information, subject to legal and medical record retention requirements.</p>
            </div>
            <button onclick="closePrivacyModal()" style="margin-top: 20px; padding: 12px 30px; background: #2A5C7D; color: white; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-size: 16px;">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSection = 1;
            const totalSections = 4;
            
            const sections = document.querySelectorAll('.form-section');
            const steps = document.querySelectorAll('.step');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            
            // Initialize form with any saved data
            initializeForm();
            
            function updateNavigation() {
                sections.forEach((section, index) => {
                    section.classList.toggle('active', index + 1 === currentSection);
                });
                
                steps.forEach((step, index) => {
                    if(index + 1 < currentSection) {
                        step.classList.add('completed');
                        step.classList.remove('active');
                    } else if(index + 1 === currentSection) {
                        step.classList.add('active');
                        step.classList.remove('completed');
                    } else {
                        step.classList.remove('active', 'completed');
                    }
                });
                
                prevBtn.disabled = currentSection === 1;
                
                if(currentSection === totalSections) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'inline-flex';
                } else {
                    nextBtn.style.display = 'inline-flex';
                    submitBtn.style.display = 'none';
                }
            }
            
            function validateSection(sectionNum) {
                const currentSectionEl = document.getElementById(`section${sectionNum}`);
                const requiredFields = currentSectionEl.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if(!field.value.trim()) {
                        field.classList.add('error');
                        isValid = false;
                        
                        // Show error message
                        showFieldError(field, 'This field is required');
                    } else {
                        field.classList.remove('error');
                        removeFieldError(field);
                        
                        // Additional validation based on field type
                        if(field.type === 'email' && !isValidEmail(field.value)) {
                            field.classList.add('error');
                            showFieldError(field, 'Please enter a valid email address');
                            isValid = false;
                        }
                        
                        if(field.classList.contains('phone-input')) {
                            if(!isValidPhone(field.value)) {
                                field.classList.add('error');
                                showFieldError(field, 'Please enter a valid phone number (10 digits starting with 07)');
                                isValid = false;
                            }
                        }
                        
                        if(field.id === 'username' && field.value.length < 4) {
                            field.classList.add('error');
                            showFieldError(field, 'Username must be at least 4 characters');
                            isValid = false;
                        }
                    }
                });
                
                return isValid;
            }
            
            function showFieldError(field, message) {
                let errorDiv = field.parentElement.querySelector('.field-error');
                if(!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error';
                    errorDiv.style.color = '#dc3545';
                    errorDiv.style.fontSize = '12px';
                    errorDiv.style.marginTop = '5px';
                    field.parentElement.appendChild(errorDiv);
                }
                errorDiv.textContent = message;
            }
            
            function removeFieldError(field) {
                const errorDiv = field.parentElement.querySelector('.field-error');
                if(errorDiv) errorDiv.remove();
            }
            
            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }
            
            function isValidPhone(phone) {
                // Remove all spaces
                const cleanPhone = phone.replace(/\s/g, '');
                
                // Check for local format (10 digits starting with 07)
                if(/^07[0-9]{8}$/.test(cleanPhone)) {
                    return true;
                }
                
                // Check for international format (+94 followed by 9 digits)
                if(/^\+94[0-9]{9}$/.test(cleanPhone)) {
                    return true;
                }
                
                return false;
            }
            
            function initializeForm() {
                // Load saved form data if any
                <?php if(!empty($form_data)): ?>
                const savedData = <?php echo json_encode($form_data); ?>;
                Object.keys(savedData).forEach(key => {
                    const field = document.querySelector(`[name="${key}"]`);
                    if(field) {
                        field.value = savedData[key];
                    }
                });
                <?php endif; ?>
            }
            
            // Next button click
            nextBtn.addEventListener('click', function() {
                if(validateSection(currentSection)) {
                    if(currentSection < totalSections) {
                        currentSection++;
                        updateNavigation();
                        document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
            
            // Previous button click
            prevBtn.addEventListener('click', function() {
                if(currentSection > 1) {
                    currentSection--;
                    updateNavigation();
                    document.querySelector('.form-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
            
            // Form submission
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if(!validateSection(currentSection)) {
                    return;
                }
                
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                
                if(password !== confirmPassword) {
                    showNotification('Passwords do not match!', 'error');
                    return;
                }
                
                if(!document.getElementById('terms').checked) {
                    showNotification('You must agree to the Terms and Conditions', 'error');
                    return;
                }
                
                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner"></span> Creating Account...';
                submitBtn.disabled = true;
                
                // Submit form
                this.submit();
            });
            
            // Real-time validation
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if(this.value.trim()) {
                        this.classList.remove('error');
                        removeFieldError(this);
                    }
                });
            });
            
            // Password strength checker
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const strengthBar = document.getElementById('passwordStrength');
                const strengthText = document.getElementById('passwordStrengthText');
                
                let strength = 0;
                
                if(password.length >= 8) strength++;
                if(password.match(/[a-z]+/)) strength++;
                if(password.match(/[A-Z]+/)) strength++;
                if(password.match(/[0-9]+/)) strength++;
                if(password.match(/[$@#&!]+/)) strength++;
                
                strengthBar.className = 'password-strength-bar';
                
                if(password.length === 0) {
                    strengthBar.style.width = '0';
                    strengthText.textContent = '';
                } else if(strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = 'Weak';
                    strengthText.style.color = '#dc3545';
                } else if(strength <= 3) {
                    strengthBar.classList.add('strength-fair');
                    strengthText.textContent = 'Fair';
                    strengthText.style.color = '#ffc107';
                } else if(strength <= 4) {
                    strengthBar.classList.add('strength-good');
                    strengthText.textContent = 'Good';
                    strengthText.style.color = '#17a2b8';
                } else {
                    strengthBar.classList.add('strength-strong');
                    strengthText.textContent = 'Strong';
                    strengthText.style.color = '#28a745';
                }
            });
            
            // Phone number formatting
            document.getElementById('phone').addEventListener('input', formatPhone);
            document.getElementById('emergency_contact').addEventListener('input', formatPhone);
            
            // Phone validation on blur
            document.getElementById('phone').addEventListener('blur', function() {
                validatePhoneField(this);
            });
            
            document.getElementById('emergency_contact').addEventListener('blur', function() {
                validatePhoneField(this);
            });
            
            function formatPhone(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove all non-digits
                const currentFormat = document.querySelector('input[name="phone_format"]:checked').value;
                
                if(currentFormat === 'international') {
                    // International format: +94 XX XXX XXXX
                    if(value.length > 0) {
                        if(!value.startsWith('94') && !value.startsWith('+')) {
                            value = '94' + value;
                        }
                        value = '+' + value.replace(/^\+?94/, '');
                        
                        if(value.length > 3) {
                            value = value.substring(0,3) + ' ' + value.substring(3);
                        }
                        if(value.length > 7) {
                            value = value.substring(0,7) + ' ' + value.substring(7);
                        }
                        if(value.length > 11) {
                            value = value.substring(0,11) + ' ' + value.substring(11,15);
                        }
                    }
                } else {
                    // Local format: XXX XXX XXXX
                    if(value.length > 0) {
                        if(value.startsWith('94')) {
                            value = '0' + value.substring(2);
                        }
                        if(value.length > 3) {
                            value = value.substring(0,3) + ' ' + value.substring(3);
                        }
                        if(value.length > 7) {
                            value = value.substring(0,7) + ' ' + value.substring(7);
                        }
                    }
                }
                
                e.target.value = value;
            }
            
            function validatePhoneField(field) {
                if(!isValidPhone(field.value)) {
                    field.classList.add('error');
                    showFieldError(field, 'Please enter a valid phone number (10 digits starting with 07)');
                } else {
                    field.classList.remove('error');
                    removeFieldError(field);
                }
            }
            
            // Username availability check
            let usernameTimer;
            document.getElementById('username').addEventListener('input', function() {
                clearTimeout(usernameTimer);
                const username = this.value;
                
                if(username.length >= 4) {
                    usernameTimer = setTimeout(() => {
                        // Simulate AJAX check
                        checkUsernameAvailability(username);
                    }, 500);
                }
            });
            
            function checkUsernameAvailability(username) {
                // This would be an AJAX call in production
                console.log('Checking username:', username);
            }
            
            // Date of birth validation
            document.getElementById('dob').addEventListener('change', function() {
                const dob = new Date(this.value);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if(age < 18 || (age === 18 && monthDiff < 0)) {
                    showNotification('You must be at least 18 years old to register', 'error');
                    this.value = '';
                }
            });
            
            // File upload preview
            document.getElementById('profile_picture').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if(file) {
                    if(file.size > 2 * 1024 * 1024) {
                        showNotification('File size must be less than 2MB', 'error');
                        this.value = '';
                    } else if(!file.type.match('image.*')) {
                        showNotification('Please select an image file', 'error');
                        this.value = '';
                    } else {
                        // Show file name
                        const uploadDiv = document.querySelector('.file-upload p');
                        uploadDiv.innerHTML = `<i class="fas fa-check-circle" style="color: #28a745;"></i> ${file.name}`;
                    }
                }
            });
            
            // Notification function
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type}`;
                notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.zIndex = '10001';
                notification.style.minWidth = '300px';
                notification.style.animation = 'slideDown 0.3s ease';
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 5000);
            }
        });
        
        // Password toggle function
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if(input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Phone format toggle function
        function togglePhoneFormat(format) {
            const phoneFields = document.querySelectorAll('.phone-input');
            const localPattern = '[0-9\\s]{10,12}';
            const intlPattern = '^\\+94[0-9]{9}$';
            
            phoneFields.forEach(field => {
                if (format === 'international') {
                    field.placeholder = '+94 77 123 4567';
                    field.pattern = intlPattern;
                    field.setAttribute('title', 'Format: +94 77 123 4567');
                } else {
                    field.placeholder = '077 123 4567';
                    field.pattern = localPattern;
                    field.setAttribute('title', 'Format: 077 123 4567');
                }
                
                // Reformat existing value
                if (field.value) {
                    const event = new Event('input', { bubbles: true });
                    field.dispatchEvent(event);
                }
            });
        }
        
        // Modal functions
        function showTermsModal() {
            document.getElementById('termsModal').style.display = 'flex';
        }
        
        function closeTermsModal() {
            document.getElementById('termsModal').style.display = 'none';
        }
        
        function showPrivacyModal() {
            document.getElementById('privacyModal').style.display = 'flex';
        }
        
        function closePrivacyModal() {
            document.getElementById('privacyModal').style.display = 'none';
        }
        
        // Close modals on outside click
        window.onclick = function(event) {
            const termsModal = document.getElementById('termsModal');
            const privacyModal = document.getElementById('privacyModal');
            if(event.target === termsModal) {
                termsModal.style.display = 'none';
            }
            if(event.target === privacyModal) {
                privacyModal.style.display = 'none';
            }
        };
    </script>
</body>
</html>