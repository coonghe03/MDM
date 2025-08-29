<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/BrandController.php";

$brandCtrl = new BrandController($conn);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $brandCtrl->create($_POST['code'], $_POST['name'], $_POST['status'], $_SESSION['user_id']);
    if ($result === true) {
        header("Location: brands.php");
        exit;
    } else {
        $message = $result;
    }
}

?>
<!DOCTYPE html>
<html>
<head><title>Create Brand</title></head>
<body>
    <h2>Create Brand</h2>
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
    <a href="brands.php">Back</a>
</body>
</html>
