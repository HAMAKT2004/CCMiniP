<?php
class DatabaseHelper {
    private $token;
    private $repoOwner;
    private $repoName;
    private $filePath;
    private $branch;
    private $cachedData = null;
    private $lastFetchTime = 0;
    private $cacheTimeout = 5; // Cache timeout in seconds

    public function __construct() {
        $this->token = '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';
        $this->repoOwner = 'HAMAKT2004';
        $this->repoName = 'CCMiniP';
        $this->filePath = 'database.json';
        $this->branch = 'main';
    }

    public function getData() {
        // Return cached data if available and not expired
        if ($this->cachedData !== null && (time() - $this->lastFetchTime) < $this->cacheTimeout) {
            return $this->cachedData;
        }

        $apiUrl = "https://api.github.com/repos/{$this->repoOwner}/{$this->repoName}/contents/{$this->filePath}?ref={$this->branch}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'User-Agent: PHP Script'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new Exception('Failed to fetch data from GitHub');
        }

        $fileData = json_decode($response, true);
        $jsonContent = base64_decode($fileData['content']);
        $this->cachedData = json_decode($jsonContent, true);
        $this->lastFetchTime = time();

        return $this->cachedData;
    }

    public function saveData($data) {
        $apiUrl = "https://api.github.com/repos/{$this->repoOwner}/{$this->repoName}/contents/{$this->filePath}";

        // First get the current file's SHA
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . "?ref={$this->branch}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'User-Agent: PHP Script'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new Exception('Failed to get file SHA from GitHub');
        }

        $fileData = json_decode($response, true);
        $fileSha = $fileData['sha'];

        // Prepare the update data
        $updateData = [
            'message' => 'Update database.json via web app',
            'content' => base64_encode(json_encode($data, JSON_PRETTY_PRINT)),
            'sha' => $fileSha,
            'branch' => $this->branch
        ];

        // Send the update request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updateData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'User-Agent: PHP Script',
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new Exception('Failed to update data on GitHub');
        }

        // Update cache with new data
        $this->cachedData = $data;
        $this->lastFetchTime = time();

        return true;
    }
}
?>