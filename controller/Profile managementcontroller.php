<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../view/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Set JSON response header
    header('Content-Type: application/json');
    
    // Handle Password Update
    if (isset($_POST['action']) && $_POST['action'] === 'updatePassword') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $userId = $_SESSION['user']['id'];

        $errors = [];

        // Validate password requirements
        if (empty($currentPassword)) {
            $errors[] = "Current password is required.";
        }
        if (strlen($newPassword) < 6) {
            $errors[] = "New password must be at least 6 characters.";
        }
        if ($newPassword !== $confirmPassword) {
            $errors[] = "New passwords do not match.";
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => $errors[0]]);
            exit;
        }

        // Update password
        $user = new User();
        $result = $user->updatePassword($userId, $currentPassword, $newPassword);

        if ($result[0]) {
            echo json_encode(['success' => true, 'message' => $result[1]]);
        } else {
            echo json_encode(['success' => false, 'message' => $result[1]]);
        }
        exit;
    }
}
?>
<?php
session_start();
require_once '../model/User.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../view/signin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle Profile Edit
    if (isset($_POST['action']) && $_POST['action'] === 'editProfile') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $gender = $_POST['gender'] ?? '';
        $country = trim($_POST['country'] ?? '');
        $dob = $_POST['dob'] ?? '';

        $errors = [];

        if (empty($name)) $errors[] = "Name is required.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
        if (!in_array($gender, ['Male', 'Female', 'Other'])) $errors[] = "Invalid gender selected.";
        if (empty($country)) $errors[] = "Country is required.";
        if (empty($dob)) $errors[] = "Date of birth is required.";

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header("Location: ../view/ProfileManagement.php");
            exit;
        }

        // Save to database (placeholder)
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: ../view/ProfileManagement.php");
        exit;
    }
}
?>
