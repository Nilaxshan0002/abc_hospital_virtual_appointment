<?php
session_start();
$pageTitle = "Book Appointment - ABC Virtual Healthcare";
$base_url = '/abc_hospital_virtual_appointment'; // Adjust this to your actual path
include 'includes/header-app.php';
include 'includes/navigation-app.php';
?>

<!-- Page Header with Blue Mixed Colors -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content" data-aos="fade-up">
            <h1>Book Your <span class="text-gradient">Appointment</span></h1>
            <p>Schedule your visit with our expert doctors. Choose your preferred doctor, date, and time.</p>
            <div class="breadcrumb">
                <a href="<?php echo $base_url; ?>/index.php">Home</a> / <span>Appointments</span>
            </div>
        </div>
    </div>
    <!-- Straight line design instead of wave -->
    <div class="header-straight-line"></div>
</section>

<!-- Main Appointment Section -->
<section class="appointment-main">
    <div class="container">
        <!-- Booking Container -->
        <div class="booking-container" data-aos="fade-up">
            <!-- Doctor Selection Panel -->
            <div class="doctor-panel">
                <h2><i class="fas fa-user-md"></i> Select Doctor</h2>
                <div class="doctor-list" id="doctorList">
                    <!-- Doctor 1 -->
                    <div class="doctor-card selected" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Kamal Perera</div>
                        <div class="doctor-specialty">Cardiologist</div>
                        <div class="doctor-experience">15+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge available"><i class="fas fa-clock"></i> Available Today</span>
                        </div>
                    </div>

                    <!-- Doctor 2 -->
                    <div class="doctor-card" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Priyani Silva</div>
                        <div class="doctor-specialty">Neurologist</div>
                        <div class="doctor-experience">12+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge tomorrow"><i class="fas fa-clock"></i> Available Tomorrow</span>
                        </div>
                    </div>

                    <!-- Doctor 3 -->
                    <div class="doctor-card" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Nuwan Fernando</div>
                        <div class="doctor-specialty">Orthopedic Surgeon</div>
                        <div class="doctor-experience">10+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge available"><i class="fas fa-clock"></i> Available Today</span>
                        </div>
                    </div>

                    <!-- Doctor 4 -->
                    <div class="doctor-card" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Malini Dissanayake</div>
                        <div class="doctor-specialty">Pediatrician</div>
                        <div class="doctor-experience">18+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge available"><i class="fas fa-clock"></i> Available Today</span>
                        </div>
                    </div>

                    <!-- Doctor 5 -->
                    <div class="doctor-card" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Sanjay Rathnayake</div>
                        <div class="doctor-specialty">Dermatologist</div>
                        <div class="doctor-experience">8+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge tomorrow"><i class="fas fa-clock"></i> Available Tomorrow</span>
                        </div>
                    </div>

                    <!-- Doctor 6 -->
                    <div class="doctor-card" onclick="selectDoctor(this)">
                        <div class="doctor-name">Dr. Thusitha Jayawardena</div>
                        <div class="doctor-specialty">General Physician</div>
                        <div class="doctor-experience">20+ years experience</div>
                        <div class="doctor-availability">
                            <span class="availability-badge available"><i class="fas fa-clock"></i> Available Today</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form Panel -->
            <div class="booking-panel">
                <h2><i class="fas fa-calendar-alt"></i> Appointment Details</h2>
                
                <form id="appointmentForm" onsubmit="return bookAppointment(event)">
                    <div class="form-group floating-label">
                        <input type="text" id="patientName" required>
                        <label for="patientName">Patient Full Name</label>
                    </div>

                    <div class="form-row">
                        <div class="form-group floating-label">
                            <input type="tel" id="phone" required>
                            <label for="phone">Phone Number</label>
                        </div>
                        <div class="form-group floating-label">
                            <input type="email" id="email" required>
                            <label for="email">Email Address</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group floating-label">
                            <input type="text" id="appointmentDate" class="date-picker" required>
                            <label for="appointmentDate">Appointment Date</label>
                        </div>
                        <div class="form-group">
                            <select id="consultationType" required>
                                <option value="" disabled selected>Select Consultation Type</option>
                                <option value="physical">Physical Visit</option>
                                <option value="video">Video Consultation</option>
                                <option value="phone">Phone Consultation</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Time Slot</label>
                        <div class="time-slots" id="timeSlots">
                            <div class="time-slot selected" onclick="selectTimeSlot(this)">09:00 AM</div>
                            <div class="time-slot" onclick="selectTimeSlot(this)">10:00 AM</div>
                            <div class="time-slot" onclick="selectTimeSlot(this)">11:00 AM</div>
                            <div class="time-slot" onclick="selectTimeSlot(this)">02:00 PM</div>
                            <div class="time-slot" onclick="selectTimeSlot(this)">03:00 PM</div>
                            <div class="time-slot" onclick="selectTimeSlot(this)">04:00 PM</div>
                        </div>
                    </div>

                    <div class="form-group floating-label">
                        <textarea id="reason" rows="4"></textarea>
                        <label for="reason">Reason for Visit (Optional)</label>
                    </div>

                    <button type="submit" class="btn-book">
                        <i class="fas fa-calendar-check"></i> Confirm Appointment
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="quick-actions">
            <div class="quick-action-card" onclick="window.location.href='<?php echo $base_url; ?>/pages/login.php?type=patient'">
                <i class="fas fa-user"></i>
                <h3>Patient Portal</h3>
                <p>View your appointments</p>
            </div>
            <div class="quick-action-card" onclick="window.location.href='<?php echo $base_url; ?>/doctors.php'">
                <i class="fas fa-stethoscope"></i>
                <h3>Find Doctors</h3>
                <p>Browse specialists</p>
            </div>
            <div class="quick-action-card" onclick="window.location.href='<?php echo $base_url; ?>/departments.php'">
                <i class="fas fa-building"></i>
                <h3>Departments</h3>
                <p>View all departments</p>
            </div>
            <div class="quick-action-card" onclick="window.location.href='<?php echo $base_url; ?>/contact.php'">
                <i class="fas fa-headset"></i>
                <h3>Need Help?</h3>
                <p>Contact support</p>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal" id="successModal">
    <div class="modal-content">
        <i class="fas fa-check-circle"></i>
        <h2>Appointment Booked!</h2>
        <p>Your appointment has been successfully scheduled. We've sent a confirmation to your email.</p>
        <button class="btn" onclick="closeModal()">OK</button>
    </div>
</div>

<!-- Add this style block for logo colors -->
<style>
    /* Logo text colors */
    .logo-text {
        color: #000000 !important; /* Black color for ABC */
    }
    .text-highlight {
        color: #90EE90 !important; /* Light green color for VIRTUAL */
    }
</style>

<?php
include 'includes/footer-app.php';
?>