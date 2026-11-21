<?php
$pageTitle = "Emergency Services - 24/7 Emergency & Trauma Care";
$base_url = '/abc_hospital_virtual_appointment';
include 'includes/header-dept.php';
include 'includes/navigation-dept.php';
?>

<style>
:root {
    --emergency-red: #dc2626;
    --emergency-dark-red: #b91c1c;
    --emergency-light: #fee2e2;
    --emergency-gradient: linear-gradient(135deg, #dc2626, #ef4444);
}

body {
    background: #f9fafb;
    font-family: 'Poppins', sans-serif;
}

.emergency-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Hero Section with Image */
.emergency-hero {
    position: relative;
    border-radius: 30px;
    overflow: hidden;
    margin-bottom: 40px;
    height: 400px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.7);
}

.hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 2;
    width: 80%;
}

.hero-content h1 {
    font-size: 52px;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.5);
}

.hero-content p {
    font-size: 22px;
    opacity: 0.95;
    text-shadow: 0 1px 5px rgba(0,0,0,0.5);
}

/* Emergency Contact Card */
.emergency-contact-card {
    background: white;
    border-radius: 30px;
    padding: 40px;
    margin-bottom: 50px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
    box-shadow: 0 20px 40px rgba(220, 38, 38, 0.15);
    border: 1px solid rgba(220, 38, 38, 0.1);
    transform: translateY(-20px);
    position: relative;
    z-index: 10;
}

.contact-left {
    display: flex;
    align-items: center;
    gap: 25px;
}

.emergency-icon-large {
    width: 90px;
    height: 90px;
    background: var(--emergency-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.emergency-icon-large i {
    font-size: 45px;
    color: white;
}

.contact-text h2 {
    font-size: 28px;
    color: #1a1a2e;
    margin-bottom: 5px;
}

.contact-text p {
    color: #666;
}

.emergency-number-large {
    font-size: 42px;
    font-weight: 700;
    color: var(--emergency-red);
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: 1px;
}

.emergency-number-large i {
    font-size: 35px;
    color: var(--emergency-red);
}

.btn-call-emergency {
    background: var(--emergency-gradient);
    color: white;
    padding: 18px 45px;
    border-radius: 60px;
    text-decoration: none;
    font-weight: 600;
    font-size: 20px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s;
    box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
    border: 2px solid transparent;
}

.btn-call-emergency:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(220, 38, 38, 0.4);
    background: transparent;
    border-color: var(--emergency-red);
    color: var(--emergency-red);
}

.btn-call-emergency:hover i {
    color: var(--emergency-red);
}

/* Services Grid */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.service-card-modern {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.3s;
    border: 1px solid #eef2f6;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.service-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 50px rgba(0,0,0,0.1);
}

.service-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s;
}

.service-card-modern:hover .service-image {
    transform: scale(1.1);
}

.service-content {
    padding: 25px;
}

