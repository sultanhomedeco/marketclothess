<?php
session_start();
require_once '../../config/database.php';
require_once '../../models/ProductModel.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Mengambil nama user yang login
$userName = $_SESSION['user_name'];

// Mengambil total produk untuk ringkasan
$productModel = new ProductModel($conn);
$totalProducts = $productModel->countProducts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?></h1>
    <h2>Dashboard</h2>
    <div class="summary">
        <p>Total Produk Tersedia: <?php echo $totalProducts; ?></p>
        <a href="produk.php">Lihat Produk</a>
    </div>
</body>
</html>
