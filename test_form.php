<?php
require_once 'db_connection.php';

// If form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h3>Form Submitted!</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    $sql = "INSERT INTO `send us a message` (your_name, email_address, phone_number, subject, your_message, submitted_at) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message', NOW())";
    
    echo "SQL: $sql<br>";
    
    if ($mysqli->query($sql)) {
        echo "✅ Success! <a href='test_form.php'>Submit another</a>";
    } else {
        echo "❌ Error: " . $mysqli->error;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Form</title>
</head>
<body>
    <h2>Simple Test Form</h2>
    <form method="POST" action="">
        <div>
            <label>Name:</label><br>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Phone:</label><br>
            <input type="text" name="phone">
        </div>
        <div>
            <label>Subject:</label><br>
            <select name="subject" required>
                <option value="appointment">Appointment</option>
                <option value="billing">Billing</option>
                <option value="technical">Technical</option>
                <option value="general">General</option>
                <option value="feedback">Feedback</option>
            </select>
        </div>
        <div>
            <label>Message:</label><br>
            <textarea name="message" required rows="4"></textarea>
        </div>
        <button type="submit">Send</button>
    </form>
</body>
</html>