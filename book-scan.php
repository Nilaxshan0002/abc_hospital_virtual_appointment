<?php
$pageTitle = "Book a Scan - Radiology Department";
$base_url = '/abc_hospital_virtual_appointment';
include 'includes/header-dept.php';
include 'includes/navigation-dept.php';
?>

<style>
:root {
    --primary-green: #059669;
    --secondary-green: #10b981;
    --light-green: #d1fae5;
    --gradient-green: linear-gradient(135deg, #059669, #10b981);
}

body {
    background: #f0f9ff;
    font-family: 'Poppins', sans-serif;
}

.scan-page {
    max-width: 1300px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Hero Section with Image */
.scan-hero {
    position: relative;
    border-radius: 40px;
    overflow: hidden;
    margin-bottom: 50px;
    height: 400px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.6);
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
    color: #f0f0f0;
    text-shadow: 0 1px 5px rgba(0,0,0,0.5);
}

/* Main Booking Container */
.booking-container-modern {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    background: white;
    border-radius: 50px;
    padding: 50px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.1);
    margin-bottom: 60px;
}

/* Scan Types Section with Images */
.scan-types-modern {
    background: #f8fafc;
    border-radius: 40px;
    padding: 35px;
}

.scan-types-modern h2 {
    font-size: 28px;
    color: #0f172a;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.scan-types-modern h2 i {
    color: var(--primary-green);
}

