<?php
// database connection file
$server = "localhost";
$user = "root";
$password = ""; 
$db_name = "abc_virtual_hospital"; 

// Enable exceptions for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection 
    $mysqli = new mysqli($server, $user, $password, $db_name);
    
    // Set charset to UTF-8
    $mysqli->set_charset("utf8mb4");
    
    // Optional: Uncomment to test connection
    // echo "Connected successfully to database: " . $db_name;
    
} catch (mysqli_sql_exception $e) {
    // Log error instead of displaying in production
    error_log("Database connection failed: " . $e->getMessage());
    
    // Show user-friendly message
    die("Unable to connect to database. Please try again later.");
    
} catch (Exception $e) {
    // Catch any other exceptions
    error_log("Unexpected error: " . $e->getMessage());
    die("An unexpected error occurred.");
}

// Optional: Add a function to get the connection
function getDBConnection() {
    global $mysqli;  
    return $mysqli;
}
?>