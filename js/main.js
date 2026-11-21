// ABC Hospital Virtual Appointment System
// Main JavaScript File - Enhanced Version
// FIXED: All paths updated for /abc_hospital_virtual_appointment/ structure

// ===== GLOBAL VARIABLES =====
const APP_CONFIG = {
    name: 'ABC Virtual',
    version: '1.0.0',
    baseUrl: '/abc_hospital_virtual_appointment', // ADDED: Base URL for all paths
    apiUrl: '/abc_hospital_virtual_appointment/api/', // FIXED: API path
    debug: true,
    toastDuration: 3000
};

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('ABC Hospital Virtual System Loaded - Version ' + APP_CONFIG.version);
    console.log('Base URL: ' + APP_CONFIG.baseUrl); // Added for debugging
    
    // Initialize all components
    initPreloader();
    initNavigation();
    initAnimations();
    initForms();
    initCounters();
    initTestimonialSlider();
    initBackToTop();
    initTooltips();
    initDatePickers();
    initSearchFilters();
    initMobileMenu();
    initScrollSpy();
    initLazyLoading();
    initParallax();
    initNotifications();
    
    // Check for alerts in URL
    checkForAlerts();
    
    // Add active class to current nav item
    setActiveNavItem();
});

// ===== PRELOADER =====
function initPreloader() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 500);
        });
    }
}

// ===== NAVIGATION =====
function initNavigation() {
    const navbar = document.querySelector('.navbar');
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    // Navbar scroll effect
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
    
    // Mobile menu toggle
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
            
            // Update aria-expanded
            const expanded = this.classList.contains('active');
            this.setAttribute('aria-expanded', expanded);
        });
    }
    
    // Close mobile menu on link click
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (navToggle && navToggle.classList.contains('active')) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
            
            // Smooth scroll for anchor links
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    smoothScroll(target);
                }
            }
        });
    });
    
    // Close menu on outside click
    document.addEventListener('click', function(e) {
        if (navMenu && navMenu.classList.contains('active')) {
            if (!navMenu.contains(e.target) && !navToggle.contains(e.target)) {
                navToggle.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        }
    });
}

// ===== MOBILE MENU =====
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
}

// ===== SMOOTH SCROLL =====
function smoothScroll(target, duration = 1000) {
    if (typeof target === 'string') {
        target = document.querySelector(target);
    }
    
    if (!target) return;
    
    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    let startTime = null;
    
    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const run = ease(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }
    
    function ease(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }
    
    requestAnimationFrame(animation);
}

// ===== ANIMATIONS =====
function initAnimations() {
    // Intersection Observer for fade-in animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    
    // Observe elements with animation classes
    document.querySelectorAll('.fade-up, .fade-left, .fade-right, .zoom-in').forEach(el => {
        observer.observe(el);
    });
    
    // Add animation on scroll
    window.addEventListener('scroll', throttle(() => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            
            if (rect.top < windowHeight - 100) {
                el.classList.add('animated');
            }
        });
    }, 100));
}

// ===== COUNTER ANIMATION =====
function initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            counter.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            counter.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 16);
                    
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(counter);
    });
}

// ===== TESTIMONIAL SLIDER =====
function initTestimonialSlider() {
    const slider = document.querySelector('.testimonial-slider');
    if (!slider) return;
    
    const cards = slider.querySelectorAll('.testimonial-card');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    let currentIndex = 0;
    let autoSlideInterval;
    
    if (cards.length === 0) return;
    
    // Show first card
    cards[currentIndex].classList.add('active');
    
    // Previous button
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            navigateSlider('prev');
            resetAutoSlide();
        });
    }
    
    // Next button
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            navigateSlider('next');
            resetAutoSlide();
        });
    }
    
    function navigateSlider(direction) {
        cards[currentIndex].classList.remove('active');
        
        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % cards.length;
        } else {
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
        }
        
        cards[currentIndex].classList.add('active');
    }
    
    // Auto slide
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            navigateSlider('next');
        }, 5000);
    }
    
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }
    
    startAutoSlide();
    
    // Pause on hover
    slider.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });
    
    slider.addEventListener('mouseleave', () => {
        startAutoSlide();
    });
}

// ===== BACK TO TOP BUTTON =====
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');
    if (!backToTop) return;
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        smoothScroll(0, 800);
    });
}

