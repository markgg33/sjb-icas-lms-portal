<?php
include 'config.php';

$course_id = $_GET['course_id'];
$semester = $_GET['semester'];

$sql = "SELECT subjects.id, subjects.code, subjects.name 
        FROM course_subjects 
        JOIN subjects ON course_subjects.subject_id = subjects.id 
        WHERE course_subjects.course_id = ? AND course_subjects.semester = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $semester);
$stmt->execute();
$result = $stmt->get_result();

$html = '';
while ($row = $result->fetch_assoc()) {
  $html .= '<div class="form-check">
              <input class="form-check-input" type="checkbox" name="subject_ids[]" value="' . $row['id'] . '">
              <label class="form-check-label">' . htmlspecialchars($row['code']) . ' - ' . htmlspecialchars($row['name']) . '</label>
            </div>';
}

echo $html ?: '<p>No subjects found for this course and semester.</p>';
?>
