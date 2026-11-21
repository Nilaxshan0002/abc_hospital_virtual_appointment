<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'ABC Virtual Healthcare'; ?></title>
    <meta name="description" content="Explore our medical departments at ABC Hospital - Specialized care across 30+ departments">
    <meta name="keywords" content="hospital departments, cardiology, neurology, orthopedics, pediatrics, Sri Lanka">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/department.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- CSS Files (Order matters - base first, then components, then page-specific) -->
    <link rel="stylesheet" href="css/style01.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/department.css">
    <link rel="stylesheet" href="css/emergency.css">
    <link rel="stylesheet" href="css/book-scan.css">
    
    <!-- Additional meta tags for better compatibility -->
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
</head>
<body>