<?php include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM aset WHERE id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Inventaris</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<h4>Edit Data Aset</h4>
<a href="aset.php" class="btn btn-secondary btn-sm mb-3">Kembali</a>

<form method="post">
<input type="hidden" name="id" value="<?= $data['id']; ?>">
<div class="row">
<div class="col-md-6">
  <label>Nama Barang</label>
  <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" class="form-control" required>
</div>
<div class="col-md-6">
  <label>Merk</label>
  <input type="text" name="merk" value="<?= $data['merk']; ?>" class="form-control">
</div>
<div class="col-md-4">
  <label>Tanggal</label>
  <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" class="form-control">
</div>
<div class="col-md-4">
  <label>Sumber Dana</label>
  <input type="text" name="sumber_dana" value="<?= $data['sumber_dana']; ?>" class="form-control">
</div>
<div class="col-md-4">
  <label>Satuan Barang</label>
  <input type="text" name="satuan_barang" value="<?= $data['satuan_barang']; ?>" class="form-control">
</div>
<div class="col-md-3">
  <label>Jumlah</label>
  <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" class="form-control">
</div>
<div class="col-md-3">
  <label>Harga Satuan</label>
  <input type="number" name="harga_satuan" value="<?= $data['harga_satuan']; ?>" class="form-control">
</div>
<div class="col-md-3">
  <label>Tahun</label>
  <input type="number" name="tahun" value="<?= $data['tahun']; ?>" class="form-control">
</div>
<div class="col-md-3">
  <label>No Inventaris</label>
  <input type="text" name="no_inv" value="<?= $data['no_inv']; ?>" class="form-control">
</div>
<div class="col-md-6">
  <label>Pengguna Barang</label>
  <select name="pengguna_barang" class="form-control">
    <option selected><?= $data['pengguna_barang']; ?></option>
    <option>DPIB</option>
    <option>TKR</option>
    <option>TKJ</option>
    <option>TSM</option>
    <option>DKV</option>
    <option>BD</option>
    <option>Petugas</option>
	<option>Perpus</option>
  </select>
</div>
<div class="col-md-2">
  <label>Baik</label>
  <input type="number" name="baik" value="<?= $data['baik']; ?>" class="form-control">
</div>
<div class="col-md-2">
  <label>Kurang Baik</label>
  <input type="number" name="kurang_baik" value="<?= $data['kurang_baik']; ?>" class="form-control">
</div>
<div class="col-md-2">
  <label>Rusak</label>
  <input type="number" name="rusak" value="<?= $data['rusak']; ?>" class="form-control">
</div>
</div>
<button name="update" class="btn btn-success mt-3">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
  $id = $_POST['id'];
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

  mysqli_query($koneksi, "UPDATE aset SET nama_barang='$nama', merk='$merk', tanggal='$tgl', sumber_dana='$sumber', satuan_barang='$satuan', jumlah='$jumlah', harga_satuan='$harga', nilai_perolehan='$nilai', tahun='$tahun', no_inv='$noinv', pengguna_barang='$pengguna', baik='$baik', kurang_baik='$kurang', rusak='$rusak' WHERE id='$id'");
  echo "<script>alert('Data berhasil diupdate');window.location='aset.php';</script>";
}
?>
</body>
</html>
