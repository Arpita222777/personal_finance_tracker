<?php
require_once 'dbmodel.php';
 
class SavingsGoalModel {
 
    private $conn;
 
    public function __construct() {
        $this->conn = getConnection();
    }
 
    public function addGoal($userId, $name, $target, $saved, $date) {
        $sql = "INSERT INTO savings_goals 
                (user_id, goal_name, target_amount, saved_amount, due_date) 
                VALUES (?, ?, ?, ?, ?)";
 
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isdds", $userId, $name, $target, $saved, $date);
 
        return $stmt->execute();
    }
}