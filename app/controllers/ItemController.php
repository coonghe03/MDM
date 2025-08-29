<?php
require_once __DIR__ . "/../config/database.php";

class ItemController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Item
    public function create($brand_id, $category_id, $code, $name, $attachment, $status = "Active") {
        $sql = "INSERT INTO master_items (brand_id, category_id, code, name, attachment, status) 
                VALUES (:brand_id, :category_id, :code, :name, :attachment, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':brand_id' => $brand_id,
            ':category_id' => $category_id,
            ':code' => $code,
            ':name' => $name,
            ':attachment' => $attachment,
            ':status' => $status
        ]);
    }

    // Get Items with Brand & Category names
    public function getAll($limit, $offset) {
        $sql = "SELECT i.*, b.name as brand_name, c.name as category_name
                FROM master_items i
                JOIN master_brands b ON i.brand_id = b.id
                JOIN master_categories c ON i.category_id = c.id
                ORDER BY i.id DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count items
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM master_items";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get by ID
    public function getById($id) {
        $sql = "SELECT * FROM master_items WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update($id, $brand_id, $category_id, $code, $name, $attachment, $status) {
        $sql = "UPDATE master_items SET brand_id=:brand_id, category_id=:category_id, 
                code=:code, name=:name, attachment=:attachment, status=:status WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':brand_id' => $brand_id,
            ':category_id' => $category_id,
            ':code' => $code,
            ':name' => $name,
            ':attachment' => $attachment,
            ':status' => $status
        ]);
    }

    // Delete
    public function delete($id) {
        $sql = "DELETE FROM master_items WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
