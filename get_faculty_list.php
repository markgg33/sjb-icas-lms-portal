<?php
require 'config.php';

$res = $conn->query("SELECT id, first_name, last_name FROM users WHERE role='faculty' ORDER BY last_name");
$faculties = [];

while ($row = $res->fetch_assoc()) {
    $faculties[] = [
        "id" => $row['id'],
        "name" => $row['first_name'] . ' ' . $row['last_name']
    ];
}

echo json_encode($faculties);
