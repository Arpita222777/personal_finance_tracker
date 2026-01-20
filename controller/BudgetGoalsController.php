<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../view/signin.php");
    exit();
}

$userEmail = is_array($_SESSION['user']) && isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_SESSION['user'];

// Initialize or load data
$goals = $_SESSION['goals'] ?? [];
$threshold = $_SESSION['threshold'] ?? 100;

$errors = [];
$old = [];

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category'], $_POST['target'], $_POST['spent'])) {
        $cat = trim($_POST['category']);
        $tgt = (float)$_POST['target'];
        $spent = (float)$_POST['spent'];

        $old = ['category' => $cat, 'target' => $tgt, 'spent' => $spent];

        // Validation
        if ($cat === '') {
            $errors['category'] = 'Enter a category.';
        }
        if ($tgt <= 0) {
            $errors['target'] = 'Enter a valid target.';
        }
        if ($spent < 0) {
            $errors['spent'] = 'Enter spent amount.';
        }

        if (empty($errors)) {
            $goals[] = ['cat' => $cat, 'tgt' => $tgt, 'spent' => $spent];
            $_SESSION['goals'] = $goals;
            $old = [];
        }
    } elseif (isset($_POST['threshold'])) {
        $thresh = (int)$_POST['threshold'];
        if ($thresh < 1 || $thresh > 200) {
            $errors['threshold'] = 'Enter 1-200%.';
        } else {
            $threshold = $thresh;
            $_SESSION['threshold'] = $threshold;
        }
    }
}

// After processing, load the view and pass variables to it
require_once __DIR__ . '/../view/budgetGoals.php';
