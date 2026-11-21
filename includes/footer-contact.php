<?php
$base_url = '/abc_hospital_virtual_appointment';
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/40x40/4f46e5/ffffff?text=ABC';">
                    <span>ABC VIRTUAL</span>
                </div>
                <p>Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
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
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 ABC Hospital. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i> for better healthcare</p>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?php echo $base_url; ?>/js/contact.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }

    // Back to top button
    const backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (backToTop) {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        }
    });

    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Preloader hide
    window.addEventListener('load', function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    });
</script>

</body>
</html>