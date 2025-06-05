<?php
require 'config.php';

$subject_id = $_GET['subject_id'];
$course_id = $_GET['course_id'];
$semester = $_GET['semester'];
$school_year = $_GET['school_year'];

$sql = "
    SELECT 
        s.id, 
        s.first_name, 
        s.middle_name, 
        s.last_name, 
        s.school_id, 
        g.grade
    FROM enrolled_subjects es
    JOIN students s ON es.student_id = s.id
    LEFT JOIN grades g 
        ON g.student_id = s.id 
        AND g.subject_id = es.subject_id 
        AND g.semester = es.semester 
        AND g.school_year = es.school_year
    WHERE es.subject_id = ? 
        AND s.course_id = ? 
        AND es.semester = ? 
        AND es.school_year = ?
    ORDER BY s.last_name
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $subject_id, $course_id, $semester, $school_year);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $row['full_name'] = "{$row['last_name']}, {$row['first_name']} {$row['middle_name']}";
    $students[] = $row;
}

echo json_encode($students);
