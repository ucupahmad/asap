<?php
include '../config/config.php';

// Pastikan user login dan level admin

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Pastikan ada parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<script>alert('ID tidak valid!'); window.location='index.php';</script>";
  exit;
}

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM ruang_lainnya WHERE id='$id'");
if (!$q || mysqli_num_rows($q) == 0) {
  echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
  exit;
}

$data = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Ruang Kantor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-warning text-white">
      <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Data Ruang Kantor</h5>
    </div>
    <div class="card-body">
      <form method="post" action="update_ruang_lainnya.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">

        <div class="mb-3">
          <label class="form-label">Jenis Ruangan</label>
          <input type="text" name="jenis_ruangan" class="form-control" 
                 value="<?= htmlspecialchars($data['jenis_ruangan']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Jumlah (buah)</label>
          <input type="number" name="jumlah" class="form-control" 
                 value="<?= htmlspecialchars($data['jumlah']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Ukuran (P x L)</label>
          <input type="text" name="ukuran" class="form-control" 
                 value="<?= htmlspecialchars($data['ukuran']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Kondisi</label>
          <select name="kondisi" class="form-select" required>
            <option value="Baik" <?= $data['kondisi'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
            <option value="Rusak Ringan" <?= $data['kondisi'] == 'Rusak Ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
            <option value="Rusak Sedang" <?= $data['kondisi'] == 'Rusak Sedang' ? 'selected' : '' ?>>Rusak Sedang</option>
            <option value="Rusak Berat" <?= $data['kondisi'] == 'Rusak Berat' ? 'selected' : '' ?>>Rusak Berat</option>
          </select>
        </div>

        <div class="text-end">
          <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
          <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
