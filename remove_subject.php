<?php
include 'config.php';

$course_id = $_POST['course_id'];
$subject_id = $_POST['subject_id'];
$semester = $_POST['semester'];

$sql = "DELETE FROM course_subjects WHERE course_id = ? AND subject_id = ? AND semester = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $course_id, $subject_id, $semester);

$response = [];

if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $conn->error;
}

echo json_encode($response);



// FOR COURSE SUBJECT
