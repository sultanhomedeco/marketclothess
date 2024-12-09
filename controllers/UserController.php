<?php
require_once 'models/TransactionModel.php';
require_once 'models/CartModel.php';

class UserController {
    public function checkout() {
        $cartModel = new CartModel();
        $transactionModel = new TransactionModel();

        // Ambil daftar item di keranjang user
        $cartItems = $cartModel->getCartByUserId($_SESSION['user_id']);

        // Hitung total harga
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['payment_method'];

            // Tambahkan transaksi baru
            $transactionId = $transactionModel->createTransaction([
                'user_id' => $_SESSION['user_id'],
                'total_price' => $totalPrice,
                'payment_method' => $paymentMethod,
            ]);

            if ($transactionId) {
                // Hapus semua item di keranjang setelah transaksi
                $cartModel->clearCart($_SESSION['user_id']);
                header("Location: /user/invoice?id=$transactionId");
                exit();
            } else {
                echo "Terjadi kesalahan saat memproses transaksi.";
            }
        }

        require 'views/user/checkout.php';
    }
}
?>
