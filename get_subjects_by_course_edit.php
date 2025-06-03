<?php
require 'config.php';

// Validate POST
if (!isset($_POST['course_id'])) {
    echo json_encode(['error' => 'Missing course_id']);
    exit;
}

$course_id = $_POST['course_id'];

// Make sure column names match your actual database
$sql = "SELECT id, subject_code, subject_name, semester FROM subjects WHERE course_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $semester = $row['semester'];
    if (!isset($subjects[$semester])) {
        $subjects[$semester] = [];
    }
    $subjects[$semester][] = $row;
}

echo json_encode($subjects);
