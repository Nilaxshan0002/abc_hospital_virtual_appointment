<?php
session_start();
$base_path = '../../';
$page_title = 'Receptionist Dashboard - ABC Hospital';

// Include database connection
require_once '../../config/database.php';

// Initialize database
initializeDatabase();

// Check if user is logged in as receptionist
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'receptionist') {
    if (!isset($_SESSION['user_id'])) {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $query = "SELECT receptionist_id, receptionist_name, receptionist_email, receptionist_phone FROM receptionists LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $receptionist = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($receptionist) {
                $_SESSION['user_id'] = $receptionist['receptionist_id'];
                $_SESSION['user_name'] = $receptionist['receptionist_name'];
                $_SESSION['user_type'] = 'receptionist';
                $_SESSION['user_email'] = $receptionist['receptionist_email'] ?? '';
            } else {
                // Set default receptionist name for demo
                $_SESSION['user_id'] = 1;
                $_SESSION['user_name'] = 'Receptionist 1';
                $_SESSION['user_type'] = 'receptionist';
                $_SESSION['user_email'] = 'reception1@abchospital.lk';
            }
        } catch(Exception $e) {
            error_log("Error getting receptionist: " . $e->getMessage());
            // Set default receptionist name for demo
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Receptionist 1';
            $_SESSION['user_type'] = 'receptionist';
            $_SESSION['user_email'] = 'reception1@abchospital.lk';
        }
    }
}

$receptionist_id = $_SESSION['user_id'];
$receptionist_name = $_SESSION['user_name'];

// Force name to be "Receptionist 1" if it's "Kamal Perera" or "Reception1"
if ($receptionist_name == 'Kamal Perera' || $receptionist_name == 'Reception1') {
    $receptionist_name = 'Receptionist 1';
    $_SESSION['user_name'] = 'Receptionist 1';
}

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get receptionist's details
$receptionist_info = [];
try {
    $query = "SELECT * FROM receptionists WHERE receptionist_id = :receptionist_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':receptionist_id', $receptionist_id);
    $stmt->execute();
    $receptionist_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching receptionist info: " . $e->getMessage());
}

