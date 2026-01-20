<?php
session_start();
 
require_once '../model/User.php';
 
/* 🔐 Authentication Check */
if (!isset($_SESSION['status']) && !isset($_COOKIE['status'])) {
    header("Location: ../view/signin.php");
    exit;
}
 
/* 🚫 Only POST allowed */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../view/savings-goals.php");
    exit;
}
 
/* 📥 Input */
$goalName   = trim($_POST['goalName'] ?? '');
$goalTarget = $_POST['goalTarget'] ?? '';
$goalSaved  = $_POST['goalSaved'] ?? '';
$goalDate   = $_POST['goalDate'] ?? '';
 
$errors = [];
 
/* ✅ Validation */
if (empty($goalName) || strlen($goalName) < 3) {
    $errors[] = "Goal name must be at least 3 characters.";
}
 
if (!is_numeric($goalTarget) || $goalTarget <= 0) {
    $errors[] = "Target amount must be a positive number.";
}
 
if (!is_numeric($goalSaved) || $goalSaved < 0 || $goalSaved > $goalTarget) {
    $errors[] = "Saved amount must be non-negative and not exceed target.";
}
 
if (empty($goalDate) || strtotime($goalDate) <= time()) {
    $errors[] = "Due date must be a future date.";
}
 
/* ❌ Validation Error */
if (!empty($errors)) {
    echo "<h3>Validation Errors</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul><a href='../view/savings-goals.php'>Back</a>";
    exit;
}
 
/* 🧠 Model Call */
$model = new SavingsGoalModel();
$userId = $_SESSION['user_id'];
 
$result = $model->addGoal(
    $userId,
    $goalName,
    (float)$goalTarget,
    (float)$goalSaved,
    $goalDate
);
 
/* 📤 Response */
if ($result) {
    header("Location: ../view/savings-goals.php?success=1");
} else {
    header("Location: ../view/savings-goals.php?error=1");
}
exit;