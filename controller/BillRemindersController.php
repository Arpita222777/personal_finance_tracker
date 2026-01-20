<?php
session_start();

// Auth check: redirect if not logged in
if (!isset($_SESSION['user_email'])) {
    header("Location:../view/signin.php");
    exit;
}

$userEmail = $_SESSION['user_email'];

// Initialize bills data from session or database (here session for demo)
if (!isset($_SESSION['bills'])) {
    $_SESSION['bills'] = [];
}

$bills = &$_SESSION['bills'];

$errors = [];
$success = "";

// Handle POST request to add bill
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['bill_name'] ?? '');
    $amount = $_POST['bill_amount'] ?? '';
    $date = $_POST['bill_date'] ?? '';

    // PHP validation
    if ($name === '') {
        $errors[] = "Bill name is required.";
    }
    if (!is_numeric($amount) || $amount <= 0) {
        $errors[] = "Amount must be a positive number.";
    }
    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors[] = "Valid due date is required.";
    }

    if (empty($errors)) {
        $bills[] = [
            'name' => htmlspecialchars($name),
            'amount' => floatval($amount),
            'date' => $date,
            'autoPay' => false,
        ];
        $success = "Bill added successfully.";
    }
}

// Pass variables to view
include __DIR__ . '/../view/billReminders.php';
