<?php
include '../config/config.php';


if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

if (isset($_POST['simpan'])) {
  $kondisi = $_POST['kondisi'];
  $ukuran_8x9 = $_POST['ukuran_8x9'];
  $ukuran_lebih73 = $_POST['ukuran_lebih73'];
  $ukuran_kurang73 = $_POST['ukuran_kurang73'];
  $jumlah_ruang = $_POST['jumlah_ruang'];
  $baik = $_POST['baik'];
  $rusak_ringan = $_POST['rusak_ringan'];
  $rusak_sedang = $_POST['rusak_sedang'];
  $rusak_berat = $_POST['rusak_berat'];
  $ruang_digunakan = $_POST['ruang_digunakan'];
  $jumlah_keseluruhan = $jumlah_ruang + $ruang_digunakan;

  mysqli_query($koneksi, "INSERT INTO ruang_teori VALUES(
    '',
    '$kondisi',
    '$ukuran_8x9',
    '$ukuran_lebih73',
    '$ukuran_kurang73',
    '$jumlah_ruang',
    '$baik',
    '$rusak_ringan',
    '$rusak_sedang',
    '$rusak_berat',
    '$ruang_digunakan',
    '$jumlah_keseluruhan'
  )");

  header("location: ruang_teori.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Ruang Teori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="card shadow">
    <div class="card-header bg-success text-white">
      <h5><i class="bi bi-plus-circle"></i> Tambah Ruang Teori</h5>
    </div>
    <div class="card-body">
      <form method="post">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Kondisi</label>
            <input type="text" name="kondisi" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Jumlah Ruang</label>
            <input type="number" name="jumlah_ruang" class="form-control" required>
          </div>
        </div>

        <h6 class="mt-3 text-primary">Ukuran Ruang</h6>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>8x9 m² / 73m²</label>
            <input type="number" name="ukuran_8x9" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>&gt;73 m²</label>
            <input type="number" name="ukuran_lebih73" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>&lt;73 m²</label>
            <input type="number" name="ukuran_kurang73" class="form-control" required>
          </div>
        </div>

        <h6 class="mt-3 text-primary">Kondisi Fisik</h6>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Baik</label>
            <input type="number" name="baik" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Rusak Ringan</label>
            <input type="number" name="rusak_ringan" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Rusak Sedang</label>
            <input type="number" name="rusak_sedang" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Rusak Berat</label>
            <input type="number" name="rusak_berat" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label>Jumlah Ruang Lainnya digunakan untuk Ruang Teori (e)</label>
          <input type="number" name="ruang_digunakan" class="form-control" required>
        </div>

        <div class="text-end">
          <button type="submit" name="simpan" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Simpan
          </button>
          <a href="ruang_teori.php" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
