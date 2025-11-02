<?php 
include '../config/config.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Notifikasi pengadaan baru
$notif_masuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Menunggu'"))['jml'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Aset Sekolah</title>
  <link rel="icon" type="image/png" href="assets/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="apple-touch-icon" href="assets/img/logo.png">
<link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
</head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Admin - Inventaris Sekolah</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- JS Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
  --sidebar-width: 250px;
  --transition: all 0.3s ease;
}

body {
  font-family: 'Poppins', sans-serif;
  background-color: #f5f6fa;
  margin: 0;
  transition: var(--transition);
  overflow-x: hidden;
}

body.dark-mode {
  background-color: #1e1e2f;
  color: #e4e6eb;
}

/* SIDEBAR */
.sidebar {
  width: var(--sidebar-width);
  background: linear-gradient(180deg, #0d6efd, #1b4dbd);
  color: white;
  height: 100vh;
  position: fixed;
  transition: var(--transition);
  z-index: 1050;
  top: 0;
  left: 0;
}

.sidebar a {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding: 12px 20px;
  text-decoration: none;
  color: white;
  border-radius: 8px;
  margin: 6px 10px;
  transition: 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
  background-color: rgba(255,255,255,0.2);
}

/* KONTEN */
.content {
  margin-left: var(--sidebar-width);
  transition: var(--transition);
  padding: 20px;
}

.card {
  border-radius: 12px;
}

.table {
  background: white;
  border-radius: 8px;
  overflow: hidden;
}

/* MODE GELAP */
.dark-mode .card {
  background-color: #2c2f48 !important;
  color: #e4e6eb;
}

.dark-mode .table {
  background: #2c2f48;
  color: #e4e6eb;
}

/* RESPONSIVE SIDEBAR */
@media (max-width: 991px) {
  .sidebar {
    left: -250px;
  }

  .sidebar.active {
    left: 0;
  }

  .content {
    margin-left: 0 !important;
    padding: 15px;
  }

  .card-body h3 {
    font-size: 1.4rem;
  }

  table th, table td {
    font-size: 0.9rem;
    padding: 8px;
  }

  #toggleSidebar {
    display: inline-block;
  }
}

@media (max-width: 575px) {
  .card-body h3 {
    font-size: 1.2rem;
  }

  .card-body h5 {
    font-size: 1rem;
  }

  .sidebar a {
    padding: 10px 15px;
  }
}

/* Overlay di HP */
#toggleSidebar {
  z-index: 1100;
}

@media (max-width: 991px) {
  body::before {
    content: '';
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 1040;
    transition: 0.3s;
  }

  body.sidebar-open::before {
    display: block;
  }
}
</style>

</head>
<?php
include '../config/config.php';


