// Contact Page Specific JavaScript

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Map
    initializeMap();
    
    // Initialize Contact Form
    initializeContactForm();
    
});

// Initialize Leaflet Map
function initializeMap() {
    // Check if map element exists
    const mapElement = document.getElementById('map');
    if (!mapElement) return;
    
    // Colombo coordinates
    const colomboLat = 6.9022;
    const colomboLng = 79.8612;
    
    // Create map
    const map = L.map('map').setView([colomboLat, colomboLng], 15);
    
    // Add tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Add marker for main hospital
    const marker = L.marker([colomboLat, colomboLng]).addTo(map);
    
    // Add popup with hospital info
    marker.bindPopup(`
        <div style="text-align: center; padding: 5px;">
            <h3 style="margin: 0 0 5px; color: #4f46e5;">ABC Hospital</h3>
            <p style="margin: 0; font-size: 12px;">123 Hospital Road, Colombo 05</p>
            <p style="margin: 5px 0 0; font-size: 12px; color: #666;">Tel: +94 11 234 5678</p>
        </div>
    `).openPopup();
    
    // Add markers for other branches
    const branches = [
        { lat: 6.9100, lng: 79.8712, name: 'Cinnamon Gardens', address: '45 Cinnamon Gardens, Colombo 07', phone: '+94 11 234 5789' },
        { lat: 6.8950, lng: 79.8512, name: 'Kollupitiya', address: '78 Galle Road, Kollupitiya', phone: '+94 11 234 5890' }
    ];
    
    branches.forEach(branch => {
        const branchMarker = L.marker([branch.lat, branch.lng]).addTo(map);
        branchMarker.bindPopup(`
            <div style="text-align: center; padding: 5px;">
                <h3 style="margin: 0 0 5px; color: #4f46e5;">${branch.name}</h3>
                <p style="margin: 0; font-size: 12px;">${branch.address}</p>
                <p style="margin: 5px 0 0; font-size: 12px; color: #666;">${branch.phone}</p>
            </div>
        `);
    });
}

// Initialize Contact Form
function initializeContactForm() {
    const contactForm = document.getElementById('contactForm');
    if (!contactForm) return;
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const firstName = document.getElementById('firstName').value.trim();
        const lastName = document.getElementById('lastName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value.trim();
        
        // Validate form
        if (!firstName || !lastName || !email || !subject || !message) {
            showFormMessage('Please fill in all required fields', 'error');
            return;
        }
        
        // Validate email format
        if (!isValidEmail(email)) {
            showFormMessage('Please enter a valid email address', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = contactForm.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            // Success message
            showFormMessage('Thank you for your message! We will get back to you within 24 hours.', 'success');
            
            // Reset form
            contactForm.reset();
            
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
        }, 1500);
    });
}

// Show form message
function showFormMessage(message, type) {
    // Check if form message element exists, if not create it
    let formMessage = document.getElementById('formMessage');
    
    if (!formMessage) {
        formMessage = document.createElement('div');
        formMessage.id = 'formMessage';
        formMessage.className = 'form-message';
        
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.appendChild(formMessage);
        }
    }
    
    formMessage.className = `form-message ${type}`;
    formMessage.textContent = message;
    formMessage.style.display = 'block';
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        formMessage.style.display = 'none';
    }, 5000);
}

// Email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Add CSS for form messages and animations
const style = document.createElement('style');
style.textContent = `
    .field-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        animation: slideIn 0.3s ease;
    }
    
    input.error, select.error, textarea.error {
        border-color: #dc3545 !important;
    }
    
    .form-message {
        margin-top: 20px;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
        animation: slideIn 0.3s ease;
    }
    
    .form-message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .form-message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;

document.head.appendChild(style);