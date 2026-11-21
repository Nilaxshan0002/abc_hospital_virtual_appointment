// Initialize AOS
AOS.init({
    duration: 1000,
    once: true,
    offset: 100
});

// Mobile menu toggle
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');

if (navToggle) {
    navToggle.addEventListener('click', () => {
        navToggle.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
}

// Back to top button
const backToTop = document.getElementById('backToTop');

if (backToTop) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.style.display = 'flex';
        } else {
            backToTop.style.display = 'none';
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Set minimum date for date picker
const dateInput = document.getElementById('preferredDate');
if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
}

// Form submission
function submitScanBooking(event) {
    event.preventDefault();
    
    // Get form data
    const formData = {
        name: document.getElementById('fullName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        scanType: document.getElementById('scanType').options[document.getElementById('scanType').selectedIndex].text,
        date: document.getElementById('preferredDate').value,
        time: document.getElementById('preferredTime').value,
        doctor: document.getElementById('doctor').value,
        notes: document.getElementById('notes').value
    };
    
    // Show success message
    alert(`Thank you ${formData.name}! Your ${formData.scanType} appointment has been booked for ${formData.date} at ${formData.time}. We will contact you shortly for confirmation.`);
    
    // Reset form
    event.target.reset();
}

// FAQ Toggle
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    faqItem.classList.toggle('active');
}

// Preloader
window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

console.log('Book Scan.js loaded successfully');