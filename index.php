<?php 
include 'config/database.php';

$q        = $_GET['q'] ?? '';
$type     = $_GET['type'] ?? '';
$min      = $_GET['min'] ?? '';
$max      = $_GET['max'] ?? '';
$category = $_GET['category'] ?? '';

$where = [];

/* =========================
   SMART CATEGORY MAP
========================= */
$smartMap = [
  'makan'   => 'Makanan & Minuman',
  'makanan' => 'Makanan & Minuman',
  'nasi'    => 'Makanan & Minuman',
  'kopi'    => 'Makanan & Minuman',
  'minum'  => 'Makanan & Minuman',
  'warung' => 'Makanan & Minuman',
  'warmindo'=> 'Makanan & Minuman',
  'Warmindo'=> 'Makanan & Minuman',
  'kedai'  => 'Makanan & Minuman',
  ''       => 'Makanan & Minuman',

  'baju'   => 'fashion',
  'celana' => 'fashion',
  'jeans'  => 'fashion',
  'sepatu' => 'fashion',
  'buket'  => 'fashion',

  'cuci'    => 'jasa',
  'service' => 'jasa',
  'servis'  => 'jasa',
  'perbaiki'=> 'jasa',
  'Modelling'=> 'jasa',
  '3d' => 'jasa',
  '3D'  => 'jasa',
  'perbaiki'=> 'jasa',


  'hp'     => 'elektronik',
  'laptop' => 'elektronik',
  'Game'   => 'elektronik',
  'game'   => 'elektronik',
];

// AUTO DETECT KATEGORI DARI SEARCH
if ($category == '' && $q != '') {
  foreach ($smartMap as $key => $value) {
    if (stripos($q, $key) !== false) {
      $category = $value;
      break;
    }
  }
}

/* =========================
   KEYWORD SEARCH
========================= */
if ($q !== '') {
  $qSafe = mysqli_real_escape_string($conn, $q);
  $where[] = "(
    b.name LIKE '%$qSafe%' OR
    b.description LIKE '%$qSafe%' OR
    p.name LIKE '%$qSafe%' OR
    u.name LIKE '%$qSafe%'
  )";
}

/* =========================
   FILTER JENIS
========================= */
if ($type === 'produk' || $type === 'jasa') {
  $where[] = "p.type = '$type'";
}

/* =========================
   FILTER KATEGORI
========================= */
if ($category !== '') {
  $where[] = "b.category = '$category'";
}

