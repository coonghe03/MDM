<?php
require_once __DIR__ . "/../config/database.php";

class BrandController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Brand
    public function create($code, $name, $status = "Active") {
        $sql = "INSERT INTO master_brands (code, name, status) VALUES (:code, :name, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':code' => $code,
            ':name' => $name,
            ':status' => $status
        ]);
    }

    // Get All Brands (with User Role)
public function getAll($limit, $offset, $is_admin, $user_id) {
    if ($is_admin) {
        $sql = "SELECT * FROM master_brands ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
    } else {
        $sql = "SELECT * FROM master_brands WHERE created_by = :user_id ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Count Brands (for pagination)
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM master_brands";
        return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get Single Brand
    public function getById($id) {
        $sql = "SELECT * FROM master_brands WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Brand
    public function update($id, $code, $name, $status) {
        $sql = "UPDATE master_brands SET code = :code, name = :name, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':code' => $code,
            ':name' => $name,
            ':status' => $status
        ]);
    }

    // Delete Brand
    public function delete($id) {
        $sql = "DELETE FROM master_brands WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
