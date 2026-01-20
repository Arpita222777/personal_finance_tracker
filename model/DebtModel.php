<?php
require_once 'dbmodel.php';
class DebtModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addDebt($userId, $loanType, $amount, $apr) {
        $stmt = $this->conn->prepare("INSERT INTO debts (user_id, loan_type, amount, apr) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $loanType, $amount, $apr]);
    }

    public function getDebtsByUser($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM debts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
