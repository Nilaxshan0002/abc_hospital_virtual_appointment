<?php
session_start();
require_once 'config/database.php';

echo "<h2>Simple Login Test</h2>";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    
    try {
        $database = new Database();
        $pdo = $database->getConnection();
        
        echo "<p>✓ Database connected</p>";
        
        $query = "SELECT * FROM users WHERE username = :username AND user_role = :user_role";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username, ':user_role' => $userType]);
        
        if ($stmt->rowCount() == 0) {
            echo "<p style='color:red'>✗ User not found</p>";
        } else {
            $user = $stmt->fetch();
            echo "<p>✓ User found: " . $user['username'] . "</p>";
            
            if (password_verify($password, $user['password'])) {
                echo "<p style='color:green'>✓ Password correct!</p>";
                echo "<p>Would redirect to: " . $user['user_role'] . "/dashboard.php</p>";
            } else {
                echo "<p style='color:red'>✗ Password incorrect</p>";
                echo "<p>Stored hash: " . $user['password'] . "</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
    }
}
?>
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type">
        <option value="admin">Admin</option>
        <option value="doctor">Doctor</option>
        <option value="patient">Patient</option>
        <option value="receptionist">Receptionist</option>
    </select><br>
    <button type="submit">Test Login</button>
</form>