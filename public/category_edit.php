<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/CategoryController.php";

$catCtrl = new CategoryController($conn);

if (!isset($_GET['id'])) { header("Location: categories.php"); exit; }

$category = $catCtrl->getById($_GET['id']);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($catCtrl->update($_GET['id'], $_POST['code'], $_POST['name'], $_POST['status'])) {
        header("Location: categories.php");
        exit;
    } else {
        $message = "Failed to update category.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Category</title></head>
<body>
    <h2>Edit Category</h2>
    <form method="POST">
        Code: <input type="text" name="code" value="<?= htmlspecialchars($category['code']) ?>" required><br>
        Name: <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required><br>
        Status:
        <select name="status">
            <option value="Active" <?= $category['status']=="Active" ? "selected" : "" ?>>Active</option>
            <option value="Inactive" <?= $category['status']=="Inactive" ? "selected" : "" ?>>Inactive</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
    <p><?= $message ?></p>
    <a href="categories.php">Back</a>
</body>
</html>
