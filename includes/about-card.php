<?php
// includes/about-card.php
// This file contains reusable card components for the about page

function renderStatCard($icon, $number, $label, $delay = 0) {
    ?>
    <div class="stat-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="stat-icon">
            <i class="fas <?php echo $icon; ?>"></i>
        </div>
        <div class="stat-content">
            <span class="stat-number"><?php echo $number; ?></span>
            <span class="stat-label"><?php echo $label; ?></span>
        </div>
    </div>
    <?php
}

function renderFeatureCard($icon, $title, $description, $delay = 0) {
    ?>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="feature-icon">
            <i class="fas <?php echo $icon; ?>"></i>
        </div>
        <h3><?php echo $title; ?></h3>
        <p><?php echo $description; ?></p>
    </div>
    <?php
}

function renderTimelineItem($year, $event, $description, $position = 'left', $index = 0) {
    $side = ($index % 2 == 0) ? 'left' : 'right';
    ?>
    <div class="timeline-item <?php echo $side; ?>" data-aos="fade-<?php echo $side == 'left' ? 'right' : 'left'; ?>" data-aos-delay="<?php echo $index * 100; ?>">
        <div class="timeline-content">
            <span class="timeline-year"><?php echo $year; ?></span>
            <h3><?php echo $event; ?></h3>
            <p><?php echo $description; ?></p>
        </div>
    </div>
    <?php
}

function renderLeadershipCard($name, $position, $image, $bio, $delay = 0) {
    global $base_url;
    ?>
    <div class="leadership-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="leader-image">
            <img src="<?php echo $base_url; ?>/images/<?php echo $image; ?>" 
                 alt="<?php echo $name; ?>"
                 onerror="this.src='https://via.placeholder.com/300x300/4f46e5/ffffff?text=<?php echo substr($name, 0, 1); ?>';">
        </div>
        <div class="leader-info">
            <h3><?php echo $name; ?></h3>
            <p class="leader-position"><?php echo $position; ?></p>
            <p class="leader-bio"><?php echo $bio; ?></p>
            <div class="leader-social">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </div>
    <?php
}

function renderValueCard($icon, $title, $description, $delay = 0) {
    ?>
    <div class="value-card" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
        <div class="value-icon">
            <i class="fas <?php echo $icon; ?>"></i>
        </div>
        <h4><?php echo $title; ?></h4>
        <p><?php echo $description; ?></p>
    </div>
    <?php
}

function renderAwardCard($icon, $title, $year, $organization, $delay = 0) {
    ?>
    <div class="award-card" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
        <div class="award-icon">
            <i class="fas fa-<?php echo $icon; ?>"></i>
        </div>
        <div class="award-content">
            <h4><?php echo $title; ?></h4>
            <p class="award-year"><?php echo $year; ?></p>
            <p class="award-org"><?php echo $organization; ?></p>
        </div>
    </div>
    <?php
}
?>