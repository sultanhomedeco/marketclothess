<?php
// Fungsi routing sederhana
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '/login':
        require 'views/auth/login.php';
        break;
    case '/admin/dashboard':
        require 'controllers/AdminController.php';
        (new AdminController())->dashboard();
        break;
    case '/admin/kelola-produk':
        require 'controllers/ProductController.php';
        (new ProductController())->manageProducts();
        break;
    case '/user/dashboard':
        require 'controllers/UserController.php';
        (new UserController())->dashboard();
        break;
    case '/user/produk':
        require 'controllers/ProductController.php';
        (new ProductController())->listProducts();
        break;
    default:
        echo "404 Page Not Found";
}
?>
