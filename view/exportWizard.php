<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location:../view/signin.php");
  exit();
}
$result = $_SESSION['export_result'] ?? ['errors' => [], 'success' => ''];
unset($_SESSION['export_result']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Export Data | FinanceTracker</title>
  <link rel="stylesheet" href="../assets/export.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <div class="user">
      <span>
  Welcome, <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'Guest'; ?>!
</span>

      <button class="profile-btn" onclick="window.location.href='profile.php'">👤</button>
    </div>
  </header>

  <nav class="tabs">
    <button class="active" data-tab="wizard">Export Wizard</button>
    <button data-tab="format">Format Selector</button>
    <button data-tab="archive">Archive Manager</button>
  </nav>

  <main>
    <!-- Export Wizard -->
    <section id="wizard" class="tab-content active">
      <div class="card">
        <h2>Export Wizard</h2>

        <?php if (!empty($result['errors'])): ?>
          <div class="notif"><?= implode('<br>', $result['errors']) ?></div>
        <?php elseif (!empty($result['success'])): ?>
          <div class="success"><?= $result['success'] ?></div>
        <?php endif; ?>

        <form method="POST" action="../controller/exportController.php" id="export-form">
          <label for="export_type">Export Format:</label>
          <select name="export_type" id="export_type">
            <option value="">Select format</option>
            <option value="csv">CSV</option>
            <option value="pdf">PDF</option>
            <option value="qbo">QBO</option>
          </select>
          <div class="notif" id="type-error" style="display: none;">Please choose a format.</div>

          <label for="schedule">Schedule Backup:</label>
          <select name="schedule" id="schedule">
            <option value="none">None</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
          </select>

          <label for="encrypt">Encrypt File?</label>
          <select name="encrypt" id="encrypt">
            <option value="no">No</option>
            <option value="yes">Yes</option>
          </select>

          <button type="submit">Download</button>
        </form>
      </div>
    </section>

    <!-- Format Selector -->
    <section id="format" class="tab-content">
      <div class="card">
        <h2>Format Selector</h2>
        <p><strong>CSV:</strong> Best for spreadsheets and manual review.</p>
        <p><strong>PDF:</strong> Suitable for printing reports.</p>
        <p><strong>QBO:</strong> Use with QuickBooks for accounting.</p>
      </div>
    </section>

    <!-- Archive Manager -->
    <section id="archive" class="tab-content">
      <div class="card">
        <h2>Archive Manager</h2>
        <ul class="entry-list">
          <li class="entry-item">
            <span><strong>backup_may.csv.enc</strong></span>
            <span><a href="#">Download</a> | <a href="#">Delete</a></span>
          </li>
          <li class="entry-item">
            <span><strong>finance_april.pdf</strong></span>
            <span><a href="#">Download</a> | <a href="#">Delete</a></span>
          </li>
        </ul>
      </div>
    </section>
  </main>

  <script src="../assets/export.js"></script>
</body>
</html>
