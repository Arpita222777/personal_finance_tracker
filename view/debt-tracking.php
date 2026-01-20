<?php
session_start();
require_once('../model/DebtModel.php');

if (!isset($_SESSION['user'])) {
    header('Location: ../view/signin.php');
    exit;
}

$userId = $_SESSION['user']['id'];  // Make sure your session stores user id here
$username = htmlspecialchars($_SESSION['username'] ?? 'User');

$debtModel = new DebtModel();
$loans = $debtModel->getDebtsByUser($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Debt Tracking - Finance Tracker</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../assets/debt-tracking.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <nav class="nav-links" id="navLinks">
      <a href="landing-page.php">Home</a>
      <a href="dashboard.php">Dashboard</a>
      <a href="ProfileManagement.php">Profile</a>
      <a href="savings-goals.php">Savings</a>
      <a href="debt-tracking.php">Debt</a>
      <a href="tax-categories.php">Tax</a>
      <a href="account-linking.php">Accounts</a>
      <a href="reports.php">Reports</a>
      <a href="../controller/Logout.php">Logout</a>
    </nav>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
  </header>

  <h1>Debt Tracking</h1>

  <div class="nav-buttons">
    <button onclick="showScreen('dashboard')">Loan Dashboard</button>
    <button onclick="showScreen('calculator')">Payoff Calculator</button>
    <button onclick="showScreen('analyzer')">Interest Analyzer</button>
  </div>

  <!-- Loan Dashboard -->
  <div id="dashboard" class="section active">
    <h2>Loan Dashboard</h2>

    <form method="POST" action="../controller/debt-trackingcontroller.php" onsubmit="return validateLoanForm();">
      <label for="loanName">Loan Type</label>
      <input type="text" id="loanName" name="loanType" placeholder="e.g. Car Loan" required />
      
      <label for="loanAmount">Amount ($)</label>
      <input type="number" id="loanAmount" name="amount" placeholder="e.g. 10000" min="0" step="0.01" required />
      
      <label for="loanRate">APR (%)</label>
      <input type="number" id="loanRate" name="apr" placeholder="e.g. 5" min="0" step="0.01" required />
      
      <button type="submit" class="add-btn">Add Loan</button>
    </form>

    <div id="loanList">
      <?php if (!empty($loans)): ?>
        <table border="1" cellpadding="8" cellspacing="0">
          <thead>
            <tr>
              <th>Loan Type</th>
              <th>Amount ($)</th>
              <th>APR (%)</th>
              <th>Date Added</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($loans as $loan): ?>
              <tr>
                <td><?= htmlspecialchars($loan['loan_type']); ?></td>
                <td><?= htmlspecialchars($loan['amount']); ?></td>
                <td><?= htmlspecialchars($loan['apr']); ?></td>
                <td><?= htmlspecialchars($loan['created_at']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No loans found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Payoff Calculator -->
  <div id="calculator" class="section">
    <h2>Payoff Calculator</h2>
    <label for="amount">Loan Amount ($)</label>
    <input type="number" id="amount" placeholder="e.g. 10000" min="0" step="0.01" />
    <label for="rate">APR (%)</label>
    <input type="number" id="rate" placeholder="e.g. 5" min="0" step="0.01" />
    <label for="payment">Monthly Payment ($)</label>
    <input type="number" id="payment" placeholder="e.g. 250" min="0" step="0.01" />
    <button onclick="calculatePayoff()">Calculate</button>
    <div id="payoffResult" class="result"></div>
    <button class="add-btn" onclick="showScreen('dashboard')">← Back to Dashboard</button>
  </div>

  <!-- Interest Analyzer -->
  <div id="analyzer" class="section">
    <h2>Interest Analyzer</h2>
    <label for="iaAmount">Total Loan Amount ($)</label>
    <input type="number" id="iaAmount" placeholder="e.g. 20000" min="0" step="0.01" />
    <label for="iaRate">APR (%)</label>
    <input type="number" id="iaRate" placeholder="e.g. 4.5" min="0" step="0.01" />
    <label for="iaTerm">Term (years)</label>
    <input type="number" id="iaTerm" placeholder="e.g. 5" min="0" />
    <button onclick="analyzeInterest()">Analyze</button>
    <div id="interestResult" class="result"></div>
    <button class="add-btn" onclick="showScreen('dashboard')">← Back to Dashboard</button>
  </div>

  <!-- Show errors or success messages -->
  <?php
  if (!empty($_SESSION['debt_errors'])) {
      foreach ($_SESSION['debt_errors'] as $error) {
          echo "<p style='color:red;'>$error</p>";
      }
      unset($_SESSION['debt_errors']);
  }
  if (!empty($_SESSION['success'])) {
      echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
      unset($_SESSION['success']);
  }
  ?>

  <script src="../assets/debt-tracking.js"></script>
</body>
</html>
