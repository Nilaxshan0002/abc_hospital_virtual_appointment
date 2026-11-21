// js/doctors.js

// Doctor Filter Functionality
class DoctorFilter {
    constructor() {
        this.form = document.getElementById('filterForm');
        this.specialty = document.getElementById('specialty');
        this.experience = document.getElementById('experience');
        this.search = document.getElementById('search');
        this.container = document.getElementById('doctorsContainer');
        this.resetBtn = document.getElementById('resetBtn');
        this.visibleCountEl = document.getElementById('visibleCount');
        this.totalCountEl = document.getElementById('totalCount');
        
        this.loadingSpinner = this.createLoadingSpinner();
        this.noResults = this.createNoResults();
        this.debounceTimer = null;
        
        // Store original doctor cards
        this.originalCards = [];
        this.storeOriginalCards();
        
        this.init();
    }
    
    storeOriginalCards() {
        if (this.container) {
            this.originalCards = Array.from(this.container.children);
            // Update total count if element exists
            if (this.totalCountEl) {
                this.totalCountEl.textContent = this.originalCards.length;
            }
        }
    }
    
    init() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.filterDoctors();
            });
        }
        
        // Real-time search with debounce
        if (this.search) {
            this.search.addEventListener('input', () => {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => {
                    this.filterDoctors();
                }, 500);
            });
        }
        
        // Filter on select change
        if (this.specialty) {
            this.specialty.addEventListener('change', () => {
                this.filterDoctors();
                this.toggleResetButton();
            });
        }
        
        if (this.experience) {
            this.experience.addEventListener('change', () => {
                this.filterDoctors();
                this.toggleResetButton();
            });
        }
        
        // Add input event for search to show reset button
        if (this.search) {
            this.search.addEventListener('keyup', () => {
                this.toggleResetButton();
            });
        }
        
        // Initialize reset button if it exists
        if (this.resetBtn) {
            this.resetBtn.addEventListener('click', () => this.resetFilters());
        }
        
        // Initialize AOS refresh after images load
        window.addEventListener('load', () => {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    }
    
    toggleResetButton() {
        if (!this.resetBtn) return;
        
        const hasFilters = (
            (this.specialty && this.specialty.value) ||
            (this.experience && this.experience.value) ||
            (this.search && this.search.value.trim() !== '')
        );
        
        this.resetBtn.style.display = hasFilters ? 'inline-flex' : 'none';
    }
    
    createLoadingSpinner() {
        const spinner = document.createElement('div');
        spinner.className = 'loading-spinner';
        spinner.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i><p>Loading doctors...</p>';
        return spinner;
    }
    
    createNoResults() {
        const noResults = document.createElement('div');
        noResults.className = 'no-results';
        noResults.innerHTML = `
            <i class="fas fa-user-md"></i>
            <h3>No Doctors Found</h3>
            <p>Try adjusting your filters or search criteria</p>
            <button class="btn-reset" onclick="doctorFilter.resetFilters()">
                <i class="fas fa-undo"></i> Reset Filters
            </button>
        `;
        return noResults;
    }
    
    filterDoctors() {
        const filters = {
            specialty: this.specialty ? this.specialty.value.toLowerCase() : '',
            experience: this.experience ? this.experience.value : '',
            search: this.search ? this.search.value.toLowerCase().trim() : ''
        };
        
        // Show loading
        this.container.innerHTML = '';
        this.container.appendChild(this.loadingSpinner);
        
        // Simulate loading delay (remove this in production with real AJAX)
        setTimeout(() => {
            this.applyFilters(filters);
        }, 300);
    }
    
    applyFilters(filters) {
        // Filter the cards
        const filteredCards = this.originalCards.filter(card => {
            return this.matchesFilters(card, filters);
        });
        
        // Clear container
        this.container.innerHTML = '';
        
        // Show results or no results message
        if (filteredCards.length === 0) {
            const noResultsClone = this.noResults.cloneNode(true);
            this.container.appendChild(noResultsClone);
        } else {
            filteredCards.forEach(card => {
                // Reset display style
                card.style.display = 'block';
                this.container.appendChild(card);
            });
            
            // Refresh AOS for new cards
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        }
        
        // Update visible count
        this.updateVisibleCount(filteredCards.length);
    }
    
    matchesFilters(card, filters) {
        // Safely get elements with null checks
        const nameEl = card.querySelector('h3');
        const specialtyEl = card.querySelector('.doctor-specialty');
        const qualificationsEl = card.querySelector('.doctor-qualifications');
        const experienceEl = card.querySelector('.stat-value');
        
        if (!nameEl || !specialtyEl || !qualificationsEl || !experienceEl) return false;
        
        const name = nameEl.textContent.toLowerCase();
        const specialty = specialtyEl.textContent.toLowerCase();
        const qualifications = qualificationsEl.textContent.toLowerCase();
        const experience = parseInt(experienceEl.textContent) || 0;
        
        // Search filter - check name, specialty, and qualifications
        if (filters.search) {
            const searchMatch = name.includes(filters.search) || 
                              specialty.includes(filters.search) ||
                              qualifications.includes(filters.search);
            if (!searchMatch) return false;
        }
        
        // Specialty filter
        if (filters.specialty) {
            const specialtyMatch = specialty.includes(filters.specialty.replace('-', ' '));
            if (!specialtyMatch) return false;
        }
        
        // Experience filter
        if (filters.experience) {
            if (experience < parseInt(filters.experience)) return false;
        }
        
        return true;
    }
    
    updateVisibleCount(count) {
        if (this.visibleCountEl) {
            this.visibleCountEl.textContent = count;
        }
    }
    
    resetFilters() {
        // Reset all filter inputs
        if (this.specialty) this.specialty.value = '';
        if (this.experience) this.experience.value = '';
        if (this.search) this.search.value = '';
        
        // Hide reset button
        if (this.resetBtn) {
            this.resetBtn.style.display = 'none';
        }
        
        // Apply filters (which will show all doctors)
        this.filterDoctors();
    }
    
    // Method to load more doctors (for pagination)
    loadMoreDoctors(page = 1) {
        // This would be implemented with AJAX to load more doctors from server
        console.log('Loading more doctors, page:', page);
        alert('Load more functionality coming soon!');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Make doctorFilter globally available for reset button
    window.doctorFilter = new DoctorFilter();
    
    // Animate stats on scroll
    const stats = document.querySelectorAll('.stat-item .stat-number');
    if (stats.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateValue(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5, rootMargin: '50px' });
        
        stats.forEach(stat => observer.observe(stat));
    }
    
    function animateValue(element) {
        const value = element.textContent;
        const numericValue = parseInt(value);
        
        if (!isNaN(numericValue)) {
            let start = 0;
            const duration = 1500;
            const increment = numericValue / (duration / 16);
            const originalText = element.textContent;
            
            const timer = setInterval(() => {
                start += increment;
                if (start >= numericValue) {
                    element.textContent = originalText;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start) + '+';
                }
            }, 16);
        }
    }
    
    // Handle image errors
    document.querySelectorAll('.doctor-image img').forEach(img => {
        img.addEventListener('error', function() {
            const name = this.alt || 'Doctor';
            this.src = 'https://via.placeholder.com/300x250/4f46e5/ffffff?text=' + encodeURIComponent(name);
            this.onerror = null; // Prevent infinite loop
        });
    });
    
    // Add smooth hover effects
    const doctorCards = document.querySelectorAll('.doctor-profile-card');
    doctorCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
        });
    });
});