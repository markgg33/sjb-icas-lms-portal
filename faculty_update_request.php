<?php
require 'config.php';
session_start();

$faculty_id = $_SESSION['faculty_id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);
$request_id = $data['id'] ?? null;
$status = ucfirst(strtolower($data['status'] ?? ''));

if (!$faculty_id || !$request_id || !in_array($status, ['Approved', 'Rejected'])) {
    echo json_encode(["status" => "error", "message" => "Invalid access or data."]);
    exit;
}

// Update status
$stmt = $conn->prepare("UPDATE requests SET status=?, updated_at=NOW() WHERE id=? AND faculty_id=?");
$stmt->bind_param("sii", $status, $request_id, $faculty_id);
if ($stmt->execute()) {
    // Notify student
    $q = $conn->query("SELECT student_id, type FROM requests WHERE id=$request_id");
    $row = $q->fetch_assoc();

    $msg = "Your `$row[type]` request has been $status.";
    $url = "studentDashboard.php#requests-page";
    $user_type = 'student';
    $student_id = $row['student_id'];

    $stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?,?,?,?,?,?)");
    $stmt2->bind_param("iissss", $student_id, $faculty_id, $row['type'], $msg, $url, $user_type);
    $stmt2->execute();

    echo json_encode(["status" => "success", "message" => "Request updated. Student notified."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update."]);
}
