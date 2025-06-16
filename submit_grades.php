<?php

//WORKING VERSION

/*require 'config.php';
session_start();

if (!isset($_SESSION['faculty_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$grades = $data['grades'] ?? [];
$subject_id = $data['subject_id'];
$semester = $data['semester'];
$school_year = $data['school_year'];

foreach ($grades as $entry) {
    $student_id = $entry['student_id'];
    $grade = $entry['grade'];

    $check = $conn->prepare("SELECT id FROM grades WHERE student_id = ? AND subject_id = ? AND semester = ? AND school_year = ?");
    $check->bind_param("iiss", $student_id, $subject_id, $semester, $school_year);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE grades SET grade = ? WHERE student_id = ? AND subject_id = ? AND semester = ? AND school_year = ?");
        $update->bind_param("siiss", $grade, $student_id, $subject_id, $semester, $school_year);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade, semester, school_year) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iisss", $student_id, $subject_id, $grade, $semester, $school_year);
        $insert->execute();
    }
}

echo json_encode(["status" => "success", "message" => "Grades submitted successfully."]);*/

require 'config.php';
session_start();

if (!isset($_SESSION['faculty_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$grades = $data['grades'] ?? [];
$subject_id = $data['subject_id'];
$semester = $data['semester'];
$school_year = $data['school_year'];

foreach ($grades as $entry) {
    $student_id = $entry['student_id'];
    $grade = $entry['grade'];

    $check = $conn->prepare("SELECT id FROM grades WHERE student_id = ? AND subject_id = ? AND semester = ? AND school_year = ?");
    $check->bind_param("iiss", $student_id, $subject_id, $semester, $school_year);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE grades SET grade = ? WHERE student_id = ? AND subject_id = ? AND semester = ? AND school_year = ?");
        $update->bind_param("siiss", $grade, $student_id, $subject_id, $semester, $school_year);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO grades (student_id, subject_id, grade, semester, school_year) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iisss", $student_id, $subject_id, $grade, $semester, $school_year);
        $insert->execute();
    }

    // ✅ Notify student after grade is updated or inserted
    $studentMsg = "Your grade for subject ID $subject_id was updated.";
    $studentUrl = "studentDashboard.php#grades-page";
    $type = "Grades";
    $user_type = "student";
    $faculty_id = $_SESSION['faculty_id'];

    $notify = $conn->prepare("INSERT INTO notifications (user_id, from_user_id, type, message, url, user_type) VALUES (?,?,?,?,?,?)");
    $notify->bind_param("iissss", $student_id, $faculty_id, $type, $studentMsg, $studentUrl, $user_type);
    $notify->execute();
}

echo json_encode(["status" => "success", "message" => "Grades submitted successfully."]);

