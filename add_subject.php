<?php

/*include 'config.php'; WORKING VERSION IN CASE

//file_put_contents("debug.log", print_r($_POST, true)); FOR DEBUGGING

$codes = $_POST['subject_codes'] ?? [];
$names = $_POST['subject_names'] ?? [];
$semesters = $_POST['subject_semesters'] ?? [];

$inserted = 0;
$skipped = 0;

for ($i = 0; $i < count($codes); $i++) {
    $code = trim($codes[$i]);
    $name = trim($names[$i]);
    $semester = (int)$semesters[$i];

    // Check for duplicate by CODE only
    $check = $conn->prepare("SELECT id FROM subjects WHERE code = ?");
    $check->bind_param("s", $code);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO subjects (code, name, semester) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $code, $name, $semester);
        $stmt->execute();
        $inserted++;
    } else {
        $skipped++;
    }
}

echo json_encode([
    "inserted" => $inserted,
    "skipped" => $skipped
]);*/

include 'config.php';

$codes = $_POST['subject_codes'] ?? [];
$names = $_POST['subject_names'] ?? [];
$semesters = $_POST['subject_semesters'] ?? [];
$units = $_POST['subject_units'] ?? [];

$inserted = 0;
$skipped = 0;

for ($i = 0; $i < count($codes); $i++) {
    $code = trim($codes[$i]);
    $name = trim($names[$i]);
    $semester = (int)$semesters[$i];
    $unit = (int)$units[$i];
    if ($unit < 2 || $unit > 3) $unit = 3;

    $check = $conn->prepare("SELECT id FROM subjects WHERE code = ?");
    $check->bind_param("s", $code);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO subjects (code, name, semester, units) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $code, $name, $semester, $unit);
        $stmt->execute();
        $inserted++;
    } else {
        $skipped++;
    }
}

echo json_encode(["inserted" => $inserted, "skipped" => $skipped]);
