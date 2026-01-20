<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign Up</title>
  <link rel="stylesheet" href="../assets/signup.css" />
</head>
<body>

  <div class="form-container">
    <h2>Sign Up</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form id="signup-form" method="POST" action="../controller/signupController.php" onsubmit="return validateForm();">
      <label for="username">Username</label>
      <input id="username" type="text" name="username" placeholder="Enter your username" required />

      <label for="email">Email</label>
      <input id="email" type="email" name="email" placeholder="Enter your email" required />

      <label for="password">Password</label>
      <input id="password" type="password" name="password" placeholder="Enter your password" required />

      <label for="confirm_password">Confirm Password</label>
      <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirm your password" required />

      <button type="submit">Register</button>
    </form>

    <a href="signin.php" class="back-link">Back to Login</a>

  </div>
  
  <script src="../assets/signupValidation.js"></script>
</body>
</html>
