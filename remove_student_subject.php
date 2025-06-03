<?php
include 'config.php';

$student_id = $_POST['student_id'];
$subject_id = $_POST['subject_id'];
$semester = $_POST['semester'];

$sql = "DELETE FROM enrolled_subjects WHERE student_id = ? AND subject_id = ? AND semester = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $student_id, $subject_id, $semester);

$response = [];

if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $conn->error;
}

echo json_encode($response);
