<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/CategoryController.php";

$catCtrl = new CategoryController($conn);

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$categories = $catCtrl->getAll($limit, $offset);
$total = $catCtrl->count();
$totalPages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html>
<head><title>Categories</title></head>
<body>
    <h2>Category Management</h2>
    <a href="category_create.php">+ Add Category</a>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Code</th><th>Name</th><th>Status</th><th>Action</th></tr>
        <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['code']) ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= $c['status'] ?></td>
                <td>
                    <a href="category_edit.php?id=<?= $c['id'] ?>">Edit</a> |
                    <a href="category_delete.php?id=<?= $c['id'] ?>" onclick="return confirm('Delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
    </p>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
