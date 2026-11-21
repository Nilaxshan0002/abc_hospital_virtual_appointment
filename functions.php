<?php
// functions.php
require_once __DIR__ . '/config.php';

// Sanitize input data
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to page
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

// Get current page name
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

// Set active class for navigation
function setActive($page) {
    $current = getCurrentPage();
    return $current == $page ? 'active' : '';
}

// Save cookie preferences
function saveCookiePreferences($userId, $preferences) {
    $conn = getConnection();
    if ($conn) {
        $pref = $conn->real_escape_string(json_encode($preferences));
        $sql = "INSERT INTO user_preferences (user_id, cookie_preferences, updated_at) 
                VALUES ('$userId', '$pref', NOW())
                ON DUPLICATE KEY UPDATE 
                cookie_preferences = '$pref', updated_at = NOW()";
        return $conn->query($sql);
    }
    return false;
}

// Get cookie preferences
function getCookiePreferences($userId) {
    $conn = getConnection();
    if ($conn) {
        $sql = "SELECT cookie_preferences FROM user_preferences WHERE user_id = '$userId'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return json_decode($result->fetch_assoc()['cookie_preferences'], true);
        }
    }
    return [
        'essential' => true,
        'preference' => false,
        'analytics' => false
    ];
}

// Display flash messages
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        
        return "<div class='alert alert-$type'>$message</div>";
    }
    return '';
}

// Format date
function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

// Generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}