.scan-item-modern {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px;
    background: white;
    border-radius: 25px;
    margin-bottom: 15px;
    transition: all 0.3s;
    border: 2px solid transparent;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.scan-item-modern:hover {
    border-color: var(--primary-green);
    transform: translateX(10px);
    box-shadow: 0 10px 30px rgba(5, 150, 105, 0.15);
}

.scan-item-image {
    width: 70px;
    height: 70px;
    border-radius: 15px;
    object-fit: cover;
}

.scan-item-details {
    flex: 1;
}

.scan-item-details h3 {
    font-size: 18px;
    color: #0f172a;
    margin-bottom: 5px;
}

.scan-item-details p {
    color: #64748b;
    font-size: 13px;
    margin-bottom: 5px;
}

.scan-item-price {
    display: inline-block;
    padding: 4px 12px;
    background: var(--light-green);
    color: var(--primary-green);
    border-radius: 50px;
    font-weight: 600;
    font-size: 13px;
}

/* Booking Form */
.booking-form-modern {
    padding: 20px 0;
}

.booking-form-modern h2 {
    font-size: 32px;
    color: #0f172a;
    margin-bottom: 30px;
    background: var(--gradient-green);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.form-group-modern {
    margin-bottom: 25px;
}

.form-group-modern label {
    display: block;
    margin-bottom: 10px;
    color: #334155;
    font-weight: 500;
    font-size: 15px;
}

.form-group-modern input,
.form-group-modern select,
.form-group-modern textarea {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    font-size: 15px;
    transition: all 0.3s;
    background: white;
}

.form-group-modern input:focus,
.form-group-modern select:focus,
.form-group-modern textarea:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
}

.form-row-modern {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.checkbox-modern {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin: 30px 0;
}

.checkbox-modern input {
    width: 20px;
    height: 20px;
    margin-top: 3px;
    accent-color: var(--primary-green);
}

.checkbox-modern label {
    color: #475569;
    font-size: 14px;
    line-height: 1.5;
}

.btn-submit-modern {
    width: 100%;
    padding: 18px;
    background: var(--gradient-green);
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
}

.btn-submit-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 35px rgba(5, 150, 105, 0.4);
}

/* Info Box */
.info-box-modern {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-radius: 25px;
    padding: 25px;
    margin: 40px 0;
    display: flex;
    align-items: flex-start;
    gap: 20px;
    border-left: 5px solid #3b82f6;
}

.info-box-modern i {
    font-size: 30px;
    color: #3b82f6;
}

.info-box-modern p {
    color: #1e40af;
    font-size: 15px;
    line-height: 1.7;
}

/* Team Section */
.team-section-scan {
    margin: 60px 0;
}

.team-section-scan h2 {
    font-size: 36px;
    color: #0f172a;
    text-align: center;
    margin-bottom: 40px;
}

.team-grid-scan {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.team-card-scan {
    background: white;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.team-card-scan:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);
}

.team-image-scan {
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.team-info-scan {
    padding: 20px;
    text-align: center;
}

.team-info-scan h3 {
    font-size: 20px;
    color: #0f172a;
    margin-bottom: 5px;
}

.team-info-scan p {
    color: var(--primary-green);
    font-weight: 500;
    margin-bottom: 5px;
}

.team-info-scan .experience {
    color: #64748b;
    font-size: 14px;
}

/* FAQ Section */
.faq-section-modern {
    margin: 80px 0;
    background: white;
    border-radius: 50px;
    padding: 60px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.faq-section-modern h2 {
    font-size: 36px;
    color: #0f172a;
    text-align: center;
    margin-bottom: 50px;
}

.faq-grid-modern {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item-modern {
    background: #f8fafc;
    border-radius: 20px;
    margin-bottom: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.faq-question-modern {
    padding: 22px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    background: #f8fafc;
    transition: all 0.3s;
}

.faq-question-modern:hover {
    background: #f1f5f9;
}

.faq-question-modern h3 {
    font-size: 18px;
    color: #0f172a;
    font-weight: 500;
}

.faq-question-modern i {
    color: var(--primary-green);
    transition: transform 0.3s;
}

.faq-item-modern.active .faq-question-modern i {
    transform: rotate(180deg);
}

.faq-answer-modern {
    padding: 0 25px;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s;
    background: white;
}

.faq-item-modern.active .faq-answer-modern {
    padding: 0 25px 25px;
    max-height: 200px;
}

.faq-answer-modern p {
    color: #475569;
    line-height: 1.7;
}

/* Technology Showcase */
.tech-showcase {
    margin: 60px 0;
    text-align: center;
}

.tech-showcase h2 {
    font-size: 32px;
    color: #0f172a;
    margin-bottom: 30px;
}

.tech-images {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.tech-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.tech-image:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 30px rgba(0,0,0,0.15);
}

/* Responsive */
@media (max-width: 968px) {
    .booking-container-modern {
        grid-template-columns: 1fr;
    }
    .hero-content h1 { font-size: 36px; }
    .hero-content p { font-size: 18px; }
    .tech-images { grid-template-columns: 1fr; }
}

@media (max-width: 576px) {
    .form-row-modern {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="scan-page">
    <!-- Hero Section with Image -->
    <div class="scan-hero" data-aos="fade-down">
        <img src="images/MRI Machine.jpg" 
             alt="MRI Machine" 
             class="hero-image">
        <div class="hero-content">
            <h1><i class="fas fa-x-ray"></i> Book Your Diagnostic Scan</h1>
            <p>Advanced imaging technology with expert radiologists</p>
        </div>
    </div>
    
    <!-- Main Booking Container -->
    <div class="booking-container-modern" data-aos="fade-up">
        <!-- Left Side - Scan Types with Images -->
        <div class="scan-types-modern">
            <h2><i class="fas fa-list"></i> Available Scans</h2>
            
            <div class="scan-item-modern">
                <img src="images/MRI Scan.jpg" 
                     alt="MRI Scan" 
                     class="scan-item-image">
                <div class="scan-item-details">
                    <h3>MRI Scan</h3>
                    <p>Magnetic Resonance Imaging</p>
                    <span class="scan-item-price">LKR 25,000</span>
                </div>
            </div>
            
            <div class="scan-item-modern">
                <img src="images/CT Scan.jpg" 
                     alt="CT Scan" 
                     class="scan-item-image">
                <div class="scan-item-details">
                    <h3>CT Scan</h3>
                    <p>Computed Tomography</p>
                    <span class="scan-item-price">LKR 15,000</span>
                </div>
            </div>
            
            <div class="scan-item-modern">
                <img src="images/X-Ray.jpg" 
                     alt="X-Ray" 
                     class="scan-item-image">
                <div class="scan-item-details">
                    <h3>X-Ray</h3>
                    <p>Digital X-Ray Imaging</p>
                    <span class="scan-item-price">LKR 3,500</span>
                </div>
            </div>
            
            <div class="scan-item-modern">
                <img src="images/Ultrasound.jpg" 
                     alt="Ultrasound" 
                     class="scan-item-image">
                <div class="scan-item-details">
                    <h3>Ultrasound</h3>
                    <p>Sonography Imaging</p>
                    <span class="scan-item-price">LKR 5,000</span>
                </div>
            </div>
            
            <div class="scan-item-modern">
                <img src="images/Mammogram.jpg" 
                     alt="Mammogram" 
                     class="scan-item-image">
                <div class="scan-item-details">
                    <h3>Mammogram</h3>
                    <p>Breast Cancer Screening</p>
                    <span class="scan-item-price">LKR 8,000</span>
                </div>
            </div>
            
            <!-- Info Box -->
            <div class="info-box-modern">
                <i class="fas fa-info-circle"></i>
                <p>All scans performed by certified radiologists. Results available within 24 hours. Emergency scans read immediately.</p>
            </div>
        </div>
        
        <!-- Right Side - Booking Form -->
        <div class="booking-form-modern">
            <h2>📋 Book Your Appointment</h2>
            
            <form onsubmit="alert('✅ Thank you! Your scan booking has been received. We will contact you within 30 minutes to confirm.'); this.reset(); return false;">
                <div class="form-group-modern">
                    <label>Full Name *</label>
                    <input type="text" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group-modern">
                    <label>Email Address *</label>
                    <input type="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group-modern">
                    <label>Phone Number *</label>
                    <input type="tel" placeholder="Enter your phone number" required>
                </div>
                
                <div class="form-group-modern">
                    <label>Select Scan Type *</label>
                    <select required>
                        <option value="">Choose a scan type</option>
                        <option value="mri">MRI Scan - LKR 25,000</option>
                        <option value="ct">CT Scan - LKR 15,000</option>
                        <option value="xray">X-Ray - LKR 3,500</option>
                        <option value="ultrasound">Ultrasound - LKR 5,000</option>
                        <option value="mammogram">Mammogram - LKR 8,000</option>
                    </select>
                </div>
                
                <div class="form-row-modern">
                    <div class="form-group-modern">
                        <label>Preferred Date *</label>
                        <input type="date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group-modern">
                        <label>Preferred Time *</label>
                        <select required>
                            <option value="">Select time</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="16:00">4:00 PM</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group-modern">
                    <label>Referring Doctor (Optional)</label>
                    <input type="text" placeholder="Doctor's name if applicable">
                </div>
                
                <div class="form-group-modern">
                    <label>Additional Notes</label>
                    <textarea rows="3" placeholder="Any specific requirements or medical history..."></textarea>
                </div>
                
                <div class="checkbox-modern">
                    <input type="checkbox" id="consent" required>
                    <label for="consent">I confirm that the information provided is accurate and I agree to the terms and conditions *</label>
                </div>
                
                <button type="submit" class="btn-submit-modern">
                    <i class="fas fa-calendar-check"></i> Confirm Booking
                </button>
            </form>
        </div>
    </div>
    
    <!-- Technology Showcase -->
    <div class="tech-showcase" data-aos="fade-up">
        <h2>Our Advanced Technology</h2>
        <div class="tech-images">
            <img src="images/MRI Machine01.jpg" 
                 alt="MRI Machine" 
                 class="tech-image">
            <img src="images/CT Scanner01.jpg" 
                 alt="CT Scanner" 
                 class="tech-image">
            <img src="images/Ultrasound Machine01.webp" 
                 alt="Ultrasound Machine" 
                 class="tech-image">
        </div>
    </div>
    
    <!-- Team Section -->
    <div class="team-section-scan" data-aos="fade-up">
        <h2>Our Radiology Team</h2>
        <div class="team-grid-scan">
            <div class="team-card-scan">
                <img src="images/Dr. Sunil Weerasinghe.jpg" 
                     alt="Dr. Sunil Weerasinghe" 
                     class="team-image-scan">
                <div class="team-info-scan">
                    <h3>Dr. Sunil Weerasinghe</h3>
                    <p>Chief Radiologist</p>
                    <span class="experience">25+ years experience</span>
                </div>
            </div>
            
            <div class="team-card-scan">
                <img src="images/Dr. Kamani Perera.jpg" 
                     alt="Dr. Kamani Perera" 
                     class="team-image-scan">
                <div class="team-info-scan">
                    <h3>Dr. Kamani Perera</h3>
                    <p>MRI Specialist</p>
                    <span class="experience">18+ years experience</span>
                </div>
            </div>
            
            <div class="team-card-scan">
                <img src="images/Dr. Ruwan Silva.jpg" 
                     alt="Dr. Ruwan Silva" 
                     class="team-image-scan">
                <div class="team-info-scan">
                    <h3>Dr. Ruwan Silva</h3>
                    <p>CT Scan Specialist</p>
                    <span class="experience">15+ years experience</span>
                </div>
            </div>
            
            <div class="team-card-scan">
                <img src="images/Dr. Nadeeka Fernando.webp" 
                     alt="Dr. Nadeeka Fernando" 
                     class="team-image-scan">
                <div class="team-info-scan">
                    <h3>Dr. Nadeeka Fernando</h3>
                    <p>Ultrasound Specialist</p>
                    <span class="experience">12+ years experience</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="faq-section-modern" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        
        <div class="faq-grid-modern">
            <div class="faq-item-modern">
                <div class="faq-question-modern" onclick="this.parentElement.classList.toggle('active')">
                    <h3>Do I need a doctor's referral?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer-modern">
                    <p>While you can book directly, most scans require a doctor's referral for medical necessity. We recommend consulting with your doctor first.</p>
                </div>
            </div>
            
            <div class="faq-item-modern">
                <div class="faq-question-modern" onclick="this.parentElement.classList.toggle('active')">
                    <h3>How long for results?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer-modern">
                    <p>Results are typically available within 24 hours. Emergency scans are read immediately.</p>
                </div>
            </div>
            
            <div class="faq-item-modern">
                <div class="faq-question-modern" onclick="this.parentElement.classList.toggle('active')">
                    <h3>Do you accept insurance?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer-modern">
                    <p>Yes, we accept most major health insurance providers. Please bring your insurance card to the appointment.</p>
                </div>
            </div>
            
            <div class="faq-item-modern">
                <div class="faq-question-modern" onclick="this.parentElement.classList.toggle('active')">
                    <h3>Is there any preparation needed?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer-modern">
                    <p>Preparation depends on the scan type. You'll receive specific instructions when you book your appointment.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Back Button -->
    <div style="text-align: center; margin: 40px 0;">
        <a href="<?php echo $base_url; ?>/departments.php" style="display: inline-flex; align-items: center; gap: 10px; padding: 15px 40px; background: white; color: #059669; text-decoration: none; border-radius: 50px; font-weight: 600; border: 2px solid #059669; transition: all 0.3s;">
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