<?php
require 'config.php';

$id = $_POST['id'];
$first = $_POST['first_name'];
$middle = $_POST['middle_name'];
$last = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'] ?? null;

$photoPath = null;

// If new photo is uploaded
if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = time() . "_student." . $ext;
    $target = "uploads/students/" . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $photoPath = $target;
    }
}

// Build query
if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE students SET first_name=?, middle_name=?, last_name=?, email=?, password=?, photo=IFNULL(?, photo) WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $first, $middle, $last, $email, $hashed, $photoPath, $id);
} else {
    $sql = "UPDATE students SET first_name=?, middle_name=?, last_name=?, email=?, photo=IFNULL(?, photo) WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first, $middle, $last, $email, $photoPath, $id);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Student updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed."]);
}
