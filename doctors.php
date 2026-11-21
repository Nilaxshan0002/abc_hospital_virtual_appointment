<?php
// doctors.php - MAIN FILE

// Include constants first (sets up all paths and variables)
require_once __DIR__ . '/config/constants-doctors.php';

// Include doctor data (now $specialties and $experience_levels are available)
require_once __DIR__ . '/data/doctors.php';

// Page specific variables
$pageTitle = "Our Expert Doctors";
$metaDescription = "Meet our team of highly qualified medical professionals at ABC Virtual Healthcare";

// Get total doctor count
$totalDoctors = count($doctors);

// Include header
include __DIR__ . '/includes/header-doctors.php';
?>

<body>
    <!-- Include navigation - This will show the navbar with proper buttons -->
    <?php include __DIR__ . '/includes/navigation-doctors.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 data-aos="fade-up">Our Expert Doctors</h1>
            <p data-aos="fade-up" data-aos-delay="100">Meet our team of <?php echo $totalDoctors; ?> highly qualified medical professionals dedicated to your health</p>
        </div>
    </section>

    <!-- Doctors Grid Section -->
    <section class="doctors-grid">
        <div class="container">
            <!-- Filter Section -->
            <div class="filter-section" data-aos="fade-up">
                <form class="filter-form" id="filterForm">
                    <div class="filter-group">
                        <select id="specialty" name="specialty">
                            <option value="">All Specialties</option>
                            <?php foreach ($specialties as $key => $value): ?>
                                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($value); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <select id="experience" name="experience">
                            <option value="">Any Experience</option>
                            <?php foreach ($experience_levels as $years => $label): ?>
                                <option value="<?php echo htmlspecialchars($years); ?>"><?php echo htmlspecialchars($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <input type="text" id="search" name="search" placeholder="Search by name or specialty...">
                    </div>
                    
                    <div class="filter-group">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search"></i> Filter Doctors
                        </button>
                    </div>
                    
                    <div class="filter-group">
                        <button type="button" class="btn-reset" id="resetBtn" style="display: none;">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
                
                <!-- Results count -->
                <div class="filter-results" id="filterResults">
                    <span>Showing <strong id="visibleCount"><?php echo $totalDoctors; ?></strong> of <strong id="totalCount"><?php echo $totalDoctors; ?></strong> doctors</span>
                </div>
            </div>

            <!-- Doctors Container -->
            <div class="doctors-container" id="doctorsContainer">
                <?php 
                $delay = 0;
                foreach ($doctors as $doctor): 
                ?>
                    <?php include __DIR__ . '/includes/doctor-card.php'; ?>
                <?php 
                    $delay += 100;
                    if ($delay > 200) $delay = 0;
                endforeach; 
                ?>
            </div>
            
            <!-- Load More Button (optional) -->
            <?php if ($totalDoctors > 6): ?>
            <div class="load-more-container">
                <button class="btn-load-more" id="loadMoreBtn">
                    <i class="fas fa-spinner"></i> Load More Doctors
                </button>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-aos="fade-up">
                    <div class="stat-number"><?php echo $totalDoctors; ?>+</div>
                    <div class="stat-label">Expert Doctors</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Care</div>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Patient Satisfaction</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Simple filter functionality -->
    <script>
    // Simple filter functionality for doctors page
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const specialtyFilter = document.getElementById('specialty');
        const experienceFilter = document.getElementById('experience');
        const searchFilter = document.getElementById('search');
        const resetBtn = document.getElementById('resetBtn');
        const visibleCountSpan = document.getElementById('visibleCount');
        const totalCount = <?php echo $totalDoctors; ?>;
        const doctorCards = document.querySelectorAll('.doctor-profile-card');
        
        function filterDoctors() {
            const specialty = specialtyFilter.value.toLowerCase();
            const experience = experienceFilter.value;
            const search = searchFilter.value.toLowerCase();
            
            let visibleCount = 0;
            
            doctorCards.forEach(card => {
                const cardSpecialty = card.querySelector('.doctor-specialty').textContent.toLowerCase();
                const cardName = card.querySelector('h3').textContent.toLowerCase();
                const cardQualifications = card.querySelector('.doctor-qualifications').textContent.toLowerCase();
                const cardExperience = card.querySelector('.stat-value').textContent.replace('+', '');
                
                let specialtyMatch = true;
                let experienceMatch = true;
                let searchMatch = true;
                
                if (specialty && specialty !== 'all specialties') {
                    specialtyMatch = cardSpecialty.includes(specialty);
                }
                
                if (experience) {
                    const expYears = parseInt(cardExperience);
                    if (experience === '0-5') experienceMatch = expYears <= 5;
                    else if (experience === '6-10') experienceMatch = expYears >= 6 && expYears <= 10;
                    else if (experience === '11-15') experienceMatch = expYears >= 11 && expYears <= 15;
                    else if (experience === '15+') experienceMatch = expYears >= 15;
                }
                
                if (search) {
                    searchMatch = cardName.includes(search) || 
                                 cardSpecialty.includes(search) || 
                                 cardQualifications.includes(search);
                }
                
                if (specialtyMatch && experienceMatch && searchMatch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            visibleCountSpan.textContent = visibleCount;
            
            // Show/hide reset button
            if (specialty || experience || search) {
                resetBtn.style.display = 'flex';
            } else {
                resetBtn.style.display = 'none';
            }
        }
        
        function resetFilters() {
            specialtyFilter.value = '';
            experienceFilter.value = '';
            searchFilter.value = '';
            filterDoctors();
        }
        
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            filterDoctors();
        });
        
        resetBtn.addEventListener('click', resetFilters);
        
        // Initial filter call to set correct counts
        filterDoctors();
    });
    </script>

    <?php
    // Include footer
    include __DIR__ . '/includes/footer-doctors.php';
    ?>
</body>
</html>