<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// --- Data Ruang Kantor ---
$qKantor = mysqli_query($koneksi, "SELECT * FROM ruang_kantor ORDER BY id ASC");
$statKantor = ['Baik'=>0, 'Rusak Ringan'=>0, 'Rusak Sedang'=>0, 'Rusak Berat'=>0];
while ($r = mysqli_fetch_assoc($qKantor)) {
  $kondisi = strtolower($r['kondisi']);
  if (strpos($kondisi,'baik')!==false) $statKantor['Baik']++;
  elseif (strpos($kondisi,'ringan')!==false) $statKantor['Rusak Ringan']++;
  elseif (strpos($kondisi,'sedang')!==false) $statKantor['Rusak Sedang']++;
  elseif (strpos($kondisi,'berat')!==false) $statKantor['Rusak Berat']++;
}

// --- Data Ruang Belajar ---
$qBelajar = mysqli_query($koneksi, "SELECT * FROM ruang_belajar ORDER BY id ASC");
$statBelajar = ['Baik'=>0, 'Rusak Ringan'=>0, 'Rusak Sedang'=>0, 'Rusak Berat'=>0];
while ($r = mysqli_fetch_assoc($qBelajar)) {
  $kondisi = strtolower($r['kondisi']);
  if (strpos($kondisi,'baik')!==false) $statBelajar['Baik']++;
  elseif (strpos($kondisi,'ringan')!==false) $statBelajar['Rusak Ringan']++;
  elseif (strpos($kondisi,'sedang')!==false) $statBelajar['Rusak Sedang']++;
  elseif (strpos($kondisi,'berat')!==false) $statBelajar['Rusak Berat']++;
}

$labels = json_encode(array_keys($statKantor));
$kantorVals = json_encode(array_values($statKantor));
$belajarVals = json_encode(array_values($statBelajar));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - Aset Sekolah</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Dashboard Admin</a>
    <div>
      <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?? 'Admin'; ?></span>
      <a href="../logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">

  <!-- SECTION: DATA RUANG KANTOR -->
  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="bi bi-building"></i> Data Ruang Kantor</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Jenis Ruangan</th>
              <th>Jumlah (buah)</th>
              <th>Ukuran (p x l)</th>
              <th>Kondisi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            mysqli_data_seek($qKantor, 0);
            $no = 1;
            if (mysqli_num_rows($qKantor) > 0) {
              while ($data = mysqli_fetch_assoc($qKantor)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['jenis_ruangan']}</td>
                        <td>{$data['jumlah']}</td>
                        <td>{$data['ukuran']}</td>
                        <td>{$data['kondisi']}</td>
                      </tr>";
                $no++;
              }
            } else {
              echo "<tr><td colspan='5'>Belum ada data ruang kantor.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SECTION: DATA RUANG BELAJAR -->
  <div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0"><i class="bi bi-easel2"></i> Data Ruang Belajar</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>No</th>
              <th>Jenis Ruangan</th>
              <th>Jumlah (buah)</th>
              <th>Ukuran (p x l)</th>
              <th>Kondisi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            mysqli_data_seek($qBelajar, 0);
            $no = 1;
            if (mysqli_num_rows($qBelajar) > 0) {
              while ($data = mysqli_fetch_assoc($qBelajar)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$data['jenis_ruangan']}</td>
                        <td>{$data['jumlah']}</td>
                        <td>{$data['ukuran']}</td>
                        <td>{$data['kondisi']}</td>
                      </tr>";
                $no++;
              }
            } else {
              echo "<tr><td colspan='5'>Belum ada data ruang belajar.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SECTION: GRAFIK PERBANDINGAN -->
  <div class="card shadow mb-4">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Statistik Kondisi Ruangan (Kantor & Belajar)</h5>
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
    labels: <?= $labels; ?>,
    datasets: [
      {
        label: 'Ruang Kantor',
        data: <?= $kantorVals; ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      },
      {
        label: 'Ruang Belajar',
        data: <?= $belajarVals; ?>,
        backgroundColor: 'rgba(75, 192, 192, 0.7)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>

</body>
</html>
