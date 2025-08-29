<?php
require_once __DIR__ . "/../config/database.php";

class CategoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Category
    public function create($code, $name, $status = "Active") {
        $sql = "INSERT INTO master_categories (code, name, status) VALUES (:code, :name, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':code' => $code,
            ':name' => $name,
            ':status' => $status
        ]);
    }

    // Get All Categories with Pagination
    public function getAll($limit, $offset) {
        $sql = "SELECT * FROM master_categories ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count Categories
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM master_categories";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get Single Category
    public function getById($id) {
        $sql = "SELECT * FROM master_categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Category
    public function update($id, $code, $name, $status) {
        $sql = "UPDATE master_categories SET code = :code, name = :name, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':code' => $code,
            ':name' => $name,
            ':status' => $status
        ]);
    }

    // Delete Category
    public function delete($id) {
        $sql = "DELETE FROM master_categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
