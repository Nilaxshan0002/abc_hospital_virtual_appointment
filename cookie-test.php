<?php
session_start();
$base_url = '/abc_hospital_virtual_appointment';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cookie Test</title>
</head>
<body>
    <h1>Cookie Policy Test</h1>
    <p>If you see this, the file loads!</p>
    <a href="<?php echo $base_url; ?>/index.php">Home</a>
</body>
</html>