<?php
require 'config.php';

$id = $_POST['id'];

$sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Student deleted."]);
} else {
    echo json_encode(["status" => "error", "message" => "Delete failed."]);
}
