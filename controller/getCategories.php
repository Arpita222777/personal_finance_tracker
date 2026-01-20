<?php
session_start();
require_once('../model/ExpenseCategory.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user']['id'];
$expenseCategory = new ExpenseCategory();

$categories = $expenseCategory->getCategoriesByUser($userId);

if ($categories !== false) {
    // Format data as needed
    echo json_encode(['success' => true, 'data' => $categories]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to load categories']);
}
?>