<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
  die('Akses ditolak');
}

$user_id = $_SESSION['user_id'];

// Ambil usaha
$business = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM businesses WHERE user_id=$user_id")
);

// 🔥 TAMBAHAN LOGIKA:
// kalau klik tambah produk
if (isset($_GET['add'])) {
  if ($business) {
    header("Location: ../product/add.php");
  } else {
    header("Location: ../business/add.php");
  }
  exit;
}

// Ambil produk
$products = [];
if ($business) {
  $products = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE business_id={$business['id']}"
  );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Wirausaha</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b>Dashboard Wirausaha</b>
  <nav>
    <a href="../index.php">Home</a>
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<div class="container">

<?php if(!$business): ?>

  <div class="card" style="text-align:center">
    <h2>Belum Ada Usaha</h2>
    <p>Silakan buat usaha terlebih dahulu</p>
    <a href="seller.php?add=1" class="btn">+ Buat Usaha</a>
  </div>

<?php else: ?>

  <div class="card">
    <h2><?= $business['name'] ?></h2>
    <p><?= $business['description'] ?></p>
   <a href="../product/add.php" class="btn">
  + Tambah Produk / Jasa
</a>

  </div>

  <div class="card">
    <h3>Produk & Jasa</h3>

    <?php if (mysqli_num_rows($products) == 0): ?>
      <p style="color:#6b7280">Belum ada produk atau jasa.</p>
    <?php endif; ?>

    <?php while($p = mysqli_fetch_assoc($products)): ?>
      <div class="item">
        <div>
          <b><?= $p['name'] ?></b><br>
          <span class="badge"><?= strtoupper($p['type']) ?></span>
        </div>
        <div class="price">
          Rp <?= number_format($p['price']) ?>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

<?php endif; ?>

</div>

<footer>
  © <?= date('Y') ?> UMKM Marketplace
</footer>

</body>
</html>
