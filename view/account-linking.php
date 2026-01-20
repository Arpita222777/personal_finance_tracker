<?php
session_start();

if (!isset($_SESSION['user'])) {
    // Not logged in, redirect to signin page
    header('Location:../view/signin.php');
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'User'); // fallback username
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Savings Goals - Finance Tracker</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

   <link rel="stylesheet" href="../assets/account-linking.css" />
</head>
<body>

 
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <nav class="nav-links" id="navLinks">
      <a href="landing-page.php">Home</a>
      <a href="Dashboard.php">Dashboard</a>
      <a href="ProfileManagement.php">Profile</a>
      <a href="debt-tracking.php">Debt</a>
      <a href="tax-categories.php">Tax</a>
      <a href="reports.php">Reports</a>
      <a href="Logout.php">Logout</a>
    </nav>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
  </header> 

  <h1>Account Linking</h1>

  <div class="nav-buttons">
    <button onclick="showScreen('wizard')">Bank Connection Wizard</button>
    <button onclick="showScreen('sync')">Sync Status</button>
    <button onclick="showScreen('resolver')">Error Resolver</button>
  </div>

 
  <div id="wizard" class="section active">
    <h2>Bank Connection Wizard</h2>
    <form id="bankForm" method="POST" action="../controller/account-linkingcontroller.php">
    <label for="bankName">Bank Name</label>
    <input
      type="text"
      id="bankName"
      name="bankName"
      placeholder="e.g., Wells Fargo"
      value="<?php echo htmlspecialchars($old['bankName'] ?? ''); ?>"
      required
    >
    <?php if (isset($errors['bankName'])): ?>
      <p class="error"><?php echo $errors['bankName']; ?></p>
    <?php endif; ?>

    <label for="accountType">Account Type</label>
    <select id="accountType" name="accountType" required>
      <option value="" disabled <?php echo empty($old['accountType']) ? 'selected' : ''; ?>>Select account type</option>
      <option value="Checking" <?php echo (isset($old['accountType']) && $old['accountType'] === 'Checking') ? 'selected' : ''; ?>>Checking</option>
      <option value="Savings" <?php echo (isset($old['accountType']) && $old['accountType'] === 'Savings') ? 'selected' : ''; ?>>Savings</option>
      <option value="Credit" <?php echo (isset($old['accountType']) && $old['accountType'] === 'Credit') ? 'selected' : ''; ?>>Credit</option>
    </select>
    <?php if (isset($errors['accountType'])): ?>
      <p class="error"><?php echo $errors['accountType']; ?></p>
    <?php endif; ?>

    <label for="login">Online Banking Username</label>
    <input
      type="text"
      id="login"
      name="login"
      placeholder="Your username"
      value="<?php echo htmlspecialchars($old['login'] ?? ''); ?>"
      required
    >
    <?php if (isset($errors['login'])): ?>
      <p class="error"><?php echo $errors['login']; ?></p>
    <?php endif; ?>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Your password" required>
    <?php if (isset($errors['password'])): ?>
      <p class="error"><?php echo $errors['password']; ?></p>
    <?php endif; ?>

    <button type="submit">Connect</button>
  </form>
</div>
  </div>

  <div id="sync" class="section">
  <h2>Sync Status</h2>
  <div class="status-box">Bank of America - Last Sync: 2 hours ago</div>
  <div class="status-box">Wells Fargo - Last Sync: 10 mins ago</div>
  <label for="syncRate">Sync Frequency</label>
  <select id="syncRate">
    <option>Every 15 minutes</option>
    <option>Hourly</option>
    <option>Daily</option>
  </select>
  <button onclick="alert('Sync frequency updated')">Update Frequency</button>
</div>

  <div id="resolver" class="section">
  <h2>Error Resolver</h2>
  <div class="status-box error">⚠️ Chase: Login expired</div>
  <div class="status-box error">⚠️ Citi Bank: Incorrect password</div>

  <label for="bankFix">Select Bank</label>
  <select id="bankFix">
    <option>Chase</option>
    <option>Citi Bank</option>
  </select>

  <label for="newPassword">Enter New Password</label>
  <input type="password" id="newPassword" placeholder="Enter new password">

  <button onclick="resolveError()">Fix Connection</button>
</div>

   <script src="../assets/account-linking.js"></script>

</body>
</html>
