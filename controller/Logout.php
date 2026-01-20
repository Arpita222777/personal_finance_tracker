<?php
// Start session
session_start();

// Destroy session variables and session data
session_unset(); 
session_destroy();

// Optionally clear the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login page after logout
header('Location: ../view/signin.php'); // Adjust path if needed
exit();
?>
