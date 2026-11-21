<?php
// includes/doctor-card.php
// Expects $doctor array and $delay to be available

// Make sure BASE_URL is defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/abc_hospital_virtual_appointment');
}

// Get the doctor's name and create filename (remove any extra spaces)
$doctor_name = trim($doctor['name']);
$image_filename = $doctor_name . '.jpg';

// For debugging - display the actual path being used (visible in page source)
echo "<!-- Loading image for: " . $doctor_name . " -->";
echo "<!-- Image path: images/doctors/" . $image_filename . " -->";
?>
<div class="doctor-profile-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
    <div class="doctor-image">
        <!-- Simple image path -->
        <img src="images/doctors/<?php echo $image_filename; ?>" 
             alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
             loading="lazy"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/300x250/4f46e5/ffffff?text=<?php echo urlencode($doctor['name']); ?>';">
        
        <div class="doctor-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
    <div class="doctor-info">
        <h3><?php echo htmlspecialchars($doctor['name']); ?></h3>
        <div class="doctor-specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></div>
        <div class="doctor-qualifications"><?php echo htmlspecialchars($doctor['qualifications']); ?></div>
        
        <div class="doctor-stats">
            <div class="stat">
                <div class="stat-value"><?php echo $doctor['experience']; ?>+</div>
                <div class="stat-label">Years Exp</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo number_format($doctor['patients']); ?>+</div>
                <div class="stat-label">Patients</div>
            </div>
            <div class="stat">
                <div class="stat-value"><?php echo $doctor['satisfaction']; ?>%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
        
        <div class="doctor-languages">
            <?php foreach($doctor['languages'] as $lang): ?>
                <span class="language-badge"><?php echo htmlspecialchars($lang); ?></span>
            <?php endforeach; ?>
        </div>
        
        <div class="doctor-actions">
            <a href="<?php echo BASE_URL; ?>/appointments.php?doctor=<?php echo $doctor['slug']; ?>" class="btn-book">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </a>
            <a href="<?php echo BASE_URL; ?>/doctor-profile.php?slug=<?php echo $doctor['slug']; ?>" class="btn-profile">
                <i class="fas fa-user-md"></i> View Profile
            </a>
        </div>
    </div>
</div>