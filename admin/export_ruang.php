<?php
ob_start(); // Hindari output HTML yang merusak file Excel
require '../vendor/autoload.php';
include '../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Tentukan jenis ruang yang diminta
$jenis = $_GET['jenis'] ?? '';
switch ($jenis) {
  case 'kantor':
    $judul = 'Ruang Kantor';
    $tabel = 'ruang_kantor';
    break;
  case 'belajar':
    $judul = 'Ruang Belajar';
    $tabel = 'ruang_lainnya';
    break;
  case 'penunjang':
    $judul = 'Ruang Penunjang';
    $tabel = 'ruang_penunjang';
    break;
  default:
    die('Jenis ruang tidak valid');
}

// Ambil data dari tabel
$query = mysqli_query($koneksi, "SELECT * FROM $tabel ORDER BY id ASC");

// Buat spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle($judul);

// Header kolom
$headers = ['No', 'Jenis Ruangan', 'Jumlah', 'Ukuran', 'Kondisi'];
$col = 'A';
foreach ($headers as $header) {
  $sheet->setCellValue($col . '1', $header);
  $sheet->getStyle($col . '1')->getFont()->setBold(true);
  $sheet->getColumnDimension($col)->setAutoSize(true);
  $col++;
}

// Isi data
$row = 2;
$no = 1;
while ($d = mysqli_fetch_assoc($query)) {
  $sheet->setCellValue('A' . $row, $no++);
  $sheet->setCellValue('B' . $row, $d['jenis_ruangan']);
  $sheet->setCellValue('C' . $row, $d['jumlah']);
  $sheet->setCellValue('D' . $row, $d['ukuran']);
  $sheet->setCellValue('E' . $row, $d['kondisi']);
  $row++;
}

// Siapkan file Excel
$filename = $judul . '_' . date('Ymd_His') . '.xlsx';

// Hapus buffer dan kirim ke browser
ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Tulis ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
