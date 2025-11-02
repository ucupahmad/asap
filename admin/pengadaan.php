<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Update status pengadaan (jika tombol ditekan)
if (isset($_POST['tetapkan'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];
  mysqli_query($koneksi, "UPDATE pengadaan SET status='$status' WHERE id='$id'");
  header("Location: pengadaan.php?success=1");
  exit;
}

// Ambil data pengadaan
$data = mysqli_query($koneksi, "SELECT * FROM pengadaan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Pengadaan Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9fafb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
      margin-top: 40px;
      margin-bottom: 40px;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .table thead th {
      background-color: #007bff;
      color: white;
    }
    .btn-download {
      background-color: #198754;
      color: white;
      border-radius: 10px;
    }
    .btn-download:hover {
      background-color: #157347;
    }
    @media (max-width: 576px) {
      .table {
        font-size: 12px;
      }
      .btn-download {
        width: 100%;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="card p-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
      <h4 class="mb-3 mb-md-0 text-center text-md-start">📦 Data Pengadaan Barang</h4>
      <a href="download_pengadaan.php" class="btn btn-download">
        ⬇️ Download Excel
      </a>
	  <a href="index.php" class="btn btn-download">
        kembali
      </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ Status berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Merk / Spesifikasi</th>
            <th>Tanggal</th>
            <th>Sumber Dana</th>
            <th>Jumlah</th>
            <th>Pengguna Barang</th>
            <th>Status</th>
            <th>Aksi Tetapkan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          while ($d = mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama_barang']) ?></td>
            <td><?= htmlspecialchars($d['merk']) ?></td>
            <td><?= date('d-m-Y', strtotime($d['tanggal'])) ?></td>
            <td><?= htmlspecialchars($d['sumber_dana']) ?></td>
            <td><?= $d['jumlah'] ?></td>
            <td><?= htmlspecialchars($d['pengguna_barang']) ?></td>
            <td>
              <?php
              $badge = 'secondary';
              if ($d['status'] == 'Menunggu') $badge = 'warning';
              elseif ($d['status'] == 'Disetujui') $badge = 'success';
              elseif ($d['status'] == 'Ditolak') $badge = 'danger';
              ?>
              <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($d['status']) ?></span>
            </td>
            <td>
              <form method="POST" class="d-flex justify-content-center gap-1">
                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                <select name="status" class="form-select form-select-sm w-auto">
                  <option <?= $d['status']=='Menunggu'?'selected':'' ?>>Menunggu</option>
                  <option <?= $d['status']=='Disetujui'?'selected':'' ?>>Disetujui</option>
                  <option <?= $d['status']=='Ditolak'?'selected':'' ?>>Ditolak</option>
                  <option <?= $d['status']=='Selesai'?'selected':'' ?>>Selesai</option>
                </select>
                <button type="submit" name="tetapkan" class="btn btn-sm btn-primary">Tetapkan</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
