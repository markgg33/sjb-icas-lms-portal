<?php
session_start();
include 'config.php';

// Determine which student to use
if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
} elseif (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
} else {
    die("Student not specified or logged in.");
}

// Step 1: Get course name
$courseQuery = "
    SELECT c.name AS course_name
    FROM students s
    JOIN courses c ON s.course_id = c.id
    WHERE s.id = ?
";
$courseStmt = $conn->prepare($courseQuery);
$courseStmt->bind_param("i", $student_id);
$courseStmt->execute();
$courseResult = $courseStmt->get_result();
$courseData = $courseResult->fetch_assoc();
$course_name = $courseData ? $courseData['course_name'] : 'N/A';

// ✅ Step 2: Get enrolled subjects with units
$subjectQuery = "
    SELECT 
        s.id AS subject_id,
        s.code,
        s.name,
        s.units,
        es.semester,
        es.school_year,
        es.date_enrolled
    FROM enrolled_subjects es
    JOIN subjects s ON s.id = es.subject_id
    WHERE es.student_id = ?
    ORDER BY es.date_enrolled DESC
";
$stmt = $conn->prepare($subjectQuery);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = [
        'id' => $row['subject_id'],
        'code' => $row['code'],
        'name' => $row['name'],
        'units' => (int)$row['units'], // ✅ Include units
        'semester' => $row['semester'],
        'school_year' => $row['school_year'],
        'date_enrolled' => $row['date_enrolled']
    ];
}

// Step 3: Return data
echo json_encode([
    'course_name' => $course_name,
    'subjects' => $subjects
]);
