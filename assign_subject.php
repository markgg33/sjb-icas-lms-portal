<?php
include 'config.php';

$course_id = $_POST['course_id'];
$semester = $_POST['semester'];
$subject_ids = $_POST['subject_ids'];

$success = false;

foreach ($subject_ids as $subject_id) {
    // Check if this subject is already assigned to the course and semester
    $check_query = "SELECT id FROM course_subjects WHERE course_id = ? AND subject_id = ? AND semester = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("iii", $course_id, $subject_id, $semester);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Not yet assigned — insert it
        $insert_query = "INSERT INTO course_subjects (course_id, subject_id, semester) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iii", $course_id, $subject_id, $semester);
        $insert_stmt->execute();
        $insert_stmt->close();
        $success = true;
    }

    $stmt->close();
}

echo $success ? "success" : "no_changes"; // can be handled in JS to notify "Subjects already assigned"
?>
