<?php
ob_start(); // 🧹 Bersihkan semua output sebelumnya
require '../vendor/autoload.php';
include '../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Pastikan tidak ada output tambahan dari include
mysqli_report(MYSQLI_REPORT_OFF);

// Ambil data dari tabel pengadaan
$query = mysqli_query($koneksi, "SELECT * FROM pengadaan ORDER BY id DESC");

// Buat spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Pengadaan Barang');

// Header kolom
$headers = ['No', 'Nama Barang', 'Merk / Spesifikasi', 'Tanggal', 'Sumber Dana', 'Jumlah', 'Pengguna Barang', 'Status'];
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
while ($data = mysqli_fetch_assoc($query)) {
  $sheet->setCellValue('A' . $row, $no++);
  $sheet->setCellValue('B' . $row, $data['nama_barang']);
  $sheet->setCellValue('C' . $row, $data['merk']);
  $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($data['tanggal'])));
  $sheet->setCellValue('E' . $row, $data['sumber_dana']);
  $sheet->setCellValue('F' . $row, $data['jumlah']);
  $sheet->setCellValue('G' . $row, $data['pengguna_barang']);
  $sheet->setCellValue('H' . $row, $data['status']);
  $row++;
}

// Siapkan file download
$filename = 'Data_Pengadaan_' . date('Ymd_His') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Hapus output buffer sebelum kirim file
ob_end_clean();

// Kirim file ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
