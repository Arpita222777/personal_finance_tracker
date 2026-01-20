<?php
session_start();
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = md5(trim($_POST['password'] ?? ''));

    $found = false;

    if (file_exists("users.txt")) {
        $lines = file("users.txt");
        foreach ($lines as $line) {
            list($savedEmail, $savedPassword) = explode("|", trim($line));
            if ($savedEmail === $email && $savedPassword === $password) {
                $_SESSION['email'] = $email;
                $found = true;
                header("Location: dashboard.php");
                exit;
            }
        }
    }
/* */
    if (!$found) {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Personal Finance Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef3f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<div class='message'>$error</div>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Don't have an account? Register</a>
</div>
</body>
</html>
