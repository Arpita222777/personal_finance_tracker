<?php
session_start();
require_once '../model/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!$email) {
        $_SESSION['error'] = "Please enter a valid email.";
        header('Location: ../view/signin.php');
        exit;
    }

    if (empty($password)) {
        $_SESSION['error'] = "Password is required.";
        header('Location: ../view/signin.php');
        exit;
    }

    $user = new User();
    [$success, $result] = $user->authenticate($email, $password);

    if ($success) {
        // Store user info in session
        $_SESSION['user'] = [
            'id' => $result['id'],
            'email' => $result['email'],
            'username' => $result['username']
        ];

        // Handle "remember me"
        if (isset($_POST['remember'])) {
            setcookie('remember_me', $result['email'], time() + (86400 * 30), "/"); // 30 days
        }

        $_SESSION['success'] = "Successfully signed in!";
        header('Location:../view/dashboard.php');
    } else {
        $_SESSION['error'] = $result;
        header('Location: ../view/signin.php');
    }
    exit;
} else {
    header('Location: ../view/signin.php');
    exit;
}
