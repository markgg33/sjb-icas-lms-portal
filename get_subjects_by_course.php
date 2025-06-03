<?php
require 'config.php';

$course_id = $_POST['course_id'];
$sql = "
    SELECT 
        subjects.id, 
        subjects.code, 
        subjects.name, 
        course_subjects.semester
    FROM 
        course_subjects
    INNER JOIN 
        subjects ON course_subjects.subject_id = subjects.id
    WHERE 
        course_subjects.course_id = ?
    ORDER BY 
        course_subjects.semester, subjects.name
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $semester = $row['semester'];
    if (!isset($subjects[$semester])) {
        $subjects[$semester] = [];
    }
    $subjects[$semester][] = $row;
}

echo json_encode($subjects);
