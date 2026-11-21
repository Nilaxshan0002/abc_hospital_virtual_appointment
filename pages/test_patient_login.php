<?php
session_start();

// Auto-login as patient for testing
$_SESSION['user_type'] = 'patient';
$_SESSION['user_id'] = 1;
$_SESSION['user_name'] = 'Miss. Malini';
$_SESSION['patient_id'] = 1;
$_SESSION['patient_name'] = 'Miss. Malini';

// Redirect to patient dashboard
header("Location: patient/dashboard.php");
exit();
?>