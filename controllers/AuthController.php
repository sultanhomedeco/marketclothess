<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userModel = new UserModel($db);
    $user = $userModel->getUserByUsername($username); // Ambil user dari MongoDB

    if ($user && password_verify($password, $user['password'])) {
        // Login sukses
        $_SESSION['user_id'] = (string) $user['_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: ../views/admin/dashboard.php');
        } else {
            header('Location: ../views/user/dashboard.php');
        }
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
