<?php
// doctor-profile.php - Main doctor profile page

// Include constants and data
require_once __DIR__ . '/config/constants-doctors.php';
require_once __DIR__ . '/data/doctors.php';

// Get doctor slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Initialize $doctor variable
$doctor = null;

// Find the doctor with matching slug
foreach ($doctors as $doc) {
    if ($doc['slug'] === $slug) {
        $doctor = $doc;
        break;
    }
}

// If doctor not found, redirect to doctors page
if (!$doctor) {
    header('Location: ' . BASE_URL . '/doctors.php');
    exit;
}

// Page specific variables
$pageTitle = $doctor['name'] . ' - Doctor Profile';
$metaDescription = $doctor['bio'];

// Include header and navigation
include __DIR__ . '/includes/header-doctors.php';
include __DIR__ . '/includes/navigation-doctors.php';
?>

<style>
    /* Doctor Profile Page Styles */
    .profile-header {
        position: relative;
        padding: 150px 0 50px;
        color: white;
        overflow: hidden;
        margin-top: 80px;
        min-height: 450px;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%);
        z-index: 1;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-repeat: no-repeat;
        background-position: bottom;
        background-size: cover;
        opacity: 0.1;
        z-index: 2;
    }

    .profile-header[style*="background-image"] {
        background-size: cover !important;
        background-position: center !important;
    }

    .profile-header .container {
        position: relative;
        z-index: 3;
        width: 100%;
    }

    .profile-header-content {
        max-width: 800px;
    }

    .profile-header h1 {
        font-size: 48px;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        font-weight: 700;
    }

    .profile-header .specialty {
        font-size: 22px;
        opacity: 0.95;
        margin-bottom: 15px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        font-weight: 500;
    }

    .profile-header .qualifications {
        font-size: 18px;
        opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        background: rgba(255,255,255,0.2);
        display: inline-block;
        padding: 8px 20px;
        border-radius: 30px;
        backdrop-filter: blur(5px);
    }

    .profile-main {
        padding: 60px 0;
        background: #f8fafc;
    }

    .profile-wrapper {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 40px;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .profile-sidebar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        color: white;
    }

    .profile-image {
        width: 100%;
        height: 300px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 25px;
        border: 5px solid rgba(255,255,255,0.3);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info-item {
        margin-bottom: 20px;
    }

    .profile-info-item h4 {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .profile-info-item p {
        font-size: 18px;
        font-weight: 500;
    }

    .profile-languages {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .profile-languages span {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 25px;
        font-size: 14px;
    }

    .profile-content {
        padding: 40px;
    }

    .profile-section {
        margin-bottom: 30px;
    }

    .profile-section h2 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
        position: relative;
        padding-bottom: 10px;
    }

    .profile-section h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #4f46e5;
    }

    .profile-section p {
        color: #666;
        line-height: 1.8;
        font-size: 16px;
    }

    .profile-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin: 30px 0;
    }

    .profile-stat-card {
        background: #f8fafc;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: all 0.3s;
    }

    .profile-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .profile-stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: #4f46e5;
        margin-bottom: 5px;
    }

    .profile-stat-card .label {
        color: #666;
        font-size: 14px;
    }

    .profile-actions {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }

    .profile-btn-book {
        padding: 15px 40px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .profile-btn-book:hover {
        background: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
    }

    .profile-btn-back {
        padding: 15px 40px;
        background: #f0f0f0;
        color: #333;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .profile-btn-back:hover {
        background: #e0e0e0;
    }

    @media (max-width: 992px) {
        .profile-wrapper {
            grid-template-columns: 1fr;
        }
        
        .profile-sidebar {
            text-align: center;
        }
        
        .profile-image {
            width: 250px;
            margin: 0 auto 25px;
        }
        
        .profile-actions {
            flex-direction: column;
        }
        
        .profile-header h1 {
            font-size: 36px;
        }
        
        .profile-header .specialty {
            font-size: 18px;
        }
        
        .profile-header .qualifications {
            font-size: 16px;
        }
    }
</style>

<!-- Profile Header with Background Image -->
<section class="profile-header" style="background-image: url('images/doctors/<?php echo $doctor['name']; ?>.jpg'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="profile-header-content">
            <h1><?php echo htmlspecialchars($doctor['name']); ?></h1>
            <div class="specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></div>
            <div class="qualifications"><?php echo htmlspecialchars($doctor['qualifications']); ?></div>
        </div>
    </div>
</section>

<!-- Profile Main Content -->
<section class="profile-main">
    <div class="container">
        <div class="profile-wrapper">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-image">
                    <img src="images/doctors/<?php echo $doctor['name']; ?>.jpg" 
                         alt="<?php echo htmlspecialchars($doctor['name']); ?>"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x300/4f46e5/ffffff?text=<?php echo urlencode($doctor['name']); ?>';">
                </div>
                
                <div class="profile-info-item">
                    <h4>Specialization</h4>
                    <p><?php echo htmlspecialchars($doctor['specialty']); ?></p>
                </div>
                
                <div class="profile-info-item">
                    <h4>Experience</h4>
                    <p><?php echo $doctor['experience']; ?>+ Years</p>
                </div>
                
                <div class="profile-info-item">
                    <h4>Patients Treated</h4>
                    <p><?php echo number_format($doctor['patients']); ?>+</p>
                </div>
                
                <div class="profile-info-item">
                    <h4>Satisfaction Rate</h4>
                    <p><?php echo $doctor['satisfaction']; ?>%</p>
                </div>
                
                <div class="profile-info-item">
                    <h4>Languages</h4>
                    <div class="profile-languages">
                        <?php foreach($doctor['languages'] as $lang): ?>
                            <span><?php echo htmlspecialchars($lang); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="profile-content">
                <div class="profile-section">
                    <h2>About Dr. <?php echo htmlspecialchars(str_replace('Dr. ', '', $doctor['name'])); ?></h2>
                    <p><?php echo htmlspecialchars($doctor['bio']); ?></p>
                </div>
                
                <div class="profile-section">
                    <h2>Qualifications & Expertise</h2>
                    <p><?php echo htmlspecialchars($doctor['qualifications']); ?></p>
                    <p>Dr. <?php echo htmlspecialchars(str_replace('Dr. ', '', $doctor['name'])); ?> has over <?php echo $doctor['experience']; ?> years of experience in <?php echo strtolower($doctor['specialty']); ?>, having successfully treated more than <?php echo number_format($doctor['patients']); ?> patients with a <?php echo $doctor['satisfaction']; ?>% satisfaction rate.</p>
                </div>
                
                <div class="profile-stats-grid">
                    <div class="profile-stat-card">
                        <div class="number"><?php echo $doctor['experience']; ?>+</div>
                        <div class="label">Years Experience</div>
                    </div>
                    <div class="profile-stat-card">
                        <div class="number"><?php echo number_format($doctor['patients']); ?>+</div>
                        <div class="label">Happy Patients</div>
                    </div>
                    <div class="profile-stat-card">
                        <div class="number"><?php echo $doctor['satisfaction']; ?>%</div>
                        <div class="label">Satisfaction</div>
                    </div>
                </div>
                
                <div class="profile-actions">
                    <a href="<?php echo BASE_URL; ?>/appointments.php?doctor=<?php echo $doctor['slug']; ?>" class="profile-btn-book">
                        <i class="fas fa-calendar-check"></i> Book Appointment with <?php echo htmlspecialchars(str_replace('Dr. ', '', $doctor['name'])); ?>
                    </a>
                    <a href="<?php echo BASE_URL; ?>/doctors.php" class="profile-btn-back">
                        <i class="fas fa-arrow-left"></i> Back to All Doctors
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include __DIR__ . '/includes/footer-doctors.php';
?>