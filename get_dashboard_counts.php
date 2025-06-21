<?php
require 'config.php';

$students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$subjects = $conn->query("SELECT COUNT(*) as count FROM subjects")->fetch_assoc()['count'];
$courses = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];
$pending_requests = $conn->query("SELECT COUNT(*) as count FROM requests WHERE status = 'Pending'")->fetch_assoc()['count'];
$assigned_faculty = $conn->query("SELECT COUNT(DISTINCT faculty_id) as count FROM faculty_subjects")->fetch_assoc()['count'];

echo json_encode([
    'students' => $students,
    'subjects' => $subjects,
    'courses' => $courses,
    'pending_requests' => $pending_requests,
    'assigned_faculty' => $assigned_faculty
]);
