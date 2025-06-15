<?php
require 'config.php';

$faculty_id = $_GET['faculty_id'] ?? null;

if (!$faculty_id) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT fs.id AS assignment_id, s.code, s.name, fs.semester, c.name AS course_name, fs.school_year
        FROM faculty_subjects fs
        JOIN subjects s ON fs.subject_id = s.id
        JOIN courses c ON fs.course_id = c.id
        WHERE fs.faculty_id = ?
        ORDER BY fs.semester, s.name";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
