<?php
require_once 'db_connection.php';

echo "<h2>Database Connection Test</h2>";

// Test connection
if ($mysqli) {
    echo "✅ Connected to database: " . $mysqli->host_info . "<br>";
    
    // Test insert
    $test_name = "Test User";
    $test_email = "test@example.com";
    $test_phone = "1234567890";
    $test_subject = "test";
    $test_message = "This is a test message";
    
    $sql = "INSERT INTO `send us a message` (your_name, email_address, phone_number, subject, your_message, submitted_at) 
            VALUES ('$test_name', '$test_email', '$test_phone', '$test_subject', '$test_message', NOW())";
    
    if ($mysqli->query($sql)) {
        echo "✅ Test data inserted successfully!<br>";
        echo "Check your table in HeidiSQL";
    } else {
        echo "❌ Insert failed: " . $mysqli->error . "<br>";
    }
    
    // Show table structure
    $result = $mysqli->query("DESCRIBE `send us a message`");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1'><tr><th>Field</th><th>Type</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['Field'] . "</td><td>" . $row['Type'] . "</td></tr>";
    }
    echo "</table>";
    
} else {
    echo "❌ Connection failed";
}
?>