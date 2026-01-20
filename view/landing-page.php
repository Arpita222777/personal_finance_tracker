<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Finance Tracker Landing Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/landing.css">
</head>
<body>

  <header>
    <div class="container">
      <nav>
        <div><strong>FinanceTracker</strong></div>
        <div class="menu-toggle" id="menu-toggle">&#9776;</div>
        <ul id="nav-links">
          <li><a href="#home">Home</a></li>
          <li><a href="#features">Features</a></li>
          <li><a href="#testimonials">Testimonials</a></li>
          <li><a href="signup.php">Signup</a></li>
          <li><a href="signin.php">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section id="home" class="hero">
    <h1>Manage All Your Money in One App</h1>
    <p>Track spending, earn cashback, and reach your financial goals.</p>
    <a href="#signup" class="btn">Get Started</a>
  </section>

  <section id="features">
    <div class="container">
      <h2>Smart Features You'll Love</h2>
      <div class="features">
        
        <?php
          $features = [
            ["📦", "Manage Subscriptions", "Automatically detect and manage all your subscriptions."],
            ["📈", "Spending Insights", "Get categorized insights to improve your budgeting habits."],
            ["🧠", "Financial Goals", "Set custom goals and track your savings progress."],
            ["🔐", "Credit Scores", "Access your credit score and tips to improve it."],
            ["💼", "Net Worth", "Link all your accounts to see your complete net worth."],
            ["📱", "Widgets", "Monitor key stats directly from your mobile home screen."],
            ["🧾", "Tax Categories", "Track deductible expenses and export data for your accountant."],
            ["💳", "Debt Tracking", "Track loans, analyze interest, and plan payoff efficiently."],
            ["🏦", "Bank Account Linking", "Securely connect and sync your bank and credit accounts."],
            ["📊", "Financial Reports", "Visualize spending trends, net worth, and compare income vs expenses."]
          ];
          foreach ($features as $f) {
            echo "<div class='feature-card'>
                    <h3>{$f[0]} {$f[1]}</h3>
                    <p>{$f[2]}</p>
                  </div>";
          }
        ?>
      </div>
    </div>
  </section>

  <section id="testimonials" class="testimonials">
    <h2>What Our Users Say</h2>
    <div class="slider">
      <div class="slide active">"This app changed my life financially!" – Arpita</div>
      <div class="slide">"Simple, clean, and powerful." – Arpi</div>
      <div class="slide">"I finally understand my spending habits!" – Barua</div>
    </div>
    <div class="slider-controls">
      <button onclick="prevSlide()">❮</button>
      <button onclick="nextSlide()">❯</button>
    </div>
  </section>

  <section class="cta-section" id="signup">
    <h2>Get the App Now for Free</h2>
    <a href="signup.php" class="btn secondary">Signup</a>
  </section>

  <footer>
    <p>&copy; 2025 FinanceTracker. All rights reserved.</p>
  </footer>

  <script src="../assets/landing.js"></script>
</body>
</html>

