// js/cookie.js

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initializePage();
    loadSavedPreferences();
    setupEventListeners();
    highlightCurrentPage();
});

// Initialize page elements
function initializePage() {
    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            disable: window.innerWidth < 768 // Disable on mobile for better performance
        });
    }
    
    // Check if user has accepted cookies
    checkCookieConsent();
}

// Hide preloader when page loads
window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        // Fade out animation
        preloader.style.transition = 'opacity 0.5s';
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

// Back to Top Button functionality
const backToTop = document.getElementById('backToTop');
if (backToTop) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.style.display = 'flex';
            backToTop.classList.add('show');
        } else {
            backToTop.style.display = 'none';
            backToTop.classList.remove('show');
        }
    });

    backToTop.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Mobile Menu Toggle
function setupMobileMenu() {
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (mobileBtn && navLinks) {
        mobileBtn.addEventListener('click', function() {
            navLinks.classList.toggle('show');
            
            // Toggle icon between bars and times
            const icon = this.querySelector('i');
            if (icon) {
                if (icon.classList.contains('fa-bars')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileBtn.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove('show');
                const icon = mobileBtn.querySelector('i');
                if (icon && icon.classList.contains('fa-times')) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        
        // Close menu when window resizes above mobile breakpoint
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                navLinks.classList.remove('show');
                const icon = mobileBtn.querySelector('i');
                if (icon && icon.classList.contains('fa-times')) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
    }
}

// Smooth scrolling for anchor links
function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                // Close mobile menu if open
                const navLinks = document.getElementById('navLinks');
                const mobileBtn = document.getElementById('mobileMenuBtn');
                if (navLinks && navLinks.classList.contains('show')) {
                    navLinks.classList.remove('show');
                    const icon = mobileBtn?.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
                
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Open external links in new tab
function setupExternalLinks() {
    document.querySelectorAll('a[href^="http"]').forEach(link => {
        if (!link.href.includes(window.location.hostname)) {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        }
    });
}

// Show success message with animation
function showSuccessMessage(message = 'Your cookie preferences have been saved successfully!') {
    // Remove any existing success message
    const existingMsg = document.querySelector('.success-message');
    if (existingMsg) {
        existingMsg.remove();
    }
    
    // Create new success message
    const successMsg = document.createElement('div');
    successMsg.className = 'success-message';
    successMsg.setAttribute('role', 'alert');
    successMsg.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <span>${message}</span>
    `;
    
    // Insert after save button
    const saveBtn = document.querySelector('.save-btn');
    if (saveBtn && saveBtn.parentNode) {
        saveBtn.parentNode.insertBefore(successMsg, saveBtn.nextSibling);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            successMsg.style.animation = 'slideIn 0.5s reverse';
            setTimeout(() => {
                if (successMsg.parentNode) {
                    successMsg.remove();
                }
            }, 500);
        }, 3000);
    }
}

// Show error message
function showErrorMessage(message = 'An error occurred. Please try again.') {
    alert(message); // Simple fallback
    console.error(message);
}

// Save preferences function with AJAX
function savePreferences() {
    const prefToggle = document.getElementById('prefToggle');
    const analyticsToggle = document.getElementById('analyticsToggle');
    
    // Check if elements exist
    if (!prefToggle || !analyticsToggle) {
        console.warn('Toggle elements not found');
        return;
    }
    
    const preferences = {
        essential: true, // Always true
        preference: prefToggle.checked,
        analytics: analyticsToggle.checked,
        timestamp: new Date().toISOString()
    };
    
    // Show loading state
    const saveBtn = document.querySelector('.save-btn');
    if (!saveBtn) return;
    
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;
    
    // Save to localStorage as backup
    localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
    
    // Send to server via AJAX
    saveToServer(preferences)
        .then(response => {
            if (response.success) {
                showSuccessMessage();
                console.log('✅ Cookie preferences saved:', preferences);
                
                // Update cookie consent status
                updateCookieConsent(preferences);
            } else {
                throw new Error('Server error');
            }
        })
        .catch(error => {
            console.error('Error saving preferences:', error);
            showSuccessMessage('Preferences saved locally! (Server sync failed)');
        })
        .finally(() => {
            // Restore button
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        });
}

// Save preferences to server (simulated AJAX)
function saveToServer(preferences) {
    return new Promise((resolve, reject) => {
        // Simulate server request
        setTimeout(() => {
            // For demo, always succeed
            resolve({ success: true });
            
            // In production, use actual AJAX:
            /*
            fetch('/api/save-cookie-preferences.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(preferences)
            })
            .then(response => response.json())
            .then(data => resolve(data))
            .catch(error => reject(error));
            */
        }, 1000);
    });
}

// Load saved preferences on page load
function loadSavedPreferences() {
    const prefToggle = document.getElementById('prefToggle');
    const analyticsToggle = document.getElementById('analyticsToggle');
    
    if (!prefToggle || !analyticsToggle) return;
    
    // Check localStorage first
    const savedPrefs = localStorage.getItem('cookiePreferences');
    if (savedPrefs) {
        try {
            const prefs = JSON.parse(savedPrefs);
            prefToggle.checked = prefs.preference || false;
            analyticsToggle.checked = prefs.analytics || false;
        } catch (e) {
            console.error('Error loading saved preferences:', e);
        }
    }
    
    // Load from server (if logged in)
    loadFromServer();
}

// Load preferences from server
function loadFromServer() {
    // Simulate server request
    setTimeout(() => {
        // In production, use actual AJAX:
        /*
        fetch('/api/get-cookie-preferences.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('prefToggle').checked = data.preferences.preference;
                    document.getElementById('analyticsToggle').checked = data.preferences.analytics;
                }
            })
            .catch(error => console.error('Error loading from server:', error));
        */
    }, 500);
}

// Cookie preference toggle handlers
function setupToggleHandlers() {
    const prefToggle = document.getElementById('prefToggle');
    const analyticsToggle = document.getElementById('analyticsToggle');
    
    if (prefToggle) {
        prefToggle.addEventListener('change', function() {
            const status = this.checked ? 'enabled' : 'disabled';
            console.log(`Preference cookies ${status}`);
            
            // Optional: Apply preference changes immediately
            if (this.checked) {
                document.documentElement.lang = 'en'; // Example
            }
        });
    }
    
    if (analyticsToggle) {
        analyticsToggle.addEventListener('change', function() {
            const status = this.checked ? 'enabled' : 'disabled';
            console.log(`Analytics cookies ${status}`);
            
            // Optional: Enable/disable analytics tracking
            if (this.checked && typeof gtag !== 'undefined') {
                gtag('consent', 'update', {
                    'analytics_storage': 'granted'
                });
            }
        });
    }
}

// Check cookie consent status
function checkCookieConsent() {
    const hasConsent = localStorage.getItem('cookieConsent');
    if (!hasConsent) {
        // Show cookie consent banner if needed
        console.log('Cookie consent not given yet');
    }
}

// Update cookie consent
function updateCookieConsent(preferences) {
    localStorage.setItem('cookieConsent', 'true');
    localStorage.setItem('cookieConsentDate', new Date().toISOString());
}

// Highlight current page in navigation
function highlightCurrentPage() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref && linkHref.includes(currentPage)) {
            link.classList.add('active');
        }
    });
}

// Handle page visibility change (for analytics)
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        console.log('Page visible - resume analytics if enabled');
    } else {
        console.log('Page hidden - pause analytics if enabled');
    }
});

// Handle browser back/forward buttons
window.addEventListener('popstate', () => {
    // Refresh any dynamic content
    console.log('Navigation detected');
});

// Setup all event listeners
function setupEventListeners() {
    setupMobileMenu();
    setupSmoothScroll();
    setupExternalLinks();
    setupToggleHandlers();
}

// Export functions for global use
window.savePreferences = savePreferences;
window.showSuccessMessage = showSuccessMessage;

// Add keyboard shortcut for debugging (Ctrl+Shift+C to log preferences)
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.shiftKey && e.key === 'C') {
        const prefs = localStorage.getItem('cookiePreferences');
        console.log('Current preferences:', prefs ? JSON.parse(prefs) : 'None saved');
    }
});

// Handle offline/online status
window.addEventListener('online', () => {
    console.log('Back online - syncing preferences...');
    // Try to sync with server
    const savedPrefs = localStorage.getItem('cookiePreferences');
    if (savedPrefs) {
        saveToServer(JSON.parse(savedPrefs))
            .then(() => console.log('Sync successful'))
            .catch(() => console.log('Sync failed - will retry later'));
    }
});

window.addEventListener('offline', () => {
    console.log('Offline - preferences saved locally only');
});