.service-icon-modern {
    width: 60px;
    height: 60px;
    background: var(--emergency-light);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.service-icon-modern i {
    font-size: 30px;
    color: var(--emergency-red);
}

.service-content h3 {
    font-size: 22px;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.service-content p {
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 15px;
}

.service-features-modern {
    list-style: none;
    padding: 0;
}

.service-features-modern li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    color: #475569;
    font-size: 14px;
}

.service-features-modern li i {
    color: var(--emergency-red);
    font-size: 16px;
}

/* Team Section */
.team-section {
    margin: 60px 0;
}

.team-section h2 {
    font-size: 36px;
    color: #1a1a2e;
    text-align: center;
    margin-bottom: 40px;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.team-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.team-info {
    padding: 20px;
    text-align: center;
}

.team-info h3 {
    font-size: 20px;
    color: #1a1a2e;
    margin-bottom: 5px;
}

.team-info p {
    color: var(--emergency-red);
    font-weight: 500;
    margin-bottom: 5px;
}

.team-info .experience {
    color: #666;
    font-size: 14px;
}

/* Stats Section */
.emergency-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin: 60px 0;
}

.stat-item-modern {
    background: white;
    padding: 30px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    border: 1px solid #eef2f6;
}

.stat-number-modern {
    font-size: 42px;
    font-weight: 700;
    color: var(--emergency-red);
    margin-bottom: 10px;
}

.stat-label-modern {
    color: #64748b;
    font-size: 16px;
    font-weight: 500;
}

/* Facilities Section */
.facilities-section {
    margin: 60px 0;
    background: white;
    border-radius: 30px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.facilities-section h2 {
    font-size: 32px;
    color: #1a1a2e;
    margin-bottom: 30px;
}

.facilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.facility-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 15px;
    transition: all 0.3s;
}

.facility-item:hover {
    background: var(--emergency-light);
    transform: translateX(10px);
}

.facility-item i {
    font-size: 30px;
    color: var(--emergency-red);
}

.facility-item h4 {
    font-size: 18px;
    color: #1a1a2e;
    margin-bottom: 5px;
}

.facility-item p {
    color: #64748b;
    font-size: 14px;
}

/* Back Button */
.back-button-modern {
    text-align: center;
    margin: 50px 0 20px;
}

.btn-back-modern {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 40px;
    background: white;
    color: var(--emergency-red);
    text-decoration: none;
    border-radius: 60px;
    font-weight: 600;
    border: 2px solid var(--emergency-red);
    transition: all 0.3s;
}

.btn-back-modern:hover {
    background: var(--emergency-red);
    color: white;
    transform: translateX(-5px);
}

@media (max-width: 768px) {
    .hero-content h1 { font-size: 36px; }
    .hero-content p { font-size: 18px; }
    .emergency-contact-card { flex-direction: column; text-align: center; }
    .contact-left { flex-direction: column; }
    .emergency-stats { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="emergency-page">
    <!-- Hero Section with Image -->
    <div class="emergency-hero" data-aos="fade-down">
        <img src="images/Emergency Room.jpg" 
             alt="Emergency Room" 
             class="hero-image">
        <div class="hero-content">
            <h1><i class="fas fa-ambulance"></i> 24/7 Emergency & Trauma Care</h1>
            <p>When every second counts, we're here for you around the clock</p>
        </div>
    </div>
    
    <!-- Emergency Contact Card -->
    <div class="emergency-contact-card" data-aos="fade-up">
        <div class="contact-left">
            <div class="emergency-icon-large">
                <i class="fas fa-phone-alt"></i>
            </div>
            <div class="contact-text">
                <h2>Emergency Hotline</h2>
                <p>Available 24/7 for immediate assistance</p>
            </div>
        </div>
        <div class="emergency-number-large">
            <i class="fas fa-phone"></i> +94 11 234 5679
        </div>
        <a href="tel:+94112345679" class="btn-call-emergency">
            <i class="fas fa-phone"></i> Call Now
        </a>
    </div>
    
    <!-- Services Grid with Images -->
    <h2 style="font-size: 32px; color: #1a1a2e; margin-bottom: 30px;" data-aos="fade-right">Our Emergency Services</h2>
    
    <div class="services-grid">
        <!-- Trauma Care -->
        <div class="service-card-modern" data-aos="fade-up">
            <img src="images/Trauma Care.jpg" 
                 alt="Trauma Care" 
                 class="service-image">
            <div class="service-content">
                <div class="service-icon-modern">
                    <i class="fas fa-user-injured"></i>
                </div>
                <h3>🚨 Trauma Care</h3>
                <p>Advanced trauma life support with specialized team available 24/7</p>
                <ul class="service-features-modern">
                    <li><i class="fas fa-check-circle"></i> Level 1 Trauma Center</li>
                    <li><i class="fas fa-check-circle"></i> Specialized Trauma Surgeons</li>
                    <li><i class="fas fa-check-circle"></i> Advanced Life Support</li>
                </ul>
            </div>
        </div>
        
        <!-- Cardiac Emergency -->
        <div class="service-card-modern" data-aos="fade-up" data-aos-delay="100">
            <img src="images/Cardiac Care.jpg" 
                 alt="Cardiac Care" 
                 class="service-image">
            <div class="service-content">
                <div class="service-icon-modern">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>❤️ Cardiac Emergency</h3>
                <p>Immediate response for heart attacks and cardiac emergencies</p>
                <ul class="service-features-modern">
                    <li><i class="fas fa-check-circle"></i> 24/7 Cath Lab</li>
                    <li><i class="fas fa-check-circle"></i> Cardiac Team on Standby</li>
                    <li><i class="fas fa-check-circle"></i> ECG & Monitoring</li>
                </ul>
            </div>
        </div>
        
        <!-- Stroke Unit -->
        <div class="service-card-modern" data-aos="fade-up" data-aos-delay="200">
            <img src="images/Stroke Unit.jpg" 
                 alt="Stroke Unit" 
                 class="service-image">
            <div class="service-content">
                <div class="service-icon-modern">
                    <i class="fas fa-brain"></i>
                </div>
                <h3>🧠 Stroke Unit</h3>
                <p>Rapid stroke assessment and treatment to minimize brain damage</p>
                <ul class="service-features-modern">
                    <li><i class="fas fa-check-circle"></i> CT/MRI Available 24/7</li>
                    <li><i class="fas fa-check-circle"></i> Neurologist on Call</li>
                    <li><i class="fas fa-check-circle"></i> Thrombolysis Therapy</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Team Section -->
    <div class="team-section">
        <h2 data-aos="fade-up">Emergency Team</h2>
        <div class="team-grid">
            <div class="team-card" data-aos="fade-up">
                <img src="images/Dr. Kamal Perera.jpg" 
                     alt="Dr. Kamal Perera" 
                     class="team-image">
                <div class="team-info">
                    <h3>Dr. Kamal Perera</h3>
                    <p>Chief Emergency Physician</p>
                    <span class="experience">20+ years experience</span>
                </div>
            </div>
            
            <div class="team-card" data-aos="fade-up" data-aos-delay="100">
                <img src="images/Dr. Priyani Silva.jpg" 
                     alt="Dr. Priyani Silva" 
                     class="team-image">
                <div class="team-info">
                    <h3>Dr. Priyani Silva</h3>
                    <p>Trauma Specialist</p>
                    <span class="experience">15+ years experience</span>
                </div>
            </div>
            
            <div class="team-card" data-aos="fade-up" data-aos-delay="200">
                <img src="images/Dr. Nuwan Fernando.jpg" 
                     alt="Dr. Nuwan Fernando" 
                     class="team-image">
                <div class="team-info">
                    <h3>Dr. Nuwan Fernando</h3>
                    <p>Emergency Surgeon</p>
                    <span class="experience">12+ years experience</span>
                </div>
            </div>
            
            <div class="team-card" data-aos="fade-up" data-aos-delay="300">
                <img src="images/Dr. Malini Dissanayake.jpg" 
                     alt="Dr. Malini Dissanayake" 
                     class="team-image">
                <div class="team-info">
                    <h3>Dr. Malini Dissanayake</h3>
                    <p>Pediatric Emergency Specialist</p>
                    <span class="experience">18+ years experience</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Facilities Section -->
    <div class="facilities-section" data-aos="fade-up">
        <h2>Our Facilities</h2>
        <div class="facilities-grid">
            <div class="facility-item">
                <i class="fas fa-ambulance"></i>
                <div>
                    <h4>Ambulance Service</h4>
                    <p>5 Advanced Life Support Ambulances</p>
                </div>
            </div>
            
            <div class="facility-item">
                <i class="fas fa-procedures"></i>
                <div>
                    <h4>Trauma Beds</h4>
                    <p>30+ Dedicated Trauma Beds</p>
                </div>
            </div>
            
            <div class="facility-item">
                <i class="fas fa-x-ray"></i>
                <div>
                    <h4>Emergency Imaging</h4>
                    <p>24/7 CT, MRI & X-Ray</p>
                </div>
            </div>
            
            <div class="facility-item">
                <i class="fas fa-syringe"></i>
                <div>
                    <h4>Emergency Pharmacy</h4>
                    <p>24/7 Fully Stocked Pharmacy</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics -->
    <div class="emergency-stats">
        <div class="stat-item-modern" data-aos="zoom-in">
            <div class="stat-number-modern">15+</div>
            <div class="stat-label-modern">Emergency Physicians</div>
        </div>
        <div class="stat-item-modern" data-aos="zoom-in" data-aos-delay="100">
            <div class="stat-number-modern">30+</div>
            <div class="stat-label-modern">Trauma Beds</div>
        </div>
        <div class="stat-item-modern" data-aos="zoom-in" data-aos-delay="200">
            <div class="stat-number-modern">24/7</div>
            <div class="stat-label-modern">Ambulance Service</div>
        </div>
        <div class="stat-item-modern" data-aos="zoom-in" data-aos-delay="300">
            <div class="stat-number-modern">5</div>
            <div class="stat-label-modern">Trauma Teams</div>
        </div>
    </div>
    
    <!-- Back Button -->
    <div class="back-button-modern">
        <a href="<?php echo $base_url; ?>/departments.php" class="btn-back-modern">
            <i class="fas fa-arrow-left"></i> Back to Departments
        </a>
    </div>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

<?php include 'includes/footer-dept.php'; ?>