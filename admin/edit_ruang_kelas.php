<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

if (!isset($_GET['id'])) {
  header("location: ruang_kelas.php");
  exit;
}

$id = intval($_GET['id']);
$q = mysqli_query($koneksi, "SELECT * FROM ruang_kelas WHERE id=$id");
$data = mysqli_fetch_assoc($q);
if (!$data) {
  echo "<script>alert('Data tidak ditemukan!');window.location='ruang_kelas.php';</script>";
  exit;
}

if (isset($_POST['update'])) {
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama_ruang']);
  $jumlah = $_POST['jumlah_ruang'];

  $meja_baik = $_POST['meja_baik'];
  $meja_ringan = $_POST['meja_rusak_ringan'];
  $meja_berat = $_POST['meja_rusak_berat'];
  $meja_jumlah = $meja_baik + $meja_ringan + $meja_berat;

  $kursi_baik = $_POST['kursi_baik'];
  $kursi_ringan = $_POST['kursi_rusak_ringan'];
  $kursi_berat = $_POST['kursi_rusak_berat'];
  $kursi_jumlah = $kursi_baik + $kursi_ringan + $kursi_berat;

  $almari_baik = $_POST['almari_baik'];
  $almari_ringan = $_POST['almari_rusak_ringan'];
  $almari_berat = $_POST['almari_rusak_berat'];
  $almari_jumlah = $almari_baik + $almari_ringan + $almari_berat;

  $papan_baik = $_POST['papan_baik'];
  $papan_ringan = $_POST['papan_rusak_ringan'];
  $papan_berat = $_POST['papan_rusak_berat'];
  $papan_jumlah = $papan_baik + $papan_ringan + $papan_berat;

  $update = "UPDATE ruang_kelas SET 
    nama_ruang='$nama',
    jumlah_ruang='$jumlah',
    meja_jumlah='$meja_jumlah',
    meja_baik='$meja_baik',
    meja_rusak_ringan='$meja_ringan',
    meja_rusak_berat='$meja_berat',
    kursi_jumlah='$kursi_jumlah',
    kursi_baik='$kursi_baik',
    kursi_rusak_ringan='$kursi_ringan',
    kursi_rusak_berat='$kursi_berat',
    almari_jumlah='$almari_jumlah',
    almari_baik='$almari_baik',
    almari_rusak_ringan='$almari_ringan',
    almari_rusak_berat='$almari_berat',
    papan_jumlah='$papan_jumlah',
    papan_baik='$papan_baik',
    papan_rusak_ringan='$papan_ringan',
    papan_rusak_berat='$papan_berat'
    WHERE id=$id";

  if (mysqli_query($koneksi, $update)) {
    echo "<script>alert('Data berhasil diperbarui!');window.location='ruang_kelas.php';</script>";
  } else {
    echo "Error: " . mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Ruang Kelas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.card { border-radius: 15px; }
.table th, .table td { text-align: center; vertical-align: middle; }
input[type=number] { width: 90px; text-align: center; }
@media (max-width:768px){
  .table-responsive { font-size: 12px; }
}
</style>
</head>
<body>
<div class="container my-4">

  <div class="card shadow">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Data Ruang Kelas</h5>
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">

        <div class="col-md-6">
          <label class="form-label">Nama Ruang</label>
          <input type="text" name="nama_ruang" value="<?= $data['nama_ruang']; ?>" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Jumlah Ruang</label>
          <input type="number" name="jumlah_ruang" value="<?= $data['jumlah_ruang']; ?>" class="form-control" required>
        </div>

        <hr class="mt-4">
        <h5>Perabot & Kondisi</h5>

        <div class="col-md-12 table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-secondary">
              <tr>
                <th rowspan="2">Perabot</th>
                <th colspan="4">Jumlah dan Kondisi</th>
              </tr>
              <tr>
                <th>Jumlah</th>
                <th>Baik</th>
                <th>Rsk. Ringan</th>
                <th>Rsk. Berat</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Meja Siswa</td>
                <td><input type="number" id="meja_total" name="meja_jumlah" value="<?= $data['meja_jumlah']; ?>" class="form-control" readonly></td>
                <td><input type="number" id="meja_baik" name="meja_baik" value="<?= $data['meja_baik']; ?>" class="form-control" oninput="hitungTotal('meja')"></td>
                <td><input type="number" id="meja_ringan" name="meja_rusak_ringan" value="<?= $data['meja_rusak_ringan']; ?>" class="form-control" oninput="hitungTotal('meja')"></td>
                <td><input type="number" id="meja_berat" name="meja_rusak_berat" value="<?= $data['meja_rusak_berat']; ?>" class="form-control" oninput="hitungTotal('meja')"></td>
              </tr>

              <tr>
                <td>Kursi Siswa</td>
                <td><input type="number" id="kursi_total" name="kursi_jumlah" value="<?= $data['kursi_jumlah']; ?>" class="form-control" readonly></td>
                <td><input type="number" id="kursi_baik" name="kursi_baik" value="<?= $data['kursi_baik']; ?>" class="form-control" oninput="hitungTotal('kursi')"></td>
                <td><input type="number" id="kursi_ringan" name="kursi_rusak_ringan" value="<?= $data['kursi_rusak_ringan']; ?>" class="form-control" oninput="hitungTotal('kursi')"></td>
                <td><input type="number" id="kursi_berat" name="kursi_rusak_berat" value="<?= $data['kursi_rusak_berat']; ?>" class="form-control" oninput="hitungTotal('kursi')"></td>
              </tr>

              <tr>
                <td>Almari + Rak Buku</td>
                <td><input type="number" id="almari_total" name="almari_jumlah" value="<?= $data['almari_jumlah']; ?>" class="form-control" readonly></td>
                <td><input type="number" id="almari_baik" name="almari_baik" value="<?= $data['almari_baik']; ?>" class="form-control" oninput="hitungTotal('almari')"></td>
                <td><input type="number" id="almari_ringan" name="almari_rusak_ringan" value="<?= $data['almari_rusak_ringan']; ?>" class="form-control" oninput="hitungTotal('almari')"></td>
                <td><input type="number" id="almari_berat" name="almari_rusak_berat" value="<?= $data['almari_rusak_berat']; ?>" class="form-control" oninput="hitungTotal('almari')"></td>
              </tr>

              <tr>
                <td>Papan Tulis</td>
                <td><input type="number" id="papan_total" name="papan_jumlah" value="<?= $data['papan_jumlah']; ?>" class="form-control" readonly></td>
                <td><input type="number" id="papan_baik" name="papan_baik" value="<?= $data['papan_baik']; ?>" class="form-control" oninput="hitungTotal('papan')"></td>
                <td><input type="number" id="papan_ringan" name="papan_rusak_ringan" value="<?= $data['papan_rusak_ringan']; ?>" class="form-control" oninput="hitungTotal('papan')"></td>
                <td><input type="number" id="papan_berat" name="papan_rusak_berat" value="<?= $data['papan_rusak_berat']; ?>" class="form-control" oninput="hitungTotal('papan')"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="text-end">
          <a href="ruang_kelas.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
          <button type="submit" name="update" class="btn btn-success"><i class="bi bi-save"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
function hitungTotal(prefix) {
  const baik = parseInt(document.getElementById(prefix + "_baik").value) || 0;
  const ringan = parseInt(document.getElementById(prefix + "_ringan").value) || 0;
  const berat = parseInt(document.getElementById(prefix + "_berat").value) || 0;
  const total = baik + ringan + berat;
  document.getElementById(prefix + "_total").value = total;
}
</script>
</body>
</html>
