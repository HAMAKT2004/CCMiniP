<?php
session_start();
require_once 'DatabaseHelper.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

try {
    $db = new DatabaseHelper();
    $database = $db->getData();
    $weather_history = [];

    foreach ($database['users'] as $user) {
        if ($user['username'] === $_SESSION['username']) {
            $weather_history = isset($user['weather_history']) ? $user['weather_history'] : [];
            break;
        }
    }

    echo json_encode(['status' => 'success', 'weather_history' => $weather_history]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>