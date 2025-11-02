<?php
include '../config/config.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Tambah lokasi
if (isset($_POST['tambah'])) {
  $nama_lokasi = $_POST['nama_lokasi'];
  mysqli_query($koneksi, "INSERT INTO lokasi (nama_lokasi) VALUES ('$nama_lokasi')");
  echo "<script>alert('Lokasi berhasil ditambahkan!');window.location='lokasi.php';</script>";
}

// Hapus lokasi
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM lokasi WHERE id='$id'");
  echo "<script>alert('Lokasi berhasil dihapus!');window.location='lokasi.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Lokasi - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f5f6fa; font-family: 'Poppins', sans-serif; }
.card { border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); }
.btn-primary { background-color: #0d6efd; border: none; border-radius: 8px; }
.btn-danger { border-radius: 8px; }
</style>
</head>
<body class="p-3">

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold text-primary"><i class="bi bi-geo-alt"></i> Kelola Lokasi</h4>
    <a href="index.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <div class="card mb-4">
    <div class="card-header bg-primary text-white"><i class="bi bi-plus-circle"></i> Tambah Lokasi</div>
    <div class="card-body">
      <form method="POST" class="row g-3">
        <div class="col-md-10">
          <label>Nama Lokasi</label>
          <input type="text" name="nama_lokasi" class="form-control" placeholder="Contoh: Lab RPL, Ruang Guru, dll" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" name="tambah" class="btn btn-primary w-100"><i class="bi bi-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white"><i class="bi bi-list"></i> Daftar Lokasi</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr><th>No</th><th>Nama Lokasi</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $data = mysqli_query($koneksi, "SELECT * FROM lokasi ORDER BY id DESC");
          while ($d = mysqli_fetch_assoc($data)) {
            echo "<tr>
              <td>$no</td>
              <td>{$d['nama_lokasi']}</td>
              <td>
                <a href='?hapus={$d['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus lokasi ini?')\"><i class='bi bi-trash'></i></a>
              </td>
            </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
