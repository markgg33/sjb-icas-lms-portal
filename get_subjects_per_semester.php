<?php
require 'config.php';
session_start();

$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$sql = "
    SELECT s.semester, COUNT(*) as subject_count
    FROM enrolled_subjects es
    JOIN subjects s ON es.subject_id = s.id
    WHERE es.student_id = ?
    GROUP BY s.semester
    ORDER BY s.semester
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        'semester' => $row['semester'],
        'subject_count' => $row['subject_count']
    ];
}

echo json_encode($data);
