<?php
require_once '../models/TransactionModel.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$transactionModel = new TransactionModel();
$transactions = $transactionModel->getAllTransactions();

// Filter data berdasarkan tanggal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $transactions = $transactionModel->getTransactionsByDate($startDate, $endDate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
</head>
<body>
    <h1>Riwayat Transaksi</h1>
    <form method="POST">
        <label for="start_date">Dari Tanggal:</label>
        <input type="date" name="start_date" required>
        <label for="end_date">Sampai Tanggal:</label>
        <input type="date" name="end_date" required>
        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>User</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= $transaction['username'] ?></td>
                    <td><?= number_format($transaction['total_price'], 2) ?></td>
                    <td><?= ucfirst($transaction['payment_method']) ?></td>
                    <td><?= ucfirst($transaction['status']) ?></td>
                    <td><?= $transaction['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
