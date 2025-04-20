<?php
session_start();
require_once 'DatabaseHelper.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Set timezone to IST
date_default_timezone_set('Asia/Kolkata');

// Get user's login history
$db = new DatabaseHelper();
try {
    $database = $db->getData();
    $user_data = null;
    foreach ($database['users'] as $user) {
        if ($user['username'] === $_SESSION['username']) {
            $user_data = $user;
            break;
        }
    }

    // Read the HTML template
    $html = file_get_contents('landing.html');

    // Prepare login history for JavaScript
    $login_history = isset($user_data['login_history']) ? json_encode($user_data['login_history']) : '[]';

    // Replace placeholders with actual data
    $replacements = [
        '{{username}}' => htmlspecialchars($_SESSION['username']),
        '{{created_at}}' => htmlspecialchars($user_data['created_at']),
        '{{login_time}}' => htmlspecialchars($_SESSION['login_time']),
        '{{login_history}}' => $login_history
    ];

    // Output the processed HTML
    echo str_replace(array_keys($replacements), array_values($replacements), $html);
} catch (Exception $e) {
    error_log("Landing page error: " . $e->getMessage());
    header("Location: login.php");
    exit();
}
?>