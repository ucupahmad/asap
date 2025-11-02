<?php
session_start();
include '../config/config.php';

// 🔒 Cek login admin
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// --------------------------------
// 🔹 Ambil data dari setiap tabel
// --------------------------------
function ambilData($koneksi, $tabel) {
  $q = mysqli_query($koneksi, "SELECT * FROM $tabel ORDER BY id ASC");
  $stat = ['Baik'=>0, 'Rusak Ringan'=>0, 'Rusak Sedang'=>0, 'Rusak Berat'=>0];
  while ($r = mysqli_fetch_assoc($q)) {
    $k = strtolower($r['kondisi']);
    if (strpos($k,'baik')!==false) $stat['Baik']++;
    elseif (strpos($k,'ringan')!==false) $stat['Rusak Ringan']++;
    elseif (strpos($k,'sedang')!==false) $stat['Rusak Sedang']++;
    elseif (strpos($k,'berat')!==false) $stat['Rusak Berat']++;
  }
  mysqli_data_seek($q, 0); // reset pointer agar bisa dibaca ulang
  return ['data'=>$q, 'stat'=>$stat];
}

$kantor = ambilData($koneksi, 'ruang_kantor');
$belajar = ambilData($koneksi, 'ruang_lainnya');
$penunjang = ambilData($koneksi, 'ruang_penunjang');

