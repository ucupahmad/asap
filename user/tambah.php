<?php 
include '../config/config.php';
if (!isset($_SESSION['level'])) header("location:../login.php");
$jurusan = strtoupper($_SESSION['level']);

// Ambil nomor inventaris terakhir untuk level ini
$qLast = mysqli_query($koneksi, "SELECT no_inv FROM aset WHERE pengguna_barang='$jurusan' ORDER BY id DESC LIMIT 1");
$dLast = mysqli_fetch_assoc($qLast);

if ($dLast) {
    // Pecah format no_inv, misal: TKJ-005
    $lastNum = (int)preg_replace('/[^0-9]/', '', $dLast['no_inv']);
    $newNum = $lastNum + 1;
} else {
    $newNum = 1;
}

// Format nomor inventaris baru
$noinv_baru = sprintf("%s-%03d", $jurusan, $newNum);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Inventaris <?= $jurusan ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
  .card { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
  .form-label { font-weight: 500; color: #555; }
  .btn-primary { background: #4a6cf7; border: none; border-radius: 8px; }
  .btn-primary:hover { background: #3c5ad6; }
  h4 { font-weight: 600; color: #333; }
</style>
</head>
<body class="p-4">

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-box-seam"></i> Tambah Inventaris - <?= $jurusan ?></h4>
    <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <div class="card p-4">
    <form method="post">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Barang</label>
          <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Merk</label>
          <input type="text" name="merk" class="form-control">
        </div>
        <div class="col-md-4">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Sumber Dana</label>
          <select name="sumber_dana" class="form-control">
            <option>Yayasan</option>
            <option>BOS</option>
            <option>BPOPP</option>
            <option>Optional</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Satuan Barang</label>
          <select name="satuan_barang" class="form-control">
            <option>Pcs</option>
            <option>Biji</option>
            <option>Unit</option>
            <option>Buah</option>
            <option>Pack</option>
            <option>Roll</option>
            <option>Liter</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Jumlah</label>
          <input type="number" name="jumlah" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Harga Satuan</label>
          <input type="number" name="harga_satuan" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Tahun</label>
          <input type="number" name="tahun" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">No Inventaris</label>
          <input type="text" name="no_inv" class="form-control" value="<?= $noinv_baru ?>" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Baik</label>
          <input type="number" name="baik" class="form-control" value="0">
        </div>
        <div class="col-md-4">
          <label class="form-label">Kurang Baik</label>
          <input type="number" name="kurang_baik" class="form-control" value="0">
        </div>
        <div class="col-md-4">
          <label class="form-label">Rusak</label>
          <input type="number" name="rusak" class="form-control" value="0">
        </div>
      </div>
      <button name="simpan" class="btn btn-primary mt-4 w-100 py-2">
        <i class="bi bi-save"></i> Simpan Data Inventaris
      </button>
    </form>
  </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama_barang'];
  $merk = $_POST['merk'];
  $tgl = $_POST['tanggal'];
  $sumber = $_POST['sumber_dana'];
  $satuan = $_POST['satuan_barang'];
  $jumlah = $_POST['jumlah'];
  $harga = $_POST['harga_satuan'];
  $nilai = $jumlah * $harga;
  $tahun = $_POST['tahun'];
  $noinv = $noinv_baru; // otomatis
  $baik = $_POST['baik'];
  $kurang = $_POST['kurang_baik'];
  $rusak = $_POST['rusak'];

  $simpan = mysqli_query($koneksi, "INSERT INTO aset 
  (nama_barang, merk, tanggal, sumber_dana, satuan_barang, jumlah, harga_satuan, nilai_perolehan, tahun, no_inv, pengguna_barang, baik, kurang_baik, rusak)
  VALUES ('$nama','$merk','$tgl','$sumber','$satuan','$jumlah','$harga','$nilai','$tahun','$noinv','$jurusan','$baik','$kurang','$rusak')");

  if ($simpan) {
    echo "<script>alert('✅ Data berhasil disimpan dengan No. Inventaris: $noinv');window.location='tambah.php';</script>";
  } else {
    echo "<script>alert('❌ Gagal menyimpan data!');</script>";
  }
}
?>
</body>
</html>
