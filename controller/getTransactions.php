<?php
session_start();
require_once('../model/Transaction.php');
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user']['id'];
$transactionModel = new Transaction();
$transactions = $transactionModel->getTransactionsByUser($userId);

if ($transactions !== false) {
    echo json_encode(['success' => true, 'data' => $transactions]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to load transactions']);
}
