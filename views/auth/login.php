<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php'; // Pastikan autoload di-include
use MongoDB\Client;
require_once '../../models/UserModel.php';

// Koneksi MongoDB
try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->marketclothes; // Nama database
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buat objek UserModel dan dapatkan data pengguna berdasarkan username
    $userModel = new UserModel($db);
    $user = $userModel->getUserByUsername($username); // Mengambil user berdasarkan username

    if ($user && password_verify($password, $user['password'])) {
        // Login sukses
        $_SESSION['user_id'] = (string) $user['_id']; // Menggunakan _id MongoDB
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../user/dashboard.php');
        }
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>
