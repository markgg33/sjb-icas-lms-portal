<?php
require 'config.php';
session_start();

$faculty_id = $_SESSION['faculty_id'] ?? null;
if (!$faculty_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT r.id, s.first_name, s.last_name, r.type, r.description, r.status, r.created_at
        FROM requests r
        JOIN students s ON r.student_id = s.id
        WHERE r.faculty_id = ?
        ORDER BY r.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $row['student_name'] = $row['first_name'] . ' ' . $row['last_name'];
    $requests[] = $row;
}

echo json_encode($requests);
