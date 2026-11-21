<?php
// cookie-policy.php - FINAL FIXED VERSION WITH ENHANCEMENTS
error_reporting(E_ALL);
ini_set('display_errors', 1);

// REMOVED session_start() from here - it will be handled in header with check

// Set base_url - EMPTY for localhost
$base_url = '';

$pageTitle = "ABC Virtual Healthcare | Cookie Policy";
$pageDescription = "Professional, clear and patient-centric cookie policy for ABC Hospital.";

// Include header with full path
include __DIR__ . '/includes/header01.php';

// Optional: Include functions if needed
// include __DIR__ . '/includes/functions.php';
?>

<!-- Page Header -->
<header class="page-header">
    <img class="header-image" src="images/cookie-policy.png" alt="Cookie Policy" onerror="this.style.display='none'">
    <div class="container">
        <div class="breadcrumb" data-aos="fade-up">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Cookie Policy</span>
        </div>
        
        <h1 data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-cookie-bite"></i> 
            Cookie & Data Trust
        </h1>
        
        <p class="header-tagline" data-aos="fade-up" data-aos-delay="200">
            Clear, professional and patient-first — we explain every byte
        </p>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="content-card" data-aos="fade-up">
        <!-- Last Updated Badge -->
        <div class="last-updated">
            <i class="fas fa-calendar-check"></i> 
            Policy Revised: <?php echo date('F j, Y', strtotime('2026-02-22')); ?> · Colombo, Sri Lanka
        </div>

        <!-- Image Cards -->
        <div class="img-grid">
            <!-- Card 1: Essential Cookies -->
            <div class="img-card" data-aos="zoom-in" data-aos-delay="100">
                <img src="images/essential-cookies.png" 
                    alt="Essential Cookies" 
                    loading="lazy"
                    onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Essential+Cookies';">
                <p><i class="fas fa-lock"></i> Essential Cookies</p>
            </div>
            
            <!-- Card 2: Anonymous Stats -->
            <div class="img-card" data-aos="zoom-in" data-aos-delay="200">
                <img src="images/analytics.jpg" 
                    alt="Anonymous Stats" 
                    loading="lazy"
                    onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Anonymous+Stats';">
                <p><i class="fas fa-chart-line"></i> Anonymous Stats</p>
            </div>
            
            <!-- Card 3: Your Choices -->
            <div class="img-card" data-aos="zoom-in" data-aos-delay="300">
                <img src="images/preferences.webp" 
                    alt="Your Choices" 
                    loading="lazy"
                    onerror="this.src='https://via.placeholder.com/130x130/4f46e5/ffffff?text=Your+Choices';">
                <p><i class="fas fa-sliders-h"></i> Your Choices</p>
            </div>
        </div>

        <!-- Table of Contents -->
        <div class="toc" data-aos="fade-up">
            <h3><i class="fas fa-list-ul"></i> On This Page</h3>
            <div class="toc-grid">
                <?php
                $toc_items = [
                    ['href' => '#what-are-cookies', 'text' => '1. What are Cookies?'],
                    ['href' => '#categories', 'text' => '2. Cookie Categories'],
                    ['href' => '#essential', 'text' => '3. Essential Cookies'],
                    ['href' => '#preferences', 'text' => '4. Your Preferences'],
                    ['href' => '#browser', 'text' => '5. Browser Controls'],
                    ['href' => '#contact', 'text' => '6. Contact']
                ];
                
                foreach ($toc_items as $item): 
                ?>
                <div class="toc-item">
                    <a href="<?php echo $item['href']; ?>">
                        <i class="fas fa-chevron-right"></i> <?php echo $item['text']; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- What are Cookies Section -->
        <h2 id="what-are-cookies"><i class="fas fa-binoculars"></i> 1. What are Cookies?</h2>
        <p>Cookies are small text files stored on your device when you visit our website. They help us remember your preferences and improve your experience. Some cookies are essential for the website to function properly, while others help us understand how visitors interact with our site.</p>

        <!-- Cookie Categories -->
        <h2 id="categories"><i class="fas fa-layer-group"></i> 2. Cookie Categories</h2>
        
        <table class="cookie-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Purpose</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $categories = [
                    ['category' => 'Essential', 'purpose' => 'Login, security, session management', 'duration' => 'Session'],
                    ['category' => 'Preference', 'purpose' => 'Language, region, accessibility', 'duration' => '1 year'],
                    ['category' => 'Analytics', 'purpose' => 'Anonymous usage data', 'duration' => '2 years']
                ];
                
                foreach ($categories as $cat): 
                ?>
                <tr>
                    <td><strong><?php echo $cat['category']; ?></strong></td>
                    <td><?php echo $cat['purpose']; ?></td>
                    <td><?php echo $cat['duration']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Essential Cookies -->
        <h2 id="essential"><i class="fas fa-lock"></i> 3. Essential Cookies</h2>
        
        <table class="cookie-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Purpose</th>
                    <th>Expiry</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $essential_cookies = [
                    ['name' => 'PHPSESSID', 'purpose' => 'Session identifier - keeps you logged in', 'expiry' => 'Session'],
                    ['name' => 'csrf_token', 'purpose' => 'Security - prevents fraud', 'expiry' => 'Session']
                ];
                
                foreach ($essential_cookies as $cookie): 
                ?>
                <tr>
                    <td><code><?php echo $cookie['name']; ?></code></td>
                    <td><?php echo $cookie['purpose']; ?></td>
                    <td><?php echo $cookie['expiry']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Your Preferences -->
        <h2 id="preferences"><i class="fas fa-sliders-up"></i> 4. Your Cookie Preferences</h2>
        <p>Use the toggles below to manage your cookie preferences. Essential cookies remain active for security and core functionality. Your choices will be saved for future visits.</p>

        <div class="toggle-panel">
            <span class="toggle-label">
                <i class="fas fa-lock"></i> 
                Essential cookies <span class="badge required">(required)</span>
            </span>
            <label class="switch">
                <input type="checkbox" checked disabled aria-label="Essential cookies (required)">
                <span class="slider"></span>
            </label>
        </div>

        <div class="toggle-panel">
            <span class="toggle-label">
                <i class="fas fa-paint-brush"></i> 
                Preference cookies
            </span>
            <label class="switch">
                <input type="checkbox" checked id="prefToggle" aria-label="Preference cookies">
                <span class="slider"></span>
            </label>
        </div>

        <div class="toggle-panel">
            <span class="toggle-label">
                <i class="fas fa-chart-line"></i> 
                Analytics cookies
            </span>
            <label class="switch">
                <input type="checkbox" id="analyticsToggle" aria-label="Analytics cookies">
                <span class="slider"></span>
            </label>
        </div>

        <div class="button-group">
            <button class="save-btn" onclick="savePreferences()">
                <i class="fas fa-save"></i> Save Preferences
            </button>
            <button class="reset-btn" onclick="resetPreferences()" style="display: none;">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>

        <!-- Browser Controls -->
        <h2 id="browser"><i class="fas fa-browser"></i> 5. Browser Controls</h2>
        <p>You can also manage cookies through your browser settings. Here's how to control cookies in popular browsers:</p>
        
        <div class="browser-grid">
            <?php
            $browsers = [
                ['icon' => 'chrome', 'color' => '#2563eb', 'name' => 'Chrome', 'steps' => 'Settings → Privacy and security → Cookies'],
                ['icon' => 'firefox', 'color' => '#f16b2b', 'name' => 'Firefox', 'steps' => 'Options → Privacy & Security → Cookies'],
                ['icon' => 'safari', 'color' => '#1877f2', 'name' => 'Safari', 'steps' => 'Preferences → Privacy → Manage cookies'],
                ['icon' => 'edge', 'color' => '#0078d7', 'name' => 'Edge', 'steps' => 'Settings → Cookies and site permissions']
            ];
            
            foreach ($browsers as $browser): 
            ?>
            <div class="browser-item">
                <i class="fab fa-<?php echo $browser['icon']; ?>" style="color: <?php echo $browser['color']; ?>; font-size: 2rem;"></i>
                <div>
                    <strong><?php echo $browser['name']; ?>:</strong>
                    <span><?php echo $browser['steps']; ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Contact Section -->
        <h2 id="contact"><i class="fas fa-address-card"></i> 6. Contact Our Data Officer</h2>
        
        <div class="contact-info">
            <ul>
                <?php
                $contacts = [
                    ['icon' => 'envelope', 'label' => 'Email', 'value' => 'privacy@abchospital.lk', 'link' => 'mailto:privacy@abchospital.lk'],
                    ['icon' => 'phone-alt', 'label' => 'Phone', 'value' => '+94 11 234 5678', 'note' => '(Mon-Fri, 9am-5pm)'],
                    ['icon' => 'map-marker-alt', 'label' => 'Address', 'value' => 'ABC Hospital, Colombo 05, Sri Lanka']
                ];
                
                foreach ($contacts as $contact): 
                ?>
                <li>
                    <i class="fas fa-<?php echo $contact['icon']; ?>"></i>
                    <div class="contact-details">
                        <strong><?php echo $contact['label']; ?>:</strong>
                        <?php if (isset($contact['link'])): ?>
                            <a href="<?php echo $contact['link']; ?>" class="contact-link"><?php echo $contact['value']; ?></a>
                        <?php else: ?>
                            <span><?php echo $contact['value']; ?></span>
                        <?php endif; ?>
                        <?php if (isset($contact['note'])): ?>
                            <small><?php echo $contact['note']; ?></small>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Social Media Connect Section -->
        <div class="social-connect" data-aos="zoom-in">
            <h3><i class="fas fa-share-alt"></i> Connect With Us</h3>
            <p>Follow us on social media for health tips, updates, and community news</p>
            <div class="social-grid">
                <?php
                $socials = [
                    ['url' => 'https://www.facebook.com/abchospital', 'icon' => 'facebook-f', 'name' => 'Facebook'],
                    ['url' => 'https://www.twitter.com/abchospital', 'icon' => 'twitter', 'name' => 'Twitter'],
                    ['url' => 'https://www.linkedin.com/company/abchospital', 'icon' => 'linkedin-in', 'name' => 'LinkedIn'],
                    ['url' => 'https://www.instagram.com/abchospital', 'icon' => 'instagram', 'name' => 'Instagram'],
                    ['url' => 'https://www.youtube.com/abchospital', 'icon' => 'youtube', 'name' => 'YouTube']
                ];
                
                foreach ($socials as $social): 
                ?>
                <a href="<?php echo $social['url']; ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="social-circle"
                   aria-label="Visit our <?php echo $social['name']; ?> page">
                    <i class="fab fa-<?php echo $social['icon']; ?>"></i>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Trust Badge -->
        <div class="trust-badge">
            <img src="images/ABC+trust+badge.jpg" 
                 alt="ABC Hospital Trust Badge" 
                 loading="lazy"
                 onerror="this.style.display='none'">
            <p>
                <i class="fas fa-check-circle" style="color:#4f46e5;"></i> 
                Last Updated: <?php echo date('F j, Y', strtotime('2026-02-22')); ?>
            </p>
        </div>
    </div>
</div>

<?php 
// Include footer
include __DIR__ . '/includes/footer01.php';

// Include schema markup separately for better code organization and VS Code syntax highlighting
include __DIR__ . '/includes/schema/cookie-policy-schema.php';
?>