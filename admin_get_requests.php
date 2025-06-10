<?php
include 'config.php';
session_start();

if ($_SESSION['user_type'] !== 'admin') {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$sql = "SELECT r.id, r.type, r.description, r.status, r.created_at, 
               CONCAT(s.first_name, ' ', s.middle_name, ' ', s.last_name) AS student_name
        FROM requests r
        JOIN students s ON r.student_id = s.id
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);
$requests = [];

while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode($requests);