// ===== FORM HANDLING =====
function initForms() {
    // Contact form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmit);
    }
    
    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', handleNewsletterSubmit);
    }
    
    // Login form
    const loginForm = document.querySelector('.login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginSubmit);
    }
    
    // Appointment form
    const appointmentForm = document.querySelector('.appointment-form');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', handleAppointmentSubmit);
    }
    
    // Password toggle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.target);
            if (input) {
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.classList.toggle('show');
            }
        });
    });
    
    // Form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', validateForm);
        form.addEventListener('input', validateField);
    });
}

// ===== CONTACT FORM HANDLER =====
function handleContactSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Validate form
    if (!validateForm(e)) return;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
    
    // Simulate AJAX request
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Message <i class="fas fa-paper-plane"></i>';
        
        // Show success message
        showAlert('Thank you for your message. We will contact you soon!', 'success');
        
        // Reset form
        form.reset();
    }, 1500);
}

// ===== NEWSLETTER HANDLER =====
function handleNewsletterSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const email = form.querySelector('input[type="email"]');
    
    if (!email || !validateEmail(email.value)) {
        showAlert('Please enter a valid email address', 'error');
        return;
    }
    
    showAlert('Successfully subscribed to newsletter!', 'success');
    email.value = '';
}

// ===== LOGIN HANDLER =====
function handleLoginSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const username = form.querySelector('#username');
    const password = form.querySelector('#password');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (!username.value || !password.value) {
        showAlert('Please fill in all fields', 'error');
        return;
    }
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
    
    // Simulate login
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Login <i class="fas fa-sign-in-alt"></i>';
        
        // FIXED: Redirect to dashboard with correct path
        showAlert('Login successful! Redirecting...', 'success');
        
        setTimeout(() => {
            window.location.href = APP_CONFIG.baseUrl + '/pages/dashboard.php';
        }, 1500);
    }, 1500);
}

// ===== APPOINTMENT HANDLER =====
function handleAppointmentSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const doctor = form.querySelector('#doctor');
    const date = form.querySelector('#date');
    const time = form.querySelector('#time');
    const reason = form.querySelector('#reason');
    
    if (!doctor.value || !date.value || !time.value || !reason.value) {
        showAlert('Please fill in all required fields', 'error');
        return;
    }
    
    showLoading();
    
    setTimeout(() => {
        hideLoading();
        showAlert('Appointment booked successfully!', 'success');
        form.reset();
    }, 1500);
}

// ===== FORM VALIDATION =====
function validateForm(e) {
    const form = e.target;
    let isValid = true;
    
    // Remove existing errors
    form.querySelectorAll('.error-message').forEach(el => el.remove());
    form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    
    // Validate required fields
    form.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        }
    });
    
    // Validate email fields
    form.querySelectorAll('input[type="email"]').forEach(field => {
        if (field.value && !validateEmail(field.value)) {
            showFieldError(field, 'Please enter a valid email address');
            isValid = false;
        }
    });
    
    // Validate phone fields
    form.querySelectorAll('input[type="tel"]').forEach(field => {
        if (field.value && !validatePhone(field.value)) {
            showFieldError(field, 'Please enter a valid phone number');
            isValid = false;
        }
    });
    
    // Validate password match
    const password = form.querySelector('#password');
    const confirmPassword = form.querySelector('#confirm_password');
    if (password && confirmPassword && password.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Passwords do not match');
        isValid = false;
    }
    
    return isValid;
}

// ===== VALIDATE INDIVIDUAL FIELD =====
function validateField(e) {
    const field = e.target;
    
    // Remove existing error for this field
    const existingError = field.parentElement.querySelector('.error-message');
    if (existingError) existingError.remove();
    field.classList.remove('error');
    
    // Validate based on field type
    if (field.hasAttribute('required') && !field.value.trim()) {
        showFieldError(field, 'This field is required');
    } else if (field.type === 'email' && field.value && !validateEmail(field.value)) {
        showFieldError(field, 'Please enter a valid email address');
    } else if (field.type === 'tel' && field.value && !validatePhone(field.value)) {
        showFieldError(field, 'Please enter a valid phone number');
    }
}

// ===== SHOW FIELD ERROR =====
function showFieldError(field, message) {
    field.classList.add('error');
    
    const error = document.createElement('div');
    error.className = 'error-message';
    error.textContent = message;
    error.style.color = '#F44336';
    error.style.fontSize = '12px';
    error.style.marginTop = '5px';
    
    field.parentElement.appendChild(error);
}

// ===== VALIDATE EMAIL =====
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// ===== VALIDATE PHONE (Sri Lankan) =====
function validatePhone(phone) {
    const re = /^(?:\+94|0)[0-9]{9}$/;
    return re.test(phone.replace(/\s/g, ''));
}

