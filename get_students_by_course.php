<?php
require 'config.php';

$sql = "
SELECT 
  students.id,
  students.first_name,
  students.middle_name,
  students.last_name,
  students.email,
  students.photo,
  students.year_level,
  courses.id AS course_id,
  courses.name AS course_name,
  courses.year_level AS course_year
FROM 
  students
JOIN 
  courses ON students.course_id = courses.id
ORDER BY 
  courses.name, courses.year_level, students.last_name
";

$result = $conn->query($sql);

$grouped = [];

while ($row = $result->fetch_assoc()) {
    $groupKey = $row['course_name'] . " - Year " . $row['course_year'];
    if (!isset($grouped[$groupKey])) {
        $grouped[$groupKey] = [];
    }

    $grouped[$groupKey][] = [
        'id' => $row['id'],
        'full_name' => $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'],
        'email' => $row['email'],
        'photo' => $row['photo'],
        'year_level' => $row['year_level']
    ];
}

echo json_encode($grouped);
