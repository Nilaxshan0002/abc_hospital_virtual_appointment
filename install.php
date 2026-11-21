<?php
/**
 * ABC Hospital Virtual Appointment System - Database Installation Script
 * Run this file once to create all necessary tables
 * IMPORTANT: Delete this file after installation for security!
 */

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'abc_virtual_hospital');

// Installation status file
$installed_file = __DIR__ . '/.installed';

// Check if already installed
if (file_exists($installed_file)) {
    die('<div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 10px; margin: 20px; font-family: Arial, sans-serif;">
            <h2>⚠️ System Already Installed!</h2>
            <p>The database has already been set up. If you want to reinstall, please delete the file: <strong>.installed</strong></p>
            <a href="index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">Go to Homepage</a>
         </div>');
    exit();
}

// Function to execute SQL and show status
function executeSQL($mysqli, $sql, $description) {
    try {
        $mysqli->query($sql);
        echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 5px;'>✓ {$description}</div>";
        return true;
    } catch (mysqli_sql_exception $e) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 10px; margin: 5px 0; border-radius: 5px;'>✗ Error: {$description}<br>Message: " . $e->getMessage() . "</div>";
        return false;
    }
}

// Function to update step status
function updateStepStatus($stepId, $status, $message) {
    echo "<script>
        try {
            var step = document.getElementById('{$stepId}');
            var statusDiv = document.getElementById('status{$stepId}');
            if(step) step.className = 'progress-step completed';
            if(statusDiv) statusDiv.innerHTML = '{$message}';
        } catch(e) { console.log(e); }
    </script>";
    ob_flush();
    flush();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Hospital - Database Installation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .progress {
            margin-bottom: 30px;
        }
        
        .progress-step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .progress-step.completed {
            background: #d4edda;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #1a2980;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .progress-step.completed .step-number {
            background: #28a745;
        }
        
        .step-info {
            flex: 1;
        }
        
        .step-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .step-status {
            font-size: 0.85rem;
            color: #666;
        }
        
        .log {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.3s;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        
        .button:hover {
            transform: translateY(-2px);
        }
        
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 20px;
            border-radius: 10px;
        }
        
        .success-box {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
        }
        
        .credentials {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        
        .credentials h4 {
            color: #1a2980;
            margin-bottom: 10px;
        }
        
        .credentials ul {
            margin-left: 20px;
        }
        
        .credentials li {
            margin: 8px 0;
        }
        
        .table-list {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
        
        .table-list h4 {
            color: #1a2980;
            margin-bottom: 10px;
        }
        
        .table-list ul {
            margin-left: 20px;
        }
        
        .table-list li {
            margin: 5px 0;
            font-family: monospace;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            color: #666;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 ABC Hospital</h1>
            <p>Virtual Appointment System - Database Installation</p>
        </div>
        
        <div class="content">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
                echo '<div class="progress">';
                
                try {
                    // Step 1: Connect to MySQL and create database
                    echo '<div class="progress-step" id="step1"><div class="step-number">1</div><div class="step-info"><div class="step-title">Creating Database</div><div class="step-status" id="status1">Creating database...</div></div></div>';
                    ob_flush();
                    flush();
                    
                    // First connect without database to create it
                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);
                    if ($mysqli->connect_error) {
                        throw new Exception("Connection failed: " . $mysqli->connect_error);
                    }
                    
                    // Create database if not exists
                    $sql = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                    if ($mysqli->query($sql)) {
                        updateStepStatus('step1', 'completed', 'Database created successfully!');
                    } else {
                        throw new Exception("Failed to create database: " . $mysqli->error);
                    }
                    
                    // Select the database
                    $mysqli->select_db(DB_NAME);
                    
                    // Step 2: Create tables
                    echo '<div class="progress-step" id="step2"><div class="step-number">2</div><div class="step-info"><div class="step-title">Creating Tables</div><div class="step-status" id="status2">Creating database tables...</div></div></div>';
                    ob_flush();
                    flush();
                    
                    // Create doctors table
                    $sql = "CREATE TABLE IF NOT EXISTS `doctors` (
                        `doctor_id` INT(11) NOT NULL AUTO_INCREMENT,
                        `doctor_name` VARCHAR(100) NOT NULL,
                        `doctor_specialty` VARCHAR(100) NOT NULL,
                        `doctor_email` VARCHAR(100) NOT NULL UNIQUE,
                        `doctor_phone` VARCHAR(20) NOT NULL,
                        `doctor_password` VARCHAR(255) NOT NULL,
                        `doctor_image` VARCHAR(255) DEFAULT NULL,
                        `doctor_qualification` TEXT,
                        `doctor_experience` INT(11) DEFAULT 0,
                        `status` ENUM('active', 'inactive') DEFAULT 'active',
                        `created_at` DATETIME NOT NULL,
                        `updated_at` DATETIME DEFAULT NULL,
                        PRIMARY KEY (`doctor_id`),
                        INDEX idx_doctor_email (`doctor_email`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                    executeSQL($mysqli, $sql, "Doctors table created");
                    
                    // Create patients table (using patient_id as primary key)
                    $sql = "CREATE TABLE IF NOT EXISTS `patients` (
                        `patient_id` INT(11) NOT NULL AUTO_INCREMENT,
                        `patient_name` VARCHAR(100) NOT NULL,
                        `email` VARCHAR(100) NOT NULL UNIQUE,
                        `phone` VARCHAR(20) NOT NULL,
                        `password` VARCHAR(255) NOT NULL,
                        `address` TEXT,
                        `dob` DATE DEFAULT NULL,
                        `gender` ENUM('male', 'female', 'other') DEFAULT NULL,
                        `blood_group` VARCHAR(5) DEFAULT NULL,
                        `emergency_contact` VARCHAR(20) DEFAULT NULL,
                        `created_at` DATETIME NOT NULL,
                        `updated_at` DATETIME DEFAULT NULL,
                        PRIMARY KEY (`patient_id`),
                        INDEX idx_patient_email (`email`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                    executeSQL($mysqli, $sql, "Patients table created");
                    
                    // Create receptionists table
                    $sql = "CREATE TABLE IF NOT EXISTS `receptionists` (
                        `receptionist_id` INT(11) NOT NULL AUTO_INCREMENT,
                        `receptionist_name` VARCHAR(100) NOT NULL,
                        `receptionist_email` VARCHAR(100) NOT NULL UNIQUE,
                        `receptionist_phone` VARCHAR(20) NOT NULL,
                        `receptionist_password` VARCHAR(255) NOT NULL,
                        `created_at` DATETIME NOT NULL,
                        `updated_at` DATETIME DEFAULT NULL,
                        PRIMARY KEY (`receptionist_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                    executeSQL($mysqli, $sql, "Receptionists table created");
                    
                    // Create appointments table
                    $sql = "CREATE TABLE IF NOT EXISTS `appointments` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `patient_id` INT(11) NOT NULL,
                        `doctor_id` INT(11) NOT NULL,
                        `appointment_date` DATE NOT NULL,
                        `appointment_time` TIME NOT NULL,
                        `appointment_type` ENUM('general', 'followup', 'emergency', 'consultation') DEFAULT 'general',
                        `reason` TEXT,
                        `status` ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
                        `created_at` DATETIME NOT NULL,
                        `updated_at` DATETIME DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        INDEX idx_appointment_date (`appointment_date`),
                        INDEX idx_patient_id (`patient_id`),
                        INDEX idx_doctor_id (`doctor_id`),
                        FOREIGN KEY (`patient_id`) REFERENCES `patients`(`patient_id`) ON DELETE CASCADE,
                        FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`doctor_id`) ON DELETE CASCADE
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                    executeSQL($mysqli, $sql, "Appointments table created");
                    
                    updateStepStatus('step2', 'completed', 'All tables created successfully!');
                    
                    // Step 3: Insert sample data
                    echo '<div class="progress-step" id="step3"><div class="step-number">3</div><div class="step-info"><div class="step-title">Inserting Sample Data</div><div class="step-status" id="status3">Inserting sample data...</div></div></div>';
                    ob_flush();
                    flush();
                    
                    // Insert sample doctors
                    $doctors_data = [
                        ['Dr. Kamal Perera', 'Cardiologist', 'kamal@abchospital.lk', '0771234567', password_hash('doctor123', PASSWORD_DEFAULT), '2024-01-01 10:00:00'],
                        ['Dr. Nimali Fernando', 'Pediatrician', 'nimali@abchospital.lk', '0772345678', password_hash('doctor123', PASSWORD_DEFAULT), '2024-01-01 10:00:00'],
                        ['Dr. Ruwan Wijesinghe', 'Neurologist', 'ruwan@abchospital.lk', '0773456789', password_hash('doctor123', PASSWORD_DEFAULT), '2024-01-01 10:00:00'],
                        ['Dr. Anoma Silva', 'Dermatologist', 'anoma@abchospital.lk', '0774567890', password_hash('doctor123', PASSWORD_DEFAULT), '2024-01-01 10:00:00'],
                        ['Dr. Priyantha Jayawardena', 'Orthopedic', 'priyantha@abchospital.lk', '0775678901', password_hash('doctor123', PASSWORD_DEFAULT), '2024-01-01 10:00:00']
                    ];
                    
                    $stmt = $mysqli->prepare("INSERT IGNORE INTO doctors (doctor_name, doctor_specialty, doctor_email, doctor_phone, doctor_password, created_at) VALUES (?, ?, ?, ?, ?, ?)");
                    $doctor_count = 0;
                    foreach ($doctors_data as $doctor) {
                        $stmt->bind_param("ssssss", $doctor[0], $doctor[1], $doctor[2], $doctor[3], $doctor[4], $doctor[5]);
                        if ($stmt->execute()) $doctor_count++;
                    }
                    echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 5px;'>✓ Inserted {$doctor_count} doctors</div>";
                    
                    // Insert sample receptionist
                    $receptionist_password = password_hash('reception123', PASSWORD_DEFAULT);
                    $stmt = $mysqli->prepare("INSERT IGNORE INTO receptionists (receptionist_name, receptionist_email, receptionist_phone, receptionist_password, created_at) VALUES (?, ?, ?, ?, ?)");
                    $receptionist_name = "Reception1";
                    $receptionist_email = "reception1@abchospital.lk";
                    $receptionist_phone = "0771234567";
                    $created_at = date('Y-m-d H:i:s');
                    $stmt->bind_param("sssss", $receptionist_name, $receptionist_email, $receptionist_phone, $receptionist_password, $created_at);
                    $stmt->execute();
                    echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 5px;'>✓ Inserted 1 receptionist</div>";
                    
                    // Insert sample patients (using patient_id)
                    $patients_data = [
                        ['Miss. Malini', 'malini@example.com', '0771112233', password_hash('patient123', PASSWORD_DEFAULT), '1990-05-15', 'female', 'O+', '2024-01-01 10:00:00'],
                        ['Mr. Samantha Perera', 'samantha@example.com', '0772223344', password_hash('patient123', PASSWORD_DEFAULT), '1985-08-20', 'male', 'A+', '2024-01-01 10:00:00'],
                        ['Mrs. Kusumawathi', 'kusum@example.com', '0773334455', password_hash('patient123', PASSWORD_DEFAULT), '1978-03-10', 'female', 'B+', '2024-01-01 10:00:00']
                    ];
                    
                    $stmt = $mysqli->prepare("INSERT IGNORE INTO patients (patient_name, email, phone, password, dob, gender, blood_group, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $patient_count = 0;
                    foreach ($patients_data as $patient) {
                        $stmt->bind_param("ssssssss", $patient[0], $patient[1], $patient[2], $patient[3], $patient[4], $patient[5], $patient[6], $patient[7]);
                        if ($stmt->execute()) $patient_count++;
                    }
                    echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 5px;'>✓ Inserted {$patient_count} patients</div>";
                    
                    // Insert sample appointments
                    $appointments_data = [
                        [1, 1, '2025-01-15', '10:00:00', 'general', 'Regular checkup', 'confirmed', '2024-01-01 10:00:00'],
                        [2, 2, '2025-01-16', '14:30:00', 'followup', 'Follow-up after treatment', 'pending', '2024-01-02 10:00:00'],
                        [3, 3, '2025-01-17', '11:00:00', 'consultation', 'New patient consultation', 'confirmed', '2024-01-03 10:00:00'],
                        [1, 4, '2025-01-18', '09:30:00', 'emergency', 'Severe headache', 'completed', '2024-01-04 10:00:00'],
                        [2, 5, '2025-01-19', '15:00:00', 'general', 'Annual health check', 'pending', '2024-01-05 10:00:00']
                    ];
                    
                    $stmt = $mysqli->prepare("INSERT IGNORE INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, appointment_type, reason, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $appointment_count = 0;
                    foreach ($appointments_data as $appointment) {
                        $stmt->bind_param("iissssss", $appointment[0], $appointment[1], $appointment[2], $appointment[3], $appointment[4], $appointment[5], $appointment[6], $appointment[7]);
                        if ($stmt->execute()) $appointment_count++;
                    }
                    echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 5px 0; border-radius: 5px;'>✓ Inserted {$appointment_count} appointments</div>";
                    
                    updateStepStatus('step3', 'completed', 'Sample data inserted successfully!');
                    
                    // Step 4: Finalize
                    echo '<div class="progress-step" id="step4"><div class="step-number">4</div><div class="step-info"><div class="step-title">Finalizing</div><div class="step-status" id="status4">Completing installation...</div></div></div>';
                    ob_flush();
                    flush();
                    
                    // Create installed file
                    file_put_contents($installed_file, date('Y-m-d H:i:s') . " - Installation completed successfully.\n");
                    updateStepStatus('step4', 'completed', 'Installation completed!');
                    
                    // Display created tables
                    $tables_result = $mysqli->query("SHOW TABLES");
                    $tables = [];
                    while ($row = $tables_result->fetch_array()) {
                        $tables[] = $row[0];
                    }
                    
                    // Success message with credentials
                    echo '<div class="success-box">
                            <h3>✅ Installation Completed Successfully!</h3>
                            <p>All database tables have been created and sample data has been inserted.</p>
                            
                            <div class="table-list">
                                <h4>📊 Tables Created:</h4>
                                <ul>
                                    ' . implode('', array_map(function($table) { 
                                        return "<li>📁 {$table}</li>"; 
                                    }, $tables)) . '
                                </ul>
                            </div>
                            
                            <div class="credentials">
                                <h4>🔐 Login Credentials:</h4>
                                <ul>
                                    <li><strong>👨‍⚕️ Doctor Login:</strong> Email: kamal@abchospital.lk | Password: doctor123</li>
                                    <li><strong>👩‍💼 Receptionist Login:</strong> Email: reception1@abchospital.lk | Password: reception123</li>
                                    <li><strong>👤 Patient Login:</strong> Email: malini@example.com | Password: patient123</li>
                                    <li><strong>👨‍💼 Admin Login:</strong> Use direct admin panel access</li>
                                </ul>
                            </div>
                            
                            <div class="warning" style="margin-top: 15px;">
                                <strong>⚠️ Important Security Note:</strong><br>
                                Please delete the <code>install.php</code> file immediately for security reasons!
                            </div>
                         </div>';
                    
                    echo '<div style="text-align: center; margin-top: 20px;">
                            <a href="index.php" class="button">🏠 Go to Homepage</a>
                            <a href="pages/login.php" class="button" style="margin-left: 10px;">🔑 Go to Login</a>
                            <a href="pages/receptionist/dashboard.php" class="button" style="margin-left: 10px;">📋 Receptionist Dashboard</a>
                            <a href="pages/doctor/dashboard.php" class="button" style="margin-left: 10px;">👨‍⚕️ Doctor Dashboard</a>
                            <a href="pages/patient/dashboard.php" class="button" style="margin-left: 10px;">👤 Patient Dashboard</a>
                          </div>';
                    
                    $mysqli->close();
                    
                } catch(Exception $e) {
                    echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-top: 20px;">
                            <h3>❌ Installation Failed!</h3>
                            <p>Error: ' . $e->getMessage() . '</p>
                            <p>Please check your database configuration and try again.</p>
                            <p>Make sure:</p>
                            <ul>
                                <li>MySQL server is running</li>
                                <li>Credentials are correct (host: ' . DB_HOST . ', user: ' . DB_USER . ')</li>
                                <li>You have permission to create databases</li>
                            </ul>
                          </div>';
                }
                
                echo '</div>';
                
            } else {
                // Show installation form
                ?>
                <div class="warning">
                    <strong>⚠️ Warning:</strong> This will install/overwrite the database tables for ABC Hospital. 
                    Make sure you have a backup if this is an existing installation.
                </div>
                
                <div class="log">
                    <p><strong>📋 This installer will create:</strong></p>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>✅ Database: <strong><?php echo DB_NAME; ?></strong></li>
                        <li>✅ Tables: <strong>doctors, patients, receptionists, appointments</strong></li>
                        <li>✅ Insert <strong>5 doctors</strong> with different specialties</li>
                        <li>✅ Insert <strong>1 receptionist</strong></li>
                        <li>✅ Insert <strong>3 patients</strong> with sample data</li>
                        <li>✅ Insert <strong>5 appointments</strong> with various statuses</li>
                        <li>✅ Set up foreign key relationships with CASCADE DELETE</li>
                        <li>✅ Create indexes for better performance</li>
                    </ul>
                    
                    <p style="margin-top: 15px;"><strong>📁 Table Structure:</strong></p>
                    <ul style="margin-left: 20px; font-family: monospace; font-size: 11px;">
                        <li><strong>doctors</strong> - doctor_id (PK), doctor_name, doctor_specialty, doctor_email, doctor_phone, doctor_password, ...</li>
                        <li><strong>patients</strong> - patient_id (PK), patient_name, email, phone, password, dob, gender, blood_group, ...</li>
                        <li><strong>receptionists</strong> - receptionist_id (PK), receptionist_name, receptionist_email, receptionist_phone, receptionist_password</li>
                        <li><strong>appointments</strong> - id (PK), patient_id (FK), doctor_id (FK), appointment_date, appointment_time, status, ...</li>
                    </ul>
                </div>
                
                <form method="POST" style="text-align: center;">
                    <input type="hidden" name="install" value="1">
                    <button type="submit" class="button" onclick="return confirm('⚠️ WARNING: This will install/overwrite database tables. Are you sure you want to continue?')">
                        🚀 Start Installation
                    </button>
                </form>
                
                <div class="warning" style="margin-top: 20px;">
                    <strong>📌 Database Configuration:</strong><br>
                    Host: <?php echo DB_HOST; ?><br>
                    Database: <?php echo DB_NAME; ?><br>
                    Username: <?php echo DB_USER; ?><br>
                    Password: <?php echo str_repeat('*', strlen(DB_PASS)); ?><br>
                    <em style="font-size: 12px;">Update these values in the install.php file if needed.</em>
                </div>
                <?php
            }
            ?>
            
        </div>
        <footer>
            &copy; <?php echo date('Y'); ?> ABC Hospital Virtual Appointment System | All Rights Reserved
        </footer>
    </div>
</body>
</html>