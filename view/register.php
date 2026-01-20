<?php
session_start();

// Retrieve server-side errors & old input from session
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

function old($key) {
    global $form_data;
    return htmlspecialchars($form_data[$key] ?? '');
}

function error($key) {
    global $errors;
    return isset($errors[$key]) ? "<span class='error'>{$errors[$key]}</span>" : "";
}

// Clear session errors & data after displaying once
unset($_SESSION['errors'], $_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Register</title>
<link rel="stylesheet" href="../assets/register.css" />
</head>
<body>
<div class="container">
  <h2>Registration</h2>
  <form method="POST" action="../controller/validation.php" onsubmit="return validateForm()">
    
    <input type="hidden" name="form_origin" value="register" />

    <label>First Name:</label>
    <input type="text" name="firstname" id="firstname" value="<?= old('firstname') ?>">
    <?= error('firstname') ?>
    <span class="error" id="fnameErr"></span>

    <label>Last Name:</label>
    <input type="text" name="lastname" id="lastname" value="<?= old('lastname') ?>">
    <?= error('lastname') ?>
    <span class="error" id="lnameErr"></span>

    <label>Email:</label>
    <input type="email" name="email" id="email" value="<?= old('email') ?>">
    <?= error('email') ?>
    <span class="error" id="emailErr"></span>

    <label>Password:</label>
    <input type="password" name="password" id="password">
    <?= error('password') ?>
    <span class="error" id="passErr"></span>

    <label>Confirm Password:</label>
    <input type="password" name="confirmPassword" id="confirmPassword">
    <?= error('confirmPassword') ?>
    <span class="error" id="confirmPassErr"></span>

    <label>Gender:</label>
    <div class="gender">
      <input type="radio" name="gender" value="Male" id="male" <?= (old('gender')==='Male') ? 'checked' : '' ?>> Male
      <input type="radio" name="gender" value="Female" id="female" <?= (old('gender')==='Female') ? 'checked' : '' ?>> Female
    </div>
    <?= error('gender') ?>
    <span class="error" id="genderErr"></span>

    <label>Date of Birth:</label>
    <input type="date" name="dob" id="dob" value="<?= old('dob') ?>">
    <?= error('dob') ?>
    <span class="error" id="dobErr"></span>

    <input type="submit" value="Register" />
  </form>

  <div class="login-link">
    <a href="Login.php">Already have an account? Login</a>
  </div>
</div>

<script src="../assets/register.js"></script>
</body>
</html>
