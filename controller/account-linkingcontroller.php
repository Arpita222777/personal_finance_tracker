<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../view/signin.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bankName = trim($_POST['bankName'] ?? '');
    $accountType = trim($_POST['accountType'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($bankName === '') {
        $errors['bankName'] = 'Bank Name is required.';
    }
    if ($accountType === '') {
        $errors['accountType'] = 'Account Type is required.';
    }
    if ($login === '') {
        $errors['login'] = 'Online Banking Username is required.';
    }
    if ($password === '') {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        // Normally, insert into DB or call API here...

        $_SESSION['success'] = 'Bank connected successfully.';
        header('Location: ../view/account-linking.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = [
            'bankName' => $bankName,
            'accountType' => $accountType,
            'login' => $login
        ];
        header('Location: ../view/account-linking.php');
        exit;
    }
}
?>
