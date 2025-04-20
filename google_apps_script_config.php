<?php
// Google Apps Script Web App URL
define('GOOGLE_APPS_SCRIPT_URL', 'https://script.google.com/macros/s/AKfycbydFAoYKZE-CsjybsY3vRb6aAPq8P4A3HgO-HWCe_y2U5NQelChOGJXbYyPBIowEGPU/exec');

function sendGoogleAppsScriptNotification($action, $email, $username) {
    $data = array(
        'action' => $action,
        'email' => $email,
        'username' => $username
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents(GOOGLE_APPS_SCRIPT_URL, false, $context);

    if ($result === FALSE) {
        error_log("Failed to send notification to Google Apps Script");
        return false;
    }

    $response = json_decode($result, true);
    return isset($response['status']) && $response['status'] === 'success';
}
?>