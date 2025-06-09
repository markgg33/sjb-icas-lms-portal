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

$photoPath = null;

// Handle photo upload
if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = time() . "_user." . $ext;
    $target = "uploads/users/" . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $photoPath = $target;
    }
}

if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET first_name=?, middle_name=?, last_name=?, gender=?, email=?, role=?, password=?, photo=IFNULL(?, photo) WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $first, $middle, $last, $gender, $email, $role, $hashed, $photoPath, $id);
} else {
    $sql = "UPDATE users SET first_name=?, middle_name=?, last_name=?, gender=?, email=?, role=?, photo=IFNULL(?, photo) WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $first, $middle, $last, $gender, $email, $role, $photoPath, $id);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Update failed."]);
}
