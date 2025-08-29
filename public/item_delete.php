<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/ItemController.php";

$itemCtrl = new ItemController($conn);

if (isset($_GET['id'])) {
    $item = $itemCtrl->getById($_GET['id']);
    if ($item['attachment'] && file_exists("uploads/" . $item['attachment'])) {
        unlink("uploads/" . $item['attachment']);
    }
    $itemCtrl->delete($_GET['id']);
}

header("Location: items.php");
exit;