/* =========================
   FILTER HARGA
========================= */
if ($min !== '') {
  $where[] = "p.price >= " . (int)$min;
}
if ($max !== '') {
  $where[] = "p.price <= " . (int)$max;
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "
SELECT DISTINCT b.*
FROM businesses b
LEFT JOIN products p ON p.business_id = b.id
LEFT JOIN users u ON u.id = b.user_id
$whereSql
ORDER BY b.id DESC
";

$data = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>UMKM Marketplace</title>
  <link rel="icon" type="image/png" href="umkm.png">
  <link rel="stylesheet" href="assets/style.css">

<style>
.search-simple {
  display: flex;
  max-width: 7000px;
  width: 100%;
  border-radius: 999px;
  overflow: hidden;
  border: 1px solid #e5e7eb;
  background: white;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.search-simple input {
  flex: 1;
  padding: 14px 22px;
  border: none;
  outline: none;
  font-size: 16px;
  border-radius: 999px 0 0 999px;
}

.search-simple button {
  background: #2563eb; /* biru */
  color: white;
  border: none;
  padding: 0 30px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  border-radius: 0 999px 999px 0;
  transition: background 0.2s ease;
}

.search-simple button:hover {
  background: #1e40af;
}

  .search-detail {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }

  .hidden {
    display: none;
  }

  .btn-back {
    background: #e5e7eb;
    color: #111827;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
  }
  
 /* =========================
   MOBILE MODE
========================= */
@media (max-width: 768px) {

  header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }

  header nav {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
  }

  h2 {
    font-size: 18px;
    text-align: center;
  }

  /* SEARCH SIMPLE */
  .search-simple {
    max-width: 100%;
  }

  .search-simple input {
    font-size: 14px;
    padding: 12px 16px;
  }

  .search-simple button {
    padding: 0 20px;
    font-size: 14px;
  }

  /* SEARCH DETAIL STACK */
  .search-detail {
    flex-direction: column;
  }

  .search-detail input,
  .search-detail select,
  .search-detail button {
    width: 100%;
    font-size: 14px;
  }

  /* GRID JADI 1 KOLOM */
  .grid {
    grid-template-columns: 1fr !important;
  }

  .business-card img {
    max-height: 200px;
  }

  footer {
    text-align: center;
    font-size: 13px;
    padding: 15px;
  }
}
  </style>
</head>
<body>

<header>
  <b>UMKM Marketplace</b>
  <nav>
    <a href="index.php">Home</a>
    <a href="auth/login.php">Login</a>
    <a href="auth/register.php">Daftar</a>
  </nav>
</header>

<div class="container">

<!-- SEARCH BOX -->
<div class="card">
  <h2>Cari Semua Barang Kebutuhan</h2>

  <!-- SEARCH SIMPLE -->
  <div id="searchSimple" class="search-simple">
    <input 
      type="text" 
      id="simpleInput" 
      placeholder="Cari makanan, jasa, fashion, elektronik..."
      onkeydown="if(event.key==='Enter'){showDetailSearch();}"
    >
    <button onclick="showDetailSearch()">Cari</button>
  </div>

  <!-- SEARCH DETAIL -->
  <form id="searchDetail" class="search-detail hidden" method="GET">

    <input 
      name="q" 
      placeholder="Nama usaha / produk"
      value="<?= htmlspecialchars($q) ?>"
    >

    <select name="category">
      <option value="">Semua Kategori</option>
      <option value="makanan" <?= $category=='makanan'?'selected':'' ?>>Makanan & Minuman</option>
      <option value="fashion" <?= $category=='fashion'?'selected':'' ?>>Fashion</option>
      <option value="jasa" <?= $category=='jasa'?'selected':'' ?>>Jasa</option>
      <option value="elektronik" <?= $category=='elektronik'?'selected':'' ?>>Elektronik</option>
    </select>

    <input 
      type="number" 
      name="min" 
      placeholder="Harga min"
      value="<?= htmlspecialchars($min) ?>"
    >

    <input 
      type="number" 
      name="max" 
      placeholder="Harga max"
      value="<?= htmlspecialchars($max) ?>"
    >

    <button>Cari</button>
    <button type="button" class="btn-back" onclick="backToSimple()">
      Kembali
    </button>
  </form>
</div>

<!-- HASIL -->
<div class="grid">

<?php if(mysqli_num_rows($data) == 0): ?>
  <div style="text-align:center;margin-top:40px">
    <p style="color:#6b7280;margin-bottom:20px">
      Belum Ada Usaha yang Terdaftar atau tidak sesuai pencarian.
    </p>
    <button type="button" class="btn-back" onclick="backToSimple()">
      Kembali ke Pencarian
    </button>
  </div>
<?php endif; ?>

<?php while($b = mysqli_fetch_assoc($data)): ?>
  <div class="business-card">

    <?php if(!empty($b['image'])): ?>
      <img 
        src="uploads/business/<?= $b['image'] ?>"
        style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;margin-bottom:15px"
      >
    <?php endif; ?>

    <div class="content">
      <h3><?= $b['name'] ?></h3>
      <p style="color:#6b7280;font-size:14px">
        <?= substr($b['description'],0,80) ?>...
      </p>

      <a href="business/detail.php?id=<?= $b['id'] ?>" class="btn">
        Lihat Detail
      </a>
    </div>
  </div>
<?php endwhile; ?>

</div>

</div>

<footer>© <?= date('Y') ?> UMKM Marketplace</footer>

<script>
function showDetailSearch() {
  const simpleValue = document.getElementById("simpleInput").value;

  // Toggle search
  document.getElementById("searchSimple").classList.add("hidden");
  document.getElementById("searchDetail").classList.remove("hidden");

  // Tampilkan hasil
  document.getElementById("resultGrid").classList.remove("hidden");

  // auto isi ke input detail
  document.querySelector("#searchDetail input[name='q']").value = simpleValue;
}

function backToSimple() {
  document.getElementById("searchDetail").classList.add("hidden");
  document.getElementById("searchSimple").classList.remove("hidden");

  // Sembunyikan hasil
  document.getElementById("resultGrid").classList.add("hidden");

  // Fokus balik ke input
  const input = document.getElementById("simpleInput");
  input.focus();
  input.select();
}
</script>

</body>
</html>

