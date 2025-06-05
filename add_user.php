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

$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Email already exists."]);
    exit;
}

// Handle photo upload
$photoPath = null;
if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $filename = time() . "_user." . $ext;
    $target = "uploads/users/" . $filename;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $photoPath = $target;
    }
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (first_name, middle_name, last_name, gender, email, password, role, photo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $first, $middle, $last, $gender, $email, $hashed, $role, $photoPath);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add user."]);
}
