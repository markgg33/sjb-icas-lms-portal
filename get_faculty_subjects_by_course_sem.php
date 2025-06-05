<?php
require 'config.php';
session_start();

if (!isset($_SESSION['faculty_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$faculty_id = $_SESSION['faculty_id'];
$course_id = $_GET['course_id'];
$semester = $_GET['semester'];

$sql = "
    SELECT s.id, s.code, s.name
    FROM faculty_subjects fs
    JOIN subjects s ON fs.subject_id = s.id
    WHERE fs.faculty_id = ? AND fs.course_id = ? AND fs.semester = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $faculty_id, $course_id, $semester);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

echo json_encode($subjects);
