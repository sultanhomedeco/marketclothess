public function createTransaction($data) {
    global $pdo;

    $stmt = $pdo->prepare("
        INSERT INTO transactions (user_id, total_price, payment_method, status) 
        VALUES (?, ?, ?, 'pending')
    ");
    $result = $stmt->execute([
        $data['user_id'],
        $data['total_price'],
        $data['payment_method'],
    ]);

    return $result ? $pdo->lastInsertId() : false;
}
