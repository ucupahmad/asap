<?php include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Inventaris</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<h4>Tambah Data Inventaris</h4>
<a href="aset.php" class="btn btn-secondary btn-sm mb-3">Kembali</a>

<form method="post">
<div class="row">
<div class="col-md-6">
  <label>Nama Barang</label>
  <input type="text" name="nama_barang" class="form-control" required>
</div>
<div class="col-md-6">
  <label>Merk</label>
  <input type="text" name="merk" class="form-control">
</div>
<div class="col-md-4">
  <label>Tanggal</label>
  <input type="date" name="tanggal" class="form-control" required>
</div>
<div class="col-md-4">
  <label>Sumber Dana</label>
  <input type="text" name="sumber_dana" class="form-control">
</div>
<div class="col-md-4">
  <label>Satuan Barang</label>
  <input type="text" name="satuan_barang" class="form-control">
</div>
<div class="col-md-3">
  <label>Jumlah</label>
  <input type="number" name="jumlah" class="form-control">
</div>
<div class="col-md-3">
  <label>Harga Satuan</label>
  <input type="number" name="harga_satuan" class="form-control">
</div>
<div class="col-md-3">
  <label>Tahun</label>
  <input type="number" name="tahun" class="form-control">
</div>
<div class="col-md-3">
  <label>No Inventaris</label>
  <input type="text" name="no_inv" class="form-control">
</div>
<div class="col-md-6">
  <label>Pengguna Barang</label>
  <select name="pengguna_barang" class="form-control">
    <option>DPIB</option>
    <option>TKR</option>
    <option>TKJ</option>
    <option>TSM</option>
    <option>DKV</option>
    <option>BD</option>
    <option>Petugas</option>
	<option>PERPUSTAKAAN</option>
	<option>HALLMEET</option>
	<option>WAKA</option>
	<option>KS</option>
	<option>GURU</option>
	<option>BENDAHARA</option>
	<option>TU</option>
  </select>
</div>
<div class="col-md-2">
  <label>Baik</label>
  <input type="number" name="baik" class="form-control" value="0">
</div>
<div class="col-md-2">
  <label>Kurang Baik</label>
  <input type="number" name="kurang_baik" class="form-control" value="0">
</div>
<div class="col-md-2">
  <label>Rusak</label>
  <input type="number" name="rusak" class="form-control" value="0">
</div>
</div>
<button name="simpan" class="btn btn-primary mt-3">Simpan</button>
</form>

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
  $noinv = $_POST['no_inv'];
  $pengguna = $_POST['pengguna_barang'];
  $baik = $_POST['baik'];
  $kurang = $_POST['kurang_baik'];
  $rusak = $_POST['rusak'];

  mysqli_query($koneksi, "INSERT INTO aset VALUES('', '$nama','$merk','$tgl','$sumber','$satuan','$jumlah','$harga','$nilai','$tahun','$noinv','$pengguna','$baik','$kurang','$rusak')");
  echo "<script>alert('Data berhasil disimpan');window.location='aset.php';</script>";
}
?>
</body>
</html>
