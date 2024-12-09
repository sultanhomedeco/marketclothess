<?php
require_once '../models/TransactionModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$transactionModel = new TransactionModel();
$transactions = $transactionModel->getTransactionsByUserId($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
</head>
<body>
    <h1>Dashboard User</h1>
    <p>Selamat datang, <?= $_SESSION['username'] ?>!</p>
    <h2>Riwayat Pesanan</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= number_format($transaction['total_price'], 2) ?></td>
                    <td><?= ucfirst($transaction['status']) ?></td>
                    <td><?= $transaction['created_at'] ?></td>
                    <td><a href="invoice.php?id=<?= $transaction['id'] ?>">Lihat Invoice</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
