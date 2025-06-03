<?php
include 'config.php';

$first = $_POST['first_name'] ?? '';
$middle = $_POST['middle_name'] ?? '';
$last = $_POST['last_name'] ?? '';
$gender = $_POST['gender'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (!$first || !$last || !$gender || !$email || !$role || !$password || !$confirm) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
    exit;
}

// Check for duplicate email
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists."]);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, gender, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $first, $middle, $last, $gender, $email, $hashed, $role);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add user."]);
}
