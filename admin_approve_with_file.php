<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$request_id = $_POST['id'] ?? null;
$admin_id = $_SESSION['user_id'];

if (!$request_id || !isset($_FILES['attachment'])) {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
    exit;
}

// Handle file upload
$uploadDir = "uploads/requests/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$filename = time() . "_" . basename($_FILES['attachment']['name']);
$targetPath = $uploadDir . $filename;

if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
    echo json_encode(["status" => "error", "message" => "File upload failed"]);
    exit;
}

// Update request: approved + set attachment
$stmt = $conn->prepare("UPDATE requests SET status='Approved', attachment=? WHERE id=?");
$stmt->bind_param("si", $targetPath, $request_id);
$stmt->execute();

// Notify student
$result = $conn->query("SELECT student_id, type FROM requests WHERE id = $request_id");
$row = $result->fetch_assoc();
$student_id = $row['student_id'];
$type = $row['type'];

$msg = "Your `$type` request has been approved with an attachment.";
$url = "studentDashboard.php#requests-page";

$stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?,?,?,?,?,?)");
$user_type = 'student';
$stmt2->bind_param("iissss", $student_id, $admin_id, $type, $msg, $url, $user_type);
$stmt2->execute();

echo json_encode(["status" => "success", "message" => "Request approved and file uploaded."]);
