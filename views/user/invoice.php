<?php
require_once '../models/TransactionModel.php';

session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$transactionModel = new TransactionModel();
$transaction = $transactionModel->getTransactionById($_GET['id']);

if (!$transaction || $transaction['user_id'] != $_SESSION['user_id']) {
    echo "Transaksi tidak ditemukan.";
    exit();
}

// Lokasi file PDF
$invoicePath = "../invoices/invoice_" . $transaction['id'] . ".pdf";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice Transaksi</h1>
    <p>ID Transaksi: <?= $transaction['id'] ?></p>
    <p>Total Harga: Rp<?= number_format($transaction['total_price'], 2) ?></p>
    <p>Metode Pembayaran: <?= ucfirst($transaction['payment_method']) ?></p>
    <p>Status: <?= ucfirst($transaction['status']) ?></p>
    <p>Tanggal: <?= $transaction['created_at'] ?></p>
    <a href="<?= $invoicePath ?>" target="_blank">Unduh Invoice</a>
    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
