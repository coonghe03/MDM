<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/ItemController.php";

// fetch brands and categories
$brands = $conn->query("SELECT id, name FROM master_brands")->fetchAll(PDO::FETCH_ASSOC);
$categories = $conn->query("SELECT id, name FROM master_categories")->fetchAll(PDO::FETCH_ASSOC);

$itemCtrl = new ItemController($conn);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = null;
    if (!empty($_FILES['attachment']['name'])) {
        $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
        $target = "../public/uploads/" . $filename;
        move_uploaded_file($_FILES["attachment"]["tmp_name"], $target);
    }

    if ($itemCtrl->create($_POST['brand_id'], $_POST['category_id'], $_POST['code'], $_POST['name'], $filename, $_POST['status'])) {
        header("Location: items.php");
        exit;
    } else {
        $message = "Failed to create item.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Item</title></head>
<body>
    <h2>Create Item</h2>
    <form method="POST" enctype="multipart/form-data">
        Code: <input type="text" name="code" required><br>
        Name: <input type="text" name="name" required><br>
        Brand:
        <select name="brand_id" required>
            <?php foreach ($brands as $b): ?>
                <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        Category:
        <select name="category_id" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        Attachment: <input type="file" name="attachment"><br>
        Status:
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br>
        <button type="submit">Save</button>
    </form>
    <p><?= $message ?></p>
    <a href="items.php">Back</a>
</body>
</html>
