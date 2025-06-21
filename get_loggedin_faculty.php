<?php
require 'config.php';
session_start();

if (!isset($_SESSION['faculty_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$id = $_SESSION['faculty_id'];

$sql = "SELECT id, first_name, middle_name, last_name, email, photo 
        FROM users 
        WHERE id = ? AND role = 'faculty'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());
