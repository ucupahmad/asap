<?php 
include '../config/config.php';


if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Aset Sekolah</title>
  <link rel="icon" type="image/png" href="assets/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f6fa;
    }
    /* SIDEBAR */
    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: linear-gradient(180deg, #0d6efd, #1b4dbd);
      color: #fff;
      padding-top: 20px;
      transition: all 0.3s;
      z-index: 1050;
    }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 8px;
      margin: 5px 10px;
      transition: 0.3s;
    }
    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(255,255,255,0.2);
    }
    .sidebar.collapsed { transform: translateX(-100%); }

    /* MAIN CONTENT */
    .content {
      margin-left: 240px;
      padding: 20px;
      transition: all 0.3s;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .content { margin-left: 0; }
      #toggleSidebar { display: inline-block; }
    }

    .table {
      border-radius: 10px;
      overflow: hidden;
      background: white;
    }
    .btn-sm { border-radius: 8px; }

    /* DARK MODE */
    body.dark-mode { background-color: #1e1e2f; color: #e4e6eb; }
    .dark-mode .table { background-color: #2c2f48; color: #e4e6eb; }
    .dark-mode .sidebar { background: linear-gradient(180deg, #212a4d, #141a30); }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
  <div class="text-center mb-4">
    <h5><i class="bi bi-building"></i> <span>Admin Inventaris</span></h5>
  </div>
  <a href="index.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
  <a href="aset.php" class="active"><i class="bi bi-box-seam"></i> <span>Data Inventaris</span></a>
  <a href="laporan_bulanan.php"><i class="bi bi-bar-chart"></i> <span>Laporan Bulanan</span></a>
  <a href="pengadaan.php"><i class="bi bi-cart-check"></i> <span>Pengadaan</span></a>
  <hr class="text-light">
  <a href="#" id="darkModeToggle"><i class="bi bi-moon"></i> <span>Dark Mode</span></a>
  <a href="../login.php"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
</div>

<!-- MAIN CONTENT -->
<div id="mainContent" class="content">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <div class="d-flex align-items-center gap-2 mb-2">
      <button id="toggleSidebar" class="btn btn-outline-primary d-lg-none"><i class="bi bi-list"></i></button>
      <h3 class="fw-bold text-primary mb-0"><i class="bi bi-box-seam"></i> Data Inventaris Sekolah</h3>
    </div>

    <div class="d-flex flex-wrap gap-2">
      <a href="tambah.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Tambah</a>
      <a href="cetak_laporan.php" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Cetak</a>
      <a href="export_aset.php" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Download Excel</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th><th>Nama Barang</th><th>Merk</th><th>Tanggal</th>
            <th>Sumber Dana</th><th>Satuan</th><th>Jumlah</th><th>Harga</th>
            <th>Nilai</th><th>Tahun</th><th>No Inv</th><th>Pengguna</th>
            <th>Baik</th><th>Kurang Baik</th><th>Rusak</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $sql = mysqli_query($koneksi, "SELECT * FROM aset ORDER BY id DESC");
        while ($d = mysqli_fetch_assoc($sql)) {
          echo "<tr>
            <td>$no</td>
            <td>{$d['nama_barang']}</td>
            <td>{$d['merk']}</td>
            <td>{$d['tanggal']}</td>
            <td>{$d['sumber_dana']}</td>
            <td>{$d['satuan_barang']}</td>
            <td>{$d['jumlah']}</td>
            <td>Rp ".number_format($d['harga_satuan'],0,',','.')."</td>
            <td>Rp ".number_format($d['nilai_perolehan'],0,',','.')."</td>
            <td>{$d['tahun']}</td>
            <td>{$d['no_inv']}</td>
            <td>{$d['pengguna_barang']}</td>
            <td>{$d['baik']}</td>
            <td>{$d['kurang_baik']}</td>
            <td>{$d['rusak']}</td>
            <td class='text-center'>
              <a href='edit.php?id={$d['id']}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i></a>
              <button class='btn btn-danger btn-sm' onclick='hapusData({$d['id']})'><i class='bi bi-trash'></i></button>
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
// Sidebar Toggle (mobile)
const sidebar = document.getElementById('sidebar');
document.getElementById('toggleSidebar').addEventListener('click', () => {
  sidebar.classList.toggle('show');
});

// Dark Mode Toggle
document.getElementById('darkModeToggle').addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
});

// SweetAlert konfirmasi hapus
function hapusData(id) {
  Swal.fire({
    title: 'Hapus Data?',
    text: "Data aset akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'hapus.php?id=' + id;
    }
  });
}
</script>
</body>
</html>