if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM ruang_teori ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Kondisi & Ukuran Ruang Teori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background: #f8f9fa; }
.table th, .table td { text-align: center; vertical-align: middle; }
canvas { max-height: 400px; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
  <h4 class="text-center mt-3 mb-4"><i class="bi bi-person-badge"></i> <span>Admin</span></h4>
  <a href="index.php" class="active"><i class="bi bi-house-door"></i> <span>Dashboard</span></a>
  <a href="ruang_teori.php"><i class="bi bi-box-seam"></i> <span>Data kondisi ruang</span></a>
  <a href="data_ruang_lainnya.php"><i class="bi bi-box-seam"></i> <span>Data ruang</span></a>
  <a href="ruang_kelas_perabot.php"><i class="bi bi-box-seam"></i> <span>Data perabot</span></a>
    <a href="aset.php"><i class="bi bi-box-seam"></i> <span>data Inventaris</span></a>
  <a href="laporan_bulanan.php"><i class="bi bi-bar-chart"></i> <span>Laporan Bulanan</span></a>
  <a href="pengadaan.php">
    <i class="bi bi-cart-check"></i> <span>Pengadaan</span>
	    <?php if($notif_masuk > 0): ?>
      <span class="badge bg-danger ms-auto"><?= $notif_masuk ?></span>
    <?php endif; ?>
  </a>
  <hr class="text-light">
  <a href="#" id="darkModeToggle"><i class="bi bi-moon"></i> <span>Dark Mode</span></a>
  <a href="login_log.php"><i class="bi bi-box-arrow-right"></i> <span>Log</span></a>
  <a href="../login.php"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
</div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="content">

  <!-- Tombol Toggle Sidebar (selalu terlihat di HP) -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <button id="toggleSidebar" class="btn btn-primary d-lg-none">
      <i class="bi bi-list fs-4"></i>
    </button>
    <h3 class="fw-bold text-primary m-0">
      <i class="bi bi-speedometer2"></i> Sarana Dan Prasarana SMK Darut Taqwa
    </h3>
  </div>

  <?php
  // Statistik utama
  $total_aset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM aset"))['jml'];
  $menunggu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Menunggu'"))['jml'];
  $disetujui = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Disetujui'"))['jml'];
  $ditolak = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Ditolak'"))['jml'];

  // Total nilai aset keseluruhan
  $total_nilai_aset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(nilai_perolehan) AS total FROM aset"))['total'];

  // Total nilai pengajuan per level
  $pengajuan_perlevel = mysqli_query($koneksi, "
    SELECT pengguna_barang AS level, 
           COUNT(*) AS total_pengajuan,
           SUM(nilai_perolehan) AS total_nilai
    FROM pengadaan 
    GROUP BY pengguna_barang
  ");

  // Total nilai pengajuan semua level
  $total_pengajuan_semua = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT SUM(nilai_perolehan) AS total FROM pengadaan
  "))['total'];
  ?>

  <!-- Total Nilai Aset Keseluruhan -->
  <div class="card shadow-sm mb-4 text-center border-0">
    <div class="card-body bg-light">
      <h5 class="fw-bold text-success mb-2"><i class="bi bi-cash-stack"></i> Total Nilai Inventaris Keseluruhan</h5>
      <h3 class="fw-bold text-primary">Rp <?= number_format($total_nilai_aset, 0, ',', '.') ?></h3>
    </div>
  </div>

  <!-- Total Pengajuan & Nilai per Level -->
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-people"></i> Total Pengajuan & Nilai per Level
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Pengguna Barang</th>
            <th>Jumlah Pengajuan</th>
            <th>Total Nilai Pengajuan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no=1;
          while($row = mysqli_fetch_assoc($pengajuan_perlevel)) {
            echo "<tr>
                    <td>$no</td>
                    <td>{$row['level']}</td>
                    <td><span class='badge bg-info'>{$row['total_pengajuan']}</span></td>
                    <td class='text-end'>Rp ".number_format($row['total_nilai'],0,',','.')."</td>
                  </tr>";
            $no++;
          }
          if ($no==1) echo "<tr><td colspan='4'>Belum ada data pengajuan</td></tr>";
          ?>
        </tbody>
        <tfoot>
          <tr class="table-secondary fw-bold">
            <td colspan="3" class="text-end">Total Semua Pengajuan</td>
            <td class="text-end">Rp <?= number_format($total_pengajuan_semua, 0, ',', '.') ?></td>
          </tr>
        </tfoot>
      </table>
	  <body>
<div class="card shadow-sm mb-4">

     </div>
	     <div class="card-body table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kondisi</th>
            <th colspan="4">Jumlah dan Ukuran</th>
            <th colspan="5">Kondisi Ruang</th>
            <th rowspan="2">Jml. Ruang Lainnya digunakan utk Ruang Teori (e)</th>
            <th rowspan="2">Jumlah Keseluruhan (f = d + e)</th>
            <th rowspan="2">Aksi</th>
          </tr>
          <tr>
            <th>8x9 m² / 73 m² (a)</th>
            <th>&gt;73 m² (b)</th>
            <th>&lt;73 m² (c)</th>
            <th>Jumlah (d = a+b+c)</th>
            <th>Baik</th>
            <th>Rsk. Ringan</th>
            <th>Rsk. Sedang</th>
            <th>Rsk. Berat</th>
            <th>Rsk. Total</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $total = [
          'a'=>0,'b'=>0,'c'=>0,'d'=>0,'e'=>0,'f'=>0,
          'baik'=>0,'ringan'=>0,'sedang'=>0,'berat'=>0,'rusak_total'=>0
        ];
        while($r = mysqli_fetch_assoc($q)){
          $rTotal = $r['rusak_ringan'] + $r['rusak_sedang'] + $r['rusak_berat'];
          echo "<tr>
            <td>$no</td>
            <td>{$r['kondisi']}</td>
            <td>{$r['ukuran_8x9']}</td>
            <td>{$r['ukuran_lebih73']}</td>
            <td>{$r['ukuran_kurang73']}</td>
            <td>{$r['jumlah_ruang']}</td>
            <td>{$r['baik']}</td>
            <td>{$r['rusak_ringan']}</td>
            <td>{$r['rusak_sedang']}</td>
            <td>{$r['rusak_berat']}</td>
            <td>$rTotal</td>
            <td>{$r['ruang_digunakan']}</td>
            <td>{$r['jumlah_keseluruhan']}</td>
           
			</td>
          </tr>";

          $total['a'] += $r['ukuran_8x9'];
          $total['b'] += $r['ukuran_lebih73'];
          $total['c'] += $r['ukuran_kurang73'];
          $total['d'] += $r['jumlah_ruang'];
          $total['baik'] += $r['baik'];
          $total['ringan'] += $r['rusak_ringan'];
          $total['sedang'] += $r['rusak_sedang'];
          $total['berat'] += $r['rusak_berat'];
          $total['rusak_total'] += $rTotal;
          $total['e'] += $r['ruang_digunakan'];
          $total['f'] += $r['jumlah_keseluruhan'];
          $no++;
        }
        ?>
        </tbody>
        <tfoot class="table-secondary fw-bold">
          <tr>
            <td colspan="2">Total</td>
            <td><?= $total['a'] ?></td>
            <td><?= $total['b'] ?></td>
            <td><?= $total['c'] ?></td>
            <td><?= $total['d'] ?></td>
            <td><?= $total['baik'] ?></td>
            <td><?= $total['ringan'] ?></td>
            <td><?= $total['sedang'] ?></td>
            <td><?= $total['berat'] ?></td>
            <td><?= $total['rusak_total'] ?></td>
            <td><?= $total['e'] ?></td>
            <td><?= $total['f'] ?></td>
            <td>-</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- GRAFIK KONDISI RUANG -->
    <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Grafik Batang Kondisi Ruang</h5>
        </div>
        <div class="card-body">
          <canvas id="grafikRuang"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Diagram Lingkaran Kondisi Ruang</h5>
        </div>
        <div class="card-body">
          <canvas id="pieRuang"></canvas>
        </div>
      </div>
    </div>
  </div>

<script>
const dataKondisi = {
  baik: <?= $total['baik'] ?>,
  ringan: <?= $total['ringan'] ?>,
  sedang: <?= $total['sedang'] ?>,
  berat: <?= $total['berat'] ?>,
  total: <?= $total['rusak_total'] ?>
};

// === Grafik Batang ===
new Chart(document.getElementById('grafikRuang'), {
  type: 'bar',
  data: {
    labels: ['Baik', 'Rsk. Ringan', 'Rsk. Sedang', 'Rsk. Berat', 'Rsk. Total'],
    datasets: [{
      label: 'Jumlah Ruang',
      data: [dataKondisi.baik, dataKondisi.ringan, dataKondisi.sedang, dataKondisi.berat, dataKondisi.total],
      backgroundColor: [
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 205, 86, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)'
      ],
      borderColor: [
        'rgb(75, 192, 192)',
        'rgb(255, 205, 86)',
        'rgb(255, 159, 64)',
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true, title: { display: true, text: 'Jumlah Ruang' } }
    }
  }
});

// === Grafik Pie ===
new Chart(document.getElementById('pieRuang'), {
  type: 'pie',
  data: {
    labels: ['Baik', 'Rsk. Ringan', 'Rsk. Sedang', 'Rsk. Berat'],
    datasets: [{
      label: 'Kondisi Ruang',
      data: [dataKondisi.baik, dataKondisi.ringan, dataKondisi.sedang, dataKondisi.berat],
      backgroundColor: [
        'rgba(75, 192, 192, 0.7)',
        'rgba(255, 205, 86, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(255, 99, 132, 0.7)'
      ],
      borderColor: 'white',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' },
      title: {
        display: true,
        text: 'Persentase Kondisi Ruang Teori'
      }
    }
  }
});
</script>

</body>
</html>

<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// ---------------------------
// STATISTIK DATA RUANG
// ---------------------------
function hitungStatistik($koneksi, $tabel) {
  $q = mysqli_query($koneksi, "SELECT * FROM $tabel ORDER BY id ASC");
  $stat = ['Baik'=>0, 'Rusak Ringan'=>0, 'Rusak Sedang'=>0, 'Rusak Berat'=>0];
  while ($r = mysqli_fetch_assoc($q)) {
    $k = strtolower($r['kondisi']);
    if (strpos($k,'baik')!==false) $stat['Baik']++;
    elseif (strpos($k,'ringan')!==false) $stat['Rusak Ringan']++;
    elseif (strpos($k,'sedang')!==false) $stat['Rusak Sedang']++;
    elseif (strpos($k,'berat')!==false) $stat['Rusak Berat']++;
  }
  return $stat;
}

$statKantor     = hitungStatistik($koneksi, "ruang_kantor");
$statBelajar    = hitungStatistik($koneksi, "ruang_lainnya");
$statPenunjang  = hitungStatistik($koneksi, "ruang_penunjang");

$labels = json_encode(array_keys($statKantor));
$kantorVals = json_encode(array_values($statKantor));
$belajarVals = json_encode(array_values($statBelajar));
$penunjangVals = json_encode(array_values($statPenunjang));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  body { background-color: #f8f9fa; }
  table th, table td { white-space: nowrap; }
  .table-responsive { overflow-x: auto; }
  @media (max-width: 768px) {
    h5, .navbar-brand { font-size: 1rem; }
    .btn-sm, .btn { padding: 0.3rem 0.6rem; font-size: 0.8rem; }
    .card-body { padding: 0.8rem; }
  }
</style>
</head>
<body>

  <!-- GRAFIK KONDISI -->
  <div class="card shadow-sm mb-4">
  <div class="card shadow mb-4">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Statistik Kondisi Ruangan</h5>
    </div>
    <div class="card-body">
      <canvas id="chartRuang" height="100"></canvas>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
new Chart(document.getElementById('chartRuang'), {
  type: 'bar',
  data: {
    labels: <?= $labels ?>,
    datasets: [
      { label: 'Ruang Kantor', data: <?= $kantorVals ?>, backgroundColor: 'rgba(54,162,235,0.7)' },
      { label: 'Ruang Belajar', data: <?= $belajarVals ?>, backgroundColor: 'rgba(75,192,192,0.7)' },
      { label: 'Ruang Penunjang', data: <?= $penunjangVals ?>, backgroundColor: 'rgba(255,206,86,0.7)' }
    ]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } }
  }
});
</script>
<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}
// === DATA GRAFIK ===
$namaRuang = [];
$baik = [];
$ringan = [];
$berat = [];

$result = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");
while ($d = mysqli_fetch_assoc($result)) {
  $namaRuang[] = $d['nama_ruang'];
  $baik[] = $d['meja_baik'] + $d['kursi_baik'] + $d['almari_baik'] + $d['papan_baik'];
  $ringan[] = $d['meja_ringan'] + $d['kursi_ringan'] + $d['almari_ringan'] + $d['papan_ringan'];
  $berat[] = $d['meja_berat'] + $d['kursi_berat'] + $d['almari_berat'] + $d['papan_berat'];

 }
?>
  <!-- GRAFIK -->
  <div class="card shadow-sm mb-4">
  <div class="card mt-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
      <h6 class="mb-0">📊 Grafik Kondisi Perabot Per Ruang</h6>
      <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalGrafik">Lihat Grafik Penuh</button>
    </div>
    <div class="card-body">
      <canvas id="grafikPerRuang" height="150"></canvas>
    </div>
  </div>
</div>

<!-- Modal Grafik Fullscreen -->
<div class="card shadow-sm mb-4">
<div class="modal fade" id="modalGrafik" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">📊 Grafik Kondisi Per Ruang (Tampilan Penuh)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body bg-light">
        <canvas id="grafikPenuh" height="200"></canvas>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const labels = <?= json_encode($namaRuang) ?>;
const dataBaik = <?= json_encode($baik) ?>;
const dataRingan = <?= json_encode($ringan) ?>;
const dataBerat = <?= json_encode($berat) ?>;

function buatGrafik(idCanvas) {
  new Chart(document.getElementById(idCanvas), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        { label: 'Baik', data: dataBaik, backgroundColor: '#28a745' },
        { label: 'Rusak Ringan', data: dataRingan, backgroundColor: '#ffc107' },
        { label: 'Rusak Berat', data: dataBerat, backgroundColor: '#dc3545' }
      ]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } },
      plugins: { legend: { position: 'bottom' } }
    }
  });
}
buatGrafik('grafikPerRuang');

