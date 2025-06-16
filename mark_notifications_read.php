<?php

/*require 'config.php'; WORKING VERSION
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;

if ($user_id) {
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND user_type = ?");
    $stmt->bind_param("is", $user_id, $user_type);
    $stmt->execute();
}*/

require 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;

if ($user_id && $user_type) {
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND user_type = ?");
    $stmt->bind_param("is", $user_id, $user_type);
    $stmt->execute();
}
