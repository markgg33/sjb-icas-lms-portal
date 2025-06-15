<?php
require 'config.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Invalid ID"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM faculty_subjects WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Subject removed"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to remove"]);
}
