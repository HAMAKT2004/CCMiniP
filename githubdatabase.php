<?php
// GitHub API Token (Replace this with your actual token)
$token = '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'; // Your GitHub token

// GitHub repository details
$repoOwner = 'HAMAKT2004'; // GitHub username or organization name
$repoName = 'CCMiniP'; // Repository name
$filePath = 'database.json'; // Path to the JSON file in the repo
$branch = 'main'; // Branch name (e.g., 'main' or 'master')

// GitHub API URL to get the file content (first request to fetch SHA and content)
$apiUrl = "https://api.github.com/repos/$repoOwner/$repoName/contents/$filePath?ref=$branch";

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,  // Use your GitHub token here
    'User-Agent: PHP Script'
]);

// Execute the request and fetch response
$response = curl_exec($ch);
curl_close($ch);

// Check if we got the response
if (!$response) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// Decode the response (get current file content and SHA)
$fileData = json_decode($response, true);

// Fetch the SHA of the file (required for updating)
$fileSha = $fileData['sha']; // SHA of the current file for update

// Modify the JSON data (for example, adding a new key-value pair)
$fileContent = base64_decode($fileData['content']); // Decode the existing content
$jsonArray = json_decode($fileContent, true); // Convert JSON to an array

// Example modification - Add a new key-value pair to the JSON file
$jsonArray['newKey'] = 'newValue'; // You can modify this to whatever data you want to add

// Re-encode the modified content to JSON
$updatedJsonContent = json_encode($jsonArray, JSON_PRETTY_PRINT);

// Prepare the data for the PUT request
$data = [
    'message' => 'Update database.json with new data', // Commit message
    'content' => base64_encode($updatedJsonContent), // Base64 encode the updated content
    'sha' => $fileSha, // The SHA of the current file
    'branch' => $branch // The branch you want to update
];

// GitHub API URL to update the file
$updateUrl = "https://api.github.com/repos/$repoOwner/$repoName/contents/$filePath";

// Initialize cURL session to send the PUT request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $updateUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,  // Your GitHub token
    'User-Agent: PHP Script',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');  // Use PUT method for updating
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Send the update data as JSON

// Execute the request and get the response
$response = curl_exec($ch);
curl_close($ch);

// Check for success
if (!$response) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// Decode the response and check for success
$responseData = json_decode($response, true);

// If successful, print the commit SHA (this confirms the update)
echo "File updated successfully. Commit: " . $responseData['commit']['sha'];
?>
