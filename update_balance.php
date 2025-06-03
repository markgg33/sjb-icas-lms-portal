<?php
include 'config.php';

$student_id = $_POST['student_id'];
$new_balance = $_POST['new_balance'];

$sql = "UPDATE students SET balance = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $new_balance, $student_id);

$response = [];
if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = $conn->error;
}

echo json_encode($response);
