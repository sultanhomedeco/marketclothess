<?php
require_once '../models/ProductModel.php';
require_once '../models/TransactionModel.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$productModel = new ProductModel();
$transactionModel = new TransactionModel();

// Statistik data
$totalProducts = $productModel->getTotalProducts();
$totalTransactions = $transactionModel->getTotalTransactions();
$totalRevenue = $transactionModel->getTotalRevenue();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <?= $_SESSION['admin_name'] ?>!</p>
    <h2>Ringkasan Data</h2>
    <ul>
        <li>Total Produk: <?= $totalProducts ?></li>
        <li>Total Transaksi: <?= $totalTransactions ?></li>
        <li>Total Pendapatan: Rp <?= number_format($totalRevenue, 2) ?></li>
    </ul>
    <a href="kelola_produk.php">Kelola Produk</a> | 
    <a href="riwayat_transaksi.php">Riwayat Transaksi</a>
</body>
</html>
