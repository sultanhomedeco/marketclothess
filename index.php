<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: views/admin/dashboard.php');
    } else {
        header('Location: views/user/dashboard.php');
    }
    exit;
} else {
    header('Location: views/auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketClothes</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1 class="logo">MarketClothes</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="auth/login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Temukan Fashion Anda di MarketClothes</h2>
            <p>Belanja pakaian terbaru dengan harga terbaik!</p>
            <a href="produk.php" class="btn">Belanja Sekarang</a>
        </div>
    </section>

    <!-- Kategori Produk -->
    <section class="categories">
        <h2>Kategori Produk</h2>
        <div class="category-list">
            <div class="category">Pakaian Pria</div>
            <div class="category">Pakaian Wanita</div>
            <div class="category">Pakaian Anak-Anak</div>
            <div class="category">Promo</div>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MarketClothes. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
