<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$pageTitle = "Contact Us - ABC Virtual Healthcare";
$base_url = '/abc_hospital_virtual_appointment';

// Include database connection
require_once 'db_connection.php';

// Check connection
if (!$mysqli) {
    die("Database connection failed");
}

// Initialize variables
$success_message = '';
$error_message = '';
$form_data = [];

// Handle contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_contact'])) {
    
    // Get and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
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
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Check if subject is too long for your column (varchar(50))
        if (strlen($subject) > 50) {
            $subject = substr($subject, 0, 50); // Truncate to 50 characters
        }
        
        // Save to database - using real_escape_string for security
        $name = $mysqli->real_escape_string($name);
        $email = $mysqli->real_escape_string($email);
        $phone = $mysqli->real_escape_string($phone);
        $subject = $mysqli->real_escape_string($subject);
        $message = $mysqli->real_escape_string($message);
        
        // IMPORTANT: Use the exact column names from your table
        $sql = "INSERT INTO `send_us_a_message` 
                (`your_name`, `email_address`, `phone_number`, `subject`, `your_message`, `submitted_at`) 
                VALUES 
                ('$name', '$email', '$phone', '$subject', '$message', NOW())";
        
        // Execute the query
        if ($mysqli->query($sql)) {
            $success_message = "Thank you! Your message has been sent successfully. We'll get back to you within 24 hours.";
            $form_data = []; // Clear form data
            
            // Optional: Send email notification
            // $to = "info@abchospital.lk";
            // $email_subject = "New Contact Form Submission: $subject";
            // $email_body = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
            // $headers = "From: $email";
            // mail($to, $email_subject, $email_body, $headers);
            
        } else {
            $error_message = "Error: " . $mysqli->error;
        }
    }
}
?>