<?php
require_once '../models/CartModel.php';
require_once '../models/TransactionModel.php';
require_once '../libraries/fpdf.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$cartModel = new CartModel();
$transactionModel = new TransactionModel();
$cartItems = $cartModel->getCartByUserId($_SESSION['user_id']);
$totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));

// Tambah ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $cartModel->addToCart($_SESSION['user_id'], $_POST['product_id'], $_POST['quantity']);
    header("Location: keranjang.php");
    exit();
}

// Proses Checkout
if (isset($_POST['checkout'])) {
    if (empty($cartItems)) {
        echo "<p>Keranjang kosong! Tidak dapat melakukan checkout.</p>";
    } else {
        // Simpan transaksi
        $transactionId = $transactionModel->createTransaction($_SESSION['user_id'], $totalPrice, 'cash', 'pending');
        
        // Simpan detail transaksi
        foreach ($cartItems as $item) {
            $transactionModel->addTransactionDetail($transactionId, $item['product_id'], $item['quantity'], $item['price']);
        }

        // Hapus keranjang
        $cartModel->clearCart($_SESSION['user_id']);

        // Buat Invoice PDF
        generateInvoicePDF($transactionId, $cartItems, $totalPrice);

        header("Location: invoice.php?id=$transactionId");
        exit();
    }
}

// Fungsi untuk mencetak invoice dalam format PDF
function generateInvoicePDF($transactionId, $cartItems, $totalPrice) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Header
    $pdf->Cell(0, 10, 'Invoice Transaksi #' . $transactionId, 0, 1, 'C');
    $pdf->Ln(10);

    // Daftar Produk
    $pdf->SetFont('Arial', '', 12);
    foreach ($cartItems as $item) {
        $pdf->Cell(0, 10, $item['name'] . ' - ' . $item['quantity'] . ' x Rp' . number_format($item['price'], 2), 0, 1);
    }

    // Total Harga
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Total Harga: Rp' . number_format($totalPrice, 2), 0, 1, 'R');

    // Simpan ke file
    $filePath = "../invoices/invoice_$transactionId.pdf";
    $pdf->Output('F', $filePath);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td>Rp<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>Rp<?= number_format($totalPrice, 2) ?></td>
            </tr>
        </tfoot>
    </table>
    <form method="POST">
        <button type="submit" name="checkout">Checkout</button>
    </form>
</body>
</html>
