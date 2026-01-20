<?php
session_start(); // start session to access $_SESSION

// Initialize variables if not set to avoid warnings
if (!isset($errors)) $errors = [];
if (!isset($success)) $success = '';
if (!isset($bills)) $bills = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bill Reminders - FinanceTracker</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/billReminders.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <div class="user">
     <span>Welcome, <?php echo htmlspecialchars($_SESSION['user']['email']); ?>!</span>

      <form method="POST" action="../signout.php" style="display:inline;">
        <button type="submit" class="profile-btn">Logout 👤</button>
      </form>
    </div>
  </header>

  <nav class="tabs">
    <button class="active" data-tab="calendar">Bill Calendar</button>
    <button data-tab="autopay">Auto-Pay Setup</button>
    <button data-tab="notifications">Notifications & History</button>
  </nav>

  <main>
    <?php if ($errors): ?>
      <div class="error-box">
        <ul>
          <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="success-box"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Bill Calendar -->
    <section id="calendar" class="tab-content active">
      <div class="card">
        <h2>Add a Bill</h2>
        <form id="bill-form" method="POST" novalidate>
          <label for="bill_name">Bill Name</label>
          <input type="text" id="bill_name" name="bill_name" required />
          <label for="bill_amount">Amount (₹)</label>
          <input type="number" id="bill_amount" name="bill_amount" min="0.01" step="0.01" required />
          <label for="bill_date">Due Date</label>
          <input type="date" id="bill_date" name="bill_date" required />
          <button type="submit">Add Bill</button>
        </form>
      </div>
      <div class="entry-list" id="bill-list">
        <?php foreach ($bills as $bill): ?>
          <div class="entry-item">
            <span><?= htmlspecialchars($bill['name']) ?> - ₹<?= number_format($bill['amount'], 2) ?> due on <?= htmlspecialchars($bill['date']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Auto-Pay -->
    <section id="autopay" class="tab-content">
      <div class="card">
        <h2>Enable Auto-Pay</h2>
        <div class="entry-list" id="autopay-list">
          <?php foreach ($bills as $index => $bill): ?>
            <div class="entry-item">
              <span><?= htmlspecialchars($bill['name']) ?> - <?= $bill['autoPay'] ? '✅ Auto-Pay Enabled' : '❌ Auto-Pay Off' ?></span>
              <form method="POST" action="../controller/toggleAutoPay.php" style="display:inline;">
                <input type="hidden" name="bill_index" value="<?= $index ?>" />
                <button type="submit">Toggle</button>
              </form>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Notifications -->
    <section id="notifications" class="tab-content">
      <div class="card">
        <h2>Upcoming Alerts</h2>
        <div id="notif-list">
          <?php
          $today = new DateTime();
          $upcoming = [];
          $history = [];
          foreach ($bills as $bill) {
              $due = new DateTime($bill['date']);
              $diff = $today->diff($due)->days;
              if ($due > $today && $diff === 3) {
                  $upcoming[] = "Reminder: {$bill['name']} is due in 3 days (₹{$bill['amount']})";
              }
              if ($due < $today && $bill['autoPay']) {
                  $history[] = "Auto-paid {$bill['name']} of ₹{$bill['amount']} on {$bill['date']}";
              }
          }
          if ($upcoming):
            foreach ($upcoming as $note): ?>
              <p class="notif"><?= htmlspecialchars($note) ?></p>
            <?php endforeach;
          else: ?>
            <p>No alerts.</p>
          <?php endif; ?>
        </div>

        <h3 style="margin-top: 2rem;">Payment History</h3>
        <div id="history-list">
          <?php if ($history):
            foreach ($history as $note): ?>
              <p><?= htmlspecialchars($note) ?></p>
            <?php endforeach;
          else: ?>
            <p>No history.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <script src="../assets/billReminders.js"></script>
</body>
</html>
