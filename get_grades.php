<?php
/*session_start();
include 'config.php';

$student_id = $_SESSION['student_id'] ?? null;

if (!$student_id) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Optional: block access if student has a balance
$checkBalance = $conn->prepare("SELECT balance FROM students WHERE id = ?");
$checkBalance->bind_param("i", $student_id);
$checkBalance->execute();
$balanceResult = $checkBalance->get_result()->fetch_assoc();

if ($balanceResult['balance'] > 0) {
    echo json_encode(['blocked' => true, 'message' => 'Please settle your balance before checking your grades']);
    exit;
}

// Get enrolled subjects with grades (if recorded)
$query = "
    SELECT s.name AS subject_name, s.code, es.semester, es.school_year, g.grade
    FROM enrolled_subjects es
    JOIN subjects s ON s.id = es.subject_id
    LEFT JOIN grades g ON g.subject_id = s.id AND g.student_id = es.student_id
    WHERE es.student_id = ?
    ORDER BY es.school_year DESC, es.semester DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}

echo json_encode($grades);

NOTE: THIS CODE ACTUALLY WORKS AND FETCHES THE DATA FOR THE GRADES AND SUBJECT FOR THE MY GRADES PAGE*/

session_start();
include 'config.php';

$student_id = $_SESSION['student_id'] ?? null;

if (!$student_id) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Optional: block access if student has a balance
$checkBalance = $conn->prepare("SELECT balance FROM students WHERE id = ?");
$checkBalance->bind_param("i", $student_id);
$checkBalance->execute();
$balanceResult = $checkBalance->get_result()->fetch_assoc();

if ($balanceResult['balance'] > 0) {
    echo json_encode(['blocked' => true, 'message' => 'Please settle your balance before checking your grades']);
    exit;
}

// ✅ Fetch the course name for this student
$courseQuery = $conn->prepare("
    SELECT c.name 
    FROM students s
    JOIN courses c ON s.course_id = c.id
    WHERE s.id = ?
");
$courseQuery->bind_param("i", $student_id);
$courseQuery->execute();
$courseResult = $courseQuery->get_result()->fetch_assoc();
$courseName = $courseResult['name'] ?? null;

// ✅ Get enrolled subjects with grades
$query = "
    SELECT s.name AS subject_name, s.code, es.semester, es.school_year, g.grade
    FROM enrolled_subjects es
    JOIN subjects s ON s.id = es.subject_id
    LEFT JOIN grades g ON g.subject_id = s.id AND g.student_id = es.student_id
    WHERE es.student_id = ?
    ORDER BY es.school_year DESC, es.semester DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$grades = [];
while ($row = $result->fetch_assoc()) {
    $row['name'] = $courseName; // ✅ Add course name to each grade entry
    $grades[] = $row;
}

echo json_encode($grades);

