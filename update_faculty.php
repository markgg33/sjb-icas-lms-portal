<?php
require 'config.php';
session_start();

$id = $_SESSION['faculty_id'];
$first = $_POST['first_name'] ?? '';
$middle = $_POST['middle_name'] ?? '';  // ✅ Added
$last = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$photoPath = null;

if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = time() . "_faculty." . $ext;
    $target = "uploads/users/" . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $photoPath = $target;
    }
}

if ($password !== "") {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users 
            SET first_name=?, middle_name=?, last_name=?, email=?, password=?, photo=IFNULL(?, photo) 
            WHERE id=? AND role='faculty'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $first, $middle, $last, $email, $hashed, $photoPath, $id);
} else {
    $sql = "UPDATE users 
            SET first_name=?, middle_name=?, last_name=?, email=?, photo=IFNULL(?, photo) 
            WHERE id=? AND role='faculty'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first, $middle, $last, $email, $photoPath, $id);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Profile updated."]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed."]);
}
