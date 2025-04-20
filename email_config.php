<?php
// Include the Google Apps Script configuration
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
        error_log("Exception sending email: " . $e->getMessage());
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

function sendWelcomeEmail($username, $email) {
    $subject = "Welcome to Weather Tracking System";
    $body = "Dear $username,\n\n"
         . "Welcome to our Weather Tracking System! Your account has been successfully created.\n\n"
         . "You can now log in and start tracking weather information.\n\n"
         . "Best regards,\nWeather Tracking Team";
    
    return sendEmail($email, $subject, $body);
}

function sendLoginNotification($username, $email, $loginTime) {
    $subject = "New Login Detected";
    $body = "Dear $username,\n\n"
         . "A new login was detected on your account at $loginTime.\n\n"
         . "If this wasn't you, please contact support immediately.\n\n"
         . "Best regards,\nWeather Tracking Team";
    
    return sendEmail($email, $subject, $body);
}

function sendWeatherAlert($username, $email, $location, $alert) {
    $subject = "Weather Alert for $location";
    $body = "Dear $username,\n\n"
         . "A weather alert has been issued for $location:\n\n"
         . "$alert\n\n"
         . "Stay safe!\n"
         . "Weather Tracking Team";
    
    return sendEmail($email, $subject, $body);
}
?>