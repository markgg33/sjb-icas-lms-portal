<?php
require 'config.php';

$sql = "SELECT id, first_name, last_name FROM users WHERE role = 'faculty'";
$result = $conn->query($sql);

$options = "";
while ($row = $result->fetch_assoc()) {
    $fullName = $row['last_name'] . ", " . $row['first_name'];
    $options .= "<option value='{$row['id']}'>" . htmlspecialchars($fullName) . "</option>";
}

echo $options ?: "<option disabled>No faculty found</option>";
