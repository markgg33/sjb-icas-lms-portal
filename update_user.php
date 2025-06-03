<?php
include 'config.php';

$id = $_POST['id'];
$first = $_POST['first_name'];
$middle = $_POST['middle_name'];
$last = $_POST['last_name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = $_POST['password'] ?? null;

if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET first_name=?, middle_name=?, last_name=?, gender=?, email=?, role=?, password=? WHERE id=?");
    $stmt->bind_param("sssssssi", $first, $middle, $last, $gender, $email, $role, $hashed, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET first_name=?, middle_name=?, last_name=?, gender=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("ssssssi", $first, $middle, $last, $gender, $email, $role, $id);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed."]);
}
