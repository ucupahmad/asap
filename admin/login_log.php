<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// 🔎 Fitur pencarian username
$cari = $_GET['cari'] ?? '';
$where = '';
if ($cari != '') {
  $cari_safe = mysqli_real_escape_string($koneksi, $cari);
  $where = "WHERE username LIKE '%$cari_safe%'";
}

// 🧹 Reset semua log jika diminta
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
  mysqli_query($koneksi, "TRUNCATE TABLE login_log");
  header("Location: login_log.php?msg=reset");
  exit;
}

// 📋 Ambil data log
$q = mysqli_query($koneksi, "SELECT * FROM login_log $where ORDER BY waktu DESC LIMIT 100");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Log Aktivitas Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <h3 class="mb-3">📜 Log Aktivitas Login</h3>
    <div class="d-flex gap-2">
      <a href="index.php" class="btn btn-secondary btn-sm">🏠 Kembali ke Dashboard</a>
      <a href="?reset=1" class="btn btn-danger btn-sm" 
         onclick="return confirm('⚠️ Yakin ingin menghapus semua log login? Data tidak bisa dikembalikan!');">
         🧹 Reset All
      </a>
    </div>
  </div>

  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'reset'): ?>
    <div class="alert alert-success py-2">✅ Semua data log berhasil dihapus.</div>
  <?php endif; ?>

  <form class="mb-3" method="get">
    <div class="input-group">
      <input type="text" name="cari" class="form-control" placeholder="Cari username..." value="<?= htmlspecialchars($cari); ?>">
      <button class="btn btn-primary" type="submit">🔍 Cari</button>
    </div>
  </form>

  <div class="table-responsive shadow-sm">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr class="text-center">
          <th style="width:50px;">No</th>
          <th>Username</th>
          <th>IP Address</th>
          <th>Browser</th>
          <th>Status</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($q) > 0): ?>
          <?php $no=1; while($row=mysqli_fetch_assoc($q)): ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['username']); ?></td>
              <td><?= htmlspecialchars($row['ip_address']); ?></td>
              <td><?= htmlspecialchars(substr($row['user_agent'],0,60)); ?>...</td>
              <td class="text-center">
                <?php if($row['status']=='BERHASIL'): ?>
                  <span class="badge bg-success">BERHASIL</span>
                <?php else: ?>
                  <span class="badge bg-danger">GAGAL</span>
                <?php endif; ?>
              </td>
              <td><?= $row['waktu']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center text-muted">Tidak ada data log login.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
