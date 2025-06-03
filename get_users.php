<?php
include 'config.php';

$query = "SELECT id, first_name, middle_name, last_name, gender, email, role FROM users ORDER BY last_name";
$result = $conn->query($query);

$users = [];

while ($row = $result->fetch_assoc()) {
    $row['full_name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    $users[] = $row;
}

echo json_encode($users);
