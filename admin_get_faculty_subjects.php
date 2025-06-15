<?php
require 'config.php';
session_start();

// Check if admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$sql = "
SELECT fs.id AS assignment_id, 
       u.first_name, u.middle_name, u.last_name,
       s.code AS subject_code, s.name AS subject_name,
       c.name AS course_name, fs.semester, fs.school_year
FROM faculty_subjects fs
JOIN users u ON fs.faculty_id = u.id
JOIN subjects s ON fs.subject_id = s.id
JOIN courses c ON fs.course_id = c.id
ORDER BY u.last_name, c.name, fs.semester
";

$result = $conn->query($sql);
$rows = [];
while ($row = $result->fetch_assoc()) {
    $row['faculty_name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    $rows[] = $row;
}

echo json_encode($rows);
