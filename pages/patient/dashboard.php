<?php
session_start();
$base_path = '../../';
$page_title = 'Patient Dashboard - ABC Hospital';

// Include database connection
require_once '../../config/database.php';

// Initialize database
initializeDatabase();

// IMPORTANT FIX: Check for patient login using PROPER session variables
$is_patient_logged_in = false;
$patient_id = null;
$patient_name = '';

// Check for patient session in multiple possible formats
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'patient') {
    $is_patient_logged_in = true;
    
    // Get patient_id from various possible session variables
    if (isset($_SESSION['patient_id'])) {
        $patient_id = $_SESSION['patient_id'];
        $patient_name = $_SESSION['patient_name'] ?? $_SESSION['user_name'] ?? 'Miss. Malini';
    } elseif (isset($_SESSION['user_id'])) {
        $patient_id = $_SESSION['user_id'];
        $patient_name = $_SESSION['user_name'] ?? 'Miss. Malini';
        // Set patient-specific variables for consistency
        $_SESSION['patient_id'] = $patient_id;
        $_SESSION['patient_name'] = $patient_name;
    } else {
        // For test_login.php compatibility
        if (isset($_SESSION['patient_id'])) {
            $patient_id = $_SESSION['patient_id'];
            $patient_name = $_SESSION['patient_name'] ?? 'Miss. Malini';
            $is_patient_logged_in = true;
        }
    }
}

// If not logged in as patient, redirect to login page
if (!$is_patient_logged_in || !$patient_id) {
    // Clear any existing session that might be from other user types
    session_destroy();
    session_start();
    header("Location: ../../login.php?type=patient&error=" . urlencode("Please login as a patient to access this page"));
    exit();
}

// Force name to be the actual patient name from database
// Remove hardcoded "Miss. Malini" - use real database name
if ($patient_name == 'Receptionist 1' || $patient_name == 'Kamal Perera' || $patient_name == 'Reception1' || $patient_name == '' || $patient_name == 'Patient') {
    // Don't force a name - let database name be used
    $patient_name = 'Patient';
}

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get patient details
$patient_info = [];
try {
    $query = "SELECT * FROM patients WHERE id = :patient_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $patient_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // If patient found in database, use that name
    if ($patient_info && isset($patient_info['patient_name']) && !empty($patient_info['patient_name'])) {
        $patient_name = $patient_info['patient_name'];
        $_SESSION['patient_name'] = $patient_name;
        $_SESSION['user_name'] = $patient_name;
    }
} catch(PDOException $e) {
    error_log("Error fetching patient info: " . $e->getMessage());
}

// Get patient's appointments
$appointments = [];
try {
    $query = "SELECT a.*, d.doctor_name, d.doctor_specialty 
              FROM appointments a
              JOIN doctors d ON a.doctor_id = d.doctor_id
              WHERE a.patient_id = :patient_id 
              ORDER BY a.appointment_date DESC, a.appointment_time DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching appointments: " . $e->getMessage());
}

// Get statistics
$upcoming_count = 0;
$completed_count = 0;
$cancelled_count = 0;

try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE patient_id = :patient_id AND appointment_date >= CURDATE() AND status != 'cancelled'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $upcoming_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE patient_id = :patient_id AND status = 'completed'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $completed_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

try {
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE patient_id = :patient_id AND status = 'cancelled'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':patient_id', $patient_id);
    $stmt->execute();
    $cancelled_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {}

