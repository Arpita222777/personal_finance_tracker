<?php
require_once 'dbmodel.php';

class Transaction {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addTransaction($userId, $categoryId, $amount, $description, $date) {
        try {
            $this->db->beginTransaction();
    
            // Insert into transactions table with date
            $stmt = $this->db->prepare(
              "INSERT INTO transactions (user_id, category_id, amount, description, transaction_date) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$userId, $categoryId, $amount, $description, $date]);
    
            // Update spent in expense_categories
            $updateStmt = $this->db->prepare("UPDATE expense_categories SET spent = spent + ? WHERE id = ? AND user_id = ?");
            $updateStmt->execute([$amount, $categoryId, $userId]);
    
            $this->db->commit();
            return [true, "Transaction added and spent updated"];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Transaction insert failed: " . $e->getMessage());
            return [false, "Failed to add transaction: " . $e->getMessage()];
        }
    }


    public function getTransactionsByUser($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT t.id, c.name as category_name, t.amount, t.description, 
                        DATE_FORMAT(t.transaction_date, '%d-%m-%Y') as transaction_date
                 FROM transactions t
                 JOIN expense_categories c ON t.category_id = c.id
                 WHERE t.user_id = ?
                 ORDER BY t.transaction_date DESC"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Failed to fetch transactions: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTransaction($userId, $transactionId) {
        try {
            $this->db->beginTransaction();
    
            // Get the amount and category to subtract
            $stmt = $this->db->prepare("SELECT amount, category_id FROM transactions WHERE id = ? AND user_id = ?");
            $stmt->execute([$transactionId, $userId]);
            $txn = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$txn) {
                $this->db->rollBack();
                return ['success' => false, 'message' => 'Transaction not found'];
            }
    
            // Delete transaction
            $deleteStmt = $this->db->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
            $deleteStmt->execute([$transactionId, $userId]);
    
            // Update spent
            $updateStmt = $this->db->prepare("UPDATE expense_categories SET spent = spent - ? WHERE id = ? AND user_id = ?");
            $updateStmt->execute([$txn['amount'], $txn['category_id'], $userId]);
    
            $this->db->commit();
            return ['success' => true, 'message' => 'Transaction deleted'];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Delete transaction failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete transaction'];
        }
    }

    public function updateTransactionDescription($transactionId, $userId, $description) {
        try {
            $stmt = $this->db->prepare("UPDATE transactions SET description = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$description, $transactionId, $userId]);
            return [true, "Description updated"];
        } catch (PDOException $e) {
            error_log("Update failed: " . $e->getMessage());
            return [false, "Failed to update description"];
        }
    }
    
    
}
