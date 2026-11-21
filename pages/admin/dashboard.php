<?php
session_start();
$base_path = '../../';
$page_title = 'Admin Dashboard';

// Include database connection
require_once '../../config/database.php';

// Initialize database with sample data if needed
initializeDatabase();

// Handle Doctor Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_doctor'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $doctor_name = trim($_POST['doctor_name']);
        $specialty = trim($_POST['specialty']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');
        
        // Check if email already exists - using doctor_email instead of email
        $check_query = "SELECT doctor_id FROM doctors WHERE doctor_email = :email";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Doctor with this email already exists!";
        } else {
            // Using correct column names based on your database schema
            $query = "INSERT INTO doctors (doctor_name, doctor_specialty, doctor_email, doctor_phone, doctor_password, created_at) 
                      VALUES (:doctor_name, :specialty, :email, :phone, :password, :created_at)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':doctor_name', $doctor_name);
            $stmt->bindParam(':specialty', $specialty);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':created_at', $created_at);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Doctor registered successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to register doctor. Please try again.";
            }
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    // Redirect to refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Receptionist Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_receptionist'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $receptionist_name = trim($_POST['receptionist_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');
        
        // Check if email already exists - using receptionist_email
        $check_query = "SELECT receptionist_id FROM receptionists WHERE receptionist_email = :email";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Receptionist with this email already exists!";
        } else {
            // Using correct column names
            $query = "INSERT INTO receptionists (receptionist_name, receptionist_email, receptionist_phone, receptionist_password, created_at) 
                      VALUES (:receptionist_name, :email, :phone, :password, :created_at)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':receptionist_name', $receptionist_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':created_at', $created_at);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Receptionist registered successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to register receptionist. Please try again.";
            }
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    // Redirect to refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Doctor Deletion
if (isset($_GET['delete_doctor'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $doctor_id = $_GET['delete_doctor'];
        // Using doctor_id instead of id
        $query = "DELETE FROM doctors WHERE doctor_id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $doctor_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Doctor deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete doctor.";
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Receptionist Deletion
if (isset($_GET['delete_receptionist'])) {
    try {
        $database = new Database();
        $db = $database->getConnection();
        
        $receptionist_id = $_GET['delete_receptionist'];
        // Using receptionist_id instead of id
        $query = "DELETE FROM receptionists WHERE receptionist_id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $receptionist_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Receptionist deleted successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to delete receptionist.";
        }
    } catch(Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get statistics
$database = new Database();
$db = $database->getConnection();

// Count doctors - using correct column names
try {
    $query = "SELECT COUNT(*) as count FROM doctors";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $doctors_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $doctors_count = 0;
    error_log("Error counting doctors: " . $e->getMessage());
}

// Count patients
try {
    $query = "SELECT COUNT(*) as count FROM patients";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $patients_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $patients_count = 0;
    error_log("Error counting patients: " . $e->getMessage());
}

// Count appointments today
$today = date('Y-m-d');
try {
    $query = "SELECT COUNT(*) as count FROM appointments WHERE appointment_date = :today";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':today', $today);
    $stmt->execute();
    $today_appointments = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch(PDOException $e) {
    $today_appointments = 0;
    error_log("Error counting appointments: " . $e->getMessage());
}

// Get all doctors - using correct column names
try {
    $query = "SELECT doctor_id as id, doctor_name, doctor_specialty as specialty, doctor_email as email, doctor_phone as phone FROM doctors ORDER BY doctor_name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $doctors = [];
    error_log("Error fetching doctors: " . $e->getMessage());
}

// Get all receptionists - using correct column names
try {
    $query = "SELECT receptionist_id as id, receptionist_name, receptionist_email as email, receptionist_phone as phone FROM receptionists ORDER BY receptionist_name";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $receptionists = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $receptionists = [];
    error_log("Error fetching receptionists: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - ABC Hospital</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/avif" href="<?php echo $base_path; ?>images/admin.avif">
    <link rel="shortcut icon" type="image/avif" href="<?php echo $base_path; ?>images/admin.avif">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
            transition: opacity 0.5s;
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
            width: 80px;
            height: 80px;
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

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .content-header h2 {
            color: #1a2980;
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* Buttons */
        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(26,41,128,0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(17,153,142,0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255,107,107,0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f2994a 0%, #f2c94c 100%);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(242,153,74,0.4);
        }

        /* Form Container */
        .form-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            animation: slideDown 0.5s ease;
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

        .form-container h3 {
            color: #1a2980;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
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
            border-color: #1a2980;
            box-shadow: 0 0 0 3px rgba(26,41,128,0.1);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            animation: fadeInUp 0.6s ease;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            color: #666;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Table Container */
        .table-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow-x: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: fadeInUp 0.6s ease;
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
            transform: scale(1.01);
        }

        .action-btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
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
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
        }

        .footer p {
            text-align: center;
            opacity: 0.9;
        }

        .footer i {
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
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
                <img src="<?php echo $base_path; ?>images/admin/Administrator.jpg" alt="Admin Avatar" onerror="this.src='https://via.placeholder.com/80x80/1a2980/ffffff?text=Admin';">
                <div class="user-name">Administrator</div>
                <div class="user-role"><i class="fas fa-shield-alt"></i> Admin</div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-item active" onclick="showSection('doctors')">
                    <i class="fas fa-user-md"></i>
                    <span>Manage Doctors</span>
                </div>
                <div class="nav-item" onclick="showSection('receptionists')">
                    <i class="fas fa-briefcase"></i>
                    <span>Manage Receptionists</span>
                </div>
                <div class="nav-item" onclick="showSection('stats')">
                    <i class="fas fa-chart-line"></i>
                    <span>Statistics</span>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
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

            <!-- Statistics Section -->
            <div id="statsSection" style="display: none;">
                <div class="content-header" data-aos="fade-down">
                    <h2><i class="fas fa-chart-line"></i> Hospital Statistics</h2>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3>Total Doctors</h3>
                        <div class="stat-number"><?php echo $doctors_count; ?></div>
                    </div>
                    
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Total Patients</h3>
                        <div class="stat-number"><?php echo $patients_count; ?></div>
                    </div>
                    
                    <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <h3>Today's Appointments</h3>
                        <div class="stat-number"><?php echo $today_appointments; ?></div>
                    </div>
                </div>
            </div>

            <!-- Doctors Management Section -->
            <div id="doctorsSection" style="display: block;">
                <div class="content-header" data-aos="fade-down">
                    <h2><i class="fas fa-user-md"></i> Manage Doctors</h2>
                    <button class="btn btn-success" onclick="showDoctorForm()">
                        <i class="fas fa-plus"></i> Register New Doctor
                    </button>
                </div>

                <!-- Doctor Registration Form -->
                <div id="doctorForm" style="display: none;" class="form-container" data-aos="fade-down">
                    <h3><i class="fas fa-user-plus"></i> Register New Doctor</h3>
                    <form method="POST" action="" onsubmit="return validateDoctorForm()">
                        <div class="form-group">
                            <label for="doctor_name">Full Name *</label>
                            <input type="text" id="doctor_name" name="doctor_name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor_specialty">Specialty *</label>
                            <input type="text" id="doctor_specialty" name="specialty" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor_email">Email *</label>
                            <input type="email" id="doctor_email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor_phone">Phone *</label>
                            <input type="tel" id="doctor_phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor_password">Password *</label>
                            <input type="password" id="doctor_password" name="password" class="form-control" required>
                            <small style="color: #666;">Minimum 6 characters</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="register_doctor">
                            <i class="fas fa-save"></i> Register Doctor
                        </button>
                        <button type="button" class="btn btn-danger" onclick="hideDoctorForm()" style="margin-left: 1rem;">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </form>
                </div>

                <!-- Doctors List -->
                <div class="table-container" data-aos="fade-up">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Specialty</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($doctors) > 0): ?>
                                <?php foreach($doctors as $doctor): ?>
                                    <tr>
                                        <td><?php echo $doctor['id']; ?></td>
                                        <td><?php echo htmlspecialchars($doctor['doctor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['specialty']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                                        <td><?php echo htmlspecialchars($doctor['phone']); ?></td>
                                        <td>
                                            <button class="action-btn btn-warning" onclick="editDoctor(<?php echo $doctor['id']; ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="?delete_doctor=<?php echo $doctor['id']; ?>" class="action-btn btn-danger" onclick="return confirmDelete()">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-info-circle" style="font-size: 40px; color: #1a2980; margin-bottom: 10px; display: block;"></i>
                                        No doctors found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Receptionists Management Section -->
            <div id="receptionistsSection" style="display: none;">
                <div class="content-header" data-aos="fade-down">
                    <h2><i class="fas fa-briefcase"></i> Manage Receptionists</h2>
                    <button class="btn btn-success" onclick="showReceptionistForm()">
                        <i class="fas fa-plus"></i> Register New Receptionist
                    </button>
                </div>

                <!-- Receptionist Registration Form -->
                <div id="receptionistForm" style="display: none;" class="form-container" data-aos="fade-down">
                    <h3><i class="fas fa-user-plus"></i> Register New Receptionist</h3>
                    <form method="POST" action="" onsubmit="return validateReceptionistForm()">
                        <div class="form-group">
                            <label for="receptionist_name">Full Name *</label>
                            <input type="text" id="receptionist_name" name="receptionist_name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="receptionist_email">Email *</label>
                            <input type="email" id="receptionist_email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="receptionist_phone">Phone *</label>
                            <input type="tel" id="receptionist_phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="receptionist_password">Password *</label>
                            <input type="password" id="receptionist_password" name="password" class="form-control" required>
                            <small style="color: #666;">Minimum 6 characters</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="register_receptionist">
                            <i class="fas fa-save"></i> Register Receptionist
                        </button>
                        <button type="button" class="btn btn-danger" onclick="hideReceptionistForm()" style="margin-left: 1rem;">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </form>
                </div>

                <!-- Receptionists List -->
                <div class="table-container" data-aos="fade-up">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($receptionists) > 0): ?>
                                <?php foreach($receptionists as $rec): ?>
                                    <tr>
                                        <td><?php echo $rec['id']; ?></td>
                                        <td><?php echo htmlspecialchars($rec['receptionist_name']); ?></td>
                                        <td><?php echo htmlspecialchars($rec['email']); ?></td>
                                        <td><?php echo htmlspecialchars($rec['phone']); ?></td>
                                        <td>
                                            <button class="action-btn btn-warning" onclick="editReceptionist(<?php echo $rec['id']; ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="?delete_receptionist=<?php echo $rec['id']; ?>" class="action-btn btn-danger" onclick="return confirmDelete()">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px;">
                                        <i class="fas fa-info-circle" style="font-size: 40px; color: #1a2980; margin-bottom: 10px; display: block;"></i>
                                        No receptionists found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart"></i> for better healthcare</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this record? This action cannot be undone.');
        }

        function showSection(section) {
            const sections = ['doctorsSection', 'receptionistsSection', 'statsSection'];
            const navItems = document.querySelectorAll('.nav-item');
            
            sections.forEach(s => {
                const element = document.getElementById(s);
                if(element) element.style.display = 'none';
            });
            
            const sectionToShow = document.getElementById(section + 'Section');
            if(sectionToShow) sectionToShow.style.display = 'block';
            
            navItems.forEach((item, index) => {
                if((section === 'doctors' && index === 0) ||
                   (section === 'receptionists' && index === 1) ||
                   (section === 'stats' && index === 2)) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }
        
        function showDoctorForm() {
            const form = document.getElementById('doctorForm');
            if(form) {
                form.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        function hideDoctorForm() {
            const form = document.getElementById('doctorForm');
            if(form) form.style.display = 'none';
        }
        
        function showReceptionistForm() {
            const form = document.getElementById('receptionistForm');
            if(form) {
                form.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        function hideReceptionistForm() {
            const form = document.getElementById('receptionistForm');
            if(form) form.style.display = 'none';
        }
        
        function validateDoctorForm() {
            const name = document.getElementById('doctor_name').value;
            const email = document.getElementById('doctor_email').value;
            const phone = document.getElementById('doctor_phone').value;
            const password = document.getElementById('doctor_password').value;
            
            if(name.trim() === '') {
                alert('Please enter doctor name');
                return false;
            }
            
            if(email.trim() === '') {
                alert('Please enter email');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }
            
            if(phone.trim() === '') {
                alert('Please enter phone number');
                return false;
            }
            
            if(password.length < 6) {
                alert('Password must be at least 6 characters long');
                return false;
            }
            
            return true;
        }
        
        function validateReceptionistForm() {
            const name = document.getElementById('receptionist_name').value;
            const email = document.getElementById('receptionist_email').value;
            const phone = document.getElementById('receptionist_phone').value;
            const password = document.getElementById('receptionist_password').value;
            
            if(name.trim() === '') {
                alert('Please enter receptionist name');
                return false;
            }
            
            if(email.trim() === '') {
                alert('Please enter email');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }
            
            if(phone.trim() === '') {
                alert('Please enter phone number');
                return false;
            }
            
            if(password.length < 6) {
                alert('Password must be at least 6 characters long');
                return false;
            }
            
            return true;
        }
        
        function editDoctor(doctorId) {
            alert('Edit functionality coming soon. Doctor ID: ' + doctorId);
        }
        
        function editReceptionist(receptionistId) {
            alert('Edit functionality coming soon. Receptionist ID: ' + receptionistId);
        }
        
        // Fixed logout function - redirects to home page (index.php)
        function logout(event) {
            if(event) event.preventDefault();
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = '../../index.php';
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 1000);
            });
        }, 5000);
    </script>
</body>
</html>