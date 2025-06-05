<?php
require 'config.php';
session_start();

if (!isset($_SESSION['faculty_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$faculty_id = $_SESSION['faculty_id'];

$sql = "
    SELECT DISTINCT c.id, c.name, c.year_level
    FROM faculty_subjects fs
    JOIN courses c ON fs.course_id = c.id
    WHERE fs.faculty_id = ?
    ORDER BY c.name, c.year_level
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

echo json_encode($courses);
