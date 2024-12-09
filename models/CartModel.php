<?php
require_once 'config/database.php';

class CartModel {
    public function getCartByUserId($userId) {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT c.*, p.name, p.price 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCart($userId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
?>
