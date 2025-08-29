<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/CategoryController.php";

$catCtrl = new CategoryController($conn);

if (isset($_GET['id'])) {
    $catCtrl->delete($_GET['id']);
}

header("Location: categories.php");
exit;
