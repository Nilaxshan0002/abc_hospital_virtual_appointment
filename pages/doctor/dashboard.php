<?php
session_start();
$base_path = '../../';
$page_title = 'Doctor Dashboard - ABC Virtual';

// Include database connection
require_once '../../config/database.php';

// Initialize database
initializeDatabase();

// Check if user is logged in as doctor
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'doctor') {
    // For demo, you can set a test doctor
    if (!isset($_SESSION['user_id'])) {
        // Get first doctor from database for demo
        try {
            $database = new Database();
            $db = $database->getConnection();
            $query = "SELECT doctor_id, doctor_name, doctor_specialty, doctor_email, doctor_phone FROM doctors LIMIT 1";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($doctor) {
                $_SESSION['user_id'] = $doctor['doctor_id'];
                // FORCE the name to be Kamal Perera
                $_SESSION['user_name'] = 'Kamal Perera';
                $_SESSION['user_type'] = 'doctor';
                $_SESSION['user_email'] = $doctor['doctor_email'] ?? '';
            } else {
                // If no doctor exists, show error
                header("Location: ../../index.php?error=no_doctor_found");
                exit();
            }
        } catch(Exception $e) {
            error_log("Error getting doctor: " . $e->getMessage());
            header("Location: ../../index.php?error=db_error");
            exit();
        }
    } else {
        // FORCE the name in session to be Kamal Perera
        $_SESSION['user_name'] = 'Kamal Perera';
    }
}

$doctor_id = $_SESSION['user_id'];
$raw_doctor_name = $_SESSION['user_name'];

// Helper function to clean doctor name - remove duplicate "Dr." prefix
function cleanDoctorName($name) {
    // Remove any existing "Dr." or "Dr " prefix to avoid duplication
    $cleaned = preg_replace('/^(Dr\.?\s*)/i', '', $name);
    // Return with single "Dr. " prefix
    return 'Dr. ' . trim($cleaned);
}

// Get cleaned doctor name for display (with single Dr. prefix)
$doctor_name_display = cleanDoctorName($raw_doctor_name);
// Keep original for database operations if needed
$doctor_name = $raw_doctor_name;

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get doctor's details
try {
    $query = "SELECT * FROM doctors WHERE doctor_id = :doctor_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $doctor_info = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $doctor_info = null;
    error_log("Error fetching doctor info: " . $e->getMessage());
}

// Handle appointment status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['status'];
    
    try {
        $query = "UPDATE appointments SET status = :status WHERE id = :id AND doctor_id = :doctor_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $appointment_id);
        $stmt->bindParam(':doctor_id', $doctor_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Appointment " . ucfirst($new_status) . " successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update appointment status.";
        }
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        error_log("Error updating appointment: " . $e->getMessage());
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get doctor's appointments with proper JOIN
try {
    $query = "SELECT a.*, p.patient_name, p.phone as patient_phone, p.email as patient_email 
              FROM appointments a
              JOIN patients p ON a.patient_id = p.id
              WHERE a.doctor_id = :doctor_id 
              ORDER BY a.appointment_date DESC, a.appointment_time DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $appointments = [];
    error_log("Error fetching appointments: " . $e->getMessage());
}

// Get today's appointments
$today = date('Y-m-d');
try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE doctor_id = :doctor_id AND appointment_date = :today AND status != 'cancelled'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $today_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $today_count = 0;
}

// Get pending appointments
try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE doctor_id = :doctor_id AND status = 'pending'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $pending_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $pending_count = 0;
}

// Get completed appointments count
try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE doctor_id = :doctor_id AND status = 'completed'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $completed_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $completed_count = 0;
}

// Get confirmed appointments count
try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE doctor_id = :doctor_id AND status = 'confirmed'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $confirmed_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $confirmed_count = 0;
}

// Get total patients (unique)
try {
    $query = "SELECT COUNT(DISTINCT patient_id) as count FROM appointments 
              WHERE doctor_id = :doctor_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->execute();
    $total_patients = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $total_patients = 0;
}

