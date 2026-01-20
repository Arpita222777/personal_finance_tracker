<?php
session_start();

if (!isset($_SESSION['came_from_login']) || $_SESSION['came_from_login'] !== true) {
    header('Location: ../view/signin.php');
    exit;
}

// Basic validation
function validateForgotPasswordEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (validateForgotPasswordEmail($email)) {
        $_SESSION['came_from_forgot'] = true; // Give access to reset password
        $message = "Reset link sent to your email (simulated).";
        $message_type = 'success';
    } else {
        $message = "Please enter a valid email address.";
        $message_type = 'error';
    }
}

include '../view/forgotpassword.php';
