<?php
require_once __DIR__ . "/../config/database.php";

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register($name, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $hashed
        ]);
    }

    // Login user
    public function login($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return true;
        }
        return false;
    }

    // Logout user
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    public static function checkAuth() {
        return isset($_SESSION['user_id']);
    }
}
