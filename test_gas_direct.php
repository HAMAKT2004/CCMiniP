<?php
// Direct test of Google Apps Script without using PHP wrapper functions
echo "<html><head><title>Direct GAS Test</title><style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
    pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; overflow: auto; }
    .success { color: green; }
    .error { color: red; }
</style></head><body>";
echo "<h1>Direct Google Apps Script Test</h1>";

// Test email and username
$testEmail = "harsh2amrute@gmail.com"; // Replace with your email for testing
$testUsername = "TestUser";

// Test different URL formats
$urls = [
    "Current URL" => "https://script.google.com/macros/s/AKfycbz1v8qieqsi3-gYMXgZRp1zeR4enLF_wcO5QLYA76X9C7R5-UzeGfQenAeMN93TzC3k/exec",
    "Alternative Format 1" => "https://script.google.com/macros/d/AKfycbz1v8qieqsi3-gYMXgZRp1zeR4enLF_wcO5QLYA76X9C7R5-UzeGfQenAeMN93TzC3k/exec",
    "Alternative Format 2" => "https://script.google.com/macros/s/AKfycbz1v8qieqsi3-gYMXgZRp1zeR4enLF_wcO5QLYA76X9C7R5-UzeGfQenAeMN93TzC3k/usercallback",
    "Alternative Format 3" => "https://script.google.com/macros/d/AKfycbz1v8qieqsi3-gYMXgZRp1zeR4enLF_wcO5QLYA76X9C7R5-UzeGfQenAeMN93TzC3k/usercallback"
];

// Test different content types
$contentTypes = [
    "application/x-www-form-urlencoded" => function($data) { return http_build_query($data); },
    "application/json" => function($data) { return json_encode($data); }
];

// Test different data formats
$dataFormats = [
    "Standard Format" => [
        'action' => 'login',
        'email' => $testEmail,
        'username' => $testUsername
    ],
    "Alternative Format 1" => [
        'to' => $testEmail,
        'subject' => 'Test Email',
        'body' => 'This is a test email for ' . $testUsername
    ],
    "Alternative Format 2" => [
        'email' => $testEmail,
        'name' => $testUsername,
        'type' => 'login'
    ]
];

// Run tests for each combination
foreach ($urls as $urlName => $url) {
    echo "<h2>Testing URL: $urlName</h2>";
    echo "<p>URL: $url</p>";
    
    foreach ($contentTypes as $contentType => $encoder) {
        echo "<h3>Content Type: $contentType</h3>";
        
        foreach ($dataFormats as $formatName => $data) {
            echo "<h4>Data Format: $formatName</h4>";
            
            // Create cURL request
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encoder($data));
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: $contentType"]);
            
            // Capture verbose output
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
            
            // Execute request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            // Get verbose output
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            
            // Display results
            echo "<p>HTTP Response Code: $httpCode</p>";
            
            if (curl_errno($ch)) {
                echo "<p class='error'>cURL Error: " . curl_error($ch) . "</p>";
            } else {
                echo "<p class='success'>cURL Request Successful</p>";
            }
            
            echo "<h5>Request Data:</h5>";
            echo "<pre>" . htmlspecialchars($encoder($data)) . "</pre>";
            
            echo "<h5>Response Headers:</h5>";
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $headerSize);
            echo "<pre>" . htmlspecialchars($headers) . "</pre>";
            
            echo "<h5>Response Body:</h5>";
            $body = substr($response, $headerSize);
            echo "<pre>" . htmlspecialchars($body) . "</pre>";
            
            // Clean up
            curl_close($ch);
            fclose($verbose);
            
            echo "<hr>";
        }
    }
    
    echo "<hr style='border-top: 2px solid #333;'>";
}

echo "</body></html>";
?> 