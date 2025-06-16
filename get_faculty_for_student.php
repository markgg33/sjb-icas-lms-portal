<?php
require 'config.php';
session_start();
$student_id = $_SESSION['student_id'];

$sql = "
SELECT DISTINCT u.id, CONCAT(u.first_name, ' ', u.last_name) AS name
FROM faculty_subjects fs
JOIN users u ON fs.faculty_id = u.id
JOIN enrolled_subjects es ON es.subject_id = fs.subject_id
WHERE es.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$faculty = [];
while ($row = $result->fetch_assoc()) {
    $faculty[] = $row;
}
echo json_encode($faculty);
