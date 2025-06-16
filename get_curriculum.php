<?php
include 'config.php';

$sql = "SELECT 
    cs.course_id, 
    c.name AS course_name, 
    cs.semester, 
    s.id AS subject_id, 
    s.name AS subject_name,
    s.code AS subject_code,
    s.units AS subject_units
FROM course_subjects cs
JOIN courses c ON cs.course_id = c.id
JOIN subjects s ON cs.subject_id = s.id
ORDER BY c.name, cs.semester, s.name
";

$result = $conn->query($sql);

$curriculum = [];

while ($row = $result->fetch_assoc()) {
    $course_id = $row['course_id'];
    $semester = $row['semester'];

    if (!isset($curriculum[$course_id])) {
        $curriculum[$course_id] = [
            'course_id' => $course_id,
            'name' => $row['course_name'],
            'subjects' => []
        ];
    }

    if (!isset($curriculum[$course_id]['subjects'][$semester])) {
        $curriculum[$course_id]['subjects'][$semester] = [];
    }

    $curriculum[$course_id]['subjects'][$semester][] = [
        'subject_id' => $row['subject_id'],
        'name'       => $row['subject_name'],
        'code'       => $row['subject_code'],
        'units'      => $row['subject_units'] ?? 0 // ✅ Include units
    ];
}

echo json_encode(array_values($curriculum));