$labels = json_encode(array_keys($kantor['stat']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Ruangan - Aset Sekolah</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
#btn-action {
	display: flex;
    align-items: end;
    justify-content: end;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<!-- 🔹 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Dashboard Ruangan</a>
    <div>
      <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?? 'Admin'; ?></span>
      <a href="../logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">

<!-- ================================================== -->
<!-- RUANG KANTOR -->
<!-- ================================================== -->
<div id="btn-action">
  <form action="import_ruang.php" method="post" enctype="multipart/form-data" style="display:inline-block;">
    <input type="hidden" name="jenis" value="kantor">
    <input type="file" name="file" accept=".xlsx,.xls" style="display:none;" id="fileKantor" onchange="this.form.submit()">
    <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('fileKantor').click();">
      <i class="bi bi-upload"></i> Import
    </button>
  </form>
  <a href="export_ruang.php?jenis=kantor" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download</a>
  <a href="tambah_ruang_kantor.php" class="btn btn-light btn-sm"><i class="bi bi-plus-circle"></i> Tambah</a>
</div>


  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th><th>Jenis Ruangan</th><th>Jumlah</th><th>Ukuran</th><th>Kondisi</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no=1;
      if (mysqli_num_rows($kantor['data'])>0){
        while($d=mysqli_fetch_assoc($kantor['data'])){
          echo "<tr>
                  <td>$no</td>
                  <td>{$d['jenis_ruangan']}</td>
                  <td>{$d['jumlah']}</td>
                  <td>{$d['ukuran']}</td>
                  <td>{$d['kondisi']}</td>
                  <td>
                    <a href='edit_ruang_kantor.php?id={$d['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                    <a href='hapus_ruang_kantor.php?id={$d['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?');\"><i class='bi bi-trash'></i></a>
                  </td>
                </tr>";
          $no++;
        }
      } else echo "<tr><td colspan='6'>Belum ada data.</td></tr>";
      ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ================================================== -->
<!-- RUANG BELAJAR -->
<!-- ================================================== -->
<div class="card shadow mb-4">
  <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-easel2"></i> Ruang Belajar</h5>
    <div>
  <form action="import_ruang.php" method="post" enctype="multipart/form-data" style="display:inline-block;">
    <input type="hidden" name="jenis" value="belajar">
    <input type="file" name="file" accept=".xlsx,.xls" style="display:none;" id="fileBelajar" onchange="this.form.submit()">
    <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('fileBelajar').click();">
      <i class="bi bi-upload"></i> Import
    </button>
  </form>
  <a href="export_ruang.php?jenis=belajar" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download</a>
  <a href="tambah_ruang_lainnya.php" class="btn btn-light btn-sm"><i class="bi bi-plus-circle"></i> Tambah</a>
</div>


  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th><th>Jenis Ruangan</th><th>Jumlah</th><th>Ukuran</th><th>Kondisi</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no=1;
      if (mysqli_num_rows($belajar['data'])>0){
        while($d=mysqli_fetch_assoc($belajar['data'])){
          echo "<tr>
                  <td>$no</td>
                  <td>{$d['jenis_ruangan']}</td>
                  <td>{$d['jumlah']}</td>
                  <td>{$d['ukuran']}</td>
                  <td>{$d['kondisi']}</td>
                  <td>
                    <a href='edit_ruang_lainnya.php?id={$d['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                    <a href='hapus_ruang_lainnya.php?id={$d['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?');\"><i class='bi bi-trash'></i></a>
                  </td>
                </tr>";
          $no++;
        }
      } else echo "<tr><td colspan='6'>Belum ada data.</td></tr>";
      ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ================================================== -->
<!-- RUANG PENUNJANG -->
<!-- ================================================== -->
<div class="card shadow mb-4">
  <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-lamp"></i> Ruang Penunjang</h5>
    <div>
  <form action="import_ruang.php" method="post" enctype="multipart/form-data" style="display:inline-block;">
    <input type="hidden" name="jenis" value="penunjang">
    <input type="file" name="file" accept=".xlsx,.xls" style="display:none;" id="filePenunjang" onchange="this.form.submit()">
    <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('filePenunjang').click();">
      <i class="bi bi-upload"></i> Import
    </button>
  </form>
  <a href="export_ruang.php?jenis=penunjang" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download</a>
  <a href="tambah_ruang_penunjang.php" class="btn btn-dark btn-sm"><i class="bi bi-plus-circle"></i> Tambah</a>
</div>


  </div>
  <div class="card-body table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>No</th><th>Jenis Ruangan</th><th>Jumlah</th><th>Ukuran</th><th>Kondisi</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no=1;
      if (mysqli_num_rows($penunjang['data'])>0){
        while($d=mysqli_fetch_assoc($penunjang['data'])){
          echo "<tr>
                  <td>$no</td>
                  <td>{$d['jenis_ruangan']}</td>
                  <td>{$d['jumlah']}</td>
                  <td>{$d['ukuran']}</td>
                  <td>{$d['kondisi']}</td>
                  <td>
                    <a href='edit_ruang_penunjang.php?id={$d['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                    <a href='hapus_ruang_penunjang.php?id={$d['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus data ini?');\"><i class='bi bi-trash'></i></a>
                  </td>
                </tr>";
          $no++;
        }
      } else echo "<tr><td colspan='6'>Belum ada data.</td></tr>";
      ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ================================================== -->
<!-- GRAFIK KONDISI -->
<!-- ================================================== -->
<div class="card shadow mb-5">
  <div class="card-header bg-dark text-white">
    <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Statistik Kondisi Ruangan</h5>
  </div>
  <div class="card-body">
    <canvas id="chartRuang" height="100"></canvas>
  </div>
</div>

</div>

<script>
const ctx = document.getElementById('chartRuang').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= $labels ?>,
    datasets: [
      { label: 'Ruang Kantor', data: <?= json_encode(array_values($kantor['stat'])) ?>, backgroundColor: 'rgba(54,162,235,0.7)' },
      { label: 'Ruang Belajar', data: <?= json_encode(array_values($belajar['stat'])) ?>, backgroundColor: 'rgba(75,192,192,0.7)' },
      { label: 'Ruang Penunjang', data: <?= json_encode(array_values($penunjang['stat'])) ?>, backgroundColor: 'rgba(255,206,86,0.7)' }
    ]
  },
  options: { responsive: true, scales: { y: { beginAtZero: true } } }
});
</script>

</body>
</html>
