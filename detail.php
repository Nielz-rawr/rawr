<?php
include '../config/database.php';
$id = (int) $_GET['id'];

$business = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM businesses WHERE id=$id")
);

$products = mysqli_query(
  $conn, "SELECT * FROM products WHERE business_id=$id"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= $business['name'] ?></title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b><?= $business['name'] ?></b>
  <nav>
    <a href="../index.php">Kembali</a>
  </nav>
</header>

<div class="container">

<!-- CARD USAHA -->
<div class="card">
  <?php if(!empty($business['image'])): ?>
    <img 
      src="../uploads/business/<?= $business['image'] ?>"
       style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;margin-bottom:15px"
      class="hero-img"
    >
  <?php endif; ?>

  <h2><?= $business['name'] ?></h2>
  <p><?= $business['description'] ?></p>

  <a class="btn"
     href="https://wa.me/<?= $business['whatsapp'] ?>"
     target="_blank">
    Hubungi WhatsApp
  </a>
</div>

<!-- KATALOG -->
<div class="card">
  <h3>Katalog Produk & Jasa</h3>

  <?php if(mysqli_num_rows($products) == 0): ?>
    <p style="color:#6b7280">Belum ada produk atau jasa.</p>
  <?php else: ?>

  <div class="product-grid">
    <?php while($p = mysqli_fetch_assoc($products)): ?>
      <div class="product-card">

        <?php if(!empty($p['image'])): ?>
          <img 
            src="../uploads/products/<?= $p['image'] ?>"
            alt="<?= $p['name'] ?>"
             style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;margin-bottom:15px">
        <?php endif; ?>

        <b><?= $p['name'] ?></b><br>
        <span class="badge"><?= strtoupper($p['type']) ?></span><br>
        Rp <?= number_format($p['price']) ?>
      </div>
    <?php endwhile; ?>
  </div>

  <?php endif; ?>
</div>

</div>

<footer>© <?= date('Y') ?> UMKM Marketplace</footer>
</body>
</html>
