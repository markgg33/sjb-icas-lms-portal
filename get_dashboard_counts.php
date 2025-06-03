<?php
require 'config.php';

$students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$subjects = $conn->query("SELECT COUNT(*) as count FROM subjects")->fetch_assoc()['count'];
$courses = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];

echo json_encode([
    'students' => $students,
    'subjects' => $subjects,
    'courses' => $courses
]);
