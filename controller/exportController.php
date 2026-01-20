<?php
session_start();

// Mock download and encryption logic for now
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['export_type'] ?? '';
    $schedule = $_POST['schedule'] ?? 'none';
    $encrypt = $_POST['encrypt'] ?? 'no';

    // Simple validation
    if ($type === '') {
        $errors[] = "Please select an export format.";
    }

    if (empty($errors)) {
        // Create a fake filename
        $filename = "export_" . date("Ymd_His") . "." . $type;
        if ($encrypt === 'yes') {
            $filename .= ".enc";
        }

        // In a real app, you’d generate and store/export file here.
        $success = "Export scheduled successfully as <strong>$filename</strong> with " .
                   ($encrypt === 'yes' ? "encryption" : "no encryption") .
                   ($schedule !== 'none' ? ", scheduled $schedule." : ".");
    }

    // Pass results back to the view
    $_SESSION['export_result'] = [
        'errors' => $errors,
        'success' => $success
    ];
}

header("Location: ../view/exportWizard.php");
exit;
