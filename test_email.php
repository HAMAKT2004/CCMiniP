<?php
// Test script for email functionality
require_once 'google_apps_script_config.php';

// Function to test direct Google Apps Script notification
function testGoogleAppsScriptNotification() {
    echo "<h2>Testing Google Apps Script Notification</h2>";
    
    $testEmail = "harsh2amrute@gmail.com"; // Replace with your email for testing
    $testUsername = "TestUser";
    
    echo "<p>Sending test notification to: $testEmail</p>";
    
    $data = array(
        'action' => 'login',
        'email' => $testEmail,
        'username' => $testUsername
    );
    
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );
    
    $context = stream_context_create($options);
    
    echo "<p>Attempting to connect to: " . GOOGLE_APPS_SCRIPT_URL . "</p>";
    
    try {
        $result = file_get_contents(GOOGLE_APPS_SCRIPT_URL, false, $context);
        
        if ($result === FALSE) {
            $error = error_get_last();
            echo "<p style='color:red'>Error: " . $error['message'] . "</p>";
            echo "<p>HTTP Response Code: " . $http_response_header[0] . "</p>";
        } else {
            echo "<p style='color:green'>Success! Response received:</p>";
            echo "<pre>" . htmlspecialchars($result) . "</pre>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>Exception: " . $e->getMessage() . "</p>";
    }
}

// Function to test using cURL for more detailed error information
function testCurlRequest() {
    echo "<h2>Testing with cURL</h2>";
    
    $testEmail = "harsh2amrute@gmail.com"; // Replace with your email for testing
    $testUsername = "TestUser";
    
    $data = array(
        'action' => 'login',
        'email' => $testEmail,
        'username' => $testUsername
    );
    
    $ch = curl_init(GOOGLE_APPS_SCRIPT_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    // Capture verbose output
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Get verbose output
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    
    echo "<p>HTTP Response Code: $httpCode</p>";
    
    if (curl_errno($ch)) {
        echo "<p style='color:red'>cURL Error: " . curl_error($ch) . "</p>";
    } else {
        echo "<p style='color:green'>cURL Request Successful</p>";
    }
    
    echo "<h3>Verbose Output:</h3>";
    echo "<pre>" . htmlspecialchars($verboseLog) . "</pre>";
    
    echo "<h3>Response Headers:</h3>";
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    echo "<pre>" . htmlspecialchars($headers) . "</pre>";
    
    echo "<h3>Response Body:</h3>";
    $body = substr($response, $headerSize);
    echo "<pre>" . htmlspecialchars($body) . "</pre>";
    
    curl_close($ch);
    fclose($verbose);
}

// Function to test alternative Google Apps Script URL format
function testAlternativeUrl() {
    echo "<h2>Testing Alternative URL Format</h2>";
    
    // Extract the script ID from the current URL
    $currentUrl = GOOGLE_APPS_SCRIPT_URL;
    preg_match('/\/s\/([^\/]+)\//', $currentUrl, $matches);
    
    if (isset($matches[1])) {
        $scriptId = $matches[1];
        $alternativeUrl = "https://script.google.com/macros/d/" . $scriptId . "/exec";
        
        echo "<p>Testing alternative URL: $alternativeUrl</p>";
        
        $testEmail = "harsh2amrute@gmail.com"; // Replace with your email for testing
        $testUsername = "TestUser";
        
        $data = array(
            'action' => 'login',
            'email' => $testEmail,
            'username' => $testUsername
        );
        
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        
        $context = stream_context_create($options);
        
        try {
            $result = file_get_contents($alternativeUrl, false, $context);
            
            if ($result === FALSE) {
                $error = error_get_last();
                echo "<p style='color:red'>Error: " . $error['message'] . "</p>";
                echo "<p>HTTP Response Code: " . $http_response_header[0] . "</p>";
            } else {
                echo "<p style='color:green'>Success! Response received:</p>";
                echo "<pre>" . htmlspecialchars($result) . "</pre>";
            }
        } catch (Exception $e) {
            echo "<p style='color:red'>Exception: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red'>Could not extract script ID from URL</p>";
    }
}

// Run the tests
echo "<html><head><title>Email Test</title><style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
    pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
</style></head><body>";
echo "<h1>Email Sending Test</h1>";

// Test 1: Direct Google Apps Script notification
testGoogleAppsScriptNotification();

echo "<hr>";

// Test 2: cURL request with detailed error information
testCurlRequest();

echo "<hr>";

// Test 3: Alternative URL format
testAlternativeUrl();

echo "</body></html>";
?>