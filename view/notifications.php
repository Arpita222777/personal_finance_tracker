<?php
session_start();

// Dummy notifications for now (in real use, other modules can push into $_SESSION['notifications'])
if (!isset($_SESSION['notifications'])) {
  $_SESSION['notifications'] = [
    "Your electricity bill is due in 3 days.",
    "Monthly spending report is ready.",
    "You have set a new budget goal.",
  ];
}

// Load user and notification preferences
$user = $_SESSION['user']['username'] ?? 'User';
$settings = $_SESSION['notificationSettings'] ?? ['email' => true, 'push' => true];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifications - FinanceTracker</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #ffffff;
      --accent-color: #420c7f;
      --card-bg: #5c0ebd;
      --hover-bg: #32095f;
      --text-color: #1a1a1a;
      --bg-color: #f4f4f4;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
    }

    .navbar {
      background-color: var(--accent-color);
      color: var(--primary-color);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .tabs {
      display: flex;
      gap: 1rem;
      justify-content: center;
      background-color: var(--card-bg);
      padding: 0.75rem 1rem;
    }

    .tabs button {
      background: none;
      border: none;
      font-size: 1rem;
      color: white;
      background-color: var(--hover-bg);
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    .tabs button.active {
      background-color: var(--accent-color);
      font-weight: bold;
    }

    .tab-content {
      display: none;
      padding: 2rem;
    }

    .tab-content.active {
      display: block;
    }

    .card {
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      max-width: 600px;
      margin: auto;
      margin-bottom: 2rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .notif-item {
      padding: 1rem;
      border-bottom: 1px solid #ddd;
    }

    .toggle-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 1rem 0;
    }

    .save-btn {
      background-color: var(--accent-color);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    .save-btn:hover {
      background-color: var(--hover-bg);
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo">FinanceTracker</div>
    <div>Welcome, <?= htmlspecialchars($user) ?></div>
  </header>

  <div class="tabs">
    <button class="active" data-tab="center">Notification Center</button>
    <button data-tab="settings">Notification Settings</button>
  </div>

  <main>
    <section id="center" class="tab-content active">
      <div class="card">
        <h2>Notifications</h2>
        <div id="notif-list">
          <?php if (!empty($_SESSION['notifications'])): ?>
            <?php foreach ($_SESSION['notifications'] as $notif): ?>
              <div class="notif-item"><?= htmlspecialchars($notif) ?></div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No notifications.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section id="settings" class="tab-content">
      <div class="card">
        <h2>Notification Preferences</h2>
        <form method="post">
          <div class="toggle-item">
            <label for="email-toggle">Email Alerts</label>
            <input type="checkbox" name="email" id="email-toggle" <?= $settings['email'] ? 'checked' : '' ?>>
          </div>
          <div class="toggle-item">
            <label for="push-toggle">Push Alerts (in-app)</label>
            <input type="checkbox" name="push" id="push-toggle" <?= $settings['push'] ? 'checked' : '' ?>>
          </div>
          <button class="save-btn" type="submit" name="save">Save Settings</button>
        </form>
        <?php
          if (isset($_POST['save'])) {
            $_SESSION['notificationSettings'] = [
              'email' => isset($_POST['email']),
              'push' => isset($_POST['push'])
            ];
            echo "<p>Preferences saved!</p>";
          }
        ?>
      </div>
    </section>
  </main>

  <script>
    // Tab switching
    document.querySelectorAll(".tabs button").forEach(button => {
      button.addEventListener("click", () => {
        document.querySelectorAll(".tabs button").forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");
        document.querySelectorAll(".tab-content").forEach(tab => tab.classList.remove("active"));
        document.getElementById(button.dataset.tab).classList.add("active");
      });
    });
  </script>
</body>
</html>
