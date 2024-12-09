<?php
require_once 'models/ProductModel.php';
require_once 'models/TransactionModel.php';

class AdminController {
    public function dashboard() {
        $productModel = new ProductModel();
        $transactionModel = new TransactionModel();

        $data = [
            'total_products' => $productModel->countProducts(),
            'total_transactions' => $transactionModel->countTransactions(),
            'sales_summary' => $transactionModel->getSalesSummary()
        ];

        require 'views/admin/dashboard.php';
    }

    public function manageProducts() {
        $productModel = new ProductModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                $productModel->addProduct($_POST, $_FILES['image']);
            }
            // Tambahkan logika untuk edit/hapus produk jika diperlukan
        }

        $products = $productModel->getAllProducts();
        require 'views/admin/kelola_produk.php';
    }

    public function transactionHistory() {
        $transactionModel = new TransactionModel();

        $transactions = $transactionModel->getAllTransactions();
        require 'views/admin/riwayat_transaksi.php';
    }
}
?>
