<?php
require 'config.php';
session_start();

$faculty_id = $_SESSION['faculty_id'] ?? 0;

// Count assigned subjects
$subjects = $conn->query("SELECT COUNT(*) AS total FROM faculty_subjects WHERE faculty_id = $faculty_id")->fetch_assoc()['total'];

// Count students handled
$students = $conn->query("
  SELECT COUNT(DISTINCT es.student_id) AS total
  FROM enrolled_subjects es
  JOIN faculty_subjects fs ON es.subject_id = fs.subject_id
  WHERE fs.faculty_id = $faculty_id
")->fetch_assoc()['total'];

// Count pending requests (type='Grades' and for this faculty)
$requests = $conn->query("
  SELECT COUNT(*) AS total
  FROM requests
  WHERE faculty_id = $faculty_id AND status = 'Pending' AND type = 'Grades'
")->fetch_assoc()['total'];

echo json_encode([
    'subjects' => $subjects,
    'students' => $students,
    'requests' => $requests
]);
