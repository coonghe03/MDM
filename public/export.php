<?php
require_once "../app/config/database.php";
require_once "../app/controllers/ItemController.php";

$itemCtrl = new ItemController($conn);
$items = $itemCtrl->getFiltered(1000, 0, "", ""); // export all

$format = $_GET['format'] ?? 'csv';

if ($format == 'csv') {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=items.csv");
    $out = fopen("php://output", "w");
    fputcsv($out, ["ID", "Code", "Name", "Brand", "Category", "Status"]);
    foreach ($items as $i) {
        fputcsv($out, [$i['id'], $i['code'], $i['name'], $i['brand_name'], $i['category_name'], $i['status']]);
    }
    fclose($out);
    exit;
}
elseif ($format == 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=items.xls");
    echo "ID\tCode\tName\tBrand\tCategory\tStatus\n";
    foreach ($items as $i) {
        echo "{$i['id']}\t{$i['code']}\t{$i['name']}\t{$i['brand_name']}\t{$i['category_name']}\t{$i['status']}\n";
    }
    exit;
}
elseif ($format == 'pdf') {
    require("../vendor/fpdf/fpdf.php");  // you need to install FPDF library
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial","B",12);
    $pdf->Cell(0,10,"Item List",0,1,"C");
    $pdf->SetFont("Arial","",10);
    foreach ($items as $i) {
        $pdf->Cell(0,8,"{$i['id']} - {$i['code']} - {$i['name']} - {$i['brand_name']} - {$i['category_name']} - {$i['status']}",0,1);
    }
    $pdf->Output();
    exit;
}
