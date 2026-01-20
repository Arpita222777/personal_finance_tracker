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

  <!-- Font Awesome for hamburger icon --->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="../assets/savings-goals.css">
</head>
<body>

  <!-- Responsive Navbar -->
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <nav class="nav-links" id="navLinks">
      <a href="landing-page.php">Home</a>
      <a href="dashboard.php">Dashboard</a>
      <a href="ProfileManagement.php">Profile</a>
      <a href="debt-tracking.php">Debt</a>
      <a href="tax-categories.php">Tax</a>
      <a href="account-linking.php">Accounts</a>
      <a href="reports.php">Reports</a>
     <a href="../controller/Logout.php">Logout</a> <!-- Corrected Logout link -->
    </nav>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
  </header> 

  <!-- Page Content -->
  <h1>Savings Goals</h1>

  <div class="nav-buttons">
    <button onclick="showScreen('visualizer')">Goal Visualizer</button>
    <button onclick="showScreen('planner')">Contribution Planner</button>
    <button onclick="showScreen('tracker')">Milestone Tracker</button>
  </div>

  <!-- Goal Visualizer -->
 <div id="visualizer" class="section active">
    <h2>🎯 Goal Visualizer</h2>
    <form action="../controller/savings-goalscontroller.php" method="POST" onsubmit="return validateGoalForm()">
        <label>Goal Name</label>
        <input type="text" id="newGoalName" name="goalName" placeholder="e.g. Vacation Fund">

        <label>Target Amount ($)</label>
        <input type="number" id="newGoalTarget" name="goalTarget">

        <label>Current Saved ($)</label>
        <input type="number" id="newGoalSaved" name="goalSaved">

        <label>Due Date</label>
        <input type="date" id="newGoalDate" name="goalDate">

        <button type="submit" class="submit">Add Goal</button>
    </form>
    <div id="goalList"></div>
</div>
  <!-- Contribution Planner -->
  <div id="planner" class="section">
    <h2>📈 Contribution Planner</h2>
    <label>Target Amount</label>
    <input type="number" id="planTarget">

    <label>Amount per Transfer</label>
    <input type="number" id="planAmount">

    <label>Transfer Frequency</label>
    <select id="planFreq">
      <option value="30">Monthly</option>
      <option value="14">Bi-weekly</option>
      <option value="7">Weekly</option>
    </select>

    <button class="submit" onclick="estimateGoalDate()">Estimate Date</button>
    <div id="planResult" class="result"></div>
  </div>

  <!-- Milestone Tracker -->
  <div id="tracker" class="section">
    <h2>🏁 Milestone Tracker</h2>
    <label>Milestone Name</label>
    <input type="text" id="milestoneText">

    <label>Date Achieved</label>
    <input type="date" id="milestoneDate">

    <button class="submit" onclick="addMilestone()">Add Milestone</button>
    <div id="milestoneList"></div>
  </div>

  <!-- Scripts -->
  <script src="../assets/savings-goals.js"></script>
</body>
</html>