// ===== TOOLTIPS =====
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltipText = this.dataset.tooltip;
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = tooltipText;
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#2C3E50';
            tooltip.style.color = '#fff';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '4px';
            tooltip.style.fontSize = '12px';
            tooltip.style.zIndex = '1000';
            tooltip.style.pointerEvents = 'none';
            tooltip.style.whiteSpace = 'nowrap';
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            let top = rect.top - tooltipRect.height - 5;
            let left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
            
            // Adjust if tooltip goes off screen
            if (left < 0) left = 5;
            if (left + tooltipRect.width > window.innerWidth) {
                left = window.innerWidth - tooltipRect.width - 5;
            }
            if (top < 0) top = rect.bottom + 5;
            
            tooltip.style.top = top + window.scrollY + 'px';
            tooltip.style.left = left + 'px';
            
            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });
}

// ===== DATE PICKERS =====
function initDatePickers() {
    const dateInputs = document.querySelectorAll('input[type="date"][min="today"]');
    const today = new Date().toISOString().split('T')[0];
    
    dateInputs.forEach(input => {
        input.min = today;
        
        // Disable past dates
        input.addEventListener('click', function() {
            if (!this.value) {
                this.value = today;
            }
        });
    });
}

// ===== SEARCH FILTERS =====
function initSearchFilters() {
    // Setup table search
    document.querySelectorAll('[data-search]').forEach(input => {
        const tableId = input.dataset.table;
        input.addEventListener('keyup', debounce(function() {
            filterTable(this.value, tableId);
        }, 300));
    });
    
    // Setup filter buttons
    document.querySelectorAll('[data-filter]').forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            const target = this.dataset.target;
            filterItems(filter, target);
            
            // Update active state
            this.parentElement.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
}

// ===== FILTER TABLE =====
function filterTable(searchText, tableId) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');
    searchText = searchText.toLowerCase();
    
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell && cell.textContent.toLowerCase().includes(searchText)) {
                found = true;
                break;
            }
        }
        
        row.style.display = found ? '' : 'none';
    }
}

