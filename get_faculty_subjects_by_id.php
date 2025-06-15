<?php
require 'config.php';

$faculty_id = $_GET['faculty_id'] ?? null;
if (!$faculty_id) {
    echo json_encode([]);
    exit;
}

$sql = "
SELECT 
  fs.id AS assignment_id,
  fs.semester,
  fs.school_year,
  s.code AS subject_code,
  s.name AS subject_name,
  c.name AS course_name
FROM faculty_subjects fs
JOIN subjects s ON fs.subject_id = s.id
JOIN courses c ON fs.course_id = c.id
WHERE fs.faculty_id = ?
ORDER BY fs.semester, s.name
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

$subjectsBySemester = [];
while ($row = $result->fetch_assoc()) {
    $sem = $row['semester'];
    $subjectsBySemester[$sem][] = $row;
}

echo json_encode($subjectsBySemester);
