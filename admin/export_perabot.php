<?php
ob_start(); // 🔧 Pastikan tidak ada output sebelum header()
require '../vendor/autoload.php';
include '../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// 🔹 Ambil data dari database
$query = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");

// 🔹 Buat Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Perabot Kelas');

// 🔹 Header kolom
$headers = [
  'Nama Ruang', 'Jumlah Ruang',
  'Meja Jml', 'Meja Baik', 'Meja Ringan', 'Meja Berat',
  'Kursi Jml', 'Kursi Baik', 'Kursi Ringan', 'Kursi Berat',
  'Almari Jml', 'Almari Baik', 'Almari Ringan', 'Almari Berat',
  'Papan Jml', 'Papan Baik', 'Papan Ringan', 'Papan Berat'
];
$col = 'A';
foreach ($headers as $header) {
  $sheet->setCellValue($col . '1', $header);
  $sheet->getStyle($col . '1')->getFont()->setBold(true);
  $sheet->getColumnDimension($col)->setAutoSize(true);
  $col++;
}

// 🔹 Isi data dari database
$row = 2;
while ($data = mysqli_fetch_assoc($query)) {
  $sheet->setCellValue('A' . $row, $data['nama_ruang']);
  $sheet->setCellValue('B' . $row, $data['jumlah_ruang']);
  $sheet->setCellValue('C' . $row, $data['meja_jml']);
  $sheet->setCellValue('D' . $row, $data['meja_baik']);
  $sheet->setCellValue('E' . $row, $data['meja_ringan']);
  $sheet->setCellValue('F' . $row, $data['meja_berat']);
  $sheet->setCellValue('G' . $row, $data['kursi_jml']);
  $sheet->setCellValue('H' . $row, $data['kursi_baik']);
  $sheet->setCellValue('I' . $row, $data['kursi_ringan']);
  $sheet->setCellValue('J' . $row, $data['kursi_berat']);
  $sheet->setCellValue('K' . $row, $data['almari_jml']);
  $sheet->setCellValue('L' . $row, $data['almari_baik']);
  $sheet->setCellValue('M' . $row, $data['almari_ringan']);
  $sheet->setCellValue('N' . $row, $data['almari_berat']);
  $sheet->setCellValue('O' . $row, $data['papan_jml']);
  $sheet->setCellValue('P' . $row, $data['papan_baik']);
  $sheet->setCellValue('Q' . $row, $data['papan_ringan']);
  $sheet->setCellValue('R' . $row, $data['papan_berat']);
  $row++;
}

// 🔹 Bersihkan buffer sebelum output
ob_end_clean();

// 🔹 Siapkan header file Excel
$filename = 'Data_Perabot_Kelas_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// 🔹 Tulis dan kirim file ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
