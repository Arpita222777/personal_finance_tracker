<?php
require_once 'dbmodel.php';

class Income {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addIncome($userId, $source, $amount, $description, $date) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO incomes (user_id, source, amount, description, income_date) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$userId, $source, $amount, $description, $date]);

            return [true, "Income added successfully"];
        } catch (PDOException $e) {
            error_log("Income insert failed: " . $e->getMessage());
            return [false, "Failed to add income: " . $e->getMessage()];
        }
    }

    public function getIncomesByUser($userId) {
        try {
            $stmt = $this->db->prepare(
                "SELECT id, source , amount, DATE_FORMAT(income_date, '%d-%m-%Y') AS date, description
                 FROM incomes
                 WHERE user_id = ?
                 ORDER BY income_date DESC"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Failed to fetch incomes: " . $e->getMessage());
            return false;
        }
    }
    

    public function deleteIncome($userId, $incomeId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM incomes WHERE id = ? AND user_id = ?");
            $stmt->execute([$incomeId, $userId]);

            return ['success' => true, 'message' => 'Income deleted'];
        } catch (PDOException $e) {
            error_log("Delete income failed: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete income'];
        }
    }

    public function updateIncomeDescription($incomeId, $userId, $description) {
        try {
            $stmt = $this->db->prepare("UPDATE incomes SET description = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$description, $incomeId, $userId]);

            return [true, "Description updated"];
        } catch (PDOException $e) {
            error_log("Update income description failed: " . $e->getMessage());
            return [false, "Failed to update description"];
        }
    }
}
