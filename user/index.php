<?php 
include '../config/config.php';
if ($_SESSION['level'] == '') header("location:../login.php");

$jurusan = $_SESSION['level'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard - <?php echo strtoupper($jurusan); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
  <h3>Dashboard Jurusan <?php echo strtoupper($jurusan); ?></h3>
  <a href="../logout.php" class="btn btn-danger btn-sm float-end">Logout</a>
  <hr>

  <!-- 🔔 Notifikasi Status Pengadaan -->
  <?php
  $notif = mysqli_query($koneksi, "SELECT * FROM pengadaan WHERE pengguna_barang='$jurusan' ORDER BY id DESC LIMIT 5");
  $ada_notif = false;
  while ($n = mysqli_fetch_assoc($notif)) {
      if ($n['status'] != 'Diajukan') { 
          $ada_notif = true;
      }
  }
  mysqli_data_seek($notif, 0); // reset pointer hasil query
  ?>

  <?php if ($ada_notif) { ?>
  <div class="alert alert-info shadow-sm">
    <h5 class="mb-3">🔔 Notifikasi Status Pengadaan Terbaru</h5>
    <ul class="list-group">
      <?php 
      while ($n = mysqli_fetch_assoc($notif)) {
          if ($n['status'] != 'Diajukan') {
              $warna = $n['status']=='Disetujui' ? 'success' : 'danger';
              echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                <div>
                  <strong>{$n['nama_barang']}</strong> 
                  <small class='text-muted'>({$n['merk']})</small><br>
                  <small>Tanggal: {$n['tanggal']}</small>
                </div>
                <span class='badge bg-$warna'>{$n['status']}</span>
              </li>";
          }
      }
      ?>
    </ul>
  </div>
  <?php } else { ?>
  <div class="alert alert-secondary shadow-sm">
    Belum ada pengajuan yang disetujui atau ditolak.
  </div>
  <?php } ?>

  <!-- Konten Utama Dashboard -->
  <div class="card shadow-sm mt-4">
    <div class="card-body">
      <h5>Selamat datang, <b><?php echo strtoupper($jurusan); ?></b></h5>
      <p>Silakan gunakan menu di atas untuk mengelola data aset dan pengadaan barang.</p>
      <a href="pengadaan.php" class="btn btn-primary">Ajukan Pengadaan</a>
      <a href="laporan.php" class="btn btn-success">Cetak Laporan</a>
    </div>
  </div>

</div>
</body>
</html>
