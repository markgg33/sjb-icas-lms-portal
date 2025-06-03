<?php
include 'config.php';

$student_id = $_POST['student_id'];
$semester = $_POST['semester'];
$school_year = date("Y") . "-" . (date("Y") + 1); // example: 2025-2026
$subject_ids = $_POST['subject_ids'] ?? [];

$inserted = 0;
$skipped = 0;

foreach ($subject_ids as $subject_id) {
    // Check for duplicate enrollment
    $check = $conn->prepare("SELECT id FROM enrolled_subjects WHERE student_id = ? AND subject_id = ? AND semester = ?");
    $check->bind_param("iii", $student_id, $subject_id, $semester);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $insert = $conn->prepare("INSERT INTO enrolled_subjects (student_id, subject_id, semester, school_year) VALUES (?, ?, ?, ?)");
        $insert->bind_param("iiis", $student_id, $subject_id, $semester, $school_year);
        $insert->execute();
        $inserted++;
    } else {
        $skipped++;
    }
}

echo json_encode([
    'inserted' => $inserted,
    'skipped' => $skipped
]);
?>
