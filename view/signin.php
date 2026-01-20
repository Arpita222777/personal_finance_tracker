<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location:../view/dashboard.php'); // Redirect logged-in users
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign In - FinanceTracker</title>
  <link rel="stylesheet" href="../assets/signin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="form-container">
    <h2>Welcome Back</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form id="signin-form" method="POST" action="../controller/signinController.php" onsubmit="return validateForm();">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required />

      <label for="password">Password</label>
      <div class="password-container">
        <input type="password" id="password" name="password" placeholder="Enter your password" required />
        <span class="password-toggle" onclick="togglePassword()">
          <i class="fas fa-eye"></i>
        </span>
      </div>

      <button type="submit" class="btn-submit">Sign In</button>

      <div class="options">
        <label><input type="checkbox" name="remember" /> Remember me</label>
        <a href="../controller/initiateForgotFlow.php">Forgot Password?</a>

      </div>

      <a href="signup.php" class="back-link">Don't have an account? Sign Up</a>
    </form>
  </div>

  <script src="../assets/signinValidation.js"></script>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>
</html>