// Handle New Patient Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_patient'])) {
    $patient_name = trim($_POST['patient_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $dob = trim($_POST['dob']);
    $gender = trim($_POST['gender']);
    $blood_group = trim($_POST['blood_group']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');
    
    try {
        $check_query = "SELECT id FROM patients WHERE email = :email";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Patient with this email already exists!";
        } else {
            $query = "INSERT INTO patients (patient_name, email, phone, address, dob, gender, blood_group, password, created_at) 
                      VALUES (:patient_name, :email, :phone, :address, :dob, :gender, :blood_group, :password, :created_at)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':patient_name', $patient_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':blood_group', $blood_group);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':created_at', $created_at);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Patient registered successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to register patient.";
            }
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle New Appointment Booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_type = $_POST['appointment_type'];
    $reason = trim($_POST['reason']);
    $status = 'confirmed';
    $created_at = date('Y-m-d H:i:s');
    
    try {
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
            $_SESSION['success_message'] = "Appointment booked successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to book appointment.";
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Appointment Status Update (Check-in, Complete, Cancel)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_appointment_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['new_status'];
    
    try {
        $query = "UPDATE appointments SET status = :status WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $appointment_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Appointment status updated to " . ucfirst($new_status);
        } else {
            $_SESSION['error_message'] = "Failed to update status.";
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Patient Deletion
if (isset($_GET['delete_patient'])) {
    $patient_id = $_GET['delete_patient'];
    
    try {
        $check_query = "SELECT COUNT(*) as count FROM appointments WHERE patient_id = :patient_id";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':patient_id', $patient_id);
        $check_stmt->execute();
        $count = $check_stmt->fetch(PDO::FETCH_ASSOC)['count'];
        
        if ($count > 0) {
            $_SESSION['error_message'] = "Cannot delete patient with existing appointments.";
        } else {
            $query = "DELETE FROM patients WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $patient_id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Patient deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to delete patient.";
            }
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get all patients
$patients = [];
try {
    $query = "SELECT * FROM patients ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching patients: " . $e->getMessage());
}

// Get all doctors
$doctors = [];
try {
    $query = "SELECT doctor_id, doctor_name, doctor_specialty, doctor_email, doctor_phone FROM doctors ORDER BY doctor_name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching doctors: " . $e->getMessage());
}

// Get all appointments with patient and doctor details
$appointments = [];
try {
    $query = "SELECT a.*, p.patient_name, p.phone as patient_phone, p.email as patient_email,
              d.doctor_name, d.doctor_specialty
              FROM appointments a
              JOIN patients p ON a.patient_id = p.id
              JOIN doctors d ON a.doctor_id = d.doctor_id
              ORDER BY a.appointment_date DESC, a.appointment_time DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching appointments: " . $e->getMessage());
}

// Get today's appointments
$today = date('Y-m-d');
$today_appointments = 0;
$checked_in_count = 0;
$pending_count = 0;
$completed_count = 0;
$total_patients = 0;
$total_appointments = 0;
$active_doctors = 0;

try {
    $query = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = :today AND status != 'cancelled'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $today_appointments = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = :today AND status = 'confirmed'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $checked_in_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments WHERE status = 'pending'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $pending_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments WHERE status = 'completed'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $completed_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM patients";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $total_patients = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $total_appointments = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM doctors";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $active_doctors = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/avif" href="<?php echo $base_path; ?>images/reception/reception1.png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #333;
            overflow-x: hidden;
        }

        /* Navbar - Receptionist Theme */
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .logo img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: cover;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #ffd89b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-text span {
            background: linear-gradient(135deg, #ffd89b 0%, #fff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .nav-links a:first-child {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
        }

        .nav-links a:last-child {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
        }

        /* Dashboard Layout */
        .dashboard-wrapper {
            display: flex;
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar - Receptionist Theme */
        .receptionist-sidebar {
            width: 280px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            height: calc(100vh - 80px);
            overflow-y: auto;
            border-radius: 20px;
            margin: 20px 0 20px 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 2px solid rgba(30,60,114,0.2);
            background: linear-gradient(135deg, rgba(30,60,114,0.1) 0%, rgba(42,82,152,0.1) 100%);
        }

        .sidebar-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 3px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e3c72;
        }

        .user-role {
            color: #2a5298;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-item {
            padding: 0.8rem 1.5rem;
            margin: 0.3rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #555;
            border-radius: 12px;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(30,60,114,0.1);
            color: #1e3c72;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(30,60,114,0.3);
        }

        .nav-item i {
            width: 25px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 320px;
            padding: 2rem;
        }

        /* Welcome Banner */
        .welcome-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid #2a5298;
        }

        .welcome-card h1 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-card p {
            color: #666;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .stat-box.primary { border-bottom-color: #1e3c72; }
        .stat-box.success { border-bottom-color: #28a745; }
        .stat-box.warning { border-bottom-color: #ffc107; }
        .stat-box.info { border-bottom-color: #17a2b8; }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3c72;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1.2rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .action-icon.blue { background: rgba(30,60,114,0.1); color: #1e3c72; }
        .action-icon.green { background: rgba(40,167,69,0.1); color: #28a745; }
        .action-icon.orange { background: rgba(255,193,7,0.1); color: #ffc107; }
        .action-icon.purple { background: rgba(102,126,234,0.1); color: #667eea; }

        .action-text h4 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .action-text p {
            font-size: 0.75rem;
            color: #999;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Buttons */
        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30,60,114,0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%);
            color: white;
        }

        /* Forms */
        .form-panel {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: none;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-panel h3 {
            color: #1e3c72;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e3c72;
            box-shadow: 0 0 0 3px rgba(30,60,114,0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Tables */
        .table-wrapper {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow-x: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: rgba(30,60,114,0.05);
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-completed { background: #d1ecf1; color: #0c5460; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-waiting { background: #e0f2fe; color: #0369a1; }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 5px 12px;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .action-btn.view { background: #1e3c72; color: white; }
        .action-btn.checkin { background: #28a745; color: white; }
        .action-btn.complete { background: #17a2b8; color: white; }
        .action-btn.cancel { background: #dc3545; color: white; }
        .action-btn.delete { background: #dc3545; color: white; }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .modal-header h3 {
            color: white;
        }

        .modal-close {
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            transition: all 0.3s;
        }

        .modal-close:hover {
            color: #ff6b6b;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .info-row {
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: 600;
            color: #1e3c72;
            font-size: 0.85rem;
        }

        .info-value {
            color: #333;
            margin-top: 5px;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .receptionist-sidebar {
                position: relative;
                width: 100%;
                height: auto;
                margin: 10px;
            }
            .main-content {
                margin-left: 0;
            }
            .dashboard-wrapper {
                flex-direction: column;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo $base_path; ?>index.php" class="logo">
                <img src="<?php echo $base_path; ?>images/ABC logo.webp" alt="ABC Hospital Logo">
                <span class="logo-text">ABC <span>VIRTUAL</span></span>
            </a>
            <div class="nav-links">
                <a href="<?php echo $base_path; ?>index.php"><i class="fas fa-home"></i> Home</a>
                <a href="#" onclick="logout(event)"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Wrapper -->
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="receptionist-sidebar" data-aos="fade-right">
            <div class="sidebar-header">
                <img src="<?php echo $base_path; ?>images/reception2.png" alt="Receptionist Avatar" onerror="this.src='https://via.placeholder.com/100x100/1e3c72/ffffff?text=R';">
                <div class="user-name"><?php echo htmlspecialchars($receptionist_name); ?></div>
                <div class="user-role"><i class="fas fa-briefcase"></i> Receptionist</div>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item active" onclick="showSection('dashboard', event)">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </div>
                <div class="nav-item" onclick="showSection('appointments', event)">
                    <i class="fas fa-calendar-check"></i> Manage Appointments
                </div>
                <div class="nav-item" onclick="showSection('patients', event)">
                    <i class="fas fa-users"></i> Patient Records
                </div>
                <div class="nav-item" onclick="showSection('new-patient', event)">
                    <i class="fas fa-user-plus"></i> Register Patient
                </div>
                <div class="nav-item" onclick="showSection('new-appointment', event)">
                    <i class="fas fa-plus-circle"></i> Book Appointment
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <!-- Dashboard Section -->
            <div id="dashboardSection">
                <div class="welcome-card">
                    <h1>Welcome, <?php echo htmlspecialchars($receptionist_name); ?>! 👋</h1>
                    <p><?php echo date('l, F j, Y'); ?> | Manage your front desk operations efficiently</p>
                </div>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-box primary" onclick="showSection('appointments', event)">
                        <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
                        <div class="stat-number"><?php echo $today_appointments; ?></div>
                        <div class="stat-label">Today's Appointments</div>
                    </div>
                    <div class="stat-box success" onclick="showSection('appointments', event)">
                        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                        <div class="stat-number"><?php echo $checked_in_count; ?></div>
                        <div class="stat-label">Checked In Today</div>
                    </div>
                    <div class="stat-box warning" onclick="showSection('appointments', event)">
                        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                        <div class="stat-number"><?php echo $pending_count; ?></div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-box info" onclick="showSection('appointments', event)">
                        <div class="stat-icon"><i class="fas fa-user-md"></i></div>
                        <div class="stat-number"><?php echo $active_doctors; ?></div>
                        <div class="stat-label">Active Doctors</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="action-card" onclick="showSection('new-patient', event)">
                        <div class="action-icon blue"><i class="fas fa-user-plus"></i></div>
                        <div class="action-text">
                            <h4>Register Patient</h4>
                            <p>Add new patient to system</p>
                        </div>
                    </div>
                    <div class="action-card" onclick="showSection('new-appointment', event)">
                        <div class="action-icon green"><i class="fas fa-calendar-plus"></i></div>
                        <div class="action-text">
                            <h4>Book Appointment</h4>
                            <p>Schedule new appointment</p>
                        </div>
                    </div>
                    <div class="action-card" onclick="showSection('patients', event)">
                        <div class="action-icon orange"><i class="fas fa-search"></i></div>
                        <div class="action-text">
                            <h4>Find Patient</h4>
                            <p>Search patient records</p>
                        </div>
                    </div>
                    <div class="action-card" onclick="showSection('appointments', event)">
                        <div class="action-icon purple"><i class="fas fa-list"></i></div>
                        <div class="action-text">
                            <h4>View All Appointments</h4>
                            <p>Manage appointments</p>
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-clock"></i> Today's Appointments</h2>
                    <button class="btn btn-primary" onclick="showSection('new-appointment', event)"><i class="fas fa-plus"></i> New Appointment</button>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="todayAppointmentsTable">
                            <?php 
                            $today_appointments_list = array_filter($appointments, function($apt) use ($today) {
                                return $apt['appointment_date'] == $today && $apt['status'] != 'cancelled';
                            });
                            if(count($today_appointments_list) > 0): 
                                foreach($today_appointments_list as $apt): 
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($apt['patient_name']); ?></td>
                                <td><?php echo htmlspecialchars($apt['doctor_name']); ?> <small>(<?php echo htmlspecialchars($apt['doctor_specialty']); ?>)</small></td>
                                <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                <td><span class="badge badge-<?php echo $apt['status']; ?>"><?php echo ucfirst($apt['status']); ?></span></td>
                                <td class="action-btns">
                                    <button class="action-btn view" onclick="viewAppointment(<?php echo htmlspecialchars(json_encode($apt)); ?>)"><i class="fas fa-eye"></i></button>
                                    <?php if($apt['status'] == 'pending'): ?>
                                    <button class="action-btn checkin" onclick="updateStatus(<?php echo $apt['id']; ?>, 'confirmed')"><i class="fas fa-fingerprint"></i> Check-in</button>
                                    <?php endif; ?>
                                    <?php if($apt['status'] == 'confirmed'): ?>
                                    <button class="action-btn complete" onclick="updateStatus(<?php echo $apt['id']; ?>, 'completed')"><i class="fas fa-check-double"></i> Complete</button>
                                    <?php endif; ?>
                                    <?php if($apt['status'] != 'cancelled' && $apt['status'] != 'completed'): ?>
                                    <button class="action-btn cancel" onclick="updateStatus(<?php echo $apt['id']; ?>, 'cancelled')"><i class="fas fa-times"></i> Cancel</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5"><div class="empty-state"><i class="fas fa-calendar-check"></i><p>No appointments scheduled for today</p></div></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Doctors on Duty -->
                <div class="section-header" style="margin-top: 2rem;">
                    <h2 class="section-title"><i class="fas fa-stethoscope"></i> Doctors on Duty</h2>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr><th>Doctor Name</th><th>Specialty</th><th>Contact</th></tr>
                        </thead>
                        <tbody>
                            <?php if(count($doctors) > 0): ?>
                                <?php foreach($doctors as $doctor): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($doctor['doctor_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($doctor['doctor_specialty']); ?></td>
                                    <td><?php echo htmlspecialchars($doctor['doctor_phone'] ?? 'N/A'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3"><div class="empty-state"><i class="fas fa-user-md"></i><p>No doctors found</p></div></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- All Appointments Section -->
            <div id="appointmentsSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-calendar-check"></i> All Appointments</h2>
                    <button class="btn btn-primary" onclick="showSection('new-appointment', event)"><i class="fas fa-plus"></i> New Appointment</button>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($appointments) > 0): ?>
                                <?php foreach($appointments as $apt): ?>
                                <tr>
                                    <td><?php echo $apt['id']; ?></td>
                                    <td><?php echo htmlspecialchars($apt['patient_name']); ?></td>
                                    <td><?php echo htmlspecialchars($apt['doctor_name']); ?> (<?php echo htmlspecialchars($apt['doctor_specialty']); ?>)</small></td>
                                    <td><?php echo date('M d, Y', strtotime($apt['appointment_date'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                    <td><?php echo ucfirst($apt['appointment_type'] ?? 'General'); ?></small></td>
                                    <td><span class="badge badge-<?php echo $apt['status']; ?>"><?php echo ucfirst($apt['status']); ?></span></td>
                                    <td class="action-btns">
                                        <button class="action-btn view" onclick="viewAppointment(<?php echo htmlspecialchars(json_encode($apt)); ?>)"><i class="fas fa-eye"></i></button>
                                        <?php if($apt['status'] == 'pending'): ?>
                                        <button class="action-btn checkin" onclick="updateStatus(<?php echo $apt['id']; ?>, 'confirmed')"><i class="fas fa-fingerprint"></i> Check-in</button>
                                        <?php endif; ?>
                                        <?php if($apt['status'] == 'confirmed'): ?>
                                        <button class="action-btn complete" onclick="updateStatus(<?php echo $apt['id']; ?>, 'completed')"><i class="fas fa-check-double"></i> Complete</button>
                                        <?php endif; ?>
                                        <?php if($apt['status'] != 'cancelled' && $apt['status'] != 'completed'): ?>
                                        <button class="action-btn cancel" onclick="updateStatus(<?php echo $apt['id']; ?>, 'cancelled')"><i class="fas fa-times"></i> Cancel</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8"><div class="empty-state"><i class="fas fa-calendar-times"></i><p>No appointments found</p></div></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Patients Section -->
            <div id="patientsSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-users"></i> Patient Records</h2>
                    <button class="btn btn-primary" onclick="showSection('new-patient', event)"><i class="fas fa-user-plus"></i> Register Patient</button>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Blood Group</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($patients) > 0): ?>
                                <?php foreach($patients as $patient): ?>
                                <tr>
                                    <td><?php echo $patient['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($patient['patient_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($patient['email']); ?></small></td>
                                    <td><?php echo htmlspecialchars($patient['phone']); ?></small></td>
                                    <td><?php echo ucfirst($patient['gender'] ?? 'N/A'); ?></small></td>
                                    <td><?php echo $patient['blood_group'] ?? 'N/A'; ?></small></td>
                                    <td><?php echo date('M d, Y', strtotime($patient['created_at'])); ?></small></td>
                                    <td class="action-btns">
                                        <button class="action-btn view" onclick="viewPatient(<?php echo htmlspecialchars(json_encode($patient)); ?>)"><i class="fas fa-eye"></i></button>
                                        <a href="?delete_patient=<?php echo $patient['id']; ?>" class="action-btn delete" onclick="return confirmDelete()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8"><div class="empty-state"><i class="fas fa-users"></i><p>No patients found</p></div></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Register Patient Form -->
            <div id="newPatientSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-user-plus"></i> Register New Patient</h2>
                </div>

                <div class="form-panel" style="display: block;">
                    <form method="POST" action="" onsubmit="return validatePatientForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name *</label>
                                <input type="text" name="patient_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Blood Group</label>
                                <select name="blood_group" class="form-control">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-control" required>
                            <small>Minimum 6 characters</small>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" name="register_patient" class="btn btn-success"><i class="fas fa-save"></i> Register Patient</button>
                        <button type="button" class="btn btn-warning" onclick="showSection('patients', event)" style="margin-left: 1rem;"><i class="fas fa-times"></i> Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Book Appointment Form -->
            <div id="newAppointmentSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-plus-circle"></i> Book New Appointment</h2>
                </div>

                <div class="form-panel" style="display: block;">
                    <form method="POST" action="" onsubmit="return validateAppointmentForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Select Patient *</label>
                                <select name="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php foreach($patients as $patient): ?>
                                        <option value="<?php echo $patient['id']; ?>"><?php echo htmlspecialchars($patient['patient_name']); ?> - <?php echo htmlspecialchars($patient['phone']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Doctor *</label>
                                <select name="doctor_id" class="form-control" required>
                                    <option value="">-- Select Doctor --</option>
                                    <?php foreach($doctors as $doctor): ?>
                                        <option value="<?php echo $doctor['doctor_id']; ?>"><?php echo htmlspecialchars($doctor['doctor_name']); ?> (<?php echo htmlspecialchars($doctor['doctor_specialty']); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Appointment Date *</label>
                                <input type="date" name="appointment_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label>Appointment Time *</label>
                                <input type="time" name="appointment_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Appointment Type</label>
                                <select name="appointment_type" class="form-control">
                                    <option value="general">General Checkup</option>
                                    <option value="followup">Follow-up</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="consultation">Consultation</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Reason for Visit</label>
                            <textarea name="reason" class="form-control" rows="3" placeholder="Brief description of symptoms or reason for appointment"></textarea>
                        </div>
                        <button type="submit" name="book_appointment" class="btn btn-success"><i class="fas fa-calendar-check"></i> Book Appointment</button>
                        <button type="button" class="btn btn-warning" onclick="showSection('appointments', event)" style="margin-left: 1rem;"><i class="fas fa-times"></i> Cancel</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-medical"></i> Details</h3>
                <span class="modal-close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart"></i> for better healthcare</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true, offset: 100 });

        function showSection(section, event) {
            const sections = ['dashboardSection', 'appointmentsSection', 'patientsSection', 'newPatientSection', 'newAppointmentSection'];
            sections.forEach(s => {
                const el = document.getElementById(s);
                if(el) el.style.display = 'none';
            });
            
            if(section === 'dashboard') document.getElementById('dashboardSection').style.display = 'block';
            else if(section === 'appointments') document.getElementById('appointmentsSection').style.display = 'block';
            else if(section === 'patients') document.getElementById('patientsSection').style.display = 'block';
            else if(section === 'new-patient') document.getElementById('newPatientSection').style.display = 'block';
            else if(section === 'new-appointment') document.getElementById('newAppointmentSection').style.display = 'block';
            
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            if(event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            } else {
                // Fallback: find and activate the corresponding nav item
                const targetSection = section;
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    const onclickAttr = item.getAttribute('onclick');
                    if(onclickAttr && onclickAttr.includes(`'${targetSection}'`)) {
                        item.classList.add('active');
                    }
                });
            }
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this patient? This action cannot be undone.');
        }

        function validatePatientForm() {
            const name = document.querySelector('input[name="patient_name"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const phone = document.querySelector('input[name="phone"]').value;
            const password = document.querySelector('input[name="password"]').value;
            
            if(name.trim() === '') { alert('Please enter patient name'); return false; }
            if(email.trim() === '') { alert('Please enter email'); return false; }
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { alert('Enter valid email'); return false; }
            if(phone.trim() === '') { alert('Please enter phone number'); return false; }
            if(password.length < 6) { alert('Password must be at least 6 characters'); return false; }
            return true;
        }

        function validateAppointmentForm() {
            const patient = document.querySelector('select[name="patient_id"]').value;
            const doctor = document.querySelector('select[name="doctor_id"]').value;
            const date = document.querySelector('input[name="appointment_date"]').value;
            const time = document.querySelector('input[name="appointment_time"]').value;
            
            if(!patient) { alert('Please select a patient'); return false; }
            if(!doctor) { alert('Please select a doctor'); return false; }
            if(!date) { alert('Please select appointment date'); return false; }
            if(!time) { alert('Please select appointment time'); return false; }
            return true;
        }

        function updateStatus(id, status) {
            let message = '';
            if(status === 'confirmed') message = 'Check-in this patient?';
            else if(status === 'completed') message = 'Mark this appointment as completed?';
            else if(status === 'cancelled') message = 'Cancel this appointment?';
            else message = 'Update appointment status?';
            
            if(confirm(message)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';
                form.innerHTML = `<input name="appointment_id" value="${id}"><input name="new_status" value="${status}"><input name="update_appointment_status" value="1">`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function viewAppointment(apt) {
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="info-row"><div class="info-label">Patient Name</div><div class="info-value"><strong>${escapeHtml(apt.patient_name)}</strong></div></div>
                <div class="info-row"><div class="info-label">Doctor</div><div class="info-value">${escapeHtml(apt.doctor_name)} (${escapeHtml(apt.doctor_specialty)})</div></div>
                <div class="info-row"><div class="info-label">Contact</div><div class="info-value">${escapeHtml(apt.patient_phone)}</div></div>
                <div class="info-row"><div class="info-label">Date & Time</div><div class="info-value">${formatDate(apt.appointment_date)} at ${formatTime(apt.appointment_time)}</div></div>
                <div class="info-row"><div class="info-label">Type</div><div class="info-value">${escapeHtml(apt.appointment_type || 'General')}</div></div>
                <div class="info-row"><div class="info-label">Reason</div><div class="info-value">${escapeHtml(apt.reason || 'General Checkup')}</div></div>
                <div class="info-row"><div class="info-label">Status</div><div class="info-value"><span class="badge badge-${apt.status}">${apt.status}</span></div></div>
            `;
            document.getElementById('detailsModal').classList.add('active');
        }

        function viewPatient(patient) {
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="info-row"><div class="info-label">Patient Name</div><div class="info-value"><strong>${escapeHtml(patient.patient_name)}</strong></div></div>
                <div class="info-row"><div class="info-label">Email</div><div class="info-value">${escapeHtml(patient.email)}</div></div>
                <div class="info-row"><div class="info-label">Phone</div><div class="info-value">${escapeHtml(patient.phone)}</div></div>
                <div class="info-row"><div class="info-label">Gender</div><div class="info-value">${escapeHtml(patient.gender || 'N/A')}</div></div>
                <div class="info-row"><div class="info-label">Blood Group</div><div class="info-value">${escapeHtml(patient.blood_group || 'N/A')}</div></div>
                <div class="info-row"><div class="info-label">Date of Birth</div><div class="info-value">${escapeHtml(patient.dob || 'N/A')}</div></div>
                <div class="info-row"><div class="info-label">Address</div><div class="info-value">${escapeHtml(patient.address || 'N/A')}</div></div>
                <div class="info-row"><div class="info-label">Registered</div><div class="info-value">${formatDate(patient.created_at)}</div></div>
            `;
            document.getElementById('detailsModal').classList.add('active');
        }

        function formatDate(dateStr) {
            if(!dateStr) return 'N/A';
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function formatTime(timeStr) {
            if(!timeStr) return 'N/A';
            const [h, m] = timeStr.split(':');
            const hour = parseInt(h);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${m} ${ampm}`;
        }

        function escapeHtml(text) {
            if(!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.remove('active');
        }

        // Fixed logout function - redirects to home page (index.php)
        function logout(event) {
            if(event) event.preventDefault();
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '../../index.php';
            }
        }

        // Auto-hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 1000);
            });
        }, 5000);
    </script>
</body>
</html>