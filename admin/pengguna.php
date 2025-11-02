<?php
include '../config/config.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Tambah pengguna
if (isset($_POST['tambah'])) {
  $nama = $_POST['nama'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $level = $_POST['level'];

  mysqli_query($koneksi, "INSERT INTO user (nama, username, password, level) VALUES ('$nama','$username','$password','$level')");
  echo "<script>alert('Pengguna berhasil ditambahkan!');window.location='pengguna.php';</script>";
}

// Hapus pengguna
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
  echo "<script>alert('Pengguna berhasil dihapus!');window.location='pengguna.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kelola Pengguna - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { background-color: #f5f6fa; font-family: 'Poppins', sans-serif; }
.card { border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); }
.btn-primary { background-color: #0d6efd; border: none; border-radius: 8px; }
.btn-danger, .btn-success { border-radius: 8px; }
</style>
</head>
<body class="p-3">

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold text-primary"><i class="bi bi-people"></i> Kelola Pengguna</h4>
    <a href="index.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <div class="card mb-4">
    <div class="card-header bg-primary text-white"><i class="bi bi-person-plus"></i> Tambah Pengguna</div>
    <div class="card-body">
      <form method="POST" class="row g-3">
        <div class="col-md-4">
          <label>Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="col-md-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label>Level</label>
          <select name="level" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="admin">Admin</option>
            <option value="rpl">RPL</option>
            <option value="tkj">TKJ</option>
            <option value="mm">MM</option>
          </select>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="tambah" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header bg-dark text-white"><i class="bi bi-list"></i> Daftar Pengguna</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr><th>No</th><th>Nama</th><th>Username</th><th>Level</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $data = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id DESC");
          while ($d = mysqli_fetch_assoc($data)) {
            echo "<tr>
              <td>$no</td>
              <td>{$d['nama']}</td>
              <td>{$d['username']}</td>
              <td><span class='badge bg-primary'>{$d['level']}</span></td>
              <td>
                <a href='?hapus={$d['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus pengguna ini?')\"><i class='bi bi-trash'></i></a>
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
