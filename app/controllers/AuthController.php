<?php
require_once __DIR__ . "/../config/database.php";

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user with validation
    public function register($name, $email, $password) {
        
        if (empty($name) || strlen($name) < 3) {
            return "Name must be at least 3 characters.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }
        if (strlen($password) < 6) {
            return "Password must be at least 6 characters.";
        }

        // Check duplicate email
        $check = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->rowCount() > 0) {
            return "Email already exists.";
        }

        // Insert
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([':name'=>$name, ':email'=>$email, ':password'=>$hashed])) {
            return true;
        }
        return "Registration failed.";
    }

    // Login
    public function login($email, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }
        if (empty($password)) {
            return "Password required.";
        }

        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return true;
        }
        return "Invalid login credentials.";
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    public static function checkAuth() {
        return isset($_SESSION['user_id']);
    }
}
