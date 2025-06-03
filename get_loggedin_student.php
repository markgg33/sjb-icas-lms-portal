<?php
require 'config.php';
session_start();

if (!isset($_SESSION['student_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$id = $_SESSION['student_id'];
$sql = "
    SELECT 
        students.id, 
        students.school_id, 
        students.first_name, 
        students.middle_name, 
        students.last_name, 
        students.email, 
        students.photo,
        students.year_level,
        courses.name AS course_name
    FROM 
        students
    LEFT JOIN courses ON students.course_id = courses.id
    WHERE students.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
echo json_encode($result->fetch_assoc());
