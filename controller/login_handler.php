<?php
session_start();
require_once '../model/dbmodel.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $remember = isset($_POST["remember"]);

    try {
        // Create database connection
        $database = new Database();
        $db = $database->connect();

        // Prepare and execute query
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION["user_id"] = $user['id'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["username"] = $user['username'];

            // Set remember-me cookie if requested
            if ($remember) {
                setcookie("email", $email, time() + (86400 * 30), "/"); // 30 days
            }

            header("Location: Dashboard.php");
            exit();
        } else {
            $_SESSION["error"] = "Invalid email or password.";
            header("Location: signin.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION["error"] = "Login failed. Please try again.";
        header("Location: signin.php");
        exit();
    }
}
?>