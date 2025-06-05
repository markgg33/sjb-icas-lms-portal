<?php
require 'config.php';
session_start();

$faculty_id = $_SESSION['faculty_id'];

$sql = "
SELECT s.id AS subject_id, s.code, s.name, c.name AS course_name, cs.semester
FROM faculty_subjects fs
JOIN subjects s ON fs.subject_id = s.id
JOIN courses c ON fs.course_id = c.id
JOIN course_subjects cs ON s.id = cs.subject_id AND fs.course_id = cs.course_id
WHERE fs.faculty_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

echo json_encode($subjects);
