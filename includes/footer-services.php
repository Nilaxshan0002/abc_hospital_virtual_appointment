<?php
// Footer for Services Page
$base_url = '/abc_hospital_virtual_appointment';
?>

<!-- Footer with all links -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" style="width: 60px; height: 60px; margin-bottom: 15px;">
                <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/abchospital" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.twitter.com/abchospital" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/company/abchospital" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/abchospital" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/abchospital" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/index.php">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>/doctors.php">Doctors</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/departments.php">Departments</a></li>
                    <li><a href="<?php echo $base_url; ?>/appointments.php">Appointments</a></li>
                    <li><a href="<?php echo $base_url; ?>/about.php">About</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Our Portals</h4>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=patient">Patient Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=doctor">Doctor Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=admin">Admin Portal</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php?type=receptionist">Receptionist Portal</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h4>Newsletter</h4>
                <p>Subscribe for health tips and updates</p>
                <form class="newsletter-form" id="newsletterForm">
                    <input type="email" placeholder="Your Email" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital. All rights reserved.</p>
            <div class="footer-links">
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