<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_connection.php';

echo "<h2>Database Connection Test</h2>";

// Test if $mysqli is set and connected
if (isset($mysqli) && $mysqli) {
    echo "✅ Connection object exists<br>";
    
    // Test a simple query
    $result = $mysqli->query("SELECT DATABASE() as db_name");
    $row = $result->fetch_assoc();
    echo "✅ Connected to database: " . $row['db_name'] . "<br>";
    
    // Show all tables
    $tables = $mysqli->query("SHOW TABLES");
    echo "<h3>Tables in database:</h3>";
    echo "<ul>";
    while ($table = $tables->fetch_array()) {
        echo "<li>" . $table[0] . "</li>";
    }
    echo "</ul>";
    
    // Check your contact table specifically
    $check_table = $mysqli->query("SHOW TABLES LIKE 'send_us_a_message'");
    if ($check_table->num_rows > 0) {
        echo "✅ Table 'send_us_a_message' exists<br>";
        
        // Show table structure
        $structure = $mysqli->query("DESCRIBE send_us_a_message");
        echo "<h3>Table Structure:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($field = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $field['Field'] . "</td>";
            echo "<td>" . $field['Type'] . "</td>";
            echo "<td>" . $field['Null'] . "</td>";
            echo "<td>" . ($field['Key'] ?? '') . "</td>";
            echo "<td>" . ($field['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count records
        $count = $mysqli->query("SELECT COUNT(*) as total FROM send_us_a_message");
        $total = $count->fetch_assoc();
        echo "<p>Total records: " . $total['total'] . "</p>";
        
    } else {
        echo "❌ Table 'send_us_a_message' does not exist<br>";
    }
    
} else {
    echo "❌ Connection failed<br>";
}

// Show PHP info about MySQL
echo "<h3>MySQL Information:</h3>";
echo "MySQL Client Version: " . $mysqli->client_info . "<br>";
echo "MySQL Server Version: " . $mysqli->server_info . "<br>";
echo "Connection Character Set: " . $mysqli->character_set_name() . "<br>";
?>