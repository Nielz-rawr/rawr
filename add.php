<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
  die('Akses ditolak');
}

$user_id = $_SESSION['user_id'];

// Ambil usaha milik user
$business = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM businesses WHERE user_id=$user_id")
);

if (!$business) {
  die('Anda belum memiliki usaha');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name     = mysqli_real_escape_string($conn, $_POST['name']);
  $price   = (int) $_POST['price'];
  $type    = $_POST['type'];      // produk / jasa
  $category= $_POST['category']; // makanan / fashion / jasa / elektronik

  /* =========================
     VALIDASI
  ========================= */
  if (!in_array($type, ['produk','jasa'])) {
    $error = 'Jenis tidak valid';
  }
  elseif (!in_array($category, ['makanan','fashion','jasa','elektronik'])) {
    $error = 'Kategori tidak valid';
  }
  // validasi upload gambar
  elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    $error = 'Gambar wajib diupload';
  }
  else {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array(strtolower($ext), $allowed)) {
      $error = 'Format gambar tidak didukung';
    } else {
      $imageName = time().'_'.rand(100,999).'.'.$ext;
      $uploadPath = '../uploads/products/'.$imageName;

      if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {

        $sql = "INSERT INTO products 
                (business_id, name, price, type, category, image)
                VALUES 
                ({$business['id']}, '$name', $price, '$type', '$category', '$imageName')";

        if (mysqli_query($conn, $sql)) {
          header("Location: ../dashboard/seller.php");
          exit;
        } else {
          $error = mysqli_error($conn);
        }

      } else {
        $error = 'Gagal upload gambar';
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk / Jasa</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b>Tambah Produk / Jasa</b>
  <nav>
    <a href="../dashboard/seller.php">Kembali</a>
    <a href="../auth/logout.php">Logout</a>
  </nav>
</header>

<div class="container">
  <div class="card">
    <h2>Form Produk / Jasa</h2>
    <p style="color:#6b7280;font-size:14px">
      Produk atau jasa ini akan tampil di katalog usaha Anda
    </p>

    <?php if ($error): ?>
      <div class="error-box"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <label>Nama Produk / Jasa</label>
      <input type="text" name="name" required>

      <label>Harga</label>
      <input type="number" name="price" required>

      <label>Jenis</label>
      <select name="type" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="produk">Produk</option>
        <option value="jasa">Jasa</option>
      </select>

      <label>Kategori</label>
      <select name="category" required>
        <option value="">-- Pilih Kategori --</option>
        <option value="makanan">Makanan & Minuman</option>
        <option value="fashion">Fashion</option>
        <option value="jasa">Jasa</option>
        <option value="elektronik">Elektronik</option>
      </select>

      <label>Foto Produk / Jasa</label>
      <input type="file" name="image" accept="image/*" required>

      <button type="submit">Simpan</button>
    </form>
  </div>
</div>

<footer>
  © <?= date('Y') ?> UMKM Marketplace
</footer>

</body>
</html>
