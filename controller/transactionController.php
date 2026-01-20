<?php
session_start();
require_once('../model/Transaction.php');

if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $userId = $_SESSION['user']['id'];
    $transactionModel = new Transaction();

    if (isset($_POST['action']) && $_POST['action'] === 'addTransaction') {
        $categoryId = intval($_POST['category_id'] ?? 0);
        $amount = floatval($_POST['transaction_amount'] ?? 0);
        $description = trim($_POST['transaction_description'] ?? '');
        $date = $_POST['transaction_date'] ?? null;
    
        if ($categoryId <= 0 || $amount <= 0 || !$date) {
            echo json_encode(['success' => false, 'message' => 'Invalid category, amount or date']);
            exit;
        }
    
        list($success, $message) = $transactionModel->addTransaction($userId, $categoryId, $amount, $description, $date);
    
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
    
     // Delete Transaction
     if (isset($_POST['action']) && $_POST['action'] === 'deleteTransaction') {
        $txnId = intval($_POST['transactionId'] ?? 0);
        if ($txnId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid transaction ID']);
            exit;
        }

        $result = $transactionModel->deleteTransaction($userId, $txnId);
        echo json_encode($result);
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'updateDescription') {
        $transactionId = intval($_POST['transactionId'] ?? 0);
        $description = trim($_POST['description'] ?? '');
    
        if ($transactionId <= 0 || $description === '') {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
            exit;
        }
    
        list($success, $message) = $transactionModel->updateTransactionDescription($transactionId, $userId, $description);
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }
    

    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}
?>