<?php
session_start();
require_once 'DatabaseHelper.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

try {
    $weatherData = json_decode(file_get_contents('php://input'), true);
    if (!$weatherData) {
        throw new Exception('Invalid weather data');
    }

    $db = new DatabaseHelper();
    $database = $db->getData();

    foreach ($database['users'] as &$user) {
        if ($user['username'] === $_SESSION['username']) {
            if (!isset($user['weather_history'])) {
                $user['weather_history'] = [];
            }
            
            // Add new weather data at the beginning of the array
            array_unshift($user['weather_history'], $weatherData);
            
            // Keep only the last 10 entries
            $user['weather_history'] = array_slice($user['weather_history'], 0, 10);
            break;
        }
    }

    $db->saveData($database);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>