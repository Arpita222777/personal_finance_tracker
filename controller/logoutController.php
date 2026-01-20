<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_unset();
session_destroy();

// Optional: clear cookies if you use any for login persistence
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// Redirect to signin page after logout
header('Location: ../view/signin.php');
exit;
