<?php
require_once 'dbmodel.php';

class User {
    private $db;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create($username, $email, $password) {
        try {
            // Check if email exists
            if ($this->emailExists($email)) {
                return [false, "User with this email already exists."];
            }

            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table} (username, email, password, created_at, monthly_budget, currency) 
                VALUES (?, ?, ?, NOW(), 0.00, 'USD')"
            );

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([
                htmlspecialchars($username),
                htmlspecialchars($email),
                $hashedPassword
            ]);

            return [true, "User registered successfully"];
        } catch (PDOException $e) {
            return [false, "Registration failed: " . $e->getMessage()];
        }
    }

    public function authenticate($email, $password) {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM {$this->table} WHERE email = ?"
            );
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // Remove password from session data
                return [true, $user];
            }
            return [false, "Invalid email or password"];
        } catch (PDOException $e) {
            return [false, "Authentication failed: " . $e->getMessage()];
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $allowedFields = ['username', 'monthly_budget', 'currency'];
            $updates = [];
            $values = [];

            foreach ($data as $field => $value) {
                if (in_array($field, $allowedFields)) {
                    $updates[] = "$field = ?";
                    $values[] = htmlspecialchars($value);
                }
            }

            if (empty($updates)) {
                return [false, "No valid fields to update"];
            }

            $values[] = $userId;
            $sql = "UPDATE {$this->table} SET " . implode(", ", $updates) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);

            return [true, "Profile updated successfully"];
        } catch (PDOException $e) {
            return [false, "Update failed: " . $e->getMessage()];
        }
    }

    public function getProfile($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, username, email, monthly_budget, currency, created_at 
                FROM {$this->table} WHERE id = ?"
            );
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    private function emailExists($email) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function updatePassword($userId, $currentPassword, $newPassword) {
        try {
            // First verify the current password
            $stmt = $this->db->prepare("SELECT password FROM {$this->table} WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user['password'])) {
                return [false, "Current password is incorrect"];
            }

            // Update with new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE {$this->table} SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $userId]);

            return [true, "Password updated successfully"];
        } catch (PDOException $e) {
            return [false, "Password update failed: " . $e->getMessage()];
        }
    }
}