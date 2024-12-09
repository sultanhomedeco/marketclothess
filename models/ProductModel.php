<?php
require_once 'config/database.php';

class ProductModel {
    // Hitung jumlah produk
    public function countProducts() {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM products");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Ambil semua produk
    public function getAllProducts() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil produk berdasarkan kategori
    public function getProductsByCategory($categoryId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah produk baru
    public function addProduct($data, $image) {
        global $pdo;

        // Simpan gambar ke folder
        $imagePath = 'uploads/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $imagePath
        ]);
    }

    // Edit produk
    public function updateProduct($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $id
        ]);
    }

    // Hapus produk
    public function deleteProduct($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
