<?php
require_once __DIR__ . '/../model/dbmodel.php';

class TaxCategoriesModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addDeduction($userId, $description, $amount) {
        $sql = "INSERT INTO tax_deductions (user_id, description, amount) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$userId, $description, $amount]);
    }

    public function getAllDeductions($userId) {
        $sql = "SELECT description, amount FROM tax_deductions WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
