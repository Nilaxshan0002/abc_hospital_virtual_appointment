<?php
include "db_connection.php";

// Get and sanitize data
$name = mysqli_real_escape_string($mysqli, $_POST['name'] ?? '');
$email = mysqli_real_escape_string($mysqli, $_POST['email'] ?? '');
$phone = mysqli_real_escape_string($mysqli, $_POST['phone'] ?? '');
$subject = mysqli_real_escape_string($mysqli, $_POST['subject'] ?? '');
$message = mysqli_real_escape_string($mysqli, $_POST['message'] ?? '');

// Validate
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    die("Please fill all required fields");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Fix column names to match your table
$sql = "INSERT INTO comments (your_name, email_address, phone_number, subject, your_message, submitted_at) 
        VALUES ('$name', '$email', '$phone', '$subject', '$message', NOW())";

if ($mysqli->query($sql)) {
    header("Location: index.php?success=1");
    exit();
} else {
    echo "Error: " . $mysqli->error;
}
?>