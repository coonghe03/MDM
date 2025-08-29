<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/BrandController.php";

$brandCtrl = new BrandController($conn);

if (!isset($_GET['id'])) { header("Location: brands.php"); exit; }

$brand = $brandCtrl->getById($_GET['id']);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($brandCtrl->update($_GET['id'], $_POST['code'], $_POST['name'], $_POST['status'])) {
        header("Location: brands.php");
        exit;
    } else {
        $message = "Failed to update brand.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Brand</title></head>
<body>
    <h2>Edit Brand</h2>
    <form method="POST">
        Code: <input type="text" name="code" value="<?= htmlspecialchars($brand['code']) ?>" required><br>
        Name: <input type="text" name="name" value="<?= htmlspecialchars($brand['name']) ?>" required><br>
        Status:
        <select name="status">
            <option value="Active" <?= $brand['status']=="Active" ? "selected" : "" ?>>Active</option>
            <option value="Inactive" <?= $brand['status']=="Inactive" ? "selected" : "" ?>>Inactive</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
    <p><?= $message ?></p>
    <a href="brands.php">Back</a>
</body>
</html>
