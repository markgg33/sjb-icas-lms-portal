<?php
include 'config.php';

$semester = $_GET['semester'];
$result = $conn->prepare("SELECT id, code, name, semester FROM subjects WHERE semester = ?");
$result->bind_param("i", $semester);
$result->execute();
$res = $result->get_result();

while ($row = $res->fetch_assoc()) {
    echo "<div class='form-check'>
            <input class='form-check-input' type='checkbox' name='subject_ids[]' value='{$row['id']}' id='subject{$row['id']}'>
            <label class='form-check-label' for='subject{$row['id']}'>
                {$row['code']} - {$row['name']} (Sem {$row['semester']})
            </label>
          </div>";
}
?>
