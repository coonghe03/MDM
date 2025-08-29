<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/CategoryController.php";

$catCtrl = new CategoryController($conn);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($catCtrl->create($_POST['code'], $_POST['name'], $_POST['status'])) {
        header("Location: categories.php");
        exit;
    } else {
        $message = "Failed to create category.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Category</title></head>
<body>
    <h2>Create Category</h2>
    <form method="POST">
        Code: <input type="text" name="code" required><br>
        Name: <input type="text" name="name" required><br>
        Status:
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br>
        <button type="submit">Save</button>
    </form>
    <p><?= $message ?></p>
    <a href="categories.php">Back</a>
</body>
</html>
