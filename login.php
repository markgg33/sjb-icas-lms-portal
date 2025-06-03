<?php
session_start();
include 'config.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user_type = $_POST['user_type'] ?? '';

    if (!$email || !$password || !$user_type) {
        die("All fields are required.");
    }

    // Determine table based on user_type
    if ($user_type === 'admin' || $user_type === 'faculty') {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $user_type);
    } elseif ($user_type === 'student') {
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
    } else {
        die("Invalid user type selected.");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user_type;
            $_SESSION['email'] = $user['email'];

            if ($user_type === 'student') {
                $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['student_id'] = $user['id'];
                header("Location: studentDashboard.php");
            } elseif ($user_type === 'faculty' || $user_type === 'admin') {
                // Ensure first_name and last_name are stored in the users table
                $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
                header("Location: " . ($user_type === 'faculty' ? "facultyDashboard.php" : "adminDashboard.php"));
            }

            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with those credentials.";
    }
} else {
    echo "Invalid request.";
}
