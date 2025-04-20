<?php
session_start();
require_once 'google_apps_script_config.php';
require_once 'DatabaseHelper.php';

if (isset($_SESSION['username'])) {
    // Set timezone to IST
    date_default_timezone_set('Asia/Kolkata');
    $logout_time = date('Y-m-d H:i:s');
    
    $db = new DatabaseHelper();
    try {
        $database = $db->getData();
        
        // Update user's last logout time
        foreach ($database['users'] as &$user) {
            if ($user['username'] === $_SESSION['username']) {
                if (isset($_SESSION['current_login_index']) && isset($user['login_history'][$_SESSION['current_login_index']])) {
                    $user['login_history'][$_SESSION['current_login_index']]['logout_time'] = $logout_time;
                }
                
                // Send logout notification email using Google Apps Script
                sendGoogleAppsScriptNotification('logout', $user['email'], $user['username']);
                break;
            }
        }
        
        $db->saveData($database);
    } catch (Exception $e) {
        error_log("Logout error: " . $e->getMessage());
    }
}

session_destroy();
header("Location: login.php");
exit();
?>