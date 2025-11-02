<?php
include '../config/config.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM ruang_penunjang WHERE id='$id'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Ruang Penunjang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-warning text-white">
      <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Data Ruang Penunjang</h5>
    </div>
    <div class="card-body">
      <form method="post" action="update_ruang_penunjang.php">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3">
          <label>Jenis Ruangan</label>
          <input type="text" name="jenis_ruangan" class="form-control" value="<?= $data['jenis_ruangan'] ?>" required>
        </div>
        <div class="mb-3">
          <label>Jumlah (buah)</label>
          <input type="number" name="jumlah" class="form-control" value="<?= $data['jumlah'] ?>" required>
        </div>
        <div class="mb-3">
          <label>Ukuran (p x l)</label>
          <input type="text" name="ukuran" class="form-control" value="<?= $data['ukuran'] ?>" required>
        </div>
        <div class="mb-3">
          <label>Kondisi</label>
          <select name="kondisi" class="form-select">
            <option <?= $data['kondisi']=='Baik'?'selected':'' ?>>Baik</option>
            <option <?= $data['kondisi']=='Rusak Ringan'?'selected':'' ?>>Rusak Ringan</option>
            <option <?= $data['kondisi']=='Rusak Sedang'?'selected':'' ?>>Rusak Sedang</option>
            <option <?= $data['kondisi']=='Rusak Berat'?'selected':'' ?>>Rusak Berat</option>
          </select>
        </div>
        <div class="text-end">
          <a href="index.php" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
