<?php
// includes/footer-doctors.php

// Define fallback values if constants aren't defined
if (!defined('BASE_URL')) define('BASE_URL', '/abc_hospital_virtual_appointment');
if (!defined('FACEBOOK_URL')) define('FACEBOOK_URL', 'https://facebook.com/abchospital');
if (!defined('TWITTER_URL')) define('TWITTER_URL', 'https://twitter.com/abchospital');
if (!defined('LINKEDIN_URL')) define('LINKEDIN_URL', 'https://linkedin.com/company/abchospital');
if (!defined('INSTAGRAM_URL')) define('INSTAGRAM_URL', 'https://instagram.com/abchospital');
if (!defined('YOUTUBE_URL')) define('YOUTUBE_URL', 'https://youtube.com/abchospital');
if (!defined('ADDRESS')) define('ADDRESS', '123 Health Avenue, Colombo, Sri Lanka');
if (!defined('CONTACT_PHONE')) define('CONTACT_PHONE', '+94 11 234 5678');
if (!defined('CONTACT_EMAIL')) define('CONTACT_EMAIL', 'info@abchospital.com');
?>
    <!-- Footer Section -->
    <footer class="footer" style="background: #1f2937; color: white; padding: 60px 0 20px; margin-top: 0;">
        <div class="container">
            <div class="footer-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; margin-bottom: 40px;">
                <div class="footer-col">
                    <div class="footer-logo" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                        <img src="<?php echo BASE_URL; ?>/images/ABC logo.webp" alt="ABC Hospital" style="height: 40px; width: 40px;" onerror="this.src='https://via.placeholder.com/40x40/4f46e5/ffffff?text=ABC';">
                        <span style="font-size: 20px; font-weight: 700;">ABC VIRTUAL</span>
                    </div>
                    <p style="color: #9ca3af; margin-bottom: 20px;">Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                    
                    <!-- SOCIAL MEDIA ICONS - WORKING LINKS -->
                    <div class="footer-social" style="display: flex; gap: 15px;">
                        <a href="<?php echo FACEBOOK_URL; ?>" target="_blank" rel="noopener noreferrer" style="color: #9ca3af; font-size: 18px; transition: color 0.3s;"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo TWITTER_URL; ?>" target="_blank" rel="noopener noreferrer" style="color: #9ca3af; font-size: 18px; transition: color 0.3s;"><i class="fab fa-twitter"></i></a>
                        <a href="<?php echo LINKEDIN_URL; ?>" target="_blank" rel="noopener noreferrer" style="color: #9ca3af; font-size: 18px; transition: color 0.3s;"><i class="fab fa-linkedin-in"></i></a>
                        <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank" rel="noopener noreferrer" style="color: #9ca3af; font-size: 18px; transition: color 0.3s;"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo YOUTUBE_URL; ?>" target="_blank" rel="noopener noreferrer" style="color: #9ca3af; font-size: 18px; transition: color 0.3s;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4 style="margin-bottom: 20px; font-size: 18px;">Quick Links</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/index.php" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Home</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/services.php" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Services</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/doctors.php" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Our Doctors</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/about.php" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> About Us</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/contact.php" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 style="margin-bottom: 20px; font-size: 18px;">Our Portals</h4>
                    <ul style="list-style: none;">
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/pages/login.php?type=patient" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Patient Portal</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/pages/login.php?type=doctor" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Doctor Portal</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/pages/login.php?type=admin" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Admin Portal</a></li>
                        <li style="margin-bottom: 10px;"><a href="<?php echo BASE_URL; ?>/pages/login.php?type=receptionist" style="color: #9ca3af; text-decoration: none; transition: color 0.3s;"><i class="fas fa-chevron-right" style="margin-right: 10px; font-size: 12px;"></i> Receptionist Portal</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4 style="margin-bottom: 20px; font-size: 18px;">Contact Info</h4>
                    <ul class="contact-info" style="list-style: none;">
                        <li style="margin-bottom: 10px; display: flex; align-items: center; color: #9ca3af;"><i class="fas fa-map-marker-alt" style="width: 20px; margin-right: 10px;"></i> <?php echo ADDRESS; ?></li>
                        <li style="margin-bottom: 10px; display: flex; align-items: center; color: #9ca3af;"><i class="fas fa-phone" style="width: 20px; margin-right: 10px;"></i> <?php echo CONTACT_PHONE; ?></li>
                        <li style="margin-bottom: 10px; display: flex; align-items: center; color: #9ca3af;"><i class="fas fa-envelope" style="width: 20px; margin-right: 10px;"></i> <?php echo CONTACT_EMAIL; ?></li>
                    </ul>
                    
                    <h4 style="margin: 20px 0 10px; font-size: 18px;">Newsletter</h4>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); subscribeNewsletter();" style="display: flex; margin-top: 10px;">
                        <input type="email" id="newsletterEmail" placeholder="Your Email" required style="flex: 1; padding: 10px; border: none; border-radius: 5px 0 0 5px;">
                        <button type="submit" style="padding: 10px 15px; background: #4f46e5; color: white; border: none; border-radius: 0 5px 5px 0; cursor: pointer;"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom" style="border-top: 1px solid #374151; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; color: #9ca3af;">
                <p>&copy; <?php echo date('Y'); ?> ABC Hospital. All rights reserved.</p>
                <div class="footer-bottom-links" style="display: flex; gap: 20px;">
                    <a href="<?php echo BASE_URL; ?>/terms-of-use.php" style="color: #9ca3af; text-decoration: none;">Terms of Use</a>
                    <a href="<?php echo BASE_URL; ?>/privacy-policy.php" style="color: #9ca3af; text-decoration: none;">Privacy Policy</a>
                    <a href="<?php echo BASE_URL; ?>/cookie-policy.php" style="color: #9ca3af; text-decoration: none;">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="Back to Top" style="position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; background: #4f46e5; color: white; border: none; border-radius: 50%; cursor: pointer; display: none; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3); transition: all 0.3s; z-index: 999;">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Doctors JS -->
    <script src="<?php echo BASE_URL; ?>/js/doctors.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
        
        // Newsletter subscription
        function subscribeNewsletter() {
            const emailInput = document.getElementById('newsletterEmail');
            if (emailInput) {
                const email = emailInput.value.trim();
                if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    alert('Thank you for subscribing to our newsletter!');
                    emailInput.value = '';
                } else {
                    alert('Please enter a valid email address.');
                }
            }
        }
        
        // Back to top button
        document.addEventListener('DOMContentLoaded', function() {
            const backToTop = document.getElementById('backToTop');
            
            if (backToTop) {
                window.addEventListener('scroll', function() {
                    backToTop.style.display = window.scrollY > 300 ? 'flex' : 'none';
                });
                
                backToTop.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
            
            // Hide preloader
            setTimeout(() => {
                const preloader = document.querySelector('.preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    setTimeout(() => preloader.style.display = 'none', 500);
                }
            }, 500);
        });
    </script>
</body>
</html>