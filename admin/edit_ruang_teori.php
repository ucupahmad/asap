<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// --- Pastikan ID ada dan valid ---
if (!isset($_GET['id'])) {
  header("location: ruang_teori.php");
  exit;
}

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM ruang_teori WHERE id='$id'");
if (mysqli_num_rows($q) == 0) {
  header("location: ruang_teori.php");
  exit;
}
$data = mysqli_fetch_assoc($q);

// --- Jika tombol update ditekan ---
if (isset($_POST['update'])) {
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

  $update = mysqli_query($koneksi, "UPDATE ruang_teori SET
    kondisi='$kondisi',
    ukuran_8x9='$ukuran_8x9',
    ukuran_lebih73='$ukuran_lebih73',
    ukuran_kurang73='$ukuran_kurang73',
    jumlah_ruang='$jumlah_ruang',
    baik='$baik',
    rusak_ringan='$rusak_ringan',
    rusak_sedang='$rusak_sedang',
    rusak_berat='$rusak_berat',
    ruang_digunakan='$ruang_digunakan',
    jumlah_keseluruhan='$jumlah_keseluruhan'
    WHERE id='$id'");

  if ($update) {
    echo "<script>
      alert('✅ Data berhasil diperbarui!');
      window.location.href='ruang_teori.php';
    </script>";
    exit;
  } else {
    echo "<script>alert('❌ Gagal memperbarui data.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Ruang Teori</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="card shadow-lg">
    <div class="card-header bg-warning text-dark">
      <h5><i class="bi bi-pencil-square"></i> Edit Data Ruang Teori</h5>
    </div>

    <div class="card-body">
      <form method="post">

        <!-- KONDISI RUANG -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Kondisi</label>
            <input type="text" name="kondisi" class="form-control" value="<?= $data['kondisi'] ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Jumlah Ruang</label>
            <input type="number" name="jumlah_ruang" class="form-control" value="<?= $data['jumlah_ruang'] ?>" required>
          </div>
        </div>

        <!-- UKURAN RUANG -->
        <h6 class="text-primary mt-4">Ukuran Ruang</h6>
        <div class="row mb-3">
          <div class="col-md-4">
            <label>8x9 m²</label>
            <input type="number" name="ukuran_8x9" class="form-control" value="<?= $data['ukuran_8x9'] ?>">
          </div>
          <div class="col-md-4">
            <label>&gt;73 m²</label>
            <input type="number" name="ukuran_lebih73" class="form-control" value="<?= $data['ukuran_lebih73'] ?>">
          </div>
          <div class="col-md-4">
            <label>&lt;73 m²</label>
            <input type="number" name="ukuran_kurang73" class="form-control" value="<?= $data['ukuran_kurang73'] ?>">
          </div>
        </div>

        <!-- KONDISI FISIK -->
        <h6 class="text-primary mt-4">Kondisi Fisik</h6>
        <div class="row mb-3">
          <div class="col-md-3">
            <label>Baik</label>
            <input type="number" name="baik" class="form-control" value="<?= $data['baik'] ?>">
          </div>
          <div class="col-md-3">
            <label>Rusak Ringan</label>
            <input type="number" name="rusak_ringan" class="form-control" value="<?= $data['rusak_ringan'] ?>">
          </div>
          <div class="col-md-3">
            <label>Rusak Sedang</label>
            <input type="number" name="rusak_sedang" class="form-control" value="<?= $data['rusak_sedang'] ?>">
          </div>
          <div class="col-md-3">
            <label>Rusak Berat</label>
            <input type="number" name="rusak_berat" class="form-control" value="<?= $data['rusak_berat'] ?>">
          </div>
        </div>

        <!-- RUANG DIGUNAKAN -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Ruang Digunakan</label>
            <input type="number" name="ruang_digunakan" class="form-control" value="<?= $data['ruang_digunakan'] ?>">
          </div>
        </div>

        <div class="text-end">
          <a href="ruang_teori.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <button type="submit" name="update" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

</body>
</html>
