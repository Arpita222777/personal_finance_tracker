<?php
require_once '../model/Transaction.php';
require_once '../model/ExpenseCategory.php';
session_start();

$userId = $_SESSION['user']['id'] ?? null;
$format = $_GET['format'] ?? '';

if (!$userId) {
    http_response_code(401);
    exit('Unauthorized');
}

$transactionModel = new Transaction();
$categoryModel = new ExpenseCategory();

$transactions = $transactionModel->getTransactionsByUser($userId);
$categories = $categoryModel->getCategoriesByUser($userId);

if ($format === 'json') {
    echo json_encode([
        'success' => true,
        'transactions' => $transactions,
        'categories' => $categories
    ]);
    exit;
}

if ($format === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="FinanceReport.csv"');
    $output = fopen('php://output', 'w');

    // Write category section
    fputcsv($output, ['Expense Categories']);
    fputcsv($output, ['Name', 'Monthly Limit', 'Spent']);
    foreach ($categories as $cat) {
        fputcsv($output, [$cat['name'], $cat['monthly_limit'], $cat['spent']]);
    }

    fputcsv($output, []); // blank line
    fputcsv($output, ['Transactions']);
    fputcsv($output, ['Date', 'Category', 'Amount', 'Description']);
    foreach ($transactions as $txn) {
        fputcsv($output, [
            $txn['transaction_date'],
            $txn['category_name'],
            $txn['amount'],
            $txn['description']
        ]);
    }

    fclose($output);
    exit;
}
