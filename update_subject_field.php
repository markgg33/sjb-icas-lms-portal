<?php
require 'config.php';

$id = $_POST['subject_id'];
$code = $_POST['code'];
$name = $_POST['name'];

$sql = "UPDATE subjects SET code = ?, name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $code, $name, $id);
echo $stmt->execute() ? 'success' : 'error';
