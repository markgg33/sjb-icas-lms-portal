<?php
require 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;

if (!$user_id || !$user_type) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, type, message, url, is_read, created_at FROM notifications WHERE user_id=? AND user_type=? ORDER BY created_at DESC LIMIT 10");
$stmt->bind_param("is", $user_id, $user_type);
$stmt->execute();

$result = $stmt->get_result();
$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
