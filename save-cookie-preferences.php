<?php
// save-cookie-preferences.php - Enhanced version
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

// Set JSON header
header('Content-Type: application/json');

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 0 in production

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'success' => false, 
        'message' => 'Method not allowed. Please use POST.'
    ]);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!$input) {
    http_response_code(400); // Bad Request
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid JSON input'
    ]);
    exit;
}

// Validate CSRF token (optional but recommended)
if (isset($input['csrf_token']) && !hash_equals($_SESSION['csrf_token'], $input['csrf_token'])) {
    http_response_code(403); // Forbidden
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid security token'
    ]);
    exit;
}

// Sanitize and validate input values
$preferences = [
    'preference' => isset($input['preference']) ? filter_var($input['preference'], FILTER_VALIDATE_BOOLEAN) : false,
    'analytics' => isset($input['analytics']) ? filter_var($input['analytics'], FILTER_VALIDATE_BOOLEAN) : false,
    'essential' => true, // Always true
    'last_updated' => date('Y-m-d H:i:s'),
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
];

// Save preferences to session
$_SESSION['cookie_preferences'] = $preferences;

// If user is logged in, save to database
$db_success = true;
if (function_exists('isLoggedIn') && isLoggedIn() && isset($_SESSION['user_id'])) {
    try {
        $saved = saveCookiePreferences($_SESSION['user_id'], $preferences);
        if (!$saved) {
            $db_success = false;
            error_log("Failed to save cookie preferences for user: " . $_SESSION['user_id']);
        }
    } catch (Exception $e) {
        $db_success = false;
        error_log("Database error saving cookie preferences: " . $e->getMessage());
    }
}

// Set actual cookies based on preferences
$cookie_domain = $_SERVER['HTTP_HOST'] ?? '';
$cookie_secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$cookie_httponly = true;
$cookie_samesite = 'Lax';

// Essential cookies are always set by the application separately
// These are preference-based cookies

// Handle Analytics cookies
if ($preferences['analytics']) {
    // Set analytics cookies (example with Google Analytics)
    $ga_cookie_options = [
        'expires' => time() + 63072000, // 2 years
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => $cookie_secure,
        'httponly' => false, // GA cookies need to be accessible by JS
        'samesite' => $cookie_samesite
    ];
    
    // Set Google Analytics cookies if not already set
    if (!isset($_COOKIE['_ga'])) {
        $client_id = uniqid('GA', true) . '.' . time();
        setcookie('_ga', 'GA1.1.' . $client_id, $ga_cookie_options);
    }
    
    // Log analytics consent
    error_log("Analytics cookies enabled for session: " . session_id());
} else {
    // Delete analytics cookies
    $cookies_to_delete = ['_ga', '_gid', '_gat', '_utm'];
    foreach ($cookies_to_delete as $cookie_name) {
        if (isset($_COOKIE[$cookie_name])) {
            setcookie($cookie_name, '', [
                'expires' => time() - 3600,
                'path' => '/',
                'domain' => $cookie_domain,
                'secure' => $cookie_secure,
                'httponly' => false,
                'samesite' => $cookie_samesite
            ]);
            unset($_COOKIE[$cookie_name]);
        }
    }
}

// Handle Preference cookies
if ($preferences['preference']) {
    // Set preference cookie (stores user preferences like language, theme)
    $pref_cookie_options = [
        'expires' => time() + 31536000, // 1 year
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => $cookie_secure,
        'httponly' => false,
        'samesite' => $cookie_samesite
    ];
    
    $pref_value = json_encode([
        'preferences_saved' => true,
        'version' => '1.0'
    ]);
    setcookie('user_preferences', $pref_value, $pref_cookie_options);
} else {
    // Delete preference cookie
    if (isset($_COOKIE['user_preferences'])) {
        setcookie('user_preferences', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => $cookie_domain,
            'secure' => $cookie_secure,
            'httponly' => false,
            'samesite' => $cookie_samesite
        ]);
        unset($_COOKIE['user_preferences']);
    }
}

// Prepare response
$response = [
    'success' => true,
    'message' => 'Cookie preferences saved successfully',
    'data' => [
        'preferences' => [
            'essential' => true,
            'preference' => $preferences['preference'],
            'analytics' => $preferences['analytics']
        ],
        'timestamp' => $preferences['last_updated'],
        'database_saved' => $db_success
    ]
];

// Add warning if database save failed but user is logged in
if (!$db_success && isLoggedIn()) {
    $response['warning'] = 'Preferences saved locally but not synced to your account';
}

// Log the action
error_log(sprintf(
    "Cookie preferences saved - Session: %s, User: %s, Analytics: %s, Preference: %s",
    session_id(),
    $_SESSION['user_id'] ?? 'guest',
    $preferences['analytics'] ? 'yes' : 'no',
    $preferences['preference'] ? 'yes' : 'no'
));

// Return success response
echo json_encode($response);
exit;