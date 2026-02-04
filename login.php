<?php
session_start();
include '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
  $u = mysqli_fetch_assoc($q);

  if ($u && password_verify($password, $u['password'])) {
    $_SESSION['user_id'] = $u['id'];
    $_SESSION['role'] = $u['role'];

    if ($u['role'] === 'seller') {
      header("Location: ../dashboard/seller.php");
    } else {
      header("Location: ../index.php");
    }
    exit;
  } else {
    $error = "Email atau password salah";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b>UMKM Marketplace</b>
  <nav>
    <a href="../index.php">Home</a>
    <a href="register.php">Daftar</a>
  </nav>
</header>

<div class="container">
  <div class="card login-card">
    <h2>Masuk Akun</h2>
    <p style="color:#6b7280;font-size:14px">
      Silakan login untuk melanjutkan
    </p>

    <?php if ($error): ?>
      <div class="error-box"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Email</label>
      <input type="email" name="email" required>

      <label>Password</label>
      <div style="position:relative;">
        <input type="password" name="password" id="password" required>

        <!-- ICON MATA -->
        <span id="eyeOpen" onclick="togglePassword()"
              style="position:absolute;right:12px;top:50%;
                     transform:translateY(-50%);
                     cursor:pointer;font-size:15px;color:#6b7280;">
          👁️
        </span>

        <span id="eyeClose" onclick="togglePassword()"
              style="position:absolute;right:12px;top:50%;
                     transform:translateY(-50%);
                     cursor:pointer;font-size:15px;color:#6b7280;display:none;">
          🙈
        </span>
      </div>

      <button type="submit">Login</button>
    </form>

    <p style="margin-top:15px;font-size:14px;text-align:center">
      Belum punya akun?
      <a href="register.php">Daftar di sini</a>
    </p>
  </div>
</div>

<footer>
  © <?= date('Y') ?> UMKM Marketplace
</footer>

<script>
function togglePassword() {
  const pwd = document.getElementById('password');
  const eyeOpen = document.getElementById('eyeOpen');
  const eyeClose = document.getElementById('eyeClose');

  if (pwd.type === 'password') {
    pwd.type = 'text';
    eyeOpen.style.display = 'none';
    eyeClose.style.display = 'inline';
  } else {
    pwd.type = 'password';
    eyeOpen.style.display = 'inline';
    eyeClose.style.display = 'none';
  }
}
</script>

</body>
</html>
