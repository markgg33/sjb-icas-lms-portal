<?php
require 'config.php';
session_start();
$student_id = $_SESSION['student_id'];
$type = $_POST['type'];
$desc = $_POST['description'];

$stmt = $conn->prepare("INSERT INTO requests (student_id, type, description) VALUES (?,?,?)");
$stmt->bind_param("iss", $student_id, $type, $desc);
if ($stmt->execute()) {
    // notify admin users
    $adminUsers = $conn->query("SELECT id FROM users WHERE role='admin'")->fetch_all(MYSQLI_ASSOC);
    foreach ($adminUsers as $a) {
        $msg = "New `$type` request from student #$student_id";
        $url = "adminDashboard.php#requests-page";
        $stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url) VALUES (?,?,?,?,?)");
        $stmt2->bind_param("iisss", $a['id'], $student_id, $type, $msg, $url);
        $stmt2->execute();
    }
    echo json_encode(["status" => "success", "message" => "Request submitted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to submit"]);
}
