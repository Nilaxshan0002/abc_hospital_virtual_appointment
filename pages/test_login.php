<?php
session_start();
require_once '../config/database.php';

// Simple test login for patient
if (isset($_GET['login'])) {
    $_SESSION['user_type'] = 'patient';
    $_SESSION['patient_id'] = 1;
    $_SESSION['patient_name'] = 'Miss. Malini';
    $_SESSION['user_name'] = 'Miss. Malini';
    $_SESSION['user_id'] = 1;
    
    header("Location: patient/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
</head>
<body>
    <h1>Test Login</h1>
    <a href="?login=patient">Click here to login as Patient (Miss. Malini)</a>
</body>
</html>