<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

require_once "../app/config/database.php";
require_once "../app/controllers/BrandController.php";

$brandCtrl = new BrandController($conn);

if (isset($_GET['id'])) {
    $brandCtrl->delete($_GET['id']);
}

header("Location: brands.php");
exit;
