<?php
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// 🧩 Tambahkan autoload PhpSpreadsheet
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
  $target_file = $_FILES['file']['tmp_name'];

  try {
    // Baca file Excel
    $spreadsheet = IOFactory::load($target_file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Lewati header baris pertama
    $first = true;
    foreach ($rows as $data) {
      if ($first) {
        $first = false;
        continue;
      }

      // Cegah error jika kolom kosong
      if (empty($data[1])) continue;

      $nama = mysqli_real_escape_string($koneksi, $data[1]);
      $jumlah = (int)$data[2];
      $sql = "INSERT INTO ruang_kelas_perabot VALUES(
        NULL, '$nama', '$jumlah',
        '{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}',
        '{$data[7]}','{$data[8]}','{$data[9]}','{$data[10]}',
        '{$data[11]}','{$data[12]}','{$data[13]}','{$data[14]}',
        '{$data[15]}','{$data[16]}','{$data[17]}','{$data[18]}'
      )";
      mysqli_query($koneksi, $sql);
    }

    echo "<script>alert('✅ Import Excel berhasil!');window.location='ruang_kelas_perabot.php';</script>";
  } catch (Exception $e) {
    echo "<script>alert('❌ Gagal membaca file Excel: {$e->getMessage()}');history.back();</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Import Excel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">📥 Import Data Ruang Kelas Perabot (Excel)</h5>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Pilih File Excel (.xls / .xlsx)</label>
          <input type="file" name="file" accept=".xls,.xlsx" class="form-control" required>
        </div>
        <button type="submit" name="import" class="btn btn-success">Import Sekarang</button>
        <a href="ruang_kelas_perabot.php" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