document.getElementById('modalGrafik').addEventListener('shown.bs.modal', () => buatGrafik('grafikPenuh'));
</script>
</body>
    </div>
  </div>

  <!-- Statistik Kartu -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card text-bg-primary text-center"><div class="card-body"><i class="bi bi-box-seam display-6"></i><h6>Total</h6><h3><?= $total_aset ?></h3></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-bg-warning text-center"><div class="card-body"><i class="bi bi-hourglass-split display-6"></i><h6>Menunggu</h6><h3><?= $menunggu ?></h3></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-bg-success text-center"><div class="card-body"><i class="bi bi-check2-circle display-6"></i><h6>Disetujui</h6><h3><?= $disetujui ?></h3></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-bg-danger text-center"><div class="card-body"><i class="bi bi-x-circle display-6"></i><h6>Ditolak</h6><h3><?= $ditolak ?></h3></div></div></div>
  </div>

  <!-- Grafik Aset & Pengajuan -->
    <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-3">Grafik Nilai Inventaris per Pengguna Barang</h5>
          <canvas id="chartAset"></canvas>
        </div>
      </div>
    </div>
	
<!-- Grafik Aset & Pengajuan -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-center mb-3">Grafik Nilai Pengajuan per lokasi</h5>
          <canvas id="chartPengajuan"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- SCRIPT -->
