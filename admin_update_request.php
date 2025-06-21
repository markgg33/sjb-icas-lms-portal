<?php

//WORKING VERSION
/*require 'config.php';
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
}*/

require 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$request_id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? '';
$attachmentPath = null;

if (!$request_id || !in_array($status, ['Approved', 'Rejected'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

// Handle attachment if approved
if ($status === 'Approved' && isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $dir = "uploads/attachments/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $filename = time() . '_' . basename($_FILES['attachment']['name']);
    $filepath = $dir . $filename;

    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $filepath)) {
        $attachmentPath = $filepath;
    }
}

// Update request
if ($status === 'Approved') {
    $stmt = $conn->prepare("UPDATE requests SET status=?, attachment=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $attachmentPath, $request_id);
} else {
    $stmt = $conn->prepare("UPDATE requests SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $request_id);
}

if ($stmt->execute()) {
    // Notify student
    $result = $conn->query("SELECT student_id, type FROM requests WHERE id = $request_id");
    $row = $result->fetch_assoc();
    $student_id = $row['student_id'];
    $type = $row['type'];
    $admin_id = $_SESSION['user_id'];

    $msg = "Your `$type` request has been $status.";
    $url = "studentDashboard.php#requests-page";

    $stmt2 = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?, ?, ?, ?, ?, 'student')");
    $stmt2->bind_param("iisss", $student_id, $admin_id, $type, $msg, $url);
    $stmt2->execute();

    echo json_encode(["status" => "success", "message" => "Request updated"]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
}
