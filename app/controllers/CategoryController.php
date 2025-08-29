<?php
require_once __DIR__ . "/../config/database.php";

class CategoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($code, $name, $status = "Active", $user_id) {
        if (empty($code) || strlen($code) < 2) {
            return "Code must be at least 2 characters.";
        }
        if (empty($name) || strlen($name) < 3) {
            return "Name must be at least 3 characters.";
        }

        $sql = "INSERT INTO master_categories (code, name, status, created_by) 
                VALUES (:code, :name, :status, :created_by)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ':code' => $code,
            ':name' => $name,
            ':status' => $status,
            ':created_by' => $user_id
        ]);
        return $ok ? true : "Failed to create category.";
    }
}
