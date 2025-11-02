<?php
require '../vendor/autoload.php';
include '../config/config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Cek file & jenis ruang
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
  die("<script>alert('Gagal upload file!'); window.history.back();</script>");
}

$jenis = $_POST['jenis'] ?? '';
switch ($jenis) {
  case 'kantor':
    $tabel = 'ruang_kantor';
    break;
  case 'belajar':
    $tabel = 'ruang_lainnya';
    break;
  case 'penunjang':
    $tabel = 'ruang_penunjang';
    break;
  default:
    die("<script>alert('Jenis ruang tidak valid!'); window.history.back();</script>");
}

$tmpFile = $_FILES['file']['tmp_name'];

try {
  $spreadsheet = IOFactory::load($tmpFile);
  $sheet = $spreadsheet->getActiveSheet();
  $rows = $sheet->toArray();

  // Lewati baris header (mulai baris ke-2)
  for ($i = 1; $i < count($rows); $i++) {
    $jenis_ruangan = $rows[$i][1] ?? '';
    $jumlah        = $rows[$i][2] ?? '';
    $ukuran        = $rows[$i][3] ?? '';
    $kondisi       = $rows[$i][4] ?? '';

    if ($jenis_ruangan != '') {
      $stmt = $koneksi->prepare("INSERT INTO $tabel (jenis_ruangan, jumlah, ukuran, kondisi) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $jenis_ruangan, $jumlah, $ukuran, $kondisi);
      $stmt->execute();
    }
  }

  echo "<script>alert('Import data berhasil!'); window.location.href='data_ruang_lainnya.php';</script>";

} catch (Exception $e) {
  echo "<script>alert('Gagal membaca file Excel: {$e->getMessage()}'); window.history.back();</script>";
}
?>
