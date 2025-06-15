<?php

/*include 'config.php'; WORKING VERSION JUST IN CASE

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
?>*/

include 'config.php';

$student_id = $_POST['student_id'];
$semester = $_POST['semester'];
$school_year = date("Y") . "-" . (date("Y") + 1);
$subject_ids = $_POST['subject_ids'] ?? [];

$inserted = 0;
$skipped = 0;
$total_units = 0;

foreach ($subject_ids as $subject_id) {
    $check = $conn->prepare("SELECT id FROM enrolled_subjects WHERE student_id = ? AND subject_id = ? AND semester = ?");
    $check->bind_param("iii", $student_id, $subject_id, $semester);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        // Get units for this subject
        $unit_q = $conn->prepare("SELECT units FROM subjects WHERE id = ?");
        $unit_q->bind_param("i", $subject_id);
        $unit_q->execute();
        $unit_q->bind_result($units);
        $unit_q->fetch();
        $unit_q->close();

        $insert = $conn->prepare("INSERT INTO enrolled_subjects (student_id, subject_id, semester, school_year) VALUES (?, ?, ?, ?)");
        $insert->bind_param("iiis", $student_id, $subject_id, $semester, $school_year);
        $insert->execute();

        $total_units += $units;
        $inserted++;
    } else {
        $skipped++;
    }
}

if ($total_units > 0) {
    $balance_add = $total_units * 320;
    $conn->query("UPDATE students SET balance = balance + $balance_add WHERE id = $student_id");
}

echo json_encode([
    'inserted' => $inserted,
    'skipped' => $skipped,
    'balance_added' => $total_units * 320
]);
