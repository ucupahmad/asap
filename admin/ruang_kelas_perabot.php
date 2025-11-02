<?php
require '../vendor/autoload.php';
include '../config/config.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// === Import Data Excel ===
if (isset($_POST['import'])) {
  $file = $_FILES['file']['tmp_name'];

  try {
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    for ($i = 1; $i < count($rows); $i++) { // baris 0 = header
      $nama_ruang   = mysqli_real_escape_string($koneksi, $rows[$i][0]);
      $jumlah_ruang = (int)$rows[$i][1];
      $meja_jml     = (int)$rows[$i][2];
      $meja_baik    = (int)$rows[$i][3];
      $meja_ringan  = (int)$rows[$i][4];
      $meja_berat   = (int)$rows[$i][5];
      $kursi_jml    = (int)$rows[$i][6];
      $kursi_baik   = (int)$rows[$i][7];
      $kursi_ringan = (int)$rows[$i][8];
      $kursi_berat  = (int)$rows[$i][9];
      $almari_jml   = (int)$rows[$i][10];
      $almari_baik  = (int)$rows[$i][11];
      $almari_ringan= (int)$rows[$i][12];
      $almari_berat = (int)$rows[$i][13];
      $papan_jml    = (int)$rows[$i][14];
      $papan_baik   = (int)$rows[$i][15];
      $papan_ringan = (int)$rows[$i][16];
      $papan_berat  = (int)$rows[$i][17];

      mysqli_query($koneksi, "INSERT INTO ruang_kelas_perabot VALUES (
        NULL, '$nama_ruang', '$jumlah_ruang',
        '$meja_jml','$meja_baik','$meja_ringan','$meja_berat',
        '$kursi_jml','$kursi_baik','$kursi_ringan','$kursi_berat',
        '$almari_jml','$almari_baik','$almari_ringan','$almari_berat',
        '$papan_jml','$papan_baik','$papan_ringan','$papan_berat'
      )");
    }

    echo "<script>alert('Import data berhasil!'); window.location='ruang_kelas_perabot.php';</script>";
  } catch (Exception $e) {
    echo "<script>alert('Gagal import: " . $e->getMessage() . "'); window.location='ruang_kelas_perabot.php';</script>";
  }
  exit;
}

// === Tambah, Update, Hapus, Ambil Data ===
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama_ruang'];
  $jumlah = $_POST['jumlah_ruang'];
  $data = [
    'meja_jml','meja_baik','meja_ringan','meja_berat',
    'kursi_jml','kursi_baik','kursi_ringan','kursi_berat',
    'almari_jml','almari_baik','almari_ringan','almari_berat',
    'papan_jml','papan_baik','papan_ringan','papan_berat'
  ];
  foreach ($data as $key) $$key = $_POST[$key] ?? 0;

  mysqli_query($koneksi, "INSERT INTO ruang_kelas_perabot VALUES(
    NULL,'$nama','$jumlah',
    '$meja_jml','$meja_baik','$meja_ringan','$meja_berat',
    '$kursi_jml','$kursi_baik','$kursi_ringan','$kursi_berat',
    '$almari_jml','$almari_baik','$almari_ringan','$almari_berat',
    '$papan_jml','$papan_baik','$papan_ringan','$papan_berat'
  )");
  header("Location: ruang_kelas_perabot.php");
  exit;
}

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  mysqli_query($koneksi, "UPDATE ruang_kelas_perabot SET
    nama_ruang='{$_POST['nama_ruang']}',
    jumlah_ruang='{$_POST['jumlah_ruang']}',
    meja_jml='{$_POST['meja_jml']}', meja_baik='{$_POST['meja_baik']}', meja_ringan='{$_POST['meja_ringan']}', meja_berat='{$_POST['meja_berat']}',
    kursi_jml='{$_POST['kursi_jml']}', kursi_baik='{$_POST['kursi_baik']}', kursi_ringan='{$_POST['kursi_ringan']}', kursi_berat='{$_POST['kursi_berat']}',
    almari_jml='{$_POST['almari_jml']}', almari_baik='{$_POST['almari_baik']}', almari_ringan='{$_POST['almari_ringan']}', almari_berat='{$_POST['almari_berat']}',
    papan_jml='{$_POST['papan_jml']}', papan_baik='{$_POST['papan_baik']}', papan_ringan='{$_POST['papan_ringan']}', papan_berat='{$_POST['papan_berat']}'
  WHERE id='$id'");
  header("Location: ruang_kelas_perabot.php");
  exit;
}

if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM ruang_kelas_perabot WHERE id='$id'");
  header("Location: ruang_kelas_perabot.php");
  exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");

// === Hitung Total dan Siapkan Data Grafik ===
$total = [
  'meja_jml'=>0,'meja_baik'=>0,'meja_ringan'=>0,'meja_berat'=>0,
  'kursi_jml'=>0,'kursi_baik'=>0,'kursi_ringan'=>0,'kursi_berat'=>0,
  'almari_jml'=>0,'almari_baik'=>0,'almari_ringan'=>0,'almari_berat'=>0,
  'papan_jml'=>0,'papan_baik'=>0,'papan_ringan'=>0,'papan_berat'=>0
];

$namaRuang = $baik = $ringan = $berat = [];
$result = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");
while ($d = mysqli_fetch_assoc($result)) {
  $namaRuang[] = $d['nama_ruang'];
  $baik[]   = $d['meja_baik'] + $d['kursi_baik'] + $d['almari_baik'] + $d['papan_baik'];
  $ringan[] = $d['meja_ringan'] + $d['kursi_ringan'] + $d['almari_ringan'] + $d['papan_ringan'];
  $berat[]  = $d['meja_berat'] + $d['kursi_berat'] + $d['almari_berat'] + $d['papan_berat'];

  foreach ($total as $key => $v) $total[$key] += $d[$key];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Perabot Kelas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; }
    .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .table thead th { text-align: center; vertical-align: middle !important; }
    .table tfoot td { font-weight: bold; background-color: #e9ecef; text-align: center; }
    .btn-sm { border-radius: 8px; }
    @media (max-width:768px){ .table{font-size:12px;} .btn{font-size:12px;padding:4px 8px;} }
  </style>
</head>
<body>
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
    <h4 class="fw-bold text-primary"><i class="bi bi-door-closed"></i> Data Perabot Ruang Kelas</h4>
    <div class="d-flex gap-2 flex-wrap">
      <a href="export_perabot.php" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
      <form action="" method="post" enctype="multipart/form-data" class="d-flex gap-2">
        <input type="file" name="file" accept=".xlsx,.xls" required class="form-control form-control-sm">
        <button type="submit" name="import" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i> Import</button>
      </form>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah</button>
    </div>
  </div>

  <!-- === TABEL DATA === -->
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Ruang</th>
            <th rowspan="2">Jumlah Ruang</th>
            <th colspan="4">Meja Siswa</th>
            <th colspan="4">Kursi Siswa</th>
            <th colspan="4">Almari + Rak Buku</th>
            <th colspan="4">Papan Tulis</th>
            <th rowspan="2">Aksi</th>
          </tr>
          <tr>
            <th>Jml</th><th>Baik</th><th>Rsk Rng</th><th>Rsk Brt</th>
            <th>Jml</th><th>Baik</th><th>Rsk Rng</th><th>Rsk Brt</th>
            <th>Jml</th><th>Baik</th><th>Rsk Rng</th><th>Rsk Brt</th>
            <th>Jml</th><th>Baik</th><th>Rsk Rng</th><th>Rsk Brt</th>
          </tr>
        </thead>
        <tbody>
          <?php $no=1; mysqli_data_seek($q,0); while($r=mysqli_fetch_assoc($q)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($r['nama_ruang']) ?></td>
            <td><?= $r['jumlah_ruang'] ?></td>
            <td><?= $r['meja_jml'] ?></td><td><?= $r['meja_baik'] ?></td><td><?= $r['meja_ringan'] ?></td><td><?= $r['meja_berat'] ?></td>
            <td><?= $r['kursi_jml'] ?></td><td><?= $r['kursi_baik'] ?></td><td><?= $r['kursi_ringan'] ?></td><td><?= $r['kursi_berat'] ?></td>
            <td><?= $r['almari_jml'] ?></td><td><?= $r['almari_baik'] ?></td><td><?= $r['almari_ringan'] ?></td><td><?= $r['almari_berat'] ?></td>
            <td><?= $r['papan_jml'] ?></td><td><?= $r['papan_baik'] ?></td><td><?= $r['papan_ringan'] ?></td><td><?= $r['papan_berat'] ?></td>
            <td>
              <a href="?hapus=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">TOTAL</td>
            <td><?= $total['meja_jml'] ?></td><td><?= $total['meja_baik'] ?></td><td><?= $total['meja_ringan'] ?></td><td><?= $total['meja_berat'] ?></td>
            <td><?= $total['kursi_jml'] ?></td><td><?= $total['kursi_baik'] ?></td><td><?= $total['kursi_ringan'] ?></td><td><?= $total['kursi_berat'] ?></td>
            <td><?= $total['almari_jml'] ?></td><td><?= $total['almari_baik'] ?></td><td><?= $total['almari_ringan'] ?></td><td><?= $total['almari_berat'] ?></td>
            <td><?= $total['papan_jml'] ?></td><td><?= $total['papan_baik'] ?></td><td><?= $total['papan_ringan'] ?></td><td><?= $total['papan_berat'] ?></td>
            <td>-</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- GRAFIK -->
  <div class="card mt-4">
    <div class="card-header bg-success text-white">
      <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Grafik Kondisi Per Ruang</h6>
    </div>
    <div class="card-body">
      <canvas id="grafikPerRuang" height="150"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const labels = <?= json_encode($namaRuang) ?>;
const dataBaik = <?= json_encode($baik) ?>;
const dataRingan = <?= json_encode($ringan) ?>;
const dataBerat = <?= json_encode($berat) ?>;
new Chart(document.getElementById('grafikPerRuang'), {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [
      { label: 'Baik', data: dataBaik, backgroundColor: '#28a745' },
      { label: 'Rusak Ringan', data: dataRingan, backgroundColor: '#ffc107' },
      { label: 'Rusak Berat', data: dataBerat, backgroundColor: '#dc3545' }
    ]
  },
  options: { responsive: true, scales: { y: { beginAtZero: true } }, plugins: { legend: { position: 'bottom' } } }
});
</script>
</body>
</html>
