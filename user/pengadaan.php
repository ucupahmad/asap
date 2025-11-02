<?php
include '../config/config.php';
if (!isset($_SESSION['level'])) header("location:../login.php");
$jurusan = strtoupper($_SESSION['level']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengadaan Barang - <?= $jurusan ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

<div class="container mt-3">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-cart-plus"></i> Form Pengajuan Pengadaan Barang (<?= $jurusan ?>)</h4>
    <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <div class="card p-4 shadow-sm">
    <form action="proses_pengadaan.php" method="POST">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Barang</label>
          <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Merk</label>
          <input type="text" name="merk" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Sumber Dana</label>
          <input type="text" name="sumber_dana" class="form-control">
        </div>

        <div class="col-md-6">
          <label class="form-label">Satuan Barang</label>
          <input type="text" name="satuan_barang" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Jumlah</label>
          <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Harga Satuan</label>
          <input type="number" name="harga_satuan" class="form-control" min="0" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tahun</label>
          <input type="number" name="tahun" class="form-control" min="2000" max="2100" required>
        </div>
      </div>

      <input type="hidden" name="pengguna_barang" value="<?= $jurusan ?>">
      <button type="submit" class="btn btn-primary mt-4 w-100 py-2"><i class="bi bi-send"></i> Ajukan Pengadaan</button>
    </form>
  </div>

 <?php
$level = $_SESSION['level'];
$jurusan = strtoupper($level);

// Statistik
if($level == 'admin'){
    $total_aset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM aset"))['jml'];
    $menunggu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Menunggu'"))['jml'];
    $disetujui = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Disetujui'"))['jml'];
    $ditolak = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Ditolak'"))['jml'];
    $sql = mysqli_query($koneksi, "SELECT * FROM pengadaan ORDER BY status DESC");
} else {
    $total_aset = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM aset WHERE pengguna_barang='$jurusan'"))['jml'];
    $menunggu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE pengguna_barang='$jurusan' AND status='Menunggu'"))['jml'];
    $disetujui = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE pengguna_barang='$jurusan' AND status='Disetujui'"))['jml'];
    $ditolak = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE pengguna_barang='$jurusan' AND status='Ditolak'"))['jml'];
    $sql = mysqli_query($koneksi, "SELECT * FROM pengadaan WHERE pengguna_barang='$jurusan' ORDER BY status DESC");
}
?>

<div class="row mt-5 g-3">
    <div class="col-md-3"><div class="card bg-primary text-white text-center p-3 shadow-sm">Total Aset<br><b><?= $total_aset ?></b></div></div>
    <div class="col-md-3"><div class="card bg-warning text-dark text-center p-3 shadow-sm">Menunggu<br><b><?= $menunggu ?></b></div></div>
    <div class="col-md-3"><div class="card bg-success text-white text-center p-3 shadow-sm">Disetujui<br><b><?= $disetujui ?></b></div></div>
    <div class="col-md-3"><div class="card bg-danger text-white text-center p-3 shadow-sm">Ditolak<br><b><?= $ditolak ?></b></div></div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header bg-dark text-white">Daftar Pengajuan Pengadaan Barang</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th><th>Nama Barang</th><th>Merk</th><th>Tanggal</th>
                    <th>Sumber Dana</th><th>Jumlah</th><th>Nilai</th>
                    <th>Pengguna Barang</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while ($d = mysqli_fetch_assoc($sql)) {
                $warna = ($d['status'] == 'Disetujui') ? 'success' : (($d['status'] == 'Ditolak') ? 'danger' : 'secondary');
                echo "<tr>
                    <td>$no</td>
                    <td>{$d['nama_barang']}</td>
                    <td>{$d['merk']}</td>
                    <td>{$d['tanggal']}</td>
                    <td>{$d['sumber_dana']}</td>
                    <td>{$d['jumlah']}</td>
                    <td>".number_format($d['nilai_perolehan'])."</td>
                    <td>".strtoupper($d['pengguna_barang'])."</td>
                    <td><span class='badge bg-$warna'>{$d['status']}</span></td>
                    <td>";
                
                // Hanya admin yang bisa approve/ditolak
                if($level == 'admin' && $d['status']=='Menunggu'){
                    echo "<button class='btn btn-success btn-sm' onclick=\"approvePengadaan({$d['id']}, 'Disetujui')\">Setujui</button>
                          <button class='btn btn-danger btn-sm' onclick=\"approvePengadaan({$d['id']}, 'Ditolak')\">Tolak</button>";
                } else {
                    echo "-";
                }

                echo "</td></tr>";
                $no++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function approvePengadaan(id, status) {
  Swal.fire({
    title: 'Konfirmasi',
    text: 'Yakin ingin mengubah status menjadi ' + status + '?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('persetujuan_aksi.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id + '&status=' + status
      })
      .then(res => res.text())
      .then(res => {
        Swal.fire('Berhasil', 'Status pengadaan diperbarui!', 'success').then(() => location.reload());
      })
      .catch(() => Swal.fire('Error', 'Gagal memperbarui data', 'error'));
    }
  });
}
</script>

</body>
</html>
