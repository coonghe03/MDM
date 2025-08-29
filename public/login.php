<?php
session_start();
require_once "../app/config/database.php";
require_once "../app/controllers/AuthController.php";

$auth = new AuthController($conn);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($auth->login($_POST['email'], $_POST['password'])) {
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid login details.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p><?= $message ?></p>
    <a href="register.php">Create account</a>
</body>
</html>
