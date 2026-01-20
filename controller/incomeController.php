<?php
session_start();
require_once('../model/Income.php');

if (!isset($_SESSION['user'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $userId = $_SESSION['user']['id'];
    $incomeModel = new Income();

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $source = trim($_POST['source'] ?? '');
            $amount = floatval($_POST['amount'] ?? 0);
            $date = $_POST['date'] ?? null;
            $description = trim($_POST['description'] ?? '');

            if ($source === '' || $amount <= 0 || !$date) {
                echo json_encode(['success' => false, 'message' => 'Invalid source, amount or date']);
                exit;
            }

            list($success, $message) = $incomeModel->addIncome($userId, $source, $amount, $description, $date);
            echo json_encode(['success' => $success, 'message' => $message]);
            exit;
        }

        if ($action === 'delete') {
            $incomeId = intval($_POST['id'] ?? 0);
            if ($incomeId <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid income ID']);
                exit;
            }

            $result = $incomeModel->deleteIncome($userId, $incomeId);
            echo json_encode($result);
            exit;
        }

        if ($action === 'getAll') {
            $incomes = $incomeModel->getIncomesByUser($userId);
            if ($incomes !== false) {
                echo json_encode(['success' => true, 'data' => $incomes]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to fetch incomes']);
            }
            exit;
        }

        // Optional: update description if needed
        if ($action === 'updateDescription') {
            $incomeId = intval($_POST['incomeId'] ?? 0);
            $description = trim($_POST['description'] ?? '');

            if ($incomeId <= 0 || $description === '') {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }

            list($success, $message) = $incomeModel->updateIncomeDescription($incomeId, $userId, $description);
            echo json_encode(['success' => $success, 'message' => $message]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}
?>
