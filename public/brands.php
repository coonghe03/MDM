<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/BrandController.php";

$brandCtrl = new BrandController($conn);


$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$brands = $brandCtrl->getAll($limit, $offset, $_SESSION['is_admin'], $_SESSION['user_id']);
$total = $brandCtrl->count();
$totalPages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html>
<head><title>Brands</title></head>
<body>
    <h2>Brand Management</h2>
    <a href="brand_create.php">+ Add Brand</a>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Code</th><th>Name</th><th>Status</th><th>Action</th></tr>
        <?php foreach ($brands as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= htmlspecialchars($b['code']) ?></td>
                <td><?= htmlspecialchars($b['name']) ?></td>
                <td><?= $b['status'] ?></td>
                <td>
                    <a href="brand_edit.php?id=<?= $b['id'] ?>">Edit</a> |
                    <a href="brand_delete.php?id=<?= $b['id'] ?>" onclick="return confirm('Delete this brand?')">Delete</a>
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
