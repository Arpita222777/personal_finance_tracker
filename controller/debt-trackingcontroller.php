<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/DebtModel.php';

$model = new DebtModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loanType = trim($_POST['loanType'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $apr = floatval($_POST['apr'] ?? 0);
    $userId = $_SESSION['user']['id'] ?? null;

    $_SESSION['debt_errors'] = [];
    if (empty($loanType) || $amount <= 0 || $apr < 0) {
        $_SESSION['debt_errors'][] = "All fields are required and must be valid.";
    }

    if (empty($_SESSION['debt_errors']) && $userId) {
        if ($model->addDebt($userId, $loanType, $amount, $apr)) {
            $_SESSION['success'] = "Loan added successfully.";
        } else {
            $_SESSION['debt_errors'][] = "Failed to add loan.";
        }
    }

    header("Location: ../view/debt-tracking.php");
    exit;
}
