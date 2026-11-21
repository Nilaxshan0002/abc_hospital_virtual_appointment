<?php
$base_url = '/abc_hospital_virtual_appointment';
?>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="<?php echo $base_url; ?>/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                        <span>ABC VIRTUAL</span>
                    </div>
                    <p style="color: #cbd5e1;">Leading the way in digital healthcare since 1959. Your trusted partner in health and wellness.</p>
                    <div class="footer-social">
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
                    <h4>Privacy Center</h4>
                    <ul>
                        <li><a href="<?php echo $base_url; ?>/privacy-policy.php"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                        <li><a href="<?php echo $base_url; ?>/cookie-policy.php"><i class="fas fa-chevron-right"></i> Cookie Policy</a></li>
                        <li><a href="<?php echo $base_url; ?>/terms-of-use.php"><i class="fas fa-chevron-right"></i> Terms of Use</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Hospital Road, Colombo 05</li>
                        <li><i class="fas fa-phone"></i> +94 11 234 5678</li>
                        <li><i class="fas fa-envelope"></i> info@abchospital.lk</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2026 ABC Virtual Healthcare – Clarity & Care. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for better healthcare</p>
                <div class="footer-bottom-links">
                    <a href="<?php echo $base_url; ?>/index.php">Home</a>
                    <a href="<?php echo $base_url; ?>/terms-of-use.php">Terms</a>
                    <a href="<?php echo $base_url; ?>/cookie-policy.php">Cookies</a>
                    <a href="<?php echo $base_url; ?>/contact.php">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" title="Back to Top" style="position: fixed; bottom: 40px; right: 40px; background: #4f46e5; color: white; width: 50px; height: 50px; border-radius: 50%; border: none; cursor: pointer; display: none; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 5px 20px rgba(79, 70, 229, 0.4); z-index: 100;">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Page Specific JavaScript -->
    <?php if (isset($pageJS) && !empty($pageJS)): ?>
        <script src="<?php echo $base_url; ?>/js/<?php echo $pageJS; ?>.js"></script>
    <?php endif; ?>

    <style>
        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 60px 0 30px;
            margin-top: 60px;
            border-radius: 50px 50px 0 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-logo img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        .footer-logo span {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .footer h4 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #ffd700;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 12px;
            color: #cbd5e1;
        }

        .footer ul li a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer ul li a:hover {
            color: #ffd700;
            transform: translateX(5px);
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        .footer-social a:hover {
            background: #ffd700;
            color: #1e293b;
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid #334155;
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom-links a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 25px;
            transition: color 0.3s;
        }

        .footer-bottom-links a:hover {
            color: #ffd700;
        }

        .footer-bottom-links a:first-child {
            margin-left: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            .footer-bottom-links a {
                margin: 0 10px;
            }
        }
    </style>
</body> 
</html>