<?php
session_start();
require_once "../app/config/database.php";
require_once "../app/controllers/AuthController.php";

$auth = new AuthController($conn);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($auth->register($_POST['name'], $_POST['email'], $_POST['password'])) {
        $message = "Registered successfully! Please login.";
    } else {
        $message = "Registration failed (Email may already exist).";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
    <p><?= $message ?></p>
    <a href="login.php">Already have an account? Login</a>
</body>
</html>
