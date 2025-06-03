<?php
include 'config.php';

$name = $_GET['name'] ?? '';

if (!$name) {
    echo json_encode([]);
    exit;
}

// Use prepared statement to prevent SQL injection
$sql = "SELECT students.id AS id,
               students.school_id, 
               CONCAT(students.first_name, ' ', students.middle_name, ' ', students.last_name) AS full_name,
               courses.name AS course_name,
               students.year_level
        FROM students
        JOIN courses ON students.course_id = courses.id
        WHERE CONCAT(students.first_name, ' ', students.middle_name, ' ', students.last_name) LIKE ?
        LIMIT 10";

$stmt = $conn->prepare($sql);
$searchName = "%$name%";
$stmt->bind_param("s", $searchName);
$stmt->execute();
$result = $stmt->get_result();

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);
exit;
