<?php
require 'config.php';
session_start();

$student_id = $_SESSION['student_id'] ?? null;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$stmt = $conn->prepare("SELECT COUNT(*) FROM requests WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT id, type, description, status FROM requests WHERE student_id = ? ORDER BY id DESC LIMIT ?, ?");
$stmt->bind_param("iii", $student_id, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
  $requests[] = $row;
}

echo json_encode([
  "requests" => $requests,
  "total" => $total,
  "page" => $page,
  "limit" => $limit
]);
