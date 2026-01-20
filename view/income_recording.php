<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$incomeMessage = $_SESSION['income_message'] ?? '';
unset($_SESSION['income_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Income Manager - FinanceTracker</title>

  <!-- External Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


  <!-- Custom Styles -->
  <link rel="stylesheet" href="../assets/expenseCategories.css" />

  <style>
    .form-group {
      margin-bottom: 15px;
    }

    .input-field, select, textarea {
      width: 100%;
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .btn {
      padding: 8px 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    .container {
      padding: 20px;
    }
  </style>
</head>

<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <div class="user">
      <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['email']); ?>!</span>
      <form method="post" action="../controller/logout.php" style="display:inline;">
        <button type="submit">Logout</button>
      </form>
    </div>
  </header>

  <main class="container">
    <h1>Income Manager</h1>
    <section class="category-section">
      <h2><i class="far fa-plus-square"></i> Add New Income</h2>
      <form id="income-form" method="POST">

        <div class="form-group">
          <label for="incomeSource">Income Source:</label>
          <input type="text" id="incomeSource" name="income_source" required placeholder="e.g. Salary, Freelance" class="input-field" />
        </div>

        <div class="form-group">
          <label for="incomeAmount">Income Amount:</label>
          <input type="number" id="incomeAmount" name="income_amount" step="0.01" min="0" required class="input-field">
        </div>

        <div class="form-group">
          <label for="incomeDate">Income Date:</label>
          <input type="date" id="incomeDate" name="income_date" required class="input-field">
        </div>

        <div class="form-group">
          <label for="incomeDescription">Income Description:</label>
          <textarea id="incomeDescription" name="income_description" rows="3" placeholder="Add details..." class="input-field"></textarea>
        </div>

        <button type="button" class="btn" onclick="handleIncomeSubmit()">Submit</button>
      </form>

      <div id="income-message"><?php echo $incomeMessage; ?></div>

      <h2><i class="fas fa-list-alt"></i> Income List</h2>
      <table id="incomeTable" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Action</th>
            <th>Date</th>
            <th>Source</th> <!-- Added Source Column -->
            <th>Amount (₹)</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </main>

  <script src="../assets/incomeRecording.js"></script>

</body>
</html>
