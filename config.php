<?php
$host = 'localhost';
$user = 'root';
$pass = 'P@ssword3309807';
$dbname = 'sjb_capstone_db'; // change this

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
