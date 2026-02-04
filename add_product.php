<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') {
  header("Location: ../auth/login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$biz = mysqli_fetch_assoc(
  mysqli_query($conn, "SELECT * FROM businesses WHERE user_id=$user_id")
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = $_POST['name'];
  $price = $_POST['price'];
  $type  = $_POST['type'];

  mysqli_query($conn, "
    INSERT INTO products (business_id, name, price, type)
    VALUES ('{$biz['id']}', '$name', '$price', '$type')
  ");

  header("Location: seller.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Produk / Jasa</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b>Tambah Produk / Jasa</b>
  <nav>
    <a href="seller.php">← Kembali</a>
  </nav>
</header>

<div class="container">
  <div class="card" style="max-width:500px;margin:auto;">
    <h2>Form Produk / Jasa</h2>

    <form method="post">
      <label>Nama</label>
      <input name="name" required>

      <label>Harga</label>
      <input type="number" name="price" required>

      <label>Jenis</label>
      <select name="type">
        <option value="produk">Produk</option>
        <option value="jasa">Jasa</option>
      </select>

      <button type="submit">Simpan</button>
    </form>
  </div>
</div>

</body>
</html>
