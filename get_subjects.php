<?php
include 'config.php';

$result = $conn->query("SELECT id, code, name, semester FROM subjects");

while ($row = $result->fetch_assoc()) {
    echo "<div class='form-check'>
            <input class='form-check-input' type='checkbox' name='subject_ids[]' value='{$row['id']}' id='subject{$row['id']}'>
            <label class='form-check-label' for='subject{$row['id']}'>
                {$row['code']} - {$row['name']} (Sem {$row['semester']})
            </label>
          </div>";
}
?>
