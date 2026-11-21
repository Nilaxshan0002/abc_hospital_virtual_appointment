<?php
$pageTitle = "Our Medical Departments - ABC Virtual Healthcare";
$base_url = '/abc_hospital_virtual_appointment';
include 'includes/header-dept.php';
include 'includes/navigation-dept.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 data-aos="fade-up">Our Medical Departments</h1>
        <p data-aos="fade-up" data-aos-delay="100">Comprehensive healthcare services across 30+ specialized departments</p>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="search-wrapper" data-aos="fade-up">
            <div class="search-box">
                <input type="text" id="departmentSearch" placeholder="Search departments by name, specialty, or doctor...">
                <button><i class="fas fa-search"></i> Search</button>
            </div>
        </div>
    </div>
</section>

<!-- Departments Section -->
<section class="departments-section">
    <div class="container">
        <!-- Category Filter -->
        <div class="department-categories" data-aos="fade-up">
            <button class="category-btn active" onclick="filterDepartments('all', event)">All Departments</button>
            <button class="category-btn" onclick="filterDepartments('clinical', event)">Clinical</button>
            <button class="category-btn" onclick="filterDepartments('surgical', event)">Surgical</button>
            <button class="category-btn" onclick="filterDepartments('diagnostic', event)">Diagnostic</button>
            <button class="category-btn" onclick="filterDepartments('emergency', event)">Emergency</button>
        </div>

        <!-- Departments Grid -->
        <div class="departments-grid" id="departmentsGrid">
            <!-- Cardiology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>Cardiology</h3>
                    <p>Heart & Vascular Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>12+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>50+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Emergency Care</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Kamal Perera</span>
                            <span class="doctor-tag">Dr. Nimal Silva</span>
                            <span class="doctor-tag">Dr. Sunil Weerasinghe</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=cardiology" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Neurology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="100">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Neurology</h3>
                    <p>Brain & Nervous System</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>8+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>30+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Stroke Unit</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Priyani Silva</span>
                            <span class="doctor-tag">Dr. Ranjith Perera</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=neurology" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Orthopedics -->
            <div class="department-card" data-category="surgical" data-aos="fade-up" data-aos-delay="200">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-bone"></i>
                    </div>
                    <h3>Orthopedics</h3>
                    <p>Bone & Joint Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>10+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>45+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Trauma Care</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Nuwan Fernando</span>
                            <span class="doctor-tag">Dr. Anura Bandara</span>
                            <span class="doctor-tag">Dr. Champa De Silva</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=orthopedics" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Pediatrics -->
            <div class="department-card" data-category="clinical" data-aos="fade-up">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Pediatrics</h3>
                    <p>Child Healthcare</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>15+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>60+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Pediatric Emergency</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Malini Dissanayake</span>
                            <span class="doctor-tag">Dr. Kumar Jayasinghe</span>
                            <span class="doctor-tag">Dr. Sriyani Perera</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=pediatrics" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Dermatology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="100">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-allergies"></i>
                    </div>
                    <h3>Dermatology</h3>
                    <p>Skin & Hair Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>6+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Sat: 9AM - 5PM</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Sanjay Rathnayake</span>
                            <span class="doctor-tag">Dr. Nadeeka Fernando</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=dermatology" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- General Medicine -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="200">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3>General Medicine</h3>
                    <p>Internal Medicine</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>20+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>100+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Service</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Thusitha Jayawardena</span>
                            <span class="doctor-tag">Dr. Shantha Perera</span>
                            <span class="doctor-tag">Dr. Deepal Silva</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=general" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Oncology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-ribbon"></i>
                    </div>
                    <h3>Oncology</h3>
                    <p>Cancer Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>9+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>40+ Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Chemotherapy</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Harsha Wickramasinghe</span>
                            <span class="doctor-tag">Dr. Kumari Jayawardena</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=oncology" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Emergency Medicine -->
            <div class="department-card" data-category="emergency" data-aos="fade-up" data-aos-delay="100">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <h3>Emergency Medicine</h3>
                    <p>24/7 Emergency & Trauma Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>15+ Emergency Physicians</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-procedures"></i>
                        <span>30+ Trauma Beds</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>+94 11 234 5679</span>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/emergency.php" class="btn-department">Emergency Info</a>
                </div>
            </div>

            <!-- Radiology -->
            <div class="department-card" data-category="diagnostic" data-aos="fade-up" data-aos-delay="200">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-x-ray"></i>
                    </div>
                    <h3>Radiology</h3>
                    <p>Diagnostic Imaging</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>8+ Radiologists</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>24/7 Emergency Scans</span>
                    </div>
                    
                    <div class="department-info" style="margin-top: 15px;">
                        <strong>Services:</strong>
                        <div class="doctor-mini-list" style="margin-top: 10px;">
                            <span class="doctor-tag">MRI</span>
                            <span class="doctor-tag">CT Scan</span>
                            <span class="doctor-tag">X-Ray</span>
                            <span class="doctor-tag">Ultrasound</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/book-scan.php" class="btn-department">Book a Scan</a>
                </div>
            </div>

            <!-- Ophthalmology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="250">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Ophthalmology</h3>
                    <p>Eye Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>7+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Sat: 8AM - 6PM</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Anura Wijesinghe</span>
                            <span class="doctor-tag">Dr. Kamani Perera</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=ophthalmology" class="btn-department">View Doctors</a>
                </div>
            </div>

            <!-- Dentistry -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="300">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-tooth"></i>
                    </div>
                    <h3>Dentistry</h3>
                    <p>Dental Care</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>5+ Dental Surgeons</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Sat: 9AM - 7PM</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Ruwan Silva</span>
                            <span class="doctor-tag">Dr. Nimali Fernando</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=dentistry" class="btn-department">View Doctors</a>
                </div>
            </div>
            
            <!-- Gastroenterology -->
            <div class="department-card" data-category="clinical" data-aos="fade-up" data-aos-delay="350">
                <div class="department-header">
                    <div class="department-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3>Gastroenterology</h3>
                    <p>Digestive Health</p>
                </div>
                <div class="department-body">
                    <div class="info-item">
                        <i class="fas fa-user-md"></i>
                        <span>6+ Specialist Doctors</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>Mon-Sat: 8AM - 5PM</span>
                    </div>
                    
                    <div class="department-doctors">
                        <strong>Key Specialists:</strong>
                        <div class="doctor-mini-list">
                            <span class="doctor-tag">Dr. Mahesh Gunasekara</span>
                            <span class="doctor-tag">Dr. Champa Wickrama</span>
                        </div>
                    </div>
                    
                    <a href="<?php echo $base_url; ?>/doctors.php?specialty=gastroenterology" class="btn-department">View Doctors</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card" data-aos="fade-up">
                <div class="number stat-number" data-count="30">0</div>
                <div class="label">Medical Departments</div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="number stat-number" data-count="150">0</div>
                <div class="label">Expert Doctors</div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="number stat-number" data-count="500">0</div>
                <div class="label">Hospital Beds</div>
            </div>
            <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="number stat-number" data-count="24">0</div>
                <div class="label">Emergency Service</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 data-aos="fade-up">Need Expert Medical Care?</h2>
        <p data-aos="fade-up" data-aos-delay="100">Book an appointment with our specialist doctors today</p>
        <div class="cta-buttons" data-aos="fade-up" data-aos-delay="200">
            <a href="<?php echo $base_url; ?>/appointments.php" class="cta-btn cta-btn-primary">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </a>
            <a href="<?php echo $base_url; ?>/doctors.php" class="cta-btn cta-btn-outline">
                <i class="fas fa-user-md"></i> Find a Doctor
            </a>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="quick-links">
    <div class="container">
        <div class="quick-links-grid">
            <a href="<?php echo $base_url; ?>/appointments.php">
                <i class="fas fa-calendar-alt"></i>
                <span>Book Appointment</span>
            </a>
            <a href="<?php echo $base_url; ?>/doctors.php">
                <i class="fas fa-user-md"></i>
                <span>Find a Doctor</span>
            </a>
            <a href="<?php echo $base_url; ?>/contact.php">
                <i class="fas fa-phone-alt"></i>
                <span>Contact Us</span>
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer-dept.php'; ?>