<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $db_name = "abc_virtual_hospital";
    private $username = "root";
    private $password = "";
    private $conn;
    
    // Error logging
    private $logFile = "../logs/db_errors.log";
    
    public function __construct() {
        // Create logs directory if it doesn't exist
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
    }

    // Get database connection
    public function getConnection() {
        $this->conn = null;
        
        try {
            // Create PDO connection with proper error handling
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                )
            );
            
            // Set timezone
            $this->conn->exec("SET time_zone = '+05:30'"); // Sri Lanka timezone
            
        } catch(PDOException $exception) {
            // Log error instead of displaying
            $this->logError("Connection error: " . $exception->getMessage());
            
            // Throw exception for better error handling upstream
            throw new Exception("Database connection failed. Please try again later.");
        }
        
        return $this->conn;
    }
    
    // Test database connection
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            return $conn !== null;
        } catch(Exception $e) {
            $this->logError("Connection test failed: " . $e->getMessage());
            return false;
        }
    }
    
    // Get database stats
    public function getStats() {
        try {
            $conn = $this->getConnection();
            $stats = [];
            
            // Get table counts
            $tables = ['users', 'doctors', 'patients', 'appointments', 'password_resets'];
            foreach($tables as $table) {
                try {
                    $query = "SELECT COUNT(*) as count FROM $table";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetch();
                    $stats[$table] = $result['count'];
                } catch(Exception $e) {
                    $stats[$table] = 0;
                }
            }
            
            return $stats;
        } catch(Exception $e) {
            $this->logError("Failed to get stats: " . $e->getMessage());
            return [];
        }
    }
    
    // Log errors to file
    private function logError($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] " . $message . PHP_EOL;
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
    
    // Close connection
    public function closeConnection() {
        $this->conn = null;
    }
}

// Initialize database with sample data if empty
function initializeDatabase() {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        if(!$db) {
            throw new Exception("Could not connect to database");
        }
        
        // Create tables if they don't exist
        createTables($db);
        
        // Check and insert sample data
        insertSampleData($db);
        
        return true;
    } catch(Exception $e) {
        error_log("Database initialization error: " . $e->getMessage());
        return false;
    }
}

// Create all necessary tables
function createTables($db) {
    // Users table
    $createUsersTable = "CREATE TABLE IF NOT EXISTS `users` (
        `user_id` INT PRIMARY KEY AUTO_INCREMENT,
        `username` VARCHAR(50) UNIQUE NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100) UNIQUE NOT NULL,
        `full_name` VARCHAR(100) NOT NULL,
        `user_role` ENUM('admin', 'doctor', 'patient', 'receptionist') NOT NULL,
        `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        `login_attempts` INT DEFAULT 0,
        `last_failed_login` TIMESTAMP NULL,
        `last_login` TIMESTAMP NULL,
        `last_login_ip` VARCHAR(45),
        `login_count` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_username (`username`),
        INDEX idx_email (`email`),
        INDEX idx_role (`user_role`),
        INDEX idx_status (`status`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $db->exec($createUsersTable);
    
    // Doctors table
    $createDoctorsTable = "CREATE TABLE IF NOT EXISTS `doctors` (
        `doctor_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT UNIQUE,
        `doctor_code` VARCHAR(20) UNIQUE NOT NULL,
        `specialization` VARCHAR(100) NOT NULL,
        `qualification` TEXT,
        `experience_years` INT,
        `consultation_fee` DECIMAL(10,2),
        `available_days` TEXT,
        `available_time` VARCHAR(50),
        `max_appointments_per_day` INT DEFAULT 10,
        `bio` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL,
        INDEX idx_specialization (`specialization`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createDoctorsTable);
    
    // Patients table
    $createPatientsTable = "CREATE TABLE IF NOT EXISTS `patients` (
        `patient_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT UNIQUE,
        `patient_code` VARCHAR(20) UNIQUE NOT NULL,
        `date_of_birth` DATE,
        `gender` ENUM('male', 'female', 'other'),
        `blood_group` VARCHAR(5),
        `address` TEXT,
        `phone` VARCHAR(15),
        `emergency_contact` VARCHAR(15),
        `medical_history` TEXT,
        `allergies` TEXT,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL,
        INDEX idx_blood_group (`blood_group`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createPatientsTable);
    
    // Receptionists table
    $createReceptionistsTable = "CREATE TABLE IF NOT EXISTS `receptionists` (
        `receptionist_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT UNIQUE,
        `receptionist_code` VARCHAR(20) UNIQUE NOT NULL,
        `shift` ENUM('morning', 'evening', 'night') DEFAULT 'morning',
        `department` VARCHAR(50),
        `phone` VARCHAR(15),
        `join_date` DATE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createReceptionistsTable);
    
    // Appointments table
    $createAppointmentsTable = "CREATE TABLE IF NOT EXISTS `appointments` (
        `appointment_id` INT PRIMARY KEY AUTO_INCREMENT,
        `appointment_code` VARCHAR(20) UNIQUE NOT NULL,
        `patient_id` INT,
        `doctor_id` INT,
        `doctor_name` VARCHAR(100),
        `appointment_date` DATE NOT NULL,
        `appointment_time` TIME NOT NULL,
        `reason` TEXT,
        `notes` TEXT,
        `status` ENUM('pending', 'confirmed', 'cancelled', 'completed', 'no_show') DEFAULT 'pending',
        `payment_status` ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`patient_id`) REFERENCES `patients`(`patient_id`) ON DELETE SET NULL,
        FOREIGN KEY (`doctor_id`) REFERENCES `doctors`(`doctor_id`) ON DELETE SET NULL,
        INDEX idx_date (`appointment_date`),
        INDEX idx_status (`status`),
        INDEX idx_patient (`patient_id`),
        INDEX idx_doctor (`doctor_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createAppointmentsTable);
    
    // Password resets table
    $createPasswordResetsTable = "CREATE TABLE IF NOT EXISTS `password_resets` (
        `reset_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `token` VARCHAR(64) NOT NULL,
        `expires_at` DATETIME NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `used_at` TIMESTAMP NULL,
        `used` TINYINT(1) DEFAULT 0,
        INDEX idx_token (`token`),
        INDEX idx_expires (`expires_at`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createPasswordResetsTable);
    
    // Login logs table
    $createLoginLogsTable = "CREATE TABLE IF NOT EXISTS `login_logs` (
        `log_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NULL,
        `username` VARCHAR(50),
        `ip_address` VARCHAR(45) NOT NULL,
        `user_agent` TEXT,
        `status` ENUM('success', 'failed') NOT NULL,
        `login_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (`user_id`),
        INDEX idx_login_time (`login_time`),
        INDEX idx_ip (`ip_address`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createLoginLogsTable);
    
    // Password reset logs table
    $createResetLogsTable = "CREATE TABLE IF NOT EXISTS `password_reset_logs` (
        `log_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `ip_address` VARCHAR(45) NOT NULL,
        `user_agent` TEXT,
        `requested_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `reset_at` TIMESTAMP NULL,
        `status` ENUM('requested', 'success', 'failed') DEFAULT 'requested',
        INDEX idx_user_id (`user_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createResetLogsTable);
    
    // Remember tokens table
    $createRememberTokensTable = "CREATE TABLE IF NOT EXISTS `remember_tokens` (
        `token_id` INT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `token` VARCHAR(64) NOT NULL,
        `expires_at` DATETIME NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_token (`token`),
        INDEX idx_expires (`expires_at`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $db->exec($createRememberTokensTable);
}

// Insert sample data
function insertSampleData($db) {
    // Check if users table is empty
    $query = "SELECT COUNT(*) as count FROM users";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($result['count'] == 0) {
        // Create a helper function to hash passwords
        function hashPassword($plainPassword) {
            return password_hash($plainPassword, PASSWORD_DEFAULT);
        }
        
        // Define users with PLAIN TEXT PASSWORDS (they will be hashed automatically)
        $users = [
            // Admin users
            ['username' => 'admin', 'password' => 'password123', 'email' => 'admin@abchospital.lk', 'full_name' => 'System Administrator', 'role' => 'admin'],
            ['username' => 'admin2', 'password' => 'password123', 'email' => 'admin2@abchospital.lk', 'full_name' => 'Senior Admin', 'role' => 'admin'],
            ['username' => 'Kamal', 'password' => 'Kamal@123', 'email' => 'kamal@abchospital.lk', 'full_name' => 'Kamal Admin', 'role' => 'admin'],
            
            // Doctors
            ['username' => 'dr.kamal', 'password' => 'password123', 'email' => 'kamal.perera@abchospital.lk', 'full_name' => 'Dr. Kamal Perera', 'role' => 'doctor'],
            ['username' => 'dr.nimali', 'password' => 'password123', 'email' => 'nimali.fernando@abchospital.lk', 'full_name' => 'Dr. Nimali Fernando', 'role' => 'doctor'],
            ['username' => 'dr.sunil', 'password' => 'password123', 'email' => 'sunil.wijesinghe@abchospital.lk', 'full_name' => 'Dr. Sunil Wijesinghe', 'role' => 'doctor'],
            ['username' => 'dr.priyani', 'password' => 'password123', 'email' => 'priyani.jayawardena@abchospital.lk', 'full_name' => 'Dr. Priyani Jayawardena', 'role' => 'doctor'],
            ['username' => 'dr.ruwan', 'password' => 'password123', 'email' => 'ruwan.silva@abchospital.lk', 'full_name' => 'Dr. Ruwan Silva', 'role' => 'doctor'],
            
            // Patients
            ['username' => 'saman.k', 'password' => 'password123', 'email' => 'saman.k@email.com', 'full_name' => 'Saman Kumara', 'role' => 'patient'],
            ['username' => 'malini.f', 'password' => 'password123', 'email' => 'malini.f@email.com', 'full_name' => 'Malini Fonseka', 'role' => 'patient'],
            ['username' => 'vijay.k', 'password' => 'password123', 'email' => 'vijay.k@email.com', 'full_name' => 'Vijay Kumaratunga', 'role' => 'patient'],
            ['username' => 'nimal.p', 'password' => 'password123', 'email' => 'nimal.p@email.com', 'full_name' => 'Nimal Perera', 'role' => 'patient'],
            ['username' => 'chamari.a', 'password' => 'password123', 'email' => 'chamari.a@email.com', 'full_name' => 'Chamari Athapaththu', 'role' => 'patient'],
            
            // Receptionists
            ['username' => 'reception1', 'password' => 'password123', 'email' => 'reception@abchospital.lk', 'full_name' => 'Dilshan Fernando', 'role' => 'receptionist'],
            ['username' => 'reception2', 'password' => 'password123', 'email' => 'frontdesk@abchospital.lk', 'full_name' => 'Kavisha Silva', 'role' => 'receptionist']
        ];
        
        $userQuery = "INSERT INTO users (username, password, email, full_name, user_role) VALUES (?, ?, ?, ?, ?)";
        $userStmt = $db->prepare($userQuery);
        
        foreach($users as $user) {
            // Hash the password on insert
            $hashedPassword = hashPassword($user['password']);
            $userStmt->execute([
                $user['username'],
                $hashedPassword,
                $user['email'],
                $user['full_name'],
                $user['role']
            ]);
        }
        
        // Insert doctor details (rest of your code remains the same)
        $doctorData = [
            ['dr.kamal', 'D001', 'Cardiologist', 'MBBS, MD (Cardiology)', 15, 2500.00, 'Monday,Wednesday,Friday', '9:00 AM - 4:00 PM', 15],
            ['dr.nimali', 'D002', 'Pediatrician', 'MBBS, DCH', 12, 2000.00, 'Tuesday,Thursday,Saturday', '10:00 AM - 5:00 PM', 12],
            ['dr.sunil', 'D003', 'Neurologist', 'MBBS, MD (Neurology), FRCP', 20, 3000.00, 'Monday,Wednesday,Friday', '8:00 AM - 3:00 PM', 10],
            ['dr.priyani', 'D004', 'Dermatologist', 'MBBS, DVD', 10, 1800.00, 'Tuesday,Thursday,Saturday', '9:00 AM - 4:00 PM', 12],
            ['dr.ruwan', 'D005', 'Orthopedic Surgeon', 'MBBS, MS (Ortho)', 18, 2800.00, 'Monday,Thursday,Saturday', '10:00 AM - 5:00 PM', 12]
        ];
        
        foreach($doctorData as $data) {
            // Get user_id
            $getUserQuery = "SELECT user_id FROM users WHERE username = ?";
            $getUserStmt = $db->prepare($getUserQuery);
            $getUserStmt->execute([$data[0]]);
            $user = $getUserStmt->fetch();
            
            if($user) {
                $doctorQuery = "INSERT INTO doctors (user_id, doctor_code, specialization, qualification, experience_years, consultation_fee, available_days, available_time, max_appointments_per_day) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $doctorStmt = $db->prepare($doctorQuery);
                $doctorStmt->execute([
                    $user['user_id'],
                    $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]
                ]);
            }
        }
        
        // Insert patient details
        $patientData = [
            ['saman.k', 'P001', '1990-05-15', 'male', 'O+', '123 Main St, Colombo 03', '0771112233', '0771112244', 'None', 'None'],
            ['malini.f', 'P002', '1985-08-22', 'female', 'A+', '456 Park Ave, Kandy', '0772223344', '0772223355', 'Asthma', 'Pollen'],
            ['vijay.k', 'P003', '1978-03-10', 'male', 'B+', '789 Lake Rd, Galle', '0773334455', '0773334466', 'Hypertension', 'None'],
            ['nimal.p', 'P004', '1995-11-30', 'male', 'AB-', '321 Beach Rd, Negombo', '0774445566', '0774445577', 'None', 'Shellfish'],
            ['chamari.a', 'P005', '1988-07-18', 'female', 'O-', '654 Hill St, Nuwara Eliya', '0775556677', '0775556688', 'None', 'None']
        ];
        
        foreach($patientData as $data) {
            // Get user_id
            $getUserQuery = "SELECT user_id FROM users WHERE username = ?";
            $getUserStmt = $db->prepare($getUserQuery);
            $getUserStmt->execute([$data[0]]);
            $user = $getUserStmt->fetch();
            
            if($user) {
                $patientQuery = "INSERT INTO patients (user_id, patient_code, date_of_birth, gender, blood_group, address, phone, emergency_contact, medical_history, allergies) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $patientStmt = $db->prepare($patientQuery);
                $patientStmt->execute([
                    $user['user_id'],
                    $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9]
                ]);
            }
        }
        
        // Insert receptionist details
        $receptionistData = [
            ['reception1', 'R001', 'morning', 'Front Desk', '0776667788', '2024-01-15'],
            ['reception2', 'R002', 'evening', 'Appointments', '0777778899', '2024-02-01']
        ];
        
        foreach($receptionistData as $data) {
            // Get user_id
            $getUserQuery = "SELECT user_id FROM users WHERE username = ?";
            $getUserStmt = $db->prepare($getUserQuery);
            $getUserStmt->execute([$data[0]]);
            $user = $getUserStmt->fetch();
            
            if($user) {
                $receptionistQuery = "INSERT INTO receptionists (user_id, receptionist_code, shift, department, phone, join_date) 
                                      VALUES (?, ?, ?, ?, ?, ?)";
                $receptionistStmt = $db->prepare($receptionistQuery);
                $receptionistStmt->execute([
                    $user['user_id'],
                    $data[1], $data[2], $data[3], $data[4], $data[5]
                ]);
            }
        }
    }
    
    // Check if appointments table is empty
    $query = "SELECT COUNT(*) as count FROM appointments";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($result['count'] == 0) {
        // Get patient and doctor IDs
        $getPatientQuery = "SELECT p.patient_id, u.username FROM patients p JOIN users u ON p.user_id = u.user_id";
        $patientStmt = $db->prepare($getPatientQuery);
        $patientStmt->execute();
        $patients = $patientStmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $getDoctorQuery = "SELECT d.doctor_id, u.username, d.doctor_code, u.full_name FROM doctors d JOIN users u ON d.user_id = u.user_id";
        $doctorStmt = $db->prepare($getDoctorQuery);
        $doctorStmt->execute();
        $doctors = $doctorStmt->fetchAll();
        
        // Insert sample appointments
        if(!empty($patients) && !empty($doctors)) {
            $patientArray = array_values($patients);
            $appointments = [
                ['A001', $patientArray[0] ?? null, $doctors[0]['doctor_id'] ?? null, $doctors[0]['full_name'] ?? 'Dr. Kamal Perera', date('Y-m-d', strtotime('+1 day')), '09:00:00', 'Chest pain and shortness of breath', 'confirmed', 'pending'],
                ['A002', $patientArray[1] ?? null, $doctors[1]['doctor_id'] ?? null, $doctors[1]['full_name'] ?? 'Dr. Nimali Fernando', date('Y-m-d', strtotime('+1 day')), '10:30:00', 'Child vaccination', 'confirmed', 'paid'],
                ['A003', $patientArray[2] ?? null, $doctors[2]['doctor_id'] ?? null, $doctors[2]['full_name'] ?? 'Dr. Sunil Wijesinghe', date('Y-m-d', strtotime('+2 days')), '14:00:00', 'Severe headache', 'pending', 'pending'],
                ['A004', $patientArray[3] ?? null, $doctors[3]['doctor_id'] ?? null, $doctors[3]['full_name'] ?? 'Dr. Priyani Jayawardena', date('Y-m-d', strtotime('+3 days')), '11:00:00', 'Skin rash', 'pending', 'pending'],
                ['A005', $patientArray[4] ?? null, $doctors[4]['doctor_id'] ?? null, $doctors[4]['full_name'] ?? 'Dr. Ruwan Silva', date('Y-m-d', strtotime('+4 days')), '15:30:00', 'Knee pain', 'confirmed', 'paid']
            ];
            
            $aptQuery = "INSERT INTO appointments (appointment_code, patient_id, doctor_id, doctor_name, appointment_date, appointment_time, reason, status, payment_status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $aptStmt = $db->prepare($aptQuery);
            
            foreach($appointments as $apt) {
                if($apt[1] && $apt[2]) {
                    $aptStmt->execute($apt);
                }
            }
        }
    }
}

// Initialize the database when this file is included
try {
    initializeDatabase();
} catch(Exception $e) {
    error_log("Database initialization error: " . $e->getMessage());
}
?>