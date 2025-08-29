<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/ItemController.php";

$itemCtrl = new ItemController($conn);

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$items = $itemCtrl->getAll($limit, $offset);
$total = $itemCtrl->count();
$totalPages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html>
<head><title>Items</title></head>
<body>
    <h2>Item Management</h2>
    <a href="item_create.php">+ Add Item</a>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Code</th><th>Name</th><th>Brand</th><th>Category</th><th>Status</th><th>Attachment</th><th>Action</th></tr>
        <?php foreach ($items as $i): ?>
            <tr>
                <td><?= $i['id'] ?></td>
                <td><?= htmlspecialchars($i['code']) ?></td>
                <td><?= htmlspecialchars($i['name']) ?></td>
                <td><?= htmlspecialchars($i['brand_name']) ?></td>
                <td><?= htmlspecialchars($i['category_name']) ?></td>
                <td><?= $i['status'] ?></td>
                <td>
                    <?php if ($i['attachment']): ?>
                        <a href="uploads/<?= $i['attachment'] ?>" target="_blank">View File</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="item_edit.php?id=<?= $i['id'] ?>">Edit</a> |
                    <a href="item_delete.php?id=<?= $i['id'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
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