<script>
const sidebar = document.getElementById('sidebar');
const toggleSidebar = document.getElementById('toggleSidebar');
const darkToggle = document.getElementById('darkModeToggle');

// Toggle Sidebar
toggleSidebar.onclick = () => {
  sidebar.classList.toggle('active');
  document.body.classList.toggle('sidebar-open');
};

// Mode Gelap
darkToggle.onclick = () => {
  document.body.classList.toggle('dark-mode');
};

// Tutup sidebar otomatis setelah klik link di HP
document.querySelectorAll('.sidebar a').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth < 992) {
      sidebar.classList.remove('active');
      document.body.classList.remove('sidebar-open');
    }
  });
});
</script>

<?php
// Data grafik aset
$data_aset = mysqli_query($koneksi, "SELECT pengguna_barang, SUM(nilai_perolehan) AS total FROM aset GROUP BY pengguna_barang");
$labels_aset = [];
$values_aset = [];
while($r = mysqli_fetch_assoc($data_aset)) {
  $labels_aset[] = $r['pengguna_barang'];
  $values_aset[] = $r['total'];
}

// Data grafik pengajuan
$data_pengajuan = mysqli_query($koneksi, "SELECT pengguna_barang, SUM(nilai_perolehan) AS total FROM pengadaan GROUP BY pengguna_barang");
$labels_pengajuan = [];
$values_pengajuan = [];
while($r = mysqli_fetch_assoc($data_pengajuan)) {
  $labels_pengajuan[] = $r['pengguna_barang'];
  $values_pengajuan[] = $r['total'];
}
?>

<script>
new Chart(document.getElementById('chartAset'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels_aset) ?>,
    datasets: [{
      label: 'Nilai Aset (Rp)',
      data: <?= json_encode($values_aset) ?>,
      backgroundColor: 'rgba(13,110,253,0.6)',
      borderColor: 'rgba(13,110,253,1)',
      borderWidth: 1
    }]
  },
  options: { scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('chartPengajuan'), {
  type: 'pie',
  data: {
    labels: <?= json_encode($labels_pengajuan) ?>,
    datasets: [{
      label: 'Total Pengajuan (Rp)',
      data: <?= json_encode($values_pengajuan) ?>,
      backgroundColor: [
        'rgba(75, 192, 192, 0.6)',
        'rgba(255, 99, 132, 0.6)',
        'rgba(255, 205, 86, 0.6)',
        'rgba(54, 162, 235, 0.6)'
      ],
      borderWidth: 1
    }]
  }
});
</script>


</html>
</body>
</html>



</body>
</html>

