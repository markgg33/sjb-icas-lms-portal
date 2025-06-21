<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$request_id = $_POST['id'] ?? null;
$admin_id = $_SESSION['user_id'];

if (!$request_id) {
    echo json_encode(["status" => "error", "message" => "Invalid request ID"]);
    exit;
}

// Mark request as rejected
$stmt = $conn->prepare("UPDATE requests SET status='Rejected', admin_id=? WHERE id=?");
$stmt->bind_param("ii", $admin_id, $request_id);
$stmt->execute();

// Notify student
$result = $conn->query("SELECT student_id, type FROM requests WHERE id = $request_id");
$row = $result->fetch_assoc();
$student_id = $row['student_id'];
$type = $row['type'];

$msg = "Your `$type` request has been rejected.";
$url = "studentDashboard.php#requests-page";

$stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?,?,?,?,?,?)");
$user_type = 'student';
$stmt2->bind_param("iissss", $student_id, $admin_id, $type, $msg, $url, $user_type);
$stmt2->execute();

echo json_encode(["status" => "success", "message" => "Request rejected."]);
