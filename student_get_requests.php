<?php
require 'config.php';
session_start();
$student_id = $_SESSION['student_id'];
$sql = "SELECT type, status, created_at FROM requests WHERE student_id=? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();
echo json_encode($res->fetch_all(MYSQLI_ASSOC));
