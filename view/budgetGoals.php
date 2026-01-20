<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/signin.php");
    exit();
}
$userEmail = $_SESSION['user']['email'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Budget Goals - FinanceTracker</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/budgetGoals.css" />
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
    <button class="active" data-tab="dashboard">Goal Dashboard</button>
    <button data-tab="progress">Progress Thermometer</button>
    <button data-tab="settings">Alert Settings</button>
  </nav>

  <main>
    <section id="dashboard" class="tab-content active">
      <div class="card">
        <h2>Set Spending Target</h2>
        <form id="goal-form" method="POST" novalidate>
          <label for="category">Category</label>
          <input type="text" id="category" name="category" value="<?= htmlspecialchars($old['category'] ?? '') ?>" required />
          <div class="error" style="display: <?= isset($errors['category']) ? 'block' : 'none' ?>">
            <?= $errors['category'] ?? '' ?>
          </div>

          <label for="target">Monthly Target (₹)</label>
          <input type="number" id="target" name="target" min="1" value="<?= htmlspecialchars($old['target'] ?? '') ?>" required />
          <div class="error" style="display: <?= isset($errors['target']) ? 'block' : 'none' ?>">
            <?= $errors['target'] ?? '' ?>
          </div>

          <label for="spent">Current Spent (₹)</label>
          <input type="number" id="spent" name="spent" min="0" value="<?= htmlspecialchars($old['spent'] ?? '') ?>" required />
          <div class="error" style="display: <?= isset($errors['spent']) ? 'block' : 'none' ?>">
            <?= $errors['spent'] ?? '' ?>
          </div>

          <button type="submit">Add Goal</button>
        </form>
      </div>

      <div class="goal-list" id="goal-list">
        <?php if (empty($goals)): ?>
          <p>No goals set yet.</p>
        <?php else: ?>
          <?php foreach ($goals as $g): ?>
            <div class="goal-item">
              <strong><?= htmlspecialchars($g['cat']) ?></strong>: ₹<?= htmlspecialchars($g['spent']) ?> / ₹<?= htmlspecialchars($g['tgt']) ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <section id="progress" class="tab-content">
      <h2 style="text-align:center;">Progress Thermometer</h2>
      <div id="progress-list">
        <?php if (empty($goals)): ?>
          <p>No goals to show progress for.</p>
        <?php else: ?>
          <?php foreach ($goals as $g):
            $pct = min(($g['spent'] / $g['tgt']) * 100, 200);
          ?>
            <div class="card">
              <h3><?= htmlspecialchars($g['cat']) ?></h3>
              <div class="thermo">
                <div class="thermo-inner" style="width:<?= $pct ?>%"><?= round($pct) ?>%</div>
              </div>
              <?php if ($pct > $threshold): ?>
                <p class="alert">⚠️ Exceeded your set threshold!</p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <section id="settings" class="tab-content">
      <div class="card">
        <h2>Alert Settings</h2>
        <form id="settings-form" method="POST" novalidate>
          <label for="threshold">Overspend Alert Threshold (%)</label>
          <input
            type="number"
            id="threshold"
            name="threshold"
            min="1"
            max="200"
            value="<?= htmlspecialchars($threshold) ?>"
            required
          />
          <div class="error" style="display: <?= isset($errors['threshold']) ? 'block' : 'none' ?>">
            <?= $errors['threshold'] ?? '' ?>
          </div>
          <button type="submit">Save Settings</button>
        </form>
      </div>
    </section>
  </main>

  <script src="../assets/budgetGoals.js"></script>
</body>
</html>
