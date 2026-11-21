<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$pageTitle = "Contact Us - ABC Virtual Healthcare";
$base_url = '/abc_hospital_virtual_appointment';

// Include database connection
require_once 'db_connection.php';

// Initialize variables
$success_message = '';
$error_message = '';
$form_data = [];
$debug_info = '';

// Handle contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    
    // Start debug output
    $debug_info .= "<div style='background:#e3f2fd; padding:15px; margin:15rem 15px 15px; border:2px solid #2196F3; border-radius:5px; font-family:Arial; position:relative; z-index:9999;'>";
    $debug_info .= "<h3 style='margin-top:0; color:#0d47a1;'>🔍 DEBUG INFORMATION</h3>";
    $debug_info .= "<p><strong>Form submitted at:</strong> " . date('Y-m-d H:i:s') . "</p>";
    
    // Get and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Map subject values to match ENUM options
    $subject_map = [
        'appointment' => 'Appointment Query',
        'billing' => 'Billing & Insurance',
        'medical' => 'Medical Records',
        'technical' => 'Technical Support',
        'feedback' => 'Feedback',
        'general' => 'General Inquiry'
    ];
    
    // Map the subject value
    if (isset($subject_map[$subject])) {
        $subject = $subject_map[$subject];
    }
    
    $debug_info .= "<p><strong>Raw POST data received:</strong></p>";
    $debug_info .= "<table style='border-collapse:collapse; width:100%; background:white;' border='1' cellpadding='5'>";
    $debug_info .= "<tr><th>Field</th><th>Value</th></tr>";
    $debug_info .= "<tr><td>Name</td><td>" . ($name ?: '<span style="color:red;">EMPTY</span>') . "</td></tr>";
    $debug_info .= "<tr><td>Email</td><td>" . ($email ?: '<span style="color:red;">EMPTY</span>') . "</td></tr>";
    $debug_info .= "<tr><td>Phone</td><td>" . ($phone ?: 'EMPTY') . "</td></tr>";
    $debug_info .= "<tr><td>Subject</td><td>" . ($subject ?: '<span style="color:red;">EMPTY</span>') . "</td></tr>";
    $debug_info .= "<tr><td>Message</td><td>" . ($message ?: '<span style="color:red;">EMPTY</span>') . "</td></tr>";
    $debug_info .= "</table>";
    
    $form_data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message
    ];
    
    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = "Please fill in all required fields.";
        $debug_info .= "<p style='color:red; font-weight:bold;'>❌ Validation failed: Empty fields detected</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
        $debug_info .= "<p style='color:red; font-weight:bold;'>❌ Validation failed: Invalid email format</p>";
    } else {
        $debug_info .= "<p style='color:green; font-weight:bold;'>✅ Validation passed</p>";
        
        // Check database connection
        if (!$mysqli) {
            $error_message = "Database connection failed";
            $debug_info .= "<p style='color:red; font-weight:bold;'>❌ Database connection failed</p>";
        } else {
            // Save to database - USING CORRECT TABLE NAME AND COLUMNS
            $name = $mysqli->real_escape_string($name);
            $email = $mysqli->real_escape_string($email);
            $phone = $mysqli->real_escape_string($phone);
            $subject = $mysqli->real_escape_string($subject);
            $message = $mysqli->real_escape_string($message);
            
            $debug_info .= "<p><strong>Using table:</strong> <code>send_us_a_message</code></p>";
            $debug_info .= "<p><strong>Table columns:</strong> id, name, email_address, phone_number, subject, message, created_at</p>";
            
            // SQL QUERY - matching your table structure
            $sql = "INSERT INTO `send_us_a_message` (`name`, `email_address`, `phone_number`, `subject`, `message`, `created_at`) 
                    VALUES ('$name', '$email', '$phone', '$subject', '$message', NOW())";
            
            $debug_info .= "<p><strong>SQL Query:</strong></p>";
            $debug_info .= "<code style='background:#f5f5f5; padding:10px; display:block; border:1px solid #ddd;'>" . htmlspecialchars($sql) . "</code>";
            
            // Execute query
            if ($mysqli->query($sql)) {
                $success_message = "Thank you! Your message has been sent successfully. We'll get back to you within 24 hours.";
                
                // Clear form data on success
                $form_data = [];
                
                $debug_info .= "<p style='color:green; font-weight:bold; font-size:16px;'>✅ DATABASE INSERT SUCCESSFUL!</p>";
                $debug_info .= "<p><strong>New Record ID:</strong> " . $mysqli->insert_id . "</p>";
                
                // Verify the inserted data
                $result = $mysqli->query("SELECT * FROM `send_us_a_message` WHERE `id` = " . $mysqli->insert_id);
                if ($result && $row = $result->fetch_assoc()) {
                    $debug_info .= "<p><strong>Inserted data verification:</strong></p>";
                    $debug_info .= "<pre style='background:#f5f5f5; padding:10px;'>";
                    $debug_info .= "ID: " . $row['id'] . "\n";
                    $debug_info .= "Name: " . $row['name'] . "\n";
                    $debug_info .= "Email: " . $row['email_address'] . "\n";
                    $debug_info .= "Subject: " . $row['subject'] . "\n";
                    $debug_info .= "Created: " . $row['created_at'];
                    $debug_info .= "</pre>";
                }
                
            } else {
                $error_message = "Error: " . $mysqli->error;
                $debug_info .= "<p style='color:red; font-weight:bold; font-size:16px;'>❌ DATABASE INSERT FAILED!</p>";
                $debug_info .= "<p><strong>MySQL Error:</strong> " . $mysqli->error . "</p>";
                $debug_info .= "<p><strong>MySQL Error Number:</strong> " . $mysqli->errno . "</p>";
                
                // Check for specific errors
                if ($mysqli->errno == 1062) {
                    $debug_info .= "<p><strong>Error Type:</strong> Duplicate entry</p>";
                } elseif ($mysqli->errno == 1452) {
                    $debug_info .= "<p><strong>Error Type:</strong> Foreign key constraint fails</p>";
                } elseif ($mysqli->errno == 1048) {
                    $debug_info .= "<p><strong>Error Type:</strong> Column cannot be NULL - This means your table allows NULL but we're trying to insert empty values</p>";
                } elseif ($mysqli->errno == 1265) {
                    $debug_info .= "<p><strong>Error Type:</strong> Data truncated for ENUM field - Check subject value: '$subject'</p>";
                }
            }
        }
    }
    
    $debug_info .= "</div>";
}

