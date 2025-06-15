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

$inserted = 0;
$skipped = 0;

// Prepare check and insert statements
$checkStmt = $conn->prepare("SELECT id FROM faculty_subjects WHERE faculty_id = ? AND subject_id = ? AND course_id = ? AND semester = ?");
$insertStmt = $conn->prepare("INSERT INTO faculty_subjects (faculty_id, subject_id, semester, school_year, course_id) VALUES (?, ?, ?, ?, ?)");

foreach ($subject_ids as $subject_id) {
    // Check if this subject is already assigned to this faculty
    $checkStmt->bind_param("iiii", $faculty_id, $subject_id, $course_id, $semester);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        // Not yet assigned, insert it
        $insertStmt->bind_param("iissi", $faculty_id, $subject_id, $semester, $school_year, $course_id);
        if ($insertStmt->execute()) {
            $inserted++;
        }
    } else {
        $skipped++;
    }
}

echo json_encode([
    "status" => "success",
    "message" => "Subjects assigned: $inserted. Skipped (already assigned): $skipped."
]);
