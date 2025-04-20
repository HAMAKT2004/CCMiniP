<?php
require_once 'google_apps_script_config.php';

function sendEmail($to, $subject, $body) {
    try {
        $data = array(
            'to' => $to,
            'subject' => $subject,
            'body' => $body
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents(GOOGLE_APPS_SCRIPT_URL, false, $context);
        
        if ($result === FALSE) {
            error_log("Email sending failed to: $to, Subject: $subject");
            error_log("Error: " . error_get_last()['message']);
            return ['status' => 'error', 'message' => 'Failed to send email'];
        }

        $response = json_decode($result, true);
        error_log("Email response for $to: " . json_encode($response));
        return $response;
    } catch (Exception $e) {
        error_log("Email exception: " . $e->getMessage());
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

function sendWelcomeEmail($username, $email) {
    return sendEmail($email, 'Welcome to Weather App', "Welcome $username! Your account has been created successfully.");
}

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

    $context = stream_context_create($options);
    $result = file_get_contents(GOOGLE_APPS_SCRIPT_URL, false, $context);

    if ($result === FALSE) {
        error_log("Failed to send notification to Google Apps Script");
        return false;
    }

    $response = json_decode($result, true);
    return isset($response['status']) && $response['status'] === 'success';
}
?>