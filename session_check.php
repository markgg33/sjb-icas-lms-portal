<?php

// Redirect to login if not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: login_page.php");
    exit;
}

// Get current page name
$currentPage = basename($_SERVER['PHP_SELF']);

// Define allowed pages per user type
$allowedPages = [
    'admin' => ['adminDashboard.php'],
    'faculty' => ['facultyDashboard.php'],
    'student' => ['studentDashboard.php'],
];

// Get user type from session
$userType = $_SESSION['user_type'];

// Redirect to correct dashboard if user type mismatch
if (!in_array($currentPage, $allowedPages[$userType])) {
    header("Location: " . $allowedPages[$userType][0]);
    exit;
}
?>
