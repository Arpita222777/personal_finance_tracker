<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="../assets/resetpassword.css">
</head>
<body>
  <div class="container">
    <h2>Reset Your Password</h2>

    <?php if (!empty($message)): ?>
      <div class="<?= $message_type === 'success' ? 'success' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <input type="password" name="newPassword" placeholder="New Password" required />
      <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
