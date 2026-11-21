<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Privacy Policy Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>🔍 Debug Information</h1>
    
    <div class="success">✅ PHP is working!</div>
    
    <h3>Server Information:</h3>
    <ul>
        <li>PHP Version: <?php echo phpversion(); ?></li>
        <li>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
        <li>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT']; ?></li>
        <li>Script Path: <?php echo __FILE__; ?></li>
        <li>Session Status: <?php echo session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive'; ?></li>
    </ul>
    
    <h3>Test Links:</h3>
    <ul>
        <li><a href="index.php">Go to Homepage</a></li>
        <li><a href="privacy-policy.php">Refresh this page</a></li>
    </ul>
    
    <p>If you can see this, the file is loading correctly. The issue is with your full HTML content.</p>
</body>
</html>