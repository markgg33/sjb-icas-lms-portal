<?php
include 'config.php';

$student_id = $_GET['student_id'];

$sql = "SELECT balance FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode(['balance' => $data['balance'] ?? 0]);