// ===== FILTER ITEMS =====
function filterItems(filter, target) {
    const items = document.querySelectorAll(target + ' [data-category]');
    
    items.forEach(item => {
        if (filter === 'all' || item.dataset.category === filter) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

// ===== SCROLL SPY =====
function initScrollSpy() {
    const sections = document.querySelectorAll('section[id]');
    
    window.addEventListener('scroll', throttle(() => {
        const scrollY = window.pageYOffset;
        
        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 100;
            const sectionId = section.getAttribute('id');
            
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                document.querySelectorAll('.nav-links a').forEach(link => {
                    link.classList.remove('active');
                    const href = link.getAttribute('href');
                    if (href === '#' + sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, 100));
}

// ===== SET ACTIVE NAV ITEM =====
function setActiveNavItem() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        // FIXED: Handle paths with base URL
        const linkPage = href.replace(APP_CONFIG.baseUrl + '/', '').split('/').pop();
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.php')) {
            link.classList.add('active');
        }
    });
}

// ===== LAZY LOADING =====
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                // FIXED: Handle data-src with base URL if needed
                if (img.dataset.src && !img.dataset.src.startsWith('http')) {
                    img.src = APP_CONFIG.baseUrl + '/' + img.dataset.src.replace(/^\//, '');
                } else {
                    img.src = img.dataset.src;
                }
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// ===== PARALLAX EFFECT =====
function initParallax() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    window.addEventListener('scroll', () => {
        const scrollY = window.pageYOffset;
        
        parallaxElements.forEach(el => {
            const speed = el.dataset.speed || 0.5;
            el.style.transform = `translateY(${scrollY * speed}px)`;
        });
    });
}

// ===== NOTIFICATIONS =====
function initNotifications() {
    // Add notification styles
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .notification-success {
            background: linear-gradient(135deg, #4CAF50, #45a049);
        }
        
        .notification-error {
            background: linear-gradient(135deg, #F44336, #e53935);
        }
        
        .notification-warning {
            background: linear-gradient(135deg, #FFC107, #ffb300);
        }
        
        .notification-info {
            background: linear-gradient(135deg, #2196F3, #1e88e5);
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .fade-out {
            animation: slideOutRight 0.3s ease forwards;
        }
    `;
    document.head.appendChild(style);
}

// ===== SHOW ALERT =====
function showAlert(message, type = 'info') {
    const alert = document.createElement('div');
    alert.className = `notification notification-${type}`;
    alert.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas ${getIconForType(type)}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(alert);
    
    // Auto remove after duration
    setTimeout(() => {
        alert.classList.add('fade-out');
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, APP_CONFIG.toastDuration);
}

// ===== GET ICON FOR NOTIFICATION TYPE =====
function getIconForType(type) {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    return icons[type] || icons.info;
}

// ===== CHECK FOR URL ALERTS =====
function checkForAlerts() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');
    const warning = urlParams.get('warning');
    const info = urlParams.get('info');
    
    if (success) showAlert(decodeURIComponent(success), 'success');
    if (error) showAlert(decodeURIComponent(error), 'error');
    if (warning) showAlert(decodeURIComponent(warning), 'warning');
    if (info) showAlert(decodeURIComponent(info), 'info');
}

// ===== SHOW LOADING SPINNER =====
function showLoading() {
    const spinner = document.createElement('div');
    spinner.className = 'loading-spinner';
    spinner.id = 'global-spinner';
    spinner.innerHTML = '<div class="spinner"></div>';
    
    // Add styles
    const style = document.createElement('style');
    style.textContent = `
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            backdrop-filter: blur(3px);
        }
        
        .loading-spinner .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top-color: #2A5C7D;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    
    document.head.appendChild(style);
    document.body.appendChild(spinner);
}

// ===== HIDE LOADING SPINNER =====
function hideLoading() {
    const spinner = document.getElementById('global-spinner');
    if (spinner) {
        spinner.classList.add('fade-out');
        setTimeout(() => {
            spinner.remove();
        }, 300);
    }
}

// ===== FORMAT DATE =====
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// ===== LOGOUT FUNCTION =====
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        showLoading();
        setTimeout(() => {
            window.location.href = APP_CONFIG.baseUrl + '/index.php';
        }, 1000);
    }
}

// ===== PRINT PAGE =====
function printPage() {
    window.print();
}

// ===== EXPORT TO CSV =====
function exportToCSV(tableId, filename = 'export') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = [];
        
        cols.forEach(col => {
            let data = col.innerText.replace(/"/g, '""');
            rowData.push('"' + data + '"');
        });
        
        csv.push(rowData.join(','));
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    
    link.href = url;
    link.download = `${filename}_${new Date().toISOString().slice(0,10)}.csv`;
    link.style.display = 'none';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    showAlert('Export completed successfully!', 'success');
}

// ===== PREVENT MULTIPLE FORM SUBMISSIONS =====
document.addEventListener('submit', function(e) {
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (submitBtn && !form.classList.contains('allow-multiple')) {
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.disabled = false;
        }, 3000);
    }
});

// ===== DEBOUNCE FUNCTION =====
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===== THROTTLE FUNCTION =====
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ===== TOGGLE PASSWORD VISIBILITY =====
function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    if (!input) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        iconElement.classList.add('show');
    } else {
        input.type = 'password';
        iconElement.classList.remove('show');
    }
}

// ===== HANDLE RESIZE =====
let resizeTimer;
window.addEventListener('resize', function() {
    document.body.classList.add('resize-animation-stopper');
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        document.body.classList.remove('resize-animation-stopper');
    }, 400);
});

// ===== ERROR HANDLING =====
window.addEventListener('error', function(e) {
    if (APP_CONFIG.debug) {
        console.error('Error caught:', e.error);
    }
});

// ===== AJAX REQUEST HELPER =====
async function makeRequest(url, options = {}) {
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };
    
    const mergedOptions = { ...defaultOptions, ...options };
    
    // FIXED: Handle URL with base path
    const fullUrl = url.startsWith('http') ? url : APP_CONFIG.baseUrl + url;
    
    try {
        showLoading();
        const response = await fetch(fullUrl, mergedOptions);
        const data = await response.json();
        hideLoading();
        return data;
    } catch (error) {
        hideLoading();
        showAlert('An error occurred. Please try again.', 'error');
        console.error('AJAX Error:', error);
        throw error;
    }
}

// ===== ADD CSS VARIABLES =====
const rootStyles = document.documentElement.style;
rootStyles.setProperty('--toast-duration', APP_CONFIG.toastDuration + 'ms');

// ===== EXPORT FUNCTIONS FOR GLOBAL USE =====
window.ABC_Hospital = {
    showAlert,
    showLoading,
    hideLoading,
    formatDate,
    logout,
    printPage,
    exportToCSV,
    validateEmail,
    validatePhone,
    smoothScroll,
    debounce,
    throttle,
    makeRequest
};