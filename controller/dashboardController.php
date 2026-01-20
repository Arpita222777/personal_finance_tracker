<?php
session_start();

if (isset($_POST['logout'])) {
    
    session_unset();
    session_destroy();

    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, "/");
    }

    header("Location: ../view/signin.php");
    exit;
}
