<?php
require 'config.php';

$id = $_POST['id'];
$amount = $_POST['amount'];

if (!$id || $amount <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit;
}

$conn->query("UPDATE students SET balance = balance - $amount WHERE id = $id");
$res = $conn->query("SELECT balance FROM students WHERE id = $id");
$newBalance = $res->fetch_assoc()['balance'];

echo json_encode(["status" => "success", "message" => "Payment applied", "new_balance" => $newBalance]);
