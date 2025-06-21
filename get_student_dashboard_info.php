<?php
require 'config.php';
session_start();

$student_id = $_SESSION['student_id'] ?? null;

if (!$student_id) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$query = "
SELECT 
    s.first_name, s.last_name, s.year_level, s.course_id, s.photo, s.balance,
    c.name AS course_name
FROM students s
LEFT JOIN courses c ON s.course_id = c.id
WHERE s.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$requestRes = $conn->prepare("SELECT COUNT(*) AS total FROM requests WHERE student_id = ? AND status = 'Pending'");
$requestRes->bind_param("i", $student_id);
$requestRes->execute();
$requestCount = $requestRes->get_result()->fetch_assoc()['total'];

echo json_encode([
    'name' => $student['first_name'] . ' ' . $student['last_name'],
    'course' => $student['course_name'],
    'year_level' => $student['year_level'],
    'photo' => $student['photo'],
    'balance' => $student['balance'],
    'pending_requests' => $requestCount
]);
