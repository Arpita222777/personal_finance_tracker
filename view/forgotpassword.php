<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/resetpassword.css">
</head>
<body>
  <div class="form-container">
    <h2>Forgot Your Password?</h2>
    <p>Enter your email to receive a reset link</p>

    <?php if (!empty($message)): ?>
      <div class="<?= $message_type === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Your email" required>
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>
