<?php
include '../config/config.php';
if (!isset($_SESSION['level'])) header("location:../login.php");
$jurusan = strtoupper($_SESSION['level']);

$bulanList = [
  "01" => "Januari", "02" => "Februari", "03" => "Maret",
  "04" => "April", "05" => "Mei", "06" => "Juni",
  "07" => "Juli", "08" => "Agustus", "09" => "September",
  "10" => "Oktober", "11" => "November", "12" => "Desember"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bulanan - <?= $jurusan ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
.card { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
h4 { font-weight: 600; margin-bottom: 20px; }
.btn-primary { border-radius: 8px; }
.btn-success { border-radius: 8px; }
.table thead { background: #4a6cf7; color: white; }
.table tbody tr:hover { background: #e6f0ff; }
</style>
</head>
<body class="p-4">

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> Laporan Bulanan - <?= $jurusan ?></h4>
    <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <div class="card p-4 mb-4">
    <form method="get" class="row g-3 align-items-end">
      <div class="col-md-4">
        <label>Bulan</label>
        <select name="bulan" class="form-control">
          <option value="">Pilih Bulan</option>
          <?php
          foreach ($bulanList as $num => $nama) {
            $sel = (isset($_GET['bulan']) && $_GET['bulan']==$num) ? "selected" : "";
            echo "<option value='$num' $sel>$nama</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <label>Tahun</label>
        <select name="tahun" class="form-control">
          <?php 
          for ($i=date('Y'); $i>=2020; $i--) {
            $sel = (isset($_GET['tahun']) && $_GET['tahun']==$i) ? "selected" : "";
            echo "<option $sel>$i</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
      </div>
    </form>
  </div>

<?php
if (isset($_GET['bulan'])):
  $b = $_GET['bulan'];
  $t = $_GET['tahun'];
  $sql = mysqli_query($koneksi, "SELECT * FROM aset WHERE pengguna_barang='$jurusan' AND MONTH(tanggal)='$b' AND YEAR(tanggal)='$t'");
?>
  <div class="card p-4 shadow-sm">
    <h5>Laporan Bulan: <?= $bulanList[$b] ?> <?= $t ?></h5>
    <div class="table-responsive mt-3">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1; $total = 0;
        while($d = mysqli_fetch_assoc($sql)):
          $total += $d['nilai_perolehan'];
        ?>
          <tr>
            <td><?= $no ?></td>
            <td><?= $d['nama_barang'] ?></td>
            <td><?= $d['merk'] ?></td>
            <td><?= $d['tanggal'] ?></td>
            <td><?= $d['jumlah'] ?></td>
            <td>Rp <?= number_format($d['nilai_perolehan'],0,',','.') ?></td>
          </tr>
        <?php $no++; endwhile; ?>
          <tr class="table-secondary">
            <td colspan="5" class="text-end"><b>Total Nilai</b></td>
            <td><b>Rp <?= number_format($total,0,',','.') ?></b></td>
          </tr>
        </tbody>
      </table>
    </div>
    <button onclick="window.print()" class="btn btn-success mt-3"><i class="bi bi-printer"></i> Cetak</button>
  </div>
<?php endif; ?>

</div>

</body>
</html>
