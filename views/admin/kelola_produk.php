<?php
require_once '../models/ProductModel.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$productModel = new ProductModel();

// Tambah produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $productModel->addProduct($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_FILES['image']);
    header("Location: kelola_produk.php");
    exit();
}

// Hapus produk
if (isset($_GET['delete_id'])) {
    $productModel->deleteProduct($_GET['delete_id']);
    header("Location: kelola_produk.php");
    exit();
}

// Ambil semua produk
$products = $productModel->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk</title>
</head>
<body>
    <h1>Kelola Produk</h1>
    <form method="POST" enctype="multipart/form-data">
        <h2>Tambah Produk</h2>
        <label>Nama:</label>
        <input type="text" name="name" required><br>
        <label>Deskripsi:</label>
        <textarea name="description" required></textarea><br>
        <label>Harga:</label>
        <input type="number" name="price" required><br>
        <label>Kategori:</label>
        <input type="text" name="category" required><br>
        <label>Gambar:</label>
        <input type="file" name="image" required><br>
        <button type="submit" name="add_product">Tambah Produk</button>
    </form>

    <h2>Daftar Produk</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td><?= number_format($product['price'], 2) ?></td>
                    <td><?= $product['category'] ?></td>
                    <td><img src="../<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100"></td>
                    <td>
                        <a href="kelola_produk.php?delete_id=<?= $product['id'] ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
