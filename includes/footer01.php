<?php
// includes/footer01.php
?>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <img src="/abc_hospital_virtual_appointment/images/ABC logo.webp" alt="ABC Hospital" onerror="this.src='https://via.placeholder.com/50x50/4f46e5/ffffff?text=ABC';">
                        <span>ABC VIRTUAL</span>
                    </div>
                    <p>Leading the way in digital healthcare since 1959.</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/abchospital" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/abc_hospital_virtual_appointment/index.php">Home</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/about.php">About</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/contact.php">Contact</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/doctors.php">Doctors</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/services.php">Services</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/departments.php">Departments</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/appointments.php">Appointments</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="/abc_hospital_virtual_appointment/terms-of-use.php">Terms of Use</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/privacy-policy.php">Privacy Policy</a></li>
                        <li><a href="/abc_hospital_virtual_appointment/cookie-policy.php">Cookie Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul class="contact-info-footer">
                        <li><i class="fas fa-phone"></i> +94 11 234 5678</li>
                        <li><i class="fas fa-envelope"></i> info@abchospital.lk</li>
                        <li><i class="fas fa-map-marker-alt"></i> Colombo 05, Sri Lanka</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 ABC Virtual Healthcare. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="/abc_hospital_virtual_appointment/index.php">Home</a>
                    <a href="/abc_hospital_virtual_appointment/privacy-policy.php">Privacy</a>
                    <a href="/abc_hospital_virtual_appointment/terms-of-use.php">Terms</a>
                    <a href="/abc_hospital_virtual_appointment/contact.php">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/abc_hospital_virtual_appointment/js/cookie.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({ 
            duration: 1000, 
            once: true,
            offset: 100,
            disable: window.innerWidth < 768
        });
        
        // Hide preloader with fade effect
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            if (preloader) {
                preloader.style.transition = 'opacity 0.5s';
                preloader.style.opacity = '0';
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 500);
            }
        });
        
        // Back to top button visibility
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.style.display = 'flex';
                    btn.style.opacity = '1';
                } else {
                    btn.style.opacity = '0';
                    setTimeout(function() {
                        if (window.scrollY <= 300) {
                            btn.style.display = 'none';
                        }
                    }, 300);
                }
            }
        });
        
        // Smooth scroll for back to top
        document.getElementById('backToTop')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <style>
        /* Additional footer styles to ensure contact info shows in white */
        .footer {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            padding: 60px 0 30px;
            margin-top: 60px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col h4 {
            color: #ffd700;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        
        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-col ul li {
            margin-bottom: 12px;
            color: white !important;
        }
        
        .footer-col ul li a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-col ul li a:hover {
            color: #ffd700;
        }
        
        .contact-info-footer li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white !important;
        }
        
        .contact-info-footer li i {
            color: #ffd700;
            width: 20px;
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
            color: white;
        }
        
        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
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
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .footer-social a:hover {
            background: #ffd700;
            color: #1e293b;
            transform: translateY(-3px);
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
        
        .footer-bottom p {
            color: #94a3b8;
            margin: 0;
        }
        
        .footer-bottom-links {
            display: flex;
            gap: 20px;
        }
        
        .footer-bottom-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-bottom-links a:hover {
            color: #ffd700;
        }
        
        #backToTop {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background: #4f46e5;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 5px 20px rgba(79, 70, 229, 0.4);
            transition: all 0.3s;
            z-index: 100;
        }
        
        #backToTop:hover {
            background: #6366f1;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.5);
        }
        
        @media (max-width: 768px) {
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-bottom-links {
                justify-content: center;
            }
            
            #backToTop {
                bottom: 20px;
                right: 20px;
                width: 40px;
                height: 40px;
            }
        }
    </style>
</body>
</html>