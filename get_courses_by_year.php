<?php
include 'config.php';

$yearLevel = $_GET['year_level'] ?? '';

if ($yearLevel !== '') {
    $stmt = $conn->prepare("SELECT id, name FROM courses WHERE year_level = ?");
    $stmt->bind_param("s", $yearLevel);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }

    $stmt->close();
}
?>