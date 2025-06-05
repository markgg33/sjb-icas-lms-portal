<?php
require 'config.php';

$faculty_id = $_POST['faculty_id'];
$course_id = $_POST['course_id'];
$semester = $_POST['semester'];
$school_year = date("Y") . "-" . (date("Y") + 1); // Example school year
$subject_ids = $_POST['subject_ids'] ?? [];

if (empty($subject_ids)) {
    echo json_encode(["status" => "error", "message" => "No subjects selected."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO faculty_subjects (faculty_id, subject_id, semester, school_year, course_id) VALUES (?, ?, ?, ?, ?)");

foreach ($subject_ids as $subject_id) {
    $stmt->bind_param("iissi", $faculty_id, $subject_id, $semester, $school_year, $course_id);
    $stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Subjects assigned successfully."]);
