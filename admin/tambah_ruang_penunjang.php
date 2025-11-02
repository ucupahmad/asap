<?php
include '../config/config.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Ruang Penunjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Data Ruang Penunjang</h5>
    </div>
    <div class="card-body">
      <form method="post" action="simpan_ruang_penunjang.php">
        <div class="mb-3">
          <label>Jenis Ruangan</label>
          <input type="text" name="jenis_ruangan" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Jumlah (buah)</label>
          <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Ukuran (p x l)</label>
          <input type="text" name="ukuran" class="form-control" placeholder="Contoh: 8x9 m" required>
        </div>
        <div class="mb-3">
          <label>Kondisi</label>
          <select name="kondisi" class="form-select">
            <option value="Baik">Baik</option>
            <option value="Rusak Ringan">Rusak Ringan</option>
            <option value="Rusak Sedang">Rusak Sedang</option>
            <option value="Rusak Berat">Rusak Berat</option>
          </select>
        </div>
        <div class="text-end">
          <a href="index.php" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
