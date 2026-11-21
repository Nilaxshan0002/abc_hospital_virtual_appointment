<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$server = "localhost";
$user = "root";
$password = "";
$db_name = "abc_virtual_hospital";

// Create connection
$conn = new mysqli($server, $user, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Initialize message variables
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    
    // Get and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Escape values
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $phone = $conn->real_escape_string($phone);
        $subject = $conn->real_escape_string($subject);
        $message = $conn->real_escape_string($message);
        
        // Insert query - using your new table name
        $sql = "INSERT INTO contact_messages (your_name, email_address, phone_number, subject, your_message, submitted_at) 
                VALUES ('$name', '$email', '$phone', '$subject', '$message', NOW())";
        
        if ($conn->query($sql)) {
            $success_message = "Message sent successfully! ID: " . $conn->insert_id;
        } else {
            $error_message = "Database error: " . $conn->error;
        }
    }
}

// Get total messages count
$count_result = $conn->query("SELECT COUNT(*) as total FROM contact_messages");
$total_messages = $count_result->fetch_assoc()['total'];

// Get latest messages
$latest_result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Message System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .stats-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .stats-box h2 {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #5a67d8;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .messages-list {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .messages-list h3 {
            margin-bottom: 15px;
            color: #333;
        }
        .message-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .message-item:last-child {
            border-bottom: none;
        }
        .message-item small {
            color: #666;
        }
        .required:after {
            content: " *";
            color: red;
        }
        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-family: monospace;
            font-size: 12px;
        }
        .nav-links {
            text-align: center;
            margin-bottom: 20px;
        }
        .nav-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="index.php">← Back to Main Site</a>
            <a href="test_message.php">Refresh Page</a>
        </div>

        <h1>📝 Test Message System</h1>
        
        <!-- Stats Box -->
        <div class="stats-box">
            <h2><?php echo $total_messages; ?></h2>
            <p>Total Messages in Database</p>
        </div>

        <!-- Form -->
        <div class="form-container">
            <h2 style="margin-bottom: 20px;">Send a Test Message</h2>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success">✅ <?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error">❌ <?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label class="required">Your Name</label>
                    <input type="text" name="name" required placeholder="Enter your full name" 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label class="required">Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Phone Number (Optional)</label>
                    <input type="text" name="phone" placeholder="Enter your phone number" 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label class="required">Subject</label>
                    <select name="subject" required>
                        <option value="">Select a subject</option>
                        <option value="appointment" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'appointment') ? 'selected' : ''; ?>>Appointment Query</option>
                        <option value="billing" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'billing') ? 'selected' : ''; ?>>Billing Issue</option>
                        <option value="technical" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'technical') ? 'selected' : ''; ?>>Technical Support</option>
                        <option value="general" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'general') ? 'selected' : ''; ?>>General Inquiry</option>
                        <option value="feedback" <?php echo (isset($_POST['subject']) && $_POST['subject'] == 'feedback') ? 'selected' : ''; ?>>Feedback</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="required">Your Message</label>
                    <textarea name="message" rows="5" required placeholder="Type your message here..."><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <input type="hidden" name="submit_message" value="1">
                
                <button type="submit">📨 Send Message</button>
            </form>
        </div>

        <!-- Latest Messages -->
        <div class="messages-list">
            <h3>📋 Latest 5 Messages</h3>
            <?php if ($latest_result->num_rows > 0): ?>
                <?php while($row = $latest_result->fetch_assoc()): ?>
                    <div class="message-item">
                        <strong><?php echo htmlspecialchars($row['your_name']); ?></strong> 
                        (<?php echo htmlspecialchars($row['email_address']); ?>)<br>
                        <small>
                            Subject: <?php echo htmlspecialchars($row['subject']); ?> | 
                            Date: <?php echo $row['submitted_at']; ?>
                        </small>
                        <p style="margin-top: 5px;"><?php echo nl2br(htmlspecialchars(substr($row['your_message'], 0, 100))); ?>...</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No messages yet. Be the first to send one!</p>
            <?php endif; ?>
        </div>

        <!-- Debug Info -->
        <div class="debug-info">
            <strong>🔧 Debug Info:</strong><br>
            Database: abc_virtual_hospital<br>
            Table: contact_messages<br>
            Server Time: <?php echo date('Y-m-d H:i:s'); ?><br>
            PHP Version: <?php echo phpversion(); ?><br>
            <?php
            // Test direct query
            $test = $conn->query("SELECT 1 as test");
            if ($test) {
                echo "✅ Database connection: Working<br>";
            } else {
                echo "❌ Database connection: Failed<br>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>