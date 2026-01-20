<?php
session_start();
require_once('../model/ExpenseCategory.php');

if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $userId = $_SESSION['user']['id'];
    $expenseCategory = new ExpenseCategory();

    if (isset($_POST['action']) && $_POST['action'] === 'saveCategory') {
        // Sanitize inputs
        $categoryName = trim($_POST['categoryName'] ?? '');
        $monthlyLimit = floatval(trim($_POST['monthlyLimit'] ?? 0));
       
        $spent = 0;
        if ($monthlyLimit > 0) {
            $spent = mt_rand(0, intval($monthlyLimit * 90)) / 100;
        }

        // Validation
        if (empty($categoryName)) {
            echo json_encode(['success' => false, 'message' => 'Category name is required.']);
            exit;
        }
        if ($monthlyLimit <= 0) {
            echo json_encode(['success' => false, 'message' => 'Monthly limit must be greater than 0.']);
            exit;
        }

        

        $result = $expenseCategory->createCategory($userId, $categoryName, $monthlyLimit, $spent);

        if ($result[0]) {
            // Add to session categories if needed
            $_SESSION['categories'][] = [
                'name' => $categoryName,
                'limit' => $monthlyLimit,
                'spent' => 0,
            ];
            echo json_encode([
                'success' => true,
                'message' => 'Category created successfully.',
                'category' => ['name' => $categoryName, 'limit' => $monthlyLimit, 'spent' => 0]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $result[1] ?? 'Failed to create category.'
            ]);
        }
        exit;
    }

    
    if (isset($_POST['action']) && $_POST['action'] === 'deleteCategory') {
        //echo json_encode(['success' => true, 'message' => 'inside delete.']);
        $categoryId = intval($_POST['categoryId'] ?? 0);
        if ($categoryId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID.']);
            exit;
        }
        list($success, $message) = $expenseCategory->deleteCategory($userId, $categoryId);
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }


    if (isset($_POST['action']) && $_POST['action'] === 'updateSpent') {
        $categoryId = intval($_POST['category_id'] ?? 0);
        $spentAmount = floatval($_POST['spent_amount'] ?? 0);
    
        if ($categoryId <= 0 || $spentAmount < 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            exit;
        }
    
        $result = $expenseCategory->updateSpentAmount($userId, $categoryId, $spentAmount);
    
        if ($result[0]) {
            echo json_encode(['success' => true, 'message' => 'Spent amount updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => $result[1]]);
        }
        exit;
    }
    

    

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
?>
