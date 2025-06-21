<?php
require 'config.php';

$sql = "
  SELECT 
    c.name AS course_name,
    s.year_level,
    COUNT(s.id) AS student_count
  FROM courses c
  LEFT JOIN students s ON c.id = s.course_id
  GROUP BY c.id, s.year_level
  ORDER BY c.name, s.year_level
";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $label = $row['course_name'] . ' - Year ' . $row['year_level'];
    $data[] = [
        'label' => $label,
        'count' => (int)$row['student_count']
    ];
}

echo json_encode($data);
