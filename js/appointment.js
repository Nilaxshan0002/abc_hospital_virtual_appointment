// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Hide preloader after page loads
    setTimeout(function() {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }, 500);

    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
    }

    // Initialize flatpickr
    if (typeof flatpickr !== 'undefined' && document.querySelector('.date-picker')) {
        flatpickr(".date-picker", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: [
                function(date) {
                    // Disable Sundays
                    return date.getDay() === 0;
                }
            ],
            locale: {
                firstDayOfWeek: 1
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Update available time slots based on selected date
                updateTimeSlots(dateStr);
            }
        });
    }

    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }

    // Back to top button
    const backToTop = document.getElementById('backToTop');
    
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Close modal when clicking outside
    const modal = document.getElementById('successModal');
    if (modal) {
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('active')) {
                modal.classList.remove('active');
            }
        });
    }

    // Add floating label functionality
    const floatingInputs = document.querySelectorAll('.floating-label input, .floating-label textarea');
    floatingInputs.forEach(input => {
        // Check if input has value on load
        if (input.value) {
            input.classList.add('has-value');
        }

        // Add event listeners
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.classList.remove('has-value');
            }
        });
    });
});

// Doctor selection
function selectDoctor(element) {
    // Remove selected class from all doctors
    document.querySelectorAll('.doctor-card').forEach(function(card) {
        card.classList.remove('selected');
    });
    // Add selected class to clicked doctor
    element.classList.add('selected');
    
    // Add animation effect
    element.style.transform = 'scale(0.98)';
    setTimeout(() => {
        element.style.transform = '';
    }, 200);
}

// Time slot selection
function selectTimeSlot(element) {
    // Remove selected class from all time slots
    document.querySelectorAll('.time-slot').forEach(function(slot) {
        slot.classList.remove('selected');
    });
    // Add selected class to clicked time slot
    element.classList.add('selected');
    
    // Add animation effect
    element.style.transform = 'scale(0.95)';
    setTimeout(() => {
        element.style.transform = '';
    }, 200);
}

// Update time slots based on selected date
function updateTimeSlots(date) {
    const timeSlots = document.querySelectorAll('.time-slot');
    const day = new Date(date).getDay();
    
    // Example: Disable certain slots on weekends
    if (day === 6) { // Saturday
        timeSlots.forEach((slot, index) => {
            if (index < 3) { // Disable morning slots on Saturday
                slot.classList.add('disabled');
            } else {
                slot.classList.remove('disabled');
            }
        });
    } else {
        timeSlots.forEach(slot => {
            slot.classList.remove('disabled');
        });
    }
}

// Book appointment
function bookAppointment(event) {
    event.preventDefault();
    
    // Get form values
    const patientName = document.getElementById('patientName') ? document.getElementById('patientName').value : '';
    const phone = document.getElementById('phone') ? document.getElementById('phone').value : '';
    const email = document.getElementById('email') ? document.getElementById('email').value : '';
    const date = document.getElementById('appointmentDate') ? document.getElementById('appointmentDate').value : '';
    const consultationType = document.getElementById('consultationType') ? document.getElementById('consultationType').value : '';
    const selectedDoctor = document.querySelector('.doctor-card.selected .doctor-name') ? document.querySelector('.doctor-card.selected .doctor-name').textContent : 'Not selected';
    const selectedTime = document.querySelector('.time-slot.selected') ? document.querySelector('.time-slot.selected').textContent : 'Not selected';

    // Validate form
    if (!patientName || !phone || !email || !date || !consultationType) {
        showNotification('Please fill in all required fields', 'error');
        return false;
    }

    // Validate phone number (Sri Lankan format)
    const phoneRegex = /^(07[0-9]{8})$/;
    if (!phoneRegex.test(phone)) {
        showNotification('Please enter a valid Sri Lankan phone number (07XXXXXXXX)', 'error');
        return false;
    }

    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Please enter a valid email address', 'error');
        return false;
    }

    // Show success modal with animation
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.classList.add('active');
        
        // Add appointment details to modal (optional)
        const modalContent = modal.querySelector('.modal-content p');
        if (modalContent) {
            modalContent.innerHTML = `Your appointment with ${selectedDoctor} on ${date} at ${selectedTime} has been scheduled. We've sent a confirmation to ${email}.`;
        }
    }
    
    // Reset form with animation
    const form = document.getElementById('appointmentForm');
    if (form) {
        form.style.opacity = '0.5';
        form.reset();
        setTimeout(() => {
            form.style.opacity = '1';
        }, 500);
    }
    
    // Reset selected classes for doctor (select first doctor)
    document.querySelectorAll('.doctor-card').forEach(function(card, index) {
        if (index === 0) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
    });
    
    // Reset selected classes for time slot (select first time slot)
    document.querySelectorAll('.time-slot').forEach(function(slot, index) {
        if (index === 0) {
            slot.classList.add('selected');
        } else {
            slot.classList.remove('selected');
        }
    });
    
    // Remove floating label classes
    document.querySelectorAll('.floating-label input, .floating-label textarea').forEach(input => {
        input.classList.remove('has-value');
    });
    
    return false;
}

// Show notification (for validation errors)
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
        <span>${message}</span>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'error' ? '#ff6b6b' : '#4f46e5'};
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 1002;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease;
        font-weight: 500;
    `;
    
    // Add animation keyframes if not exists
    if (!document.querySelector('#notificationStyles')) {
        const style = document.createElement('style');
        style.id = 'notificationStyles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Close modal
function closeModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

// Smooth scroll to section
function scrollToSection(sectionId) {
    const section = document.querySelector(sectionId);
    if (section) {
        section.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}