// Test database connection and table
try {
    if ($mysqli) {
        $test_query = $mysqli->query("SELECT COUNT(*) as count FROM `send_us_a_message`");
        if ($test_query) {
            $count = $test_query->fetch_assoc()['count'];
            // You can uncomment this for testing
            // echo "<!-- Table has $count records -->";
        }
    }
} catch (Exception $e) {
    // Table might not exist yet
    error_log("Table check failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="Contact ABC Hospital - Get in touch with Sri Lanka's leading healthcare provider. Book appointments, ask questions, or provide feedback.">
    <meta name="keywords" content="contact hospital, ABC Hospital, healthcare Sri Lanka, hospital contact, medical inquiries">
     
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/contact.jpg">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    
    <style>
        /* Page Specific Styles */
        .page-header {
            background: linear-gradient(135deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            padding: 120px 0 60px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            animation: gradientShift 8s ease infinite;
            background-size: 200% 200%;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.1;
            animation: wave 10s linear infinite;
        }
        
        @keyframes wave {
            0% { transform: translateX(0) scaleX(1); }
            50% { transform: translateX(-5%) scaleX(1.05); }
            100% { transform: translateX(0) scaleX(1); }
        }
        
        .page-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .page-header h1 {
            font-size: 52px;
            margin-bottom: 15px;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            animation: floatText 3s ease-in-out infinite;
        }
        
        @keyframes floatText {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }
        
        .page-header p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 20px;
            position: relative;
            opacity: 0.95;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .breadcrumb {
            position: relative;
            margin-top: 20px;
            display: inline-block;
            padding: 10px 25px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumb a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .breadcrumb a:hover {
            color: #ffd700;
            transform: translateY(-2px);
        }
        
        .breadcrumb span {
            margin: 0 10px;
            opacity: 0.7;
        }
        
        /* Contact Info Cards */
        .contact-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin: -50px 0 60px;
            position: relative;
            z-index: 10;
        }
        
        .contact-info-card {
            background: white;
            padding: 35px 20px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .contact-info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .contact-info-card .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .contact-info-card .icon i {
            font-size: 30px;
            color: white;
        }
        
        .contact-info-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .contact-info-card p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }
        
        .contact-info-card .detail {
            font-weight: 600;
            color: #4f46e5;
        }
        
        /* Map Section */
        .map-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border: 5px solid white;
        }
        
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }
        
        /* Contact Form Section */
        .contact-form-section {
            padding: 80px 0;
            background: white;
        }
        
        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        
        .contact-info-detailed,
        .contact-form-container {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .contact-info-detailed h2,
        .contact-form-container h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
        }
        
        .contact-info-detailed h2:after,
        .contact-form-container h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #4f46e5, #ff6b6b);
            border-radius: 3px;
        }
        
        .info-list-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s;
            border-left: 3px solid #4f46e5;
        }
        
        .info-list-item:hover {
            transform: translateX(5px);
            background: #f0f3ff;
        }
        
        .info-list-item i {
            font-size: 22px;
            color: #4f46e5;
        }
        
        .info-list-item h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }
        
        .info-list-item p {
            color: #666;
            font-size: 14px;
        }
        
        .business-hours {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            border: 1px solid rgba(79, 70, 229, 0.2);
        }
        
        .business-hours h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .business-hours h3 i {
            color: #4f46e5;
        }
        
        .hours-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        
        .hours-row:last-child {
            border-bottom: none;
        }
        
        .hours-row .time {
            color: #4f46e5;
            font-weight: 500;
        }
        
        .emergency-note {
            margin-top: 15px;
            padding: 15px;
            background: #fee2e2;
            border-radius: 12px;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #dc2626;
        }
        
        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #dc2626;
        }
        
        /* Button Styles */
        .btn-primary {
            background: #ff6b6b;
            color: white;
            border: 2px solid #ff6b6b;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            background: #ff5252;
            border-color: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }
        
        .btn-outline-light {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn-outline-light:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }
        
        .btn-block {
            width: 100%;
        }
        
        /* Login/Register Buttons */
        .btn-login {
            background: transparent !important;
            border: 2px solid #ff6b6b !important;
            color: #ff6b6b !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            margin-left: 5px !important;
        }
        
        .btn-login:hover {
            background: #ff6b6b !important;
            color: #fff !important;
            border-color: #ff6b6b !important;
        }
        
        .btn-register {
            background: #ff6b6b !important;
            border: 2px solid #ff6b6b !important;
            color: #fff !important;
            padding: 8px 20px !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            margin-left: 5px !important;
        }
        
        .btn-register:hover {
            background: #ff5252 !important;
            border-color: #ff5252 !important;
        }
        
        /* FAQ Section */
        .faq-section {
            padding: 60px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf1 100%);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-subtitle {
            color: #4f46e5;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
        }
        
        .section-title {
            font-size: 36px;
            margin: 10px 0;
            color: #333;
        }
        
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }
        
        .faq-item {
            background: white;
            padding: 25px;
            border-radius: 15px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .faq-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: #4f46e5;
        }
        
        .faq-item h3 {
            font-size: 18px;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .faq-item p {
            color: #666;
            line-height: 1.6;
            display: none;
            font-size: 14px;
        }
        
        .faq-item.active p {
            display: block;
        }
        
        .faq-item i {
            transition: transform 0.3s;
            color: #4f46e5;
        }
        
        .faq-item.active i {
            transform: rotate(180deg);
        }
        
        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.1;
        }
        
        .cta-content {
            position: relative;
            z-index: 1;
        }
        
        .cta h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .cta p {
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        /* Social Links */
        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 38px;
            height: 38px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .social-links a:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Alert Messages */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .close-btn {
            margin-left: auto;
            cursor: pointer;
            font-size: 18px;
            opacity: 0.7;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .contact-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .contact-wrapper {
                grid-template-columns: 1fr;
            }
            
            .faq-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 576px) {
            .contact-info-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header h1 {
                font-size: 36px;
            }
            
            .cta h2 {
                font-size: 24px;
            }
        }
        
        /* Navigation */
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
        
        .nav-links li:last-child {
            margin-right: 0;
        }
        
        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        /* Dark text */
        .dark-text {
            color: #000000 !important;
            font-weight: 500;
        }
        
        /* Text gradient */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4f46e5;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Back to Top */
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 40px;
            height: 40px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99;
            transition: all 0.3s;
        }
        
        #backToTop:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Show debug info at the top of the page (only when form is submitted) -->
    <?php if (!empty($debug_info)) echo $debug_info; ?>

    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-fixed">
        <div class="container">
            <div class="nav-wrapper">
                <a href="<?php echo $base_url; ?>/index.php" class="logo">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                    <span class="logo-text">ABC <span class="text-highlight">VIRTUAL</span></span>
                </a>
                
                <ul class="nav-links" id="navMenu">
                    <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php" class="active">Contact</a></li>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 data-aos="fade-up">Contact Us</h1>
            <p data-aos="fade-up" data-aos-delay="100">We're here to help you with any questions or concerns</p>
            <div class="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo $base_url; ?>/index.php">Home</a>
                <span>/</span>
                <span>Contact</span>
            </div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <div class="container">
        <div class="contact-info-grid">
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="100">
                <div class="icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Call Us</h3>
                <p class="detail">+94 11 234 5678</p>
                <p>Emergency: +94 11 234 5679</p>
                <p>24/7 Support</p>
            </div>
            
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="200">
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email Us</h3>
                <p class="detail">info@abchospital.lk</p>
                <p>support@abcvirtual.lk</p>
                <p>appointments@abchospital.lk</p>
            </div>
            
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="300">
                <div class="icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Visit Us</h3>
                <p class="detail">123 Hospital Road</p>
                <p>Colombo 05</p>
                <p>Sri Lanka</p>
            </div>
            
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="400">
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Working Hours</h3>
                <p class="detail">Mon - Fri: 8AM - 8PM</p>
                <p>Sat - Sun: 9AM - 5PM</p>
                <p>Emergency: 24/7</p>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container" data-aos="zoom-in">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467531612!2d79.861245!3d6.902156!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596d3c6b1b7b%3A0x1f6c7f8a5d8e7b0!2sColombo%2005%2C%20Sri%20Lanka!5e0!3m2!1sen!2s!4v1620000000000!5m2!1sen!2s" 
                        allowfullscreen="" 
                        loading="lazy"
                        title="ABC Hospital Location">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-wrapper">
                <!-- Detailed Contact Info -->
                <div class="contact-info-detailed" data-aos="fade-right">
                    <h2>Get in Touch</h2>
                    <p>Have questions about our services, appointments, or anything else? We're here to help.</p>
                    
                    <div class="info-list">
                        <div class="info-list-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Main Hospital</h4>
                                <p>123 Hospital Road, Colombo 05, Sri Lanka</p>
                                <p style="margin-top: 5px;"><i class="fas fa-phone"></i> +94 11 234 5678</p>
                            </div>
                        </div>
                        
                        <div class="info-list-item">
                            <i class="fas fa-building"></i>
                            <div>
                                <h4>Kandy Branch</h4>
                                <p>45 Peradeniya Road, Kandy, Sri Lanka</p>
                                <p style="margin-top: 5px;"><i class="fas fa-phone"></i> +94 81 234 5678</p>
                            </div>
                        </div>
                        
                        <div class="info-list-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email Departments</h4>
                                <p>General: info@abchospital.lk</p>
                                <p>Appointments: appointments@abchospital.lk</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="business-hours">
                        <h3><i class="fas fa-clock"></i> Business Hours</h3>
                        <div class="hours-row">
                            <span class="day">Monday - Friday</span>
                            <span class="time">8:00 AM - 8:00 PM</span>
                        </div>
                        <div class="hours-row">
                            <span class="day">Saturday - Sunday</span>
                            <span class="time">9:00 AM - 5:00 PM</span>
                        </div>
                        <div class="hours-row">
                            <span class="day">Emergency</span>
                            <span class="time">24/7</span>
                        </div>
                        
                        <div class="emergency-note">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Emergency:</strong> +94 11 234 5679
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="contact-form-container" data-aos="fade-left">
                    <?php if ($success_message): ?>
                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success_message; ?>
                        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                    <div class="alert alert-error" id="errorAlert">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error_message; ?>
                        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
                    </div>
                    <?php endif; ?>
                    
                    <h2>Send us a Message</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="contactForm">
                        <div class="form-group">
                            <input type="text" 
                                   name="name" 
                                   placeholder="Your Full Name *"
                                   value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <input type="email" 
                                   name="email" 
                                   placeholder="Your Email Address *"
                                   value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <input type="tel" 
                                   name="phone" 
                                   placeholder="Phone Number (Optional)"
                                   value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <select name="subject" required>
                                <option value="" disabled <?php echo empty($form_data['subject']) ? 'selected' : ''; ?>>Select Subject *</option>
                                <option value="appointment" <?php echo ($form_data['subject'] ?? '') == 'Appointment Query' ? 'selected' : ''; ?>>Appointment Query</option>
                                <option value="billing" <?php echo ($form_data['subject'] ?? '') == 'Billing & Insurance' ? 'selected' : ''; ?>>Billing & Insurance</option>
                                <option value="medical" <?php echo ($form_data['subject'] ?? '') == 'Medical Records' ? 'selected' : ''; ?>>Medical Records</option>
                                <option value="technical" <?php echo ($form_data['subject'] ?? '') == 'Technical Support' ? 'selected' : ''; ?>>Technical Support</option>
                                <option value="feedback" <?php echo ($form_data['subject'] ?? '') == 'Feedback' ? 'selected' : ''; ?>>Feedback</option>
                                <option value="general" <?php echo ($form_data['subject'] ?? '') == 'General Inquiry' ? 'selected' : ''; ?>>General Inquiry</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="message" 
                                      rows="5" 
                                      placeholder="Your Message *" 
                                      required><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
                        </div>
                        
                        <input type="hidden" name="submit_contact" value="1">
                        
                        <button type="submit" class="btn-primary btn-block">
                            Send Message <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="section-subtitle">FAQ</span>
                <h2 class="section-title">Frequently Asked <span class="text-gradient">Questions</span></h2>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>How do I book an appointment?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>Book appointments through our website or Patient Portal. Call +94 11 234 5678 for assistance.</p>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>What are your visiting hours?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>Visiting hours: 10AM-12PM & 4PM-6PM daily. ICU has different policies.</p>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>Do you accept international patients?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>Yes, we welcome international patients. Contact our international services department.</p>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>What insurance do you accept?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>We accept major Sri Lankan and international insurance providers.</p>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>How do I access my medical records?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>Access records through Patient Portal or visit medical records department with ID.</p>
                </div>
                
                <div class="faq-item" onclick="toggleFAQ(this)">
                    <h3>
                        <span>Is parking available?</span>
                        <i class="fas fa-chevron-down"></i>
                    </h3>
                    <p>Yes, multi-story parking with 500+ spaces. Valet parking available 7AM-8PM.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2>Need Immediate Assistance?</h2>
                <p>Our support team is available 24/7 to help you with any urgent matters</p>
                
                <div class="cta-buttons">
                    <a href="tel:+94112345679" class="btn-primary">
                        <i class="fas fa-phone-alt"></i> Call Emergency
                    </a>
                    <a href="<?php echo $base_url; ?>/appointments.php" class="btn-outline-light">
                        <i class="fas fa-calendar-check"></i> Book Appointment
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/40x40/4f46e5/ffffff?text=ABC';">
                        <span>ABC VIRTUAL</span>
                    </div>
                    <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="<?php echo $base_url; ?>/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                        <li><a href="<?php echo $base_url; ?>/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                        <li><a href="<?php echo $base_url; ?>/departments.php"><i class="fas fa-chevron-right"></i> Departments</a></li>
                        <li><a href="<?php echo $base_url; ?>/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                        <li><a href="<?php echo $base_url; ?>/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="<?php echo $base_url; ?>/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Our Portals</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=patient"><i class="fas fa-chevron-right"></i> Patient Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=doctor"><i class="fas fa-chevron-right"></i> Doctor Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=admin"><i class="fas fa-chevron-right"></i> Admin Portal</a></li>
                        <li><a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist"><i class="fas fa-chevron-right"></i> Receptionist Portal</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Subscribe for health tips and updates</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                        <input type="email" placeholder="Your Email" required>
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> for better healthcare</p>
                <div class="footer-bottom-links">
                    <a href="<?php echo $base_url; ?>/terms-of-use.php">Terms of Use</a>
                    <a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a>
                    <a href="<?php echo $base_url; ?>/cookie-policy.php">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?php echo $base_url; ?>/js/main.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Mobile Navigation Toggle
        const navToggle = document.getElementById('navToggle');
        const navMenu = document.getElementById('navMenu');

        if (navToggle && navMenu) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (backToTop) {
                if (window.scrollY > 300) {
                    backToTop.style.display = 'flex';
                } else {
                    backToTop.style.display = 'none';
                }
            }
        });

        if (backToTop) {
            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // FAQ Toggle Function
        function toggleFAQ(element) {
            element.classList.toggle('active');
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 1000);
            });
        }, 5000);

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }
        });

        // Form Validation
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.querySelector('input[name="name"]');
            const email = document.querySelector('input[name="email"]');
            const subject = document.querySelector('select[name="subject"]');
            const message = document.querySelector('textarea[name="message"]');
            
            // Reset error states
            [name, email, subject, message].forEach(field => {
                if (field) field.classList.remove('error');
            });
            
            // Validate Name
            if (!name.value.trim()) {
                name.classList.add('error');
                isValid = false;
            }
            
            // Validate Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                email.classList.add('error');
                isValid = false;
            }
            
            // Validate Subject
            if (!subject.value) {
                subject.classList.add('error');
                isValid = false;
            }
            
            // Validate Message
            if (!message.value.trim()) {
                message.classList.add('error');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields correctly.');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>