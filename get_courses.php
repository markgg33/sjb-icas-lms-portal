<?php
include 'config.php';

$result = $conn->query("SELECT id, name, year_level FROM courses");

while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['name']} - Year {$row['year_level']}</option>";
}
?>
