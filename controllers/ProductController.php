<?php
require_once 'models/ProductModel.php';

class ProductController {
    public function listProducts() {
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();

        require 'views/user/produk.php';
    }

    public function manageProducts() {
        $productModel = new ProductModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                $productModel->addProduct($_POST, $_FILES['image']);
            } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
                $productModel->deleteProduct($_POST['product_id']);
            }
        }

        $products = $productModel->getAllProducts();
        require 'views/admin/kelola_produk.php';
    }
}
?>
