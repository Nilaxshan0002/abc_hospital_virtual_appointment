<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Cleared</title>
    <meta http-equiv="refresh" content="2;url=../index.php">
</head>
<body>
    <h2>Session has been cleared!</h2>
    <p>Redirecting to home page...</p>
    <a href="../index.php">Click here if not redirected</a>
</body>
</html>