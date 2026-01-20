<?php
require_once('../controller/expenseCategoriesController.php');

$categoryMessage = $_SESSION['category_message'] ?? '';
unset($_SESSION['category_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Expense Categories - FinanceTracker</title>

  <!-- External Libraries -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>




  <!-- Custom Styles -->
  <link rel="stylesheet" href="../assets/expenseCategories.css" />

  <style>
    .modal {
      position: fixed;
      z-index: 999;
      left: 0; top: 0; width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
    }
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      margin: 10% auto;
      width: 90%;
      max-width: 400px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .input-field {
      width: 100%;
      padding: 6px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
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
    <div class="tabs">
      <!-- Tab Controls -->
    
      <input type="radio" id="tab1" name="tab-control" checked>
      <input type="radio" id="tab2" name="tab-control">
      <input type="radio" id="tab3" name="tab-control">


      <!-- Tab Buttons -->
      <div class="tab-buttons">
        <label for="tab1">Expense Manager</label>
        <label for="tab2">Spending Manager</label>
        <label for="tab3">Report Download</label>
      </div>


      <!-- Tab Content -->
      <div class="content-container">
        <!-- Tab 1 -->
        <div class="tab-content" id="tab-1-content">
          <h1>Expense Categories</h1>
          <section class="category-section">
            <h2><i class="far fa-plus-square"></i> Add New Category</h2>
            <form id="category-form" method="POST">
              <input type="hidden" name="action" value="add_category">
              <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="category_name" required>
              </div>
              <div class="form-group">
                <label for="monthlyLimit">Monthly Limit:</label>
                <input type="number" id="monthlyLimit" name="monthly_limit" step="0.01" min="0" required>
              </div>
              <button type="button" onclick="saveCategory()">Save Category</button>
            </form>

            <div id="category-message"><?php echo $categoryMessage; ?></div>

            <h2><i class="fas fa-list-alt"></i> Category List</h2>
            <table id="categoryTable" class="display">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Name</th>
                  <th>Monthly Limit (₹)</th>
                  <th>Spent (₹)</th>
                  <th>Progress</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </section>
        </div>

        <!-- Tab 2 -->
        <div class="tab-content" id="tab-2-content">
        <h1>Transactions</h1>
          <section class="category-section">
            <h2><i class="far fa-plus-square"></i> Add New Transaction</h2>
            <form id="transaction-form" method="POST">
              <div class="form-group">
                <label for="dropdownCategory">Category:</label>
                <select id="dropdownCategory" name="category_id" required>
                  <option value="">Loading...</option>
                </select>
              </div>
              <div class="form-group">
                <label for="transactionAmount">Transaction Amount:</label>
                <input type="number" id="transactionAmount" name="transaction_amount" step="0.01" min="0" required>
              </div>

              <div class="form-group">
                <label for="transactionDate">Transaction Date:</label>
                <input type="date" id="transactionDate" name="transaction_date" required />
              </div>

              <div class="form-group">
                <label for="transactionDescription">Transaction Description:</label>
                <textarea id="transactionDescription" name="transaction_description" rows="3" placeholder="Add details..."></textarea>
              </div>
              <button type="button" onclick="handleTransactionSubmit()">Submit</button>
            </form>
            <div id="transaction-message"></div>

            <h2><i class="fas fa-list-alt"></i> Transaction List</h2>
            <table id="transactionTable" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>Action</th> 
                  <th>Date</th>
                  <th>Category</th>
                  <th>Amount (₹)</th>
                  <th>Description</th>
                </tr>
              </thead>
            </table>

          </section>
        </div>


        
        <!-- Tab 3 -->
        <form onsubmit="event.preventDefault(); handleReportDownload();">
          <div class="form-group">
            <label for="reportFormat">Download Format:</label>
            <select id="reportFormat" name="format" required>
              <option value="pdf">PDF</option>
              <option value="csv">CSV</option>
            </select>
          </div>
          <button type="submit">Download Report</button>
        </form>






        <!-- Transaction Modal -->
        <div id="transactionModal" class="modal" style="display:none;">
          <div class="modal-content">
            <h2>Transaction Details</h2>
            
            <label for="modal-date">Date</label>
            <input type="text" id="modal-date" readonly>

            <label for="modal-category">Category</label>
            <input type="text" id="modal-category" readonly>

            <label for="modal-amount">Amount</label>
            <input type="text" id="modal-amount" readonly>

            <label for="modal-description">Description</label>
            <!-- <textarea id="modal-description"></textarea> -->
            <textarea id="modal-description-input"></textarea>

            <input type="hidden" id="modal-transaction-id" />

            <div style="margin-top: 10px;">
              <button onclick="updateTransactionDescription()">Update</button>
              <button onclick="$('#transactionModal').fadeOut()">Close</button>
            </div>
          </div>
        </div>





      </div>
    </div>
  </main>

  <div id="toast" class="toast"></div>
  <script src="../assets/expenseCategories.js"></script>
  <script src="../assets/transaction.js"></script>
</body>
</html>
