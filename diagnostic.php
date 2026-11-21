<?php
echo "<h1>🔍 Complete System Diagnostic</h1>";

// Test 1: PHP Version
echo "<h2>1. PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";

// Test 2: Check folder structure
echo "<h2>2. Folder Structure Check</h2>";
$root = __DIR__;
echo "Root path: " . $root . "<br>";

$paths = [
    '/config/database.php',
    '/pages/login.php',
    '/pages/authenticate.php',
    '/pages/forgot-password.php'
];

foreach ($paths as $path) {
    $fullPath = $root . $path;
    if (file_exists($fullPath)) {
        echo "✅ " . $path . " - FOUND<br>";
    } else {
        echo "❌ " . $path . " - NOT FOUND<br>";
    }
}

// Test 3: Database connection
echo "<h2>3. Database Connection Test</h2>";
try {
    require_once $root . '/config/database.php';
    echo "✅ database.php loaded successfully<br>";
    
    $database = new Database();
    $conn = $database->getConnection();
    
    if ($conn) {
        echo "✅ Database connected successfully<br>";
        
        // Check if database exists
        $dbName = "abc_virtual_hospital";
        $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
        if ($result->rowCount() > 0) {
            echo "✅ Database '$dbName' exists<br>";
        } else {
            echo "❌ Database '$dbName' does NOT exist<br>";
        }
        
        // Check users table
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        if ($result->rowCount() > 0) {
            echo "✅ Users table exists<br>";
            
            // Count users
            $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
            $row = $stmt->fetch();
            echo "📊 Total users: " . $row['count'] . "<br>";
            
            // Show users
            $stmt = $conn->query("SELECT user_id, username, user_role, status FROM users LIMIT 5");
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Status</th></tr>";
            while ($row = $stmt->fetch()) {
                echo "<td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['user_role'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } else {
            echo "❌ Users table does NOT exist<br>";
        }
    }
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 4: Check if session is working
echo "<h2>4. Session Test</h2>";
session_start();
$_SESSION['test'] = 'working';
echo "Session test variable set: " . ($_SESSION['test'] ?? 'not set') . "<br>";

// Test 5: Check error logs
echo "<h2>5. Error Log Check</h2>";
$logFile = $root . '/logs/db_errors.log';
if (file_exists($logFile)) {
    echo "✅ Log file exists<br>";
    $logs = file_get_contents($logFile);
    if ($logs) {
        echo "<pre>" . htmlspecialchars(substr($logs, -500)) . "</pre>";
    } else {
        echo "Log file is empty<br>";
    }
} else {
    echo "❌ Log file not found at: " . $logFile . "<br>";
}

// Test 6: Create a test user
echo "<h2>6. Create Test User</h2>";
try {
    // Check if test user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = 'testuser'");
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        // Create test user
        $hashedPassword = password_hash('Test@123', PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password, email, full_name, user_role, status) VALUES (?, ?, ?, ?, ?, 'active')");
        $insert->execute(['testuser', $hashedPassword, 'test@test.com', 'Test User', 'patient']);
        echo "✅ Test user created: username='testuser', password='Test@123'<br>";
    } else {
        echo "✅ Test user already exists<br>";
    }
} catch(Exception $e) {
    echo "❌ Could not create test user: " . $e->getMessage() . "<br>";
}

// Test 7: Test password verification
echo "<h2>7. Password Verification Test</h2>";
try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = 'testuser'");
    $stmt->execute();
    $user = $stmt->fetch();
    
    if ($user) {
        if (password_verify('Test@123', $user['password'])) {
            echo "✅ Password verification working correctly<br>";
        } else {
            echo "❌ Password verification FAILED<br>";
            echo "Stored hash: " . $user['password'] . "<br>";
        }
    }
} catch(Exception $e) {
    echo "❌ Password test error: " . $e->getMessage() . "<br>";
}

echo "<h2>📝 Next Steps:</h2>";
echo "1. Try logging in with: username='testuser', password='Test@123' (select Patient role)<br>";
echo "2. If that works, your system is fine - your original user 'Kamal' has wrong password hash<br>";
echo "3. If testuser doesn't work, there's a system configuration issue<br>";
?>