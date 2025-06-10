<?php

require 'config.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$request_id = $data['id'] ?? null;
$status = ucfirst(strtolower($data['status'] ?? '')); // normalize case

// Check if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if (!$request_id || !in_array($status, ['Approved', 'Rejected'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

// Update request status
$stmt = $conn->prepare("UPDATE requests SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $request_id);
if ($stmt->execute()) {
    // Notify the student
    $result = $conn->query("SELECT student_id, type FROM requests WHERE id = $request_id");
    $row = $result->fetch_assoc();
    $student_id = $row['student_id'];
    $type = $row['type'];
    $admin_id = $_SESSION['user_id'];

    $msg = "Your `$type` request has been $status.";
    $url = "studentDashboard.php#requests-page";

    $user_type = 'student';
    $stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?,?,?,?,?,?)");
    $stmt2->bind_param("iissss", $student_id, $admin_id, $type, $msg, $url, $user_type);
    $stmt2->execute();


    echo json_encode(["status" => "success", "message" => "Request updated and student notified"]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
}
