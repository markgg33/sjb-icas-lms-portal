<?php
require 'config.php';
session_start();

$faculty_id = $_SESSION['faculty_id'] ?? 0;

$sql = "
  SELECT s.code AS subject_code, COUNT(DISTINCT es.student_id) AS student_count
  FROM faculty_subjects fs
  JOIN subjects s ON fs.subject_id = s.id
  JOIN enrolled_subjects es ON es.subject_id = s.id
  WHERE fs.faculty_id = ?
  GROUP BY s.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
