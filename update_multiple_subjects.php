<?php
require 'config.php';

$updates = json_decode($_POST['updates'], true);

foreach ($updates as $row) {
    $stmt = $conn->prepare("UPDATE subjects SET code = ?, name = ? WHERE id = ?");
    $stmt->bind_param("ssi", $row['code'], $row['name'], $row['id']);
    $stmt->execute();
}

echo "success";
