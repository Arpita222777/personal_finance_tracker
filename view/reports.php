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
  <title>Reports & Graphs - Finance Tracker</title>

  <!-- Font Awesome for Hamburger Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 
  <link rel="stylesheet" href="../assets/reports.css">
</head>
<body>

  <!-- Navbar -->
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <nav class="nav-links" id="navLinks">
      <a href="landing-page.php">Home</a>
      <a href="Dashboard.php">Dashboard</a>
      <a href="ProfileManagement.php">Profile</a>
      <a href="savings-goals.php">Savings</a>
      <a href="debt-tracking.php">Debt</a>
      <a href="tax-categories.php">Tax</a>
      <a href="account-linking.php">Accounts</a>
      <a href="../controller/Logout.php">Logout</a> <!-- Corrected Logout link -->
    </nav>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
  </header>

  <!-- Main Content -->
  <h1>Reports & Graphs</h1>

  <div class="nav-buttons">
    <button onclick="showSection('trends')">Spending Trends</button>
    <button onclick="showSection('incomeVsExpense')">Income vs Expense</button>
    <button onclick="showSection('netWorth')">Net Worth</button>
  </div>

  <div id="trends" class="report-section active">
    <h2>Spending Trends</h2>
    <canvas id="trendsChart"></canvas>
    <button class="export-btn" onclick="exportChart('trendsChart')">Export Chart</button>
  </div>

  <div id="incomeVsExpense" class="report-section">
    <h2>Income vs Expense</h2>
    <canvas id="incomeExpenseChart"></canvas>
    <button class="export-btn" onclick="exportChart('incomeExpenseChart')">Export Chart</button>
  </div>

  <div id="netWorth" class="report-section">
    <h2>Net Worth</h2>
    <canvas id="netWorthChart"></canvas>
    <button class="export-btn" onclick="exportChart('netWorthChart')">Export Chart</button>
  </div>

  <script src="../assets/reports.js"></script>
</body>
</html>
