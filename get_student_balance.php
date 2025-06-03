<?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Missing student ID']);
    exit;
}

$student_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT balance FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode([
    'balance' => $data ? $data['balance'] : 0.00
]);
