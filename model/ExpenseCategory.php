<?php
require_once 'dbmodel.php';

class ExpenseCategory {
    private $db;
    private $table = 'expense_categories';
   
    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function createCategory($userId, $name, $monthlyLimit, $spent) {
        try {
            if (!$this->db) {
                error_log("Database connection failed");
                return [false, "Database connection failed", null];
            }
            
            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table} (user_id, name, monthly_limit, spent) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$userId, trim($name), floatval($monthlyLimit), $spent]);
            return [true, "Category created successfully", $this->db->lastInsertId()];
        } catch (PDOException $e) {
            error_log("Failed to create category: " . $e->getMessage());
            return [false, "Failed to create category: " . $e->getMessage(), null];
        }
    }
    public function getCategoriesByUser($userId) {
        try {
            $stmt = $this->db->prepare("SELECT id, name, monthly_limit, spent FROM {$this->table} WHERE user_id = ?");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Failed to fetch categories: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCategory($userId, $categoryId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ? AND user_id = ?");
            $stmt->execute([$categoryId, $userId]);
    
            if ($stmt->rowCount() > 0) {
                return [true, "Category deleted successfully"];
            } else {
                return [false, "Category not found or you do not have permission to delete it"];
            }
        } catch (PDOException $e) {
            error_log("Failed to delete category: " . $e->getMessage());
            return [false, "Failed to delete category: " . $e->getMessage()];
        }
    }

    public function updateSpentAmount($userId, $categoryId, $spentAmount) {
        try {
            $stmt = $this->db->prepare("UPDATE {$this->table} SET spent = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$spentAmount, $categoryId, $userId]);
    
            if ($stmt->rowCount() > 0) {
                return [true, "Spent amount updated"];
            } else {
                return [false, "No rows updated (check category ownership or values)"];
            }
        } catch (PDOException $e) {
            error_log("Failed to update spent: " . $e->getMessage());
            return [false, "Database error: " . $e->getMessage()];
        }
    }
    
    
    
}