<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../view/signin.php');
    exit;
}

require_once '../model/TaxCategoriesModel.php';

$model = new TaxCategoriesModel();
$userId = $_SESSION['user']['id']; // assuming user session stores user info in ['user']

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['deductionName'] ?? '');
    $amount = $_POST['deductionAmount'] ?? '';

    if ($description === '' || !is_numeric($amount) || floatval($amount) <= 0) {
        $_SESSION['error'] = "Please enter a valid description and amount.";
        header('Location: ../view/tax-categories.php');
        exit;
    }

    $success = $model->addDeduction($userId, $description, floatval($amount));
    if ($success) {
        $_SESSION['success'] = "Deduction added successfully.";
    } else {
        $_SESSION['error'] = "Failed to add deduction. Please try again.";
    }
    header('Location: ../view/tax-categories.php');
    exit;
}
