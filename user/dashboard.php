<?php 
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] == 'admin') {
    header("location:../login.php");
    exit;
}

$jurusan = strtoupper($_SESSION['level']);

// 🧭 Proses update status barang
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $aksi = $_GET['aksi'];

    if ($aksi == 'rusak') {
        mysqli_query($koneksi, "UPDATE aset SET rusak = rusak + 1 WHERE id = $id AND pengguna_barang='$jurusan'");
        echo "<script>alert('Barang ditandai rusak!');window.location='dashboard.php';</script>";
    } elseif ($aksi == 'hilang') {
        mysqli_query($koneksi, "UPDATE aset SET hilang = hilang + 1 WHERE id = $id AND pengguna_barang='$jurusan'");
        echo "<script>alert('Barang ditandai hilang!');window.location='dashboard.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard <?= $jurusan ?> - Inventaris Sekolah</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f5f7fb;
  margin: 0;
}

/* === SIDEBAR === */
.sidebar {
  position: fixed;
  top: 0; left: 0;
  width: 240px; height: 100vh;
  background: linear-gradient(135deg, #0d6efd, #6610f2);
  color: #fff;
  padding: 20px 15px;
  display: flex; flex-direction: column;
  transition: all 0.3s ease;
  box-shadow: 2px 0 10px rgba(0,0,0,0.1);
  z-index: 1000;
}

.sidebar a {
  color: rgba(255,255,255,0.9);
  text-decoration: none;
  margin: 8px 0;
  padding: 10px 15px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.sidebar a.active, .sidebar a:hover {
  background: rgba(255,255,255,0.2);
  transform: translateX(3px);
}

/* === KONTEN === */
.content {
  margin-left: 240px;
  padding: 25px;
  transition: all 0.3s ease;
}

/* === MODE GELAP === */
body.dark { background: #1e1e2d; color: #eee; }
body.dark .sidebar { background: linear-gradient(135deg, #212529, #343a40); }
body.dark .card, body.dark .table { background-color: #2c2c3a !important; color: #ddd !important; }

/* === RESPONSIVE === */
@media (max-width: 991px) {
  .sidebar {
    left: -240px;
  }
  .sidebar.show {
    left: 0;
  }
  .content {
    margin-left: 0;
    padding: 20px;
  }
  .table {
    font-size: 14px;
  }
  .table td, .table th {
    padding: 8px;
  }
  .table-responsive {
    overflow-x: auto;
  }
}

/* Tombol toggle sidebar (hanya muncul di HP) */
#toggleSidebar {
  border: none;
}

/* Tombol aksi kecil di HP */
@media (max-width: 576px) {
  .table-actions button {
    margin-bottom: 5px;
    width: 100%;
  }
}
</style>
</head>

<body>
<!-- 🌙 SIDEBAR -->
<div class="sidebar" id="sidebar">
  <h4><i class="bi bi-person-circle"></i> <?= $jurusan ?></h4>
  <a href="dashboard.php" class="active"><i class="bi bi-house-door"></i> Dashboard</a>
  <a href="tambah.php"><i class="bi bi-box-seam"></i> Inventaris</a>
  <a href="pengadaan.php"><i class="bi bi-cart"></i> Pengadaan</a>
  <a href="laporan_bulanan.php"><i class="bi bi-file-earmark-text"></i> Laporan</a>
  <a href="../login.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- 🌟 KONTEN -->
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-outline-primary d-lg-none" id="toggleSidebar"><i class="bi bi-list"></i></button>
      <h3 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard <?= $jurusan ?></h3>
    </div>
    <button class="btn btn-light border" id="darkToggle"><i class="bi bi-moon-stars"></i></button>
  </div>

  <!-- 📦 DATA INVENTARIS -->
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <i class="bi bi-box-seam"></i> Data Inventaris Jurusan <?= $jurusan ?>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>No</th><th>Nama Barang</th><th>Merk</th><th>Tanggal</th>
            <th>Sumber Dana</th><th>Jumlah</th><th>Nilai</th>
            <th>Kondisi</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $sql = mysqli_query($koneksi, "SELECT * FROM aset WHERE pengguna_barang='$jurusan' ORDER BY id DESC");
        while($d = mysqli_fetch_assoc($sql)){
          echo "<tr>
            <td>$no</td>
            <td>{$d['nama_barang']}</td>
            <td>{$d['merk']}</td>
            <td>{$d['tanggal']}</td>
            <td>{$d['sumber_dana']}</td>
            <td>{$d['jumlah']}</td>
            <td>Rp ".number_format($d['nilai_perolehan'],0,',','.')."</td>
            <td>
              <span class='badge bg-success'>Baik: {$d['baik']}</span><br>
              <span class='badge bg-warning text-dark'>Kurang: {$d['kurang_baik']}</span><br>
              <span class='badge bg-danger'>Rusak: {$d['rusak']}</span>
            </td>
            <td class='table-actions'>
              <button class='btn btn-sm btn-outline-danger' onclick=\"konfirmasi('rusak', {$d['id']})\"><i class='bi bi-tools'></i> Rusak</button>
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

<script>
// 🌙 Dark Mode
const btn = document.getElementById('darkToggle');
btn.addEventListener('click', () => {
  document.body.classList.toggle('dark');
  btn.innerHTML = document.body.classList.contains('dark') 
    ? '<i class="bi bi-sun"></i>' 
    : '<i class="bi bi-moon-stars"></i>';
});

// 📱 Sidebar Toggle
document.getElementById('toggleSidebar').addEventListener('click', () => {
  document.getElementById('sidebar').classList.toggle('show');
});

// 🧰 Konfirmasi tindakan rusak/hilang
function konfirmasi(aksi, id) {
  let pesan = aksi === 'rusak' 
    ? 'Tandai barang ini sebagai RUSAK?' 
    : 'Tandai barang ini sebagai HILANG?';
  if (confirm(pesan)) {
    window.location = `?aksi=${aksi}&id=${id}`;
  }
}
</script>
</body>
</html>
