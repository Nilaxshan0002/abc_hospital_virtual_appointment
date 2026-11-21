<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/abc_hospital_virtual_appointment';
$pageTitle = "ABC Virtual Healthcare | Privacy Policy";
$metaDescription = "ABC Hospital's comprehensive privacy policy";
$metaKeywords = "privacy policy, data protection, healthcare privacy";
$pageCSS = "privacy-policy";
$pageJS = "privacy-policy";

include_once 'includes/header02.php';
?>

<!-- Page Header with SVG Pattern (matching terms-of-use.php) -->
<header class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0 80px; position: relative; overflow: hidden;">
    <!-- SVG Pattern Overlay -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\' opacity=\'0.1\'><path d=\'M40 50 L80 30 L120 50 L160 30 L180 50\' stroke=\'white\' fill=\'none\' stroke-width=\'3\'/><circle cx=\'80\' cy=\'120\' r=\'12\' fill=\'white\'/><circle cx=\'140\' cy=\'150\' r=\'20\' fill=\'white\'/></svg>'); background-size: 400px; pointer-events: none; z-index: 1;"></div>
    
    <!-- Header Image -->
    <img class="header-image" src="images/privacy-shield.webp" alt="Privacy" onerror="this.style.display='none'" style="position: absolute; right: 5%; bottom: 0; width: 300px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3)); animation: float 6s ease-in-out infinite; z-index: 2;">
    
    <div class="container" style="position: relative; z-index: 3;">
        <!-- Breadcrumb -->
        <div class="breadcrumb" style="display: inline-flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); padding: 15px 30px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.3); margin-bottom: 30px;">
            <a href="<?php echo $base_url; ?>/index.php" style="color: white; text-decoration: none; transition: all 0.3s;"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right" style="color: white;"></i>
            <span style="color: white;">Privacy Policy</span>
        </div>
        
        <!-- Title -->
        <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 20px; line-height: 1.2; color: white;">
            <i class="fas fa-shield-halved" style="background: rgba(255,255,255,0.15); padding: 15px 25px; border-radius: 60px; margin-right: 20px; backdrop-filter: blur(5px);"></i> 
            Your Privacy,<br>Our Promise
        </h1>
        
        <!-- Tagline -->
        <p class="header-tagline" style="font-size: 1.3rem; opacity: 0.95; max-width: 700px; margin-bottom: 30px; color: white;">
            Enterprise-grade security meets compassionate care.
        </p>
    </div>
</header>

<style>
/* Animation for header image */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* Responsive */
@media (max-width: 900px) {
    .header-image { 
        opacity: 0.2; 
        right: -20px; 
    }
}

/* Breadcrumb hover effect */
.breadcrumb a:hover {
    color: #ffd700 !important;
}
</style>

<!-- Main Content -->
<div class="container">
    <div class="content-card">
        <div class="last-updated">
            <i class="fas fa-calendar-check"></i> 
            Last Updated: 22 February 2026
        </div>

        <!-- Trust Grid -->
        <div class="trust-grid">
            <div class="trust-item"><i class="fas fa-lock"></i><h4>256-bit Encryption</h4><p>Bank-grade security</p></div>
            <div class="trust-item"><i class="fas fa-eye-slash"></i><h4>Zero Tracking</h4><p>We never sell your data</p></div>
            <div class="trust-item"><i class="fas fa-globe"></i><h4>Global Compliance</h4><p>GDPR, HIPAA, PDPA</p></div>
            <div class="trust-item"><i class="fas fa-shield-check"></i><h4>ISO 27001 Certified</h4><p>International standards</p></div>
        </div>

        <!-- TOC -->
        <div class="toc">
            <h3><i class="fas fa-list-ul"></i> On This Page</h3>
            <div class="toc-grid">
                <div class="toc-item"><a href="#intro">1. Introduction</a></div>
                <div class="toc-item"><a href="#collect">2. Information Collection</a></div>
                <div class="toc-item"><a href="#use">3. How We Use Data</a></div>
                <div class="toc-item"><a href="#rights">4. Your Rights</a></div>
                <div class="toc-item"><a href="#contact">5. Contact Us</a></div>
            </div>
        </div>

        <!-- Introduction -->
        <h2 id="intro"><i class="fas fa-hospital"></i> 1. Introduction</h2>
        <p>ABC Virtual Healthcare is committed to protecting your privacy. This policy explains how we collect, use, and protect your information.</p>

        <!-- Information Collection -->
        <h2 id="collect"><i class="fas fa-layer-group"></i> 2. Information We Collect</h2>
        <table class="data-table">
            <tr><th>Category</th><th>Data Points</th></tr>
            <tr><td>Identity</td><td>Name, NIC, DOB, Gender</td></tr>
            <tr><td>Contact</td><td>Email, Phone, Address</td></tr>
            <tr><td>Medical</td><td>History, Allergies, Medications</td></tr>
            <tr><td>Technical</td><td>IP Address, Device Info</td></tr>
        </table>

        <!-- How We Use -->
        <h2 id="use"><i class="fas fa-file-lines"></i> 3. How We Use Your Information</h2>
        <ul>
            <li><i class="fas fa-check-circle"></i> Healthcare delivery and consultations</li>
            <li><i class="fas fa-check-circle"></i> Appointment reminders and communications</li>
            <li><i class="fas fa-check-circle"></i> Billing and payments processing</li>
            <li><i class="fas fa-check-circle"></i> Quality improvement and research</li>
        </ul>

        <!-- Your Rights with Enhanced Boxes -->
        <h2 id="rights"><i class="fas fa-user-check"></i> 4. Your Privacy Rights</h2>
        <p class="section-intro">Under the Sri Lanka Personal Data Protection Act No. 9 of 2022, you have the following rights regarding your personal data:</p>
        
        <div class="rights-grid">
            <!-- Right to Access Box -->
            <a href="<?php echo $base_url; ?>/right-to-access.php" class="rights-card">
                <div class="rights-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h4>Right to Access</h4>
                <p class="rights-description">Request a copy of your personal data</p>
                
                <div class="rights-details">
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>View your complete medical records</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Check what personal data we hold</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Know who accessed your information</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Get copies of prescriptions and reports</span>
                    </div>
                </div>
                
                <div class="rights-footer">
                    <span class="btn-small">Learn More <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <!-- Right to Rectification Box -->
            <a href="<?php echo $base_url; ?>/right-to-rectification.php" class="rights-card">
                <div class="rights-icon">
                    <i class="fas fa-pen"></i>
                </div>
                <h4>Right to Rectification</h4>
                <p class="rights-description">Correct inaccurate or incomplete information</p>
                
                <div class="rights-details">
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Update your contact details and address</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Fix incorrect medical information</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Complete any missing personal data</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Correct name after marriage/legal change</span>
                    </div>
                </div>
                
                <div class="rights-footer">
                    <span class="btn-small">Learn More <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <!-- Right to Erasure Box -->
            <a href="<?php echo $base_url; ?>/right-to-erasure.php" class="rights-card">
                <div class="rights-icon">
                    <i class="fas fa-trash"></i>
                </div>
                <h4>Right to Erasure</h4>
                <p class="rights-description">Request deletion of your data</p>
                
                <div class="rights-details">
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Delete your patient account permanently</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Remove personal information from our systems</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Withdraw consent for data processing</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i>
                        <span>Medical records kept for 10 years (legal requirement)</span>
                    </div>
                </div>
                
                <div class="rights-footer">
                    <span class="btn-small">Learn More <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <!-- Right to Portability Box -->
            <a href="<?php echo $base_url; ?>/right-to-portability.php" class="rights-card">
                <div class="rights-icon">
                    <i class="fas fa-download"></i>
                </div>
                <h4>Right to Portability</h4>
                <p class="rights-description">Receive your data in a portable format</p>
                
                <div class="rights-details">
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Download your data as PDF, CSV, or JSON</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Transfer your records to another healthcare provider</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Get machine-readable format for analysis</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Receive structured, commonly used format</span>
                    </div>
                </div>
                
                <div class="rights-footer">
                    <span class="btn-small">Learn More <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>

        <!-- Enhanced Contact Section -->
        <h2 id="contact"><i class="fas fa-phone-alt"></i> 5. Contact Our Data Protection Team</h2>
        
        <div class="contact-enhanced">
            <div class="contact-header">
                <i class="fas fa-shield-alt"></i>
                <h3>We're Here to Help</h3>
                <p>For any privacy-related questions or requests, contact our Data Protection Officer</p>
            </div>
            
            <div class="contact-details-grid">
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <h4>Email</h4>
                    <p class="contact-primary"><a href="mailto:dpo@abchospital.lk">dpo@abchospital.lk</a></p>
                    <p class="contact-secondary">Response within 24 hours</p>
                    <p class="contact-alt">Alternate: <a href="mailto:privacy@abchospital.lk">privacy@abchospital.lk</a></p>
                </div>
                
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <h4>Phone</h4>
                    <p class="contact-primary">+94 11 234 5678</p>
                    <p class="contact-secondary">Ext. 1234 (Data Protection Office)</p>
                    <p class="contact-alt">Mon-Fri: 9:00 AM - 5:00 PM</p>
                </div>
                
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h4>Office Address</h4>
                    <p class="contact-primary">Data Protection Office</p>
                    <p>ABC Hospital<br>123 Hospital Road<br>Colombo 05, Sri Lanka</p>
                    <p class="contact-alt">Postal Code: 00500</p>
                </div>
                
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-clock"></i></div>
                    <h4>Office Hours</h4>
                    <p class="contact-primary">Monday - Friday</p>
                    <p>9:00 AM - 5:00 PM</p>
                    <p class="contact-alt">Saturday: 9:00 AM - 1:00 PM<br>Sunday: Closed</p>
                </div>
                
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-fax"></i></div>
                    <h4>Fax</h4>
                    <p class="contact-primary">+94 11 234 5679</p>
                    <p class="contact-secondary">For secure document transmission</p>
                </div>
                
                <div class="contact-detail-card">
                    <div class="contact-icon"><i class="fas fa-globe"></i></div>
                    <h4>Online Portal</h4>
                    <p class="contact-primary"><a href="<?php echo $base_url; ?>/privacy-request.php">Submit Privacy Request</a></p>
                    <p class="contact-secondary">Use our online form for faster processing</p>
                </div>
            </div>
            
            <div class="contact-emergency">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>For Urgent Privacy Concerns:</strong>
                    <p>Call our emergency privacy hotline: <a href="tel:+94771234567">+94 77 123 4567</a> (24/7 for data breach reporting)</p>
                </div>
            </div>
        </div>

        <!-- Social Media with Working Links -->
        <div class="social-connect">
            <h3><i class="fas fa-share-alt"></i> Connect With Us</h3>
            <p>Follow us on social media for updates on data protection and privacy news</p>
            <div class="social-grid">
                <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle" title="Follow us on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle" title="Follow us on Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle" title="Connect on LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle" title="Follow us on Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer" class="social-circle" title="Subscribe on YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://wa.me/94771234567" target="_blank" rel="noopener noreferrer" class="social-circle" title="Chat on WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            <p class="social-handles">@abchospital | #ABCPrivacy</p>
        </div>

        <!-- Trust Badge -->
            <div style="text-align: center; margin-top: 30px;">
                <img src="images/ABC+trust+badge.jpg" alt="ABC Hospital Trust Badge" style="max-width: 200px; border-radius: 20px;" onerror="this.style.display='none'">
                <p style="margin-top: 15px; color: #94a3b8;">
                    <i class="fas fa-check-circle" style="color:#4f46e5;"></i> 
                    Last Updated: February 22, 2026
                </p>
            </div>
        </div> 
    </div>
<?php include_once 'includes/footer02.php'; ?>