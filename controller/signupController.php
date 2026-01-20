<?php
session_start();
require_once '../model/User.php';

// Get form inputs
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Basic validation
if (!$username || !$email || !$password || !$confirm_password) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ../view/signup.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
    header("Location: ../view/signup.php");
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Password must be at least 6 characters.";
    header("Location: ../view/signup.php");
    exit();
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match.";
    header("Location: ../view/signup.php");
    exit();
}

// Create user
$user = new User();
[$success, $message] = $user->create($username, $email, $password);

if ($success) {
    $_SESSION['success'] = "Registration successful! Please log in.";
    header("Location: ../view/signin.php");
} else {
    $_SESSION['error'] = $message;
    header("Location: ../view/signup.php");
}
exit();