<?php
session_start();

if (!isset($_SESSION['came_from_forgot']) || $_SESSION['came_from_forgot'] !== true) {
    header('Location: ../signin.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (strlen($newPassword) < 6) {
        $message = "Password must be at least 6 characters.";
        $message_type = 'error';
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
        $message_type = 'error';
    } else {
        $message = "Password successfully reset.";
        $message_type = 'success';
    }
}

include '../view/resetpassword.php';
