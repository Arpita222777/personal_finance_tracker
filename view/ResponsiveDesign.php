<?php
session_start();
// Check if session or cookie is set
if (!isset($_SESSION['status']) && !isset($_COOKIE['status'])) {
    header('Location: Login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Responsive Layout</title>
  
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 <link rel="stylesheet" href="../assets/ResponsiveDesign.css">
</head>
<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <nav class="nav-links" id="navLinks">
      <a href="landing-page.php">Home</a>
      <a href="Dashboard.php">Dashboard</a>
<a href="Profile management.php">Profile</a>
<a href="savings-goals.php">Savings</a>
<a href="debt-tracking.php">Debt</a>
<a href="tax-categories.php">Tax</a>
<a href="account-linking.php">Accounts</a>
<a href="reports.php">Reports</a>
<a href="../controller/Logout.php">Logout</a> <!-- Corrected Logout link -->

    </nav>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>

  </header>

  <main class="content">
    <section class="hero">
      <h1>Welcome to your Finance Tracker</h1>
      <p>Track expenses, income, and savings effortlessly across all your devices.</p>
    </section>
  </main>
script src="../assets/ResponsiveDesign.js"></script>

</body>
</html>
