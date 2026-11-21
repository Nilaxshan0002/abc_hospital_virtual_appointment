<?php
$base_url = '/abc_hospital_virtual_appointment';
$root = $_SERVER['DOCUMENT_ROOT'];

echo "<h1>File Existence Check</h1>";

$files_to_check = [
    '/abc_hospital_virtual_appointment/right-to-access.php',
    '/abc_hospital_virtual_appointment/right-to-rectification.php',
    '/abc_hospital_virtual_appointment/right-to-erasure.php',
    '/abc_hospital_virtual_appointment/right-to-portability.php',
    '/abc_hospital_virtual_appointment/privacy-request.php',
    '/abc_hospital_virtual_appointment/includes/header02.php',
    '/abc_hospital_virtual_appointment/includes/footer02.php',
    '/abc_hospital_virtual_appointment/css/rights-pages.css',
    '/abc_hospital_virtual_appointment/js/rights-pages.js',
];

echo "<ul>";
foreach ($files_to_check as $file) {
    $full_path = $root . $file;
    if (file_exists($full_path)) {
        echo "<li style='color: green;'>✓ $file - EXISTS</li>";
    } else {
        echo "<li style='color: red;'>✗ $file - NOT FOUND at: $full_path</li>";
    }
}
echo "</ul>";

echo "<h2>Directory Contents:</h2>";
$dirs_to_check = [
    '/abc_hospital_virtual_appointment/',
    '/abc_hospital_virtual_appointment/includes/',
    '/abc_hospital_virtual_appointment/css/',
    '/abc_hospital_virtual_appointment/js/',
];

foreach ($dirs_to_check as $dir) {
    $full_dir = $root . $dir;
    echo "<h3>$dir</h3>";
    if (is_dir($full_dir)) {
        $files = scandir($full_dir);
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li>$file</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>Directory NOT FOUND: $full_dir</p>";
    }
}
?>