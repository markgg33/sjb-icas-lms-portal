<?php
require 'config.php';

$id = $_GET['id'];
$sql = "SELECT id, first_name, middle_name, last_name, email, photo FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Student not found']);
}
