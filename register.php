<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  mysqli_query(
    $conn,
    "INSERT INTO users (name,email,password,role)
     VALUES ('$name','$email','$password','$role')"
  );

  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
  <b>UMKM Marketplace</b>
  <span style="float:right">
    <a href="../index.php">Home</a>
    <a href="login.php">Login</a>
  </span>
</header>

<div class="container">
  <div class="card">
    <h2>Daftar Akun</h2>
    <form method="post">
      <input name="name" placeholder="Nama Lengkap" required>
      <input name="email" type="email" placeholder="Email" required>

      <!-- PASSWORD + TOGGLE -->
      <div style="position:relative;">
        <input name="password" type="password" id="password" placeholder="Password" required>

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

      <select name="role">
        <option value="buyer">Pembeli</option>
        <option value="seller">Wirausaha</option>
      </select>

      <button type="submit">Daftar</button>
    </form>
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