// Get all doctors for booking form
$doctors = [];
try {
    $query = "SELECT doctor_id, doctor_name, doctor_specialty, doctor_email, doctor_phone FROM doctors ORDER BY doctor_name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching doctors: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $base_path; ?>images/patient/patient.png">
    
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: #333;
            overflow-x: hidden;
        }

        /* Navbar - Patient Theme */
        .navbar {
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
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

        /* Sidebar - Patient Theme */
        .patient-sidebar {
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
            border-bottom: 2px solid rgba(17,153,142,0.2);
            background: linear-gradient(135deg, rgba(17,153,142,0.1) 0%, rgba(56,239,125,0.1) 100%);
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
            color: #0f5c5c;
        }

        .user-role {
            color: #11998e;
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
            background: rgba(17,153,142,0.1);
            color: #0f5c5c;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(17,153,142,0.3);
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
            border-left: 5px solid #11998e;
        }

        .welcome-card h1 {
            font-size: 1.8rem;
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
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

        .stat-box.primary { border-bottom-color: #0f5c5c; }
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
            color: #0f5c5c;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
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
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17,153,142,0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
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
            color: #0f5c5c;
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
            border-color: #11998e;
            box-shadow: 0 0 0 3px rgba(17,153,142,0.1);
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
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: rgba(17,153,142,0.05);
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-completed { background: #d1ecf1; color: #0c5460; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }

        /* Action Buttons */
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

        .action-btn.cancel {
            background: #dc3545;
            color: white;
        }

        .action-btn.view {
            background: #0f5c5c;
            color: white;
        }

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
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
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
            color: #0f5c5c;
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
            background: linear-gradient(135deg, #0f5c5c 0%, #11998e 100%);
            color: white;
            padding: 1.5rem 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .patient-sidebar {
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
                <a href="../../logout.php" onclick="return confirmLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- Dashboard Wrapper -->
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="patient-sidebar" data-aos="fade-right">
            <div class="sidebar-header">
                <img src="<?php echo $base_path; ?>images/malini.jpg" alt="Patient Avatar" onerror="this.src='https://via.placeholder.com/100x100/0f5c5c/ffffff?text=M';">
                <div class="user-name"><?php echo htmlspecialchars($patient_name); ?></div>
                <div class="user-role"><i class="fas fa-user"></i> Patient</div>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item active" onclick="showSection(event, 'booking')">
                    <i class="fas fa-calendar-plus"></i> Book Appointment
                </div>
                <div class="nav-item" onclick="showSection(event, 'appointments')">
                    <i class="fas fa-calendar-check"></i> My Appointments
                </div>
                <div class="nav-item" onclick="showSection(event, 'profile')">
                    <i class="fas fa-user-circle"></i> My Profile
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

            <!-- Dashboard / Welcome Section -->
            <div id="dashboardSection">
                <div class="welcome-card">
                    <h1>Welcome, <?php echo htmlspecialchars($patient_name); ?>! 👋</h1>
                    <p><?php echo date('l, F j, Y'); ?> | Manage your appointments and health records</p>
                </div>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-box primary" onclick="showSection(event, 'appointments')">
                        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
                        <div class="stat-number"><?php echo $upcoming_count; ?></div>
                        <div class="stat-label">Upcoming Appointments</div>
                    </div>
                    <div class="stat-box success" onclick="showSection(event, 'appointments')">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-number"><?php echo $completed_count; ?></div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-box warning" onclick="showSection(event, 'appointments')">
                        <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-number"><?php echo $cancelled_count; ?></div>
                        <div class="stat-label">Cancelled</div>
                    </div>
                    <div class="stat-box info" onclick="showSection(event, 'booking')">
                        <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
                        <div class="stat-number">Book New</div>
                        <div class="stat-label">Schedule Appointment</div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-clock"></i> Recent Appointments</h2>
                    <button class="btn btn-primary" onclick="showSection(event, 'booking')"><i class="fas fa-plus"></i> Book New</button>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Doctor</th><th>Date</th><th>Time</th><th>Specialty</th><th>Status</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $recent = array_slice($appointments, 0, 5);
                            if(count($recent) > 0): 
                                foreach($recent as $apt): 
                            ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($apt['doctor_name']); ?></strong></td>
                                <td><?php echo date('M d, Y', strtotime($apt['appointment_date'])); ?></td>
                                <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                <td><?php echo htmlspecialchars($apt['doctor_specialty']); ?></td>
                                <td><span class="badge badge-<?php echo $apt['status']; ?>"><?php echo ucfirst($apt['status']); ?></span></td>
                                <td class="action-btns">
                                    <button class="action-btn view" onclick="viewAppointment(<?php echo htmlspecialchars(json_encode($apt)); ?>)"><i class="fas fa-eye"></i></button>
                                    <?php if($apt['status'] == 'pending'): ?>
                                    <button class="action-btn cancel" onclick="cancelAppointment(<?php echo $apt['id']; ?>)"><i class="fas fa-times"></i> Cancel</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="6"><div class="empty-state"><i class="fas fa-calendar-times"></i><p>No appointments found</p></div>NonNull</small></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Booking Section -->
            <div id="bookingSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-calendar-plus"></i> Book New Appointment</h2>
                </div>

                <div class="form-panel" style="display: block;">
                    <form method="POST" action="book-appointment.php" onsubmit="return validateBookingForm()">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Select Doctor *</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">-- Select Doctor --</option>
                                    <?php foreach($doctors as $doctor): ?>
                                        <option value="<?php echo $doctor['doctor_id']; ?>">
                                            <?php echo htmlspecialchars($doctor['doctor_name']); ?> - <?php echo htmlspecialchars($doctor['doctor_specialty']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Appointment Date *</label>
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Appointment Time *</label>
                                <select name="appointment_time" id="appointment_time" class="form-control" required>
                                    <option value="">-- Select Time --</option>
                                    <option value="09:00:00">09:00 AM</option>
                                    <option value="09:30:00">09:30 AM</option>
                                    <option value="10:00:00">10:00 AM</option>
                                    <option value="10:30:00">10:30 AM</option>
                                    <option value="11:00:00">11:00 AM</option>
                                    <option value="11:30:00">11:30 AM</option>
                                    <option value="14:00:00">02:00 PM</option>
                                    <option value="14:30:00">02:30 PM</option>
                                    <option value="15:00:00">03:00 PM</option>
                                    <option value="15:30:00">03:30 PM</option>
                                    <option value="16:00:00">04:00 PM</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Appointment Type</label>
                                <select name="appointment_type" class="form-control">
                                    <option value="general">General Checkup</option>
                                    <option value="followup">Follow-up</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="consultation">Consultation</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Reason for Visit *</label>
                            <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Please describe your symptoms or reason for appointment" required></textarea>
                        </div>
                        <button type="submit" name="book_appointment" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Book Appointment</button>
                    </form>
                </div>
            </div>

            <!-- Appointments List Section -->
            <div id="appointmentsSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-calendar-check"></i> My Appointments</h2>
                    <button class="btn btn-primary" onclick="showSection(event, 'booking')"><i class="fas fa-plus"></i> Book New</button>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th><th>Doctor</th><th>Specialty</th><th>Date</th><th>Time</th><th>Reason</th><th>Status</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($appointments) > 0): ?>
                                <?php foreach($appointments as $apt): ?>
                                <tr>
                                    <td><?php echo $apt['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($apt['doctor_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($apt['doctor_specialty']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($apt['appointment_date'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($apt['appointment_time'])); ?></td>
                                    <td><?php echo htmlspecialchars(substr($apt['reason'] ?? 'General Checkup', 0, 30)); ?>...</small></td>
                                    <td><span class="badge badge-<?php echo $apt['status']; ?>"><?php echo ucfirst($apt['status']); ?></span></td>
                                    <td class="action-btns">
                                        <button class="action-btn view" onclick="viewAppointment(<?php echo htmlspecialchars(json_encode($apt)); ?>)"><i class="fas fa-eye"></i></button>
                                        <?php if($apt['status'] == 'pending'): ?>
                                        <button class="action-btn cancel" onclick="cancelAppointment(<?php echo $apt['id']; ?>)"><i class="fas fa-times"></i> Cancel</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <td><td colspan="8"><div class="empty-state"><i class="fas fa-calendar-times"></i><p>No appointments found</p></div>NonNull</small></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Profile Section -->
            <div id="profileSection" style="display: none;">
                <div class="section-header">
                    <h2 class="section-title"><i class="fas fa-user-circle"></i> My Profile</h2>
                </div>

                <div class="form-panel" style="display: block;">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user"></i> Patient Name</div>
                        <div class="info-value"><strong><?php echo htmlspecialchars($patient_name); ?></strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card"></i> Patient ID</div>
                        <div class="info-value"><?php echo htmlspecialchars($patient_id); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="info-value"><?php echo htmlspecialchars($patient_info['email'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-phone"></i> Phone</div>
                        <div class="info-value"><?php echo htmlspecialchars($patient_info['phone'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-venus-mars"></i> Gender</div>
                        <div class="info-value"><?php echo ucfirst($patient_info['gender'] ?? 'N/A'); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-tint"></i> Blood Group</div>
                        <div class="info-value"><?php echo $patient_info['blood_group'] ?? 'N/A'; ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar-alt"></i> Total Appointments</div>
                        <div class="info-value"><?php echo count($appointments); ?> appointments</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-medical"></i> Appointment Details</h3>
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

        // Show dashboard section by default
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('dashboardSection').style.display = 'block';
            document.getElementById('bookingSection').style.display = 'none';
            document.getElementById('appointmentsSection').style.display = 'none';
            document.getElementById('profileSection').style.display = 'none';
        });

        function showSection(event, section) {
            const sections = ['dashboardSection', 'bookingSection', 'appointmentsSection', 'profileSection'];
            sections.forEach(s => {
                const el = document.getElementById(s);
                if(el) el.style.display = 'none';
            });
            
            if(section === 'dashboard') {
                document.getElementById('dashboardSection').style.display = 'block';
            } else if(section === 'booking') {
                document.getElementById('bookingSection').style.display = 'block';
            } else if(section === 'appointments') {
                document.getElementById('appointmentsSection').style.display = 'block';
            } else if(section === 'profile') {
                document.getElementById('profileSection').style.display = 'block';
            }
            
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            if(event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }
        }

        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }

        function validateBookingForm() {
            const doctor = document.querySelector('select[name="doctor_id"]').value;
            const date = document.querySelector('input[name="appointment_date"]').value;
            const time = document.querySelector('select[name="appointment_time"]').value;
            const reason = document.querySelector('textarea[name="reason"]').value;
            
            if(!doctor) { alert('Please select a doctor'); return false; }
            if(!date) { alert('Please select appointment date'); return false; }
            if(!time) { alert('Please select appointment time'); return false; }
            if(reason.trim() === '') { alert('Please enter reason for visit'); return false; }
            return true;
        }

        function cancelAppointment(id) {
            if(confirm('Are you sure you want to cancel this appointment?')) {
                window.location.href = 'cancel-appointment.php?id=' + id;
            }
        }

        function viewAppointment(apt) {
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="info-row"><div class="info-label">Doctor</div><div class="info-value"><strong>${escapeHtml(apt.doctor_name)}</strong> (${escapeHtml(apt.doctor_specialty)})</div></div>
                <div class="info-row"><div class="info-label">Date & Time</div><div class="info-value">${formatDate(apt.appointment_date)} at ${formatTime(apt.appointment_time)}</div></div>
                <div class="info-row"><div class="info-label">Appointment Type</div><div class="info-value">${escapeHtml(apt.appointment_type || 'General')}</div></div>
                <div class="info-row"><div class="info-label">Reason for Visit</div><div class="info-value">${escapeHtml(apt.reason || 'General Checkup')}</div></div>
                <div class="info-row"><div class="info-label">Status</div><div class="info-value"><span class="badge badge-${apt.status}">${apt.status}</span></div></div>
                <div class="info-row"><div class="info-label">Booked On</div><div class="info-value">${formatDate(apt.created_at || new Date())}</div></div>
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

        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => alert.style.display = 'none', 1000);
            });
        }, 5000);
        
        window.onclick = function(event) {
            const modal = document.getElementById('detailsModal');
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        }
    </script>
</body>
</html>