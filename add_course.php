<?php
include 'config.php';

$name = $_POST['name'];
$year_level = $_POST['year_level'];

// Check for duplicate
$check = $conn->prepare("SELECT id FROM courses WHERE name = ? AND year_level = ?");
$check->bind_param("si", $name, $year_level);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "duplicate";
} else {
    $stmt = $conn->prepare("INSERT INTO courses (name, year_level) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $year_level);
    $stmt->execute();
    echo "success";
}
?>
