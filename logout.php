<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <link rel="stylesheet" href="../assets/style.css">
  <meta http-equiv="refresh" content="2;url=../index.php">
</head>
<body>

<header>
  <b>UMKM Marketplace</b>
</header>

<div class="container">
  <div class="card" style="text-align:center;max-width:400px;margin:auto">
    <h2>👋 Logout Berhasil</h2>
    <p style="color:#6b7280">
      Anda telah keluar dari akun.
    </p>

    <div style="margin:20px 0">
      <span class="badge">Redirect otomatis...</span>
    </div>

    <a href="../index.php" class="btn">
      Kembali ke Beranda
    </a>
  </div>
</div>

<footer>
  © <?= date('Y') ?> UMKM Marketplace
</footer>

</body>
</html>