// Helper function to escape JSON
function safe_json_encode($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

$base_url = '/abc_hospital_virtual_appointment';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | <?php echo htmlspecialchars($doctor_name_display); ?></title>
    <meta name="description" content="Doctor Dashboard - ABC Hospital Virtual Healthcare System">
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="<?php echo $base_path; ?>images/doctor/doctor.jpg">
    <link rel="shortcut icon" type="image/jpg" href="<?php echo $base_path; ?>images/doctor/doctor.jpg">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            overflow-x: hidden;
        }

        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s;
        }

        .loader {
            width: 80px;
            height: 80px;
            border: 5px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hide preloader when page is ready */
        .preloader.hide {
            opacity: 0;
            visibility: hidden;
            display: none;
        }

        /* Navbar - Premium Deep Blue Gradient */
        .navbar {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
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
            background-clip: text;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a:first-child {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            border: none;
        }

        .nav-links a:first-child:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255,107,107,0.3);
        }

        .nav-links a:last-child {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .nav-links a:last-child:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar */
        .sidebar {
            width: 300px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            position: fixed;
            height: calc(100vh - 80px);
            overflow-y: auto;
            border-radius: 20px;
            margin: 20px 0 20px 20px;
        }

        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 2px solid rgba(26,41,128,0.2);
            background: linear-gradient(135deg, rgba(26,41,128,0.1) 0%, rgba(38,208,206,0.1) 100%);
        }

        .sidebar-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid #fff;
            box-shadow: 0 10px 30px rgba(26,41,128,0.3);
        }

        .user-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a2980;
            margin-bottom: 0.5rem;
        }

        .user-role {
            color: #26d0ce;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .user-specialty {
            color: #666;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-item {
            padding: 1rem 1.5rem;
            margin: 0.5rem 1rem;
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
            background: linear-gradient(135deg, rgba(26,41,128,0.1) 0%, rgba(38,208,206,0.1) 100%);
            color: #1a2980;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(26,41,128,0.3);
        }

        .nav-item i {
            font-size: 1.3rem;
            width: 30px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 340px;
            padding: 2rem;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .welcome-banner h1 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-banner p {
            color: #666;
            font-size: 1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.primary { background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%); color: white; }
        .stat-icon.warning { background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%); color: white; }
        .stat-icon.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; }
        .stat-icon.info { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
            margin-top: 0.25rem;
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
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .filter-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1.25rem;
            border: 2px solid rgba(26,41,128,0.2);
            background: white;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .filter-btn:hover {
            border-color: #1a2980;
            color: #1a2980;
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            border-color: transparent;
        }

        /* Table Container */
        .table-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow-x: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(26,41,128,0.05);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending { background: rgba(242,153,74,0.15); color: #f2994a; }
        .status-confirmed { background: rgba(17,153,142,0.15); color: #11998e; }
        .status-completed { background: rgba(102,126,234,0.15); color: #667eea; }
        .status-cancelled { background: rgba(255,107,107,0.15); color: #ff6b6b; }

        /* Action Buttons */
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            font-family: 'Poppins', sans-serif;
        }

        .action-btn.confirm {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .action-btn.confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17,153,142,0.4);
        }

        .action-btn.complete {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .action-btn.complete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }

        .action-btn.cancel {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
        }

        .action-btn.cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,107,107,0.4);
        }

        .action-btn.view {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
        }

        .action-btn.view:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26,41,128,0.4);
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
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 2px solid rgba(26,41,128,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .modal-close {
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            transition: all 0.3s;
        }

        .modal-close:hover {
            color: #ff6b6b;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .detail-row {
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .detail-label {
            font-weight: 600;
            color: #1a2980;
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
        }

        .detail-value {
            color: #333;
            font-size: 1rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 0;
        }

        .footer p {
            text-align: center;
            opacity: 0.9;
        }

        .footer i {
            color: #ff6b6b;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .sidebar {
                width: 280px;
                margin: 10px 0 10px 10px;
            }
            
            .main-content {
                margin-left: 300px;
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                margin: 10px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .dashboard-container {
                flex-direction: column;
            }
            
            .nav-links {
                gap: 10px;
            }
            
            .nav-links a {
                padding: 8px 15px;
                font-size: 14px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-buttons {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo $base_path; ?>index.php" class="logo">
                <img src="<?php echo $base_path; ?>images/ABC logo.webp" alt="ABC Hospital Logo" onerror="this.src='https://via.placeholder.com/50x50/1a2980/ffffff?text=ABC';">
                <span class="logo-text">ABC <span>VIRTUAL</span></span>
            </a>
            <div class="nav-links">
                <a href="<?php echo $base_path; ?>index.php">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="#" onclick="logout(event)">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" data-aos="fade-right">
            <div class="sidebar-header">
                <img src="<?php echo $base_path; ?>images/Dr. Kamal Perera.jpg" alt="Doctor Avatar" onerror="this.src='https://via.placeholder.com/100x100/1a2980/ffffff?text=DR';">
                <div class="user-name"><?php echo htmlspecialchars($doctor_name_display); ?></div>
                <div class="user-role"><i class="fas fa-user-md"></i> Doctor</div>
                <div class="user-specialty"><i class="fas fa-stethoscope"></i> <?php echo htmlspecialchars($doctor_info['doctor_specialty'] ?? 'General Medicine'); ?></div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-item active" onclick="showSection('appointments')">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Appointments</span>
                </div>
                <div class="nav-item" onclick="showSection('today')">
                    <i class="fas fa-calendar-day"></i>
                    <span>Today's Schedule</span>
                </div>
                <div class="nav-item" onclick="showSection('pending')">
                    <i class="fas fa-clock"></i>
                    <span>Pending Requests</span>
                </div>
                <div class="nav-item" onclick="showSection('profile')">
                    <i class="fas fa-user-circle"></i>
                    <span>My Profile</span>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Display any session messages -->
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" data-aos="fade-down">
                    <i class="fas fa-check-circle"></i>
                    <?php 
                        echo $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-error" data-aos="fade-down">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php 
                        echo $_SESSION['error_message'];
                        unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Welcome Banner -->
            <div class="welcome-banner" data-aos="fade-up">
                <h1>Welcome back, <?php echo htmlspecialchars($doctor_name_display); ?>! 👨‍⚕️</h1>
                <p>Here's your daily overview and upcoming appointments.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $today_count; ?></div>
                        <div class="stat-label">Today's Appointments</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $pending_count; ?></div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $confirmed_count; ?></div>
                        <div class="stat-label">Confirmed</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $total_patients; ?></div>
                        <div class="stat-label">Total Patients</div>
                    </div>
                </div>
            </div>

            <!-- Appointments Section -->
            <div id="appointmentsSection" style="display: block;">
                <div class="section-header" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="section-title">
                        <i class="fas fa-calendar-check"></i> My Appointments
                    </h2>
                    <div class="filter-buttons">
                        <button class="filter-btn active" onclick="filterAppointments('all')">All</button>
                        <button class="filter-btn" onclick="filterAppointments('today')">Today</button>
                        <button class="filter-btn" onclick="filterAppointments('pending')">Pending</button>
                        <button class="filter-btn" onclick="filterAppointments('confirmed')">Confirmed</button>
                        <button class="filter-btn" onclick="filterAppointments('completed')">Completed</button>
                    </div>
                </div>

                <div class="table-container" data-aos="fade-up" data-aos-delay="300">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTable">
                            <?php if(count($appointments) > 0): ?>
                                <?php foreach($appointments as $apt): ?>
                                <tr class="appointment-row" 
                                    data-date="<?php echo $apt['appointment_date']; ?>" 
                                    data-status="<?php echo $apt['status']; ?>">
                                    <td>
                                        <strong><?php echo htmlspecialchars($apt['patient_name']); ?></strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone"></i> <?php echo htmlspecialchars($apt['patient_phone']); ?>
                                    </td>
                                    <td>
                                        <?php echo date('M d, Y', strtotime($apt['appointment_date'])); ?>
                                    </td>
                                    <td>
                                        <?php echo date('h:i A', strtotime($apt['appointment_time'])); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars(substr($apt['reason'] ?? 'General Checkup', 0, 40)); ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $apt['status']; ?>">
                                            <i class="fas <?php echo $apt['status'] == 'confirmed' ? 'fa-check-circle' : ($apt['status'] == 'pending' ? 'fa-clock' : ($apt['status'] == 'completed' ? 'fa-check-double' : 'fa-times-circle')); ?>"></i>
                                            <?php echo ucfirst($apt['status']); ?>
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <?php if($apt['status'] == 'pending'): ?>
                                        <button class="action-btn confirm" onclick="updateStatus(<?php echo $apt['id']; ?>, 'confirmed')">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                        <?php endif; ?>
                                        
                                        <?php if($apt['status'] == 'confirmed'): ?>
                                        <button class="action-btn complete" onclick="updateStatus(<?php echo $apt['id']; ?>, 'completed')">
                                            <i class="fas fa-check-double"></i> Complete
                                        </button>
                                        <?php endif; ?>
                                        
                                        <?php if($apt['status'] == 'pending' || $apt['status'] == 'confirmed'): ?>
                                        <button class="action-btn cancel" onclick="updateStatus(<?php echo $apt['id']; ?>, 'cancelled')">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <?php endif; ?>
                                        
                                        <button class="action-btn view" onclick='viewDetails(<?php echo safe_json_encode($apt); ?>)'>
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times"></i>
                                            <p>No appointments found</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Today's Schedule Section -->
            <div id="todaySection" style="display: none;">
                <div class="section-header" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="section-title">
                        <i class="fas fa-calendar-day"></i> Today's Schedule
                    </h2>
                </div>

                <div class="table-container" data-aos="fade-up" data-aos-delay="300">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="todayTable">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pending Requests Section -->
            <div id="pendingSection" style="display: none;">
                <div class="section-header" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i> Pending Requests
                    </h2>
                </div>

                <div class="table-container" data-aos="fade-up" data-aos-delay="300">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="pendingTable">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profileSection" style="display: none;">
                <div class="section-header" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="section-title">
                        <i class="fas fa-user-circle"></i> My Profile
                    </h2>
                </div>

                <div class="table-container" data-aos="fade-up" data-aos-delay="300" style="padding: 2rem;">
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-user-md"></i> Doctor Name</div>
                        <div class="detail-value"><strong><?php echo htmlspecialchars($doctor_name_display); ?></strong></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-id-card"></i> Doctor ID</div>
                        <div class="detail-value"><?php echo htmlspecialchars($doctor_id); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="detail-value"><?php echo htmlspecialchars($doctor_info['doctor_email'] ?? 'doctor@abchospital.lk'); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-phone"></i> Phone</div>
                        <div class="detail-value"><?php echo htmlspecialchars($doctor_info['doctor_phone'] ?? '+94 XX XXX XXXX'); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-stethoscope"></i> Specialty</div>
                        <div class="detail-value"><?php echo htmlspecialchars($doctor_info['doctor_specialty'] ?? 'General Medicine'); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-calendar-alt"></i> Total Appointments</div>
                        <div class="detail-value"><?php echo count($appointments); ?> appointments</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label"><i class="fas fa-users"></i> Total Patients</div>
                        <div class="detail-value"><?php echo $total_patients; ?> unique patients</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-medical"></i> Appointment Details</h3>
                <span class="modal-close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Dynamic content -->
            </div>
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
        // Hide preloader immediately when DOM is ready
        (function() {
            var preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
            }
        })();
        
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Appointment data from PHP
        const appointmentsData = <?php echo safe_json_encode($appointments); ?>;
        const todayDate = '<?php echo date('Y-m-d'); ?>';

        // Populate sections function
        function populateSections() {
            var todayTable = document.getElementById('todayTable');
            var pendingTable = document.getElementById('pendingTable');
            
            if (!todayTable || !pendingTable) {
                return;
            }
            
            var todayAppointments = [];
            var pendingAppointments = [];
            
            for (var i = 0; i < appointmentsData.length; i++) {
                var apt = appointmentsData[i];
                if (apt.appointment_date === todayDate && apt.status !== 'cancelled') {
                    todayAppointments.push(apt);
                }
                if (apt.status === 'pending') {
                    pendingAppointments.push(apt);
                }
            }
            
            // Populate today's table
            if (todayAppointments.length > 0) {
                var todayHtml = '';
                for (var i = 0; i < todayAppointments.length; i++) {
                    var apt = todayAppointments[i];
                    todayHtml += '<tr>' +
                        '<td>' + formatTime(apt.appointment_time) + '</td>' +
                        '<td><strong>' + escapeHtml(apt.patient_name) + '</strong></td>' +
                        '<td><i class="fas fa-phone"></i> ' + escapeHtml(apt.patient_phone) + '</td>' +
                        '<td>' + escapeHtml(apt.reason || 'General Checkup') + '</td>' +
                        '<td><span class="status-badge status-' + apt.status + '">' + apt.status + '</span></td>' +
                        '<td>' +
                            (apt.status === 'pending' ? '<button class="action-btn confirm" onclick="updateStatus(' + apt.id + ', \'confirmed\')">Confirm</button>' : '') +
                            (apt.status === 'confirmed' ? '<button class="action-btn complete" onclick="updateStatus(' + apt.id + ', \'completed\')">Complete</button>' : '') +
                            '<button class="action-btn view" onclick="viewDetails(\'' + JSON.stringify(apt).replace(/'/g, "\\'") + '\')">View</button>' +
                        '</td>' +
                        '</tr>';
                }
                todayTable.innerHTML = todayHtml;
            } else {
                todayTable.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar-check"></i><p>No appointments scheduled for today</p></div></td></tr>';
            }
            
            // Populate pending table
            if (pendingAppointments.length > 0) {
                var pendingHtml = '';
                for (var i = 0; i < pendingAppointments.length; i++) {
                    var apt = pendingAppointments[i];
                    pendingHtml += '<tr>' +
                        '<td><strong>' + escapeHtml(apt.patient_name) + '</strong></td>' +
                        '<td><i class="fas fa-phone"></i> ' + escapeHtml(apt.patient_phone) + '</td>' +
                        '<td>' + formatDate(apt.appointment_date) + '</td>' +
                        '<td>' + formatTime(apt.appointment_time) + '</td>' +
                        '<td>' + escapeHtml(apt.reason || 'General Checkup') + '</td>' +
                        '<td>' +
                            '<button class="action-btn confirm" onclick="updateStatus(' + apt.id + ', \'confirmed\')">Confirm</button>' +
                            '<button class="action-btn cancel" onclick="updateStatus(' + apt.id + ', \'cancelled\')">Cancel</button>' +
                            '<button class="action-btn view" onclick="viewDetails(\'' + JSON.stringify(apt).replace(/'/g, "\\'") + '\')">View</button>' +
                        '</td>' +
                        '</tr>';
                }
                pendingTable.innerHTML = pendingHtml;
            } else {
                pendingTable.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="fas fa-check-circle"></i><p>No pending requests</p></div></td></tr>';
            }
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            var d = new Date(dateString);
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
        }

        function formatTime(timeString) {
            if (!timeString) return 'N/A';
            var parts = timeString.split(':');
            var hour = parseInt(parts[0]);
            var minutes = parts[1];
            var ampm = hour >= 12 ? 'PM' : 'AM';
            var hour12 = hour % 12 || 12;
            return hour12 + ':' + minutes + ' ' + ampm;
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function showSection(section) {
            var sections = ['appointmentsSection', 'todaySection', 'pendingSection', 'profileSection'];
            var navItems = document.querySelectorAll('.nav-item');
            
            for (var i = 0; i < sections.length; i++) {
                var element = document.getElementById(sections[i]);
                if (element) element.style.display = 'none';
            }
            
            var sectionToShow = '';
            if (section === 'appointments') sectionToShow = 'appointmentsSection';
            else if (section === 'today') sectionToShow = 'todaySection';
            else if (section === 'pending') sectionToShow = 'pendingSection';
            else if (section === 'profile') sectionToShow = 'profileSection';
            else sectionToShow = 'appointmentsSection';
            
            var element = document.getElementById(sectionToShow);
            if (element) element.style.display = 'block';
            
            for (var i = 0; i < navItems.length; i++) {
                navItems[i].classList.remove('active');
            }
            
            if (section === 'appointments') navItems[0].classList.add('active');
            else if (section === 'today') navItems[1].classList.add('active');
            else if (section === 'pending') navItems[2].classList.add('active');
            else if (section === 'profile') navItems[3].classList.add('active');
        }

        function filterAppointments(filter) {
            var rows = document.querySelectorAll('#appointmentsTable .appointment-row');
            var today = todayDate;
            
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var rowDate = row.getAttribute('data-date');
                var rowStatus = row.getAttribute('data-status');
                
                var show = false;
                if (filter === 'all') show = true;
                else if (filter === 'today') show = (rowDate === today);
                else if (filter === 'pending') show = (rowStatus === 'pending');
                else if (filter === 'confirmed') show = (rowStatus === 'confirmed');
                else if (filter === 'completed') show = (rowStatus === 'completed');
                else show = true;
                
                row.style.display = show ? '' : 'none';
            }
            
            var filterBtns = document.querySelectorAll('.filter-btn');
            for (var i = 0; i < filterBtns.length; i++) {
                filterBtns[i].classList.remove('active');
                if (filterBtns[i].textContent.toLowerCase().includes(filter)) {
                    filterBtns[i].classList.add('active');
                }
            }
        }

        function updateStatus(appointmentId, status) {
            var message = '';
            if (status === 'confirmed') message = 'Confirm this appointment?';
            else if (status === 'completed') message = 'Mark this appointment as completed?';
            else if (status === 'cancelled') message = 'Cancel this appointment?';
            else message = 'Update this appointment?';
            
            if (confirm(message)) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                form.innerHTML = '<input type="hidden" name="appointment_id" value="' + appointmentId + '">' +
                                '<input type="hidden" name="status" value="' + status + '">' +
                                '<input type="hidden" name="update_status" value="1">';
                document.body.appendChild(form);
                form.submit();
            }
        }

        function viewDetails(aptString) {
            try {
                var apt = JSON.parse(aptString);
                var modalBody = document.getElementById('modalBody');
                modalBody.innerHTML = 
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-user"></i> Patient Name</div>' +
                        '<div class="detail-value"><strong>' + escapeHtml(apt.patient_name) + '</strong></div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-phone"></i> Contact Number</div>' +
                        '<div class="detail-value">' + escapeHtml(apt.patient_phone) + '</div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-envelope"></i> Email</div>' +
                        '<div class="detail-value">' + escapeHtml(apt.patient_email || 'N/A') + '</div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-calendar"></i> Appointment Date</div>' +
                        '<div class="detail-value">' + formatDate(apt.appointment_date) + '</div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-clock"></i> Appointment Time</div>' +
                        '<div class="detail-value">' + formatTime(apt.appointment_time) + '</div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-notes-medical"></i> Reason for Visit</div>' +
                        '<div class="detail-value">' + escapeHtml(apt.reason || 'General Checkup') + '</div>' +
                    '</div>' +
                    '<div class="detail-row">' +
                        '<div class="detail-label"><i class="fas fa-info-circle"></i> Status</div>' +
                        '<div class="detail-value"><span class="status-badge status-' + apt.status + '">' + apt.status + '</span></div>' +
                    '</div>';
                document.getElementById('detailsModal').classList.add('active');
            } catch(e) {
                console.error('Error parsing appointment data:', e);
            }
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.remove('active');
        }

        window.onclick = function(event) {
            var modal = document.getElementById('detailsModal');
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        }

        // Fixed logout function - redirects to home page (index.php)
        function logout(event) {
            if (event) event.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '../../index.php';
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            for (var i = 0; i < alerts.length; i++) {
                alerts[i].style.transition = 'opacity 1s';
                alerts[i].style.opacity = '0';
                setTimeout(function(el) {
                    if (el) el.style.display = 'none';
                }, 1000, alerts[i]);
            }
        }, 5000);

        // Call populate sections when page loads
        window.addEventListener('load', function() {
            populateSections();
        });
    </script>
</body>
</html>