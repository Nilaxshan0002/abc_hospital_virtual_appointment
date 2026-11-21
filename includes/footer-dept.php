<?php
$base_url = '/abc_hospital_virtual_appointment';
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" 
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/60x60/4f46e5/ffffff?text=ABC';">
                    <span>ABC VIRTUAL</span>
                </div>
                <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                
                <!-- Social Media Links -->
                <div class="social-links">
                    <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php"><i class="fas fa-chevron-right"></i> Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/departments.php"><i class="fas fa-chevron-right"></i> Departments</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php"><i class="fas fa-chevron-right"></i> Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Our Portals</h4>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=patient"><i class="fas fa-chevron-right"></i> Patient Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=doctor"><i class="fas fa-chevron-right"></i> Doctor Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=admin"><i class="fas fa-chevron-right"></i> Admin Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist"><i class="fas fa-chevron-right"></i> Receptionist Portal</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Subscribe for health tips and updates</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Thank you for subscribing!');">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
                
                <div class="contact-info">
                    <p><i class="fas fa-phone-alt"></i> +94 11 234 5678</p>
                    <p><i class="fas fa-envelope"></i> info@abchospital.lk</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Hospital Road, Colombo 05</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for better healthcare</p>
            <div class="footer-bottom-links">
                <a href="<?php echo $base_url; ?>/terms-of-use.php">Terms of Use</a>
                <a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a>
                <a href="<?php echo $base_url; ?>/cookie-policy.php">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" title="Back to Top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?php echo $base_url; ?>/js/department.js"></script>