<?php 
include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan</title>
  <link rel="icon" type="image/png" href="assets/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body {
    background-color: #f8fafc;
    font-family: 'Segoe UI', sans-serif;
  }
  .card {
    border-radius: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }
  .btn-primary {
    background: linear-gradient(90deg, #0066ff, #0099ff);
    border: none;
  }
  .btn-primary:hover {
    background: linear-gradient(90deg, #0052cc, #007acc);
  }
  table th {
    background-color: #0d6efd;
    color: #fff;
    text-align: center;
  }
  table td {
    vertical-align: middle;
  }
  h4 {
    color: #0d6efd;
    font-weight: 600;
  }
</style>
</head>
<body class="p-4">

<div class="container">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4><i class="bi bi-calendar3"></i> Laporan Bulanan Aset Sekolah</h4>
      <a href="index.php" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    </div>

    <form method="get" class="row g-3 align-items-end mb-4">
      <div class="col-md-4">
        <label class="form-label fw-semibold">Bulan</label>
        <select name="bulan" class="form-select" required>
          <option value="">Pilih Bulan</option>
          <?php
          $bulanList = [
            "01" => "Januari", "02" => "Februari", "03" => "Maret",
            "04" => "April", "05" => "Mei", "06" => "Juni",
            "07" => "Juli", "08" => "Agustus", "09" => "September",
            "10" => "Oktober", "11" => "November", "12" => "Desember"
          ];
          foreach ($bulanList as $num => $nama) {
            $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $num) ? 'selected' : '';
            echo "<option value='$num' $selected>$nama</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label fw-semibold">Tahun</label>
        <select name="tahun" class="form-select" required>
          <?php 
          for ($i = date('Y'); $i >= 2020; $i--) {
            $sel = (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? 'selected' : '';
            echo "<option value='$i' $sel>$i</option>"; 
          }
          ?>
        </select>
      </div>

      <div class="col-md-2">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
      </div>
    </form>

    <?php
    if (isset($_GET['bulan'])) {
      $b = $_GET['bulan'];
      $t = $_GET['tahun'];
      $sql = mysqli_query($koneksi, "SELECT * FROM aset WHERE MONTH(tanggal)='$b' AND YEAR(tanggal)='$t'");
      
      if (mysqli_num_rows($sql) > 0) {
        echo "<div class='table-responsive'>";
        echo "<h5 class='text-center mb-3 text-primary'>Laporan Bulan: ".$bulanList[$b]." $t</h5>";
        echo "<table class='table table-bordered table-hover align-middle'>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Tanggal</th>
            <th>Sumber Dana</th>
            <th>Jumlah</th>
            <th>Nilai Perolehan</th>
            <th>Pengguna Barang</th>
          </tr>
        </thead>
        <tbody>";
        $no=1; $total=0;
        while($d=mysqli_fetch_assoc($sql)){
          echo "<tr>
          <td class='text-center'>$no</td>
          <td>$d[nama_barang]</td>
          <td>$d[merk]</td>
          <td>".date('d-m-Y', strtotime($d['tanggal']))."</td>
          <td>$d[sumber_dana]</td>
          <td class='text-center'>$d[jumlah]</td>
          <td class='text-end'>".number_format($d['nilai_perolehan'],0,',','.')."</td>
          <td>$d[pengguna_barang]</td>
          </tr>";
          $no++;
          $total += $d['nilai_perolehan'];
        }
        echo "</tbody>
        <tfoot>
          <tr class='table-secondary fw-bold'>
            <td colspan='6' class='text-end'>Total Nilai Perolehan</td>
            <td colspan='2' class='text-end'>Rp ".number_format($total,0,',','.')."</td>
          </tr>
        </tfoot>
        </table>";
        echo "<div class='text-center mt-3'>
          <button onclick='window.print()' class='btn btn-success'><i class=\"bi bi-printer\"></i> Cetak Laporan</button>
        </div>";
        echo "</div>";
      } else {
        echo "<div class='alert alert-warning mt-4 text-center'>Tidak ada data aset pada bulan ini.</div>";
      }
    }
    ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.js"></script>
</body>
</html>
