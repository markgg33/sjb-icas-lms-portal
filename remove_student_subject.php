<?php
include 'config.php';

$student_id = $_POST['student_id'];
$subject_id = $_POST['subject_id'];
$semester = $_POST['semester'];

// Get subject units
$get = $conn->prepare("SELECT units FROM subjects WHERE id = ?");
$get->bind_param("i", $subject_id);
$get->execute();
$get->bind_result($units);
$get->fetch();
$get->close();

$cost = $units * 320;

// Delete the subject
$delete = $conn->prepare("DELETE FROM enrolled_subjects WHERE student_id = ? AND subject_id = ? AND semester = ?");
$delete->bind_param("iii", $student_id, $subject_id, $semester);
$delete->execute();

// Update the student's balance
$update = $conn->prepare("UPDATE students SET balance = balance - ? WHERE id = ?");
$update->bind_param("di", $cost, $student_id);
$update->execute();

echo json_encode(["status" => "success"]);
