<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>ABC Hospital</h4>
                <p>Leading healthcare provider since 1959</p>
                <p>Colombo, Sri Lanka</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <!-- FIXED: Changed anchor links to actual pages with base_url -->
                    <li><a href="<?php echo $base_url; ?>/about.php">About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>/services.php">Services</a></li>
                    <li><a href="<?php echo $base_url; ?>/contact.php">Contact</a></li>
                    <li><a href="<?php echo $base_url; ?>/privacy-policy.php">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p><i class="fas fa-phone-alt"></i> +94 11 2 345 678</p>
                <p><i class="fas fa-envelope"></i> info@abchospital.lk</p>
                <p><i class="fas fa-map-marker-alt"></i> 123 Hospital Road, Colombo 05</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ABC Hospital. All rights reserved. | ABC Virtual Appointment System</p>
        </div>
    </div>
</footer>

<!-- FIXED: JavaScript path with base_url -->
<script src="<?php echo $base_url; ?>/js/main.js"></script>
</body>
</html>