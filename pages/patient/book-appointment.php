<?php
session_start();
require_once '../../config/database.php';

// Initialize database
initializeDatabase();

// Check if patient is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    $patient_id = $_SESSION['user_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_type = $_POST['appointment_type'] ?? 'general';
    $reason = trim($_POST['reason']);
    $status = 'pending';
    $created_at = date('Y-m-d H:i:s');
    
    // Validate inputs
    if (empty($doctor_id) || empty($appointment_date) || empty($appointment_time) || empty($reason)) {
        $_SESSION['error_message'] = "Please fill all required fields.";
        header("Location: dashboard.php");
        exit();
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    try {
        // Check if slot is available
        $check_query = "SELECT COUNT(*) as count FROM appointments 
                        WHERE doctor_id = :doctor_id 
                        AND appointment_date = :appointment_date 
                        AND appointment_time = :appointment_time 
                        AND status != 'cancelled'";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':doctor_id', $doctor_id);
        $check_stmt->bindParam(':appointment_date', $appointment_date);
        $check_stmt->bindParam(':appointment_time', $appointment_time);
        $check_stmt->execute();
        $existing = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing['count'] > 0) {
            $_SESSION['error_message'] = "This time slot is already booked. Please select another time.";
            header("Location: dashboard.php");
            exit();
        }
        
        // Insert appointment
        $query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, appointment_type, reason, status, created_at) 
                  VALUES (:patient_id, :doctor_id, :appointment_date, :appointment_time, :appointment_type, :reason, :status, :created_at)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':patient_id', $patient_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->bindParam(':appointment_time', $appointment_time);
        $stmt->bindParam(':appointment_type', $appointment_type);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_at', $created_at);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Appointment booked successfully! We will confirm it shortly.";
        } else {
            $_SESSION['error_message'] = "Failed to book appointment. Please try again.";
        }
    } catch(PDOException $e) {
        error_log("Error booking appointment: " . $e->getMessage());
        $_SESSION['error_message'] = "Database error. Please try again.";
    }
    
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>