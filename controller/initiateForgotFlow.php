<?php
session_start();
$_SESSION['came_from_login'] = true; // only set once
header('Location: forgotpassController.php'); // redirect to controller
exit;
