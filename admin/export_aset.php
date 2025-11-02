<?php
ob_start(); // 🧹 Hentikan semua output yang tidak diinginkan

require '../vendor/autoload.php';
include '../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

// Nonaktifkan error notice agar tidak merusak file
error_reporting(0);

// Ambil data aset
$query = mysqli_query($koneksi, "SELECT * FROM aset ORDER BY id DESC");

// Buat spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Aset Sekolah');

// Header kolom
$headers = [
  'No', 'Nama Barang', 'Merk', 'Tanggal', 'Sumber Dana',
  'Satuan', 'Jumlah', 'Harga Satuan', 'Nilai Perolehan',
  'Tahun', 'No Inventaris', 'Pengguna', 'Baik', 'Kurang Baik', 'Rusak'
];

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
  $sheet->setCellValue('B' . $row, $d['nama_barang']);
  $sheet->setCellValue('C' . $row, $d['merk']);
  $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($d['tanggal'])));
  $sheet->setCellValue('E' . $row, $d['sumber_dana']);
  $sheet->setCellValue('F' . $row, $d['satuan_barang']);
  $sheet->setCellValue('G' . $row, $d['jumlah']);
  $sheet->setCellValue('H' . $row, $d['harga_satuan']);
  $sheet->setCellValue('I' . $row, $d['nilai_perolehan']);
  $sheet->setCellValue('J' . $row, $d['tahun']);
  $sheet->setCellValue('K' . $row, $d['no_inv']);
  $sheet->setCellValue('L' . $row, $d['pengguna_barang']);
  $sheet->setCellValue('M' . $row, $d['baik']);
  $sheet->setCellValue('N' . $row, $d['kurang_baik']);
  $sheet->setCellValue('O' . $row, $d['rusak']);
  $row++;
}

// Siapkan file download
$filename = 'Data_Aset_' . date('Ymd_His') . '.xlsx';

// Hapus semua output buffer
ob_end_clean();

// Kirim header file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Simpan ke output (browser)
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
