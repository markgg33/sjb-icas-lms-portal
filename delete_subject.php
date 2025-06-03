<?php
require 'config.php';

$id = $_POST['subject_id'];
$stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);
echo $stmt->execute() ? "success" : "error";
