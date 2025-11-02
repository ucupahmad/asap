<?php
include '../config/config.php';
if (!isset($_SESSION['level'])) header("location:../login.php");

// Ambil data dari form
$nama_barang     = isset($_POST['nama_barang']) ? trim($_POST['nama_barang']) : '';
$merk            = isset($_POST['merk']) ? trim($_POST['merk']) : '';
$tanggal         = isset($_POST['tanggal']) ? trim($_POST['tanggal']) : date('Y-m-d');
$sumber_dana     = isset($_POST['sumber_dana']) ? trim($_POST['sumber_dana']) : '-';
$satuan_barang   = isset($_POST['satuan_barang']) ? trim($_POST['satuan_barang']) : '-';
$jumlah          = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0;
$harga_satuan    = isset($_POST['harga_satuan']) ? (float)$_POST['harga_satuan'] : 0;
$tahun           = isset($_POST['tahun']) ? (int)$_POST['tahun'] : date('Y');
$pengguna_barang = isset($_POST['pengguna_barang']) ? trim($_POST['pengguna_barang']) : '-';

// Hitung nilai perolehan otomatis
$nilai_perolehan = $jumlah * $harga_satuan;

// Validasi input wajib
if ($nama_barang == '' || $merk == '' || $jumlah <= 0 || $harga_satuan <= 0) {
    echo "<script>alert('⚠️ Harap isi Nama Barang, Merk, Jumlah, dan Harga Satuan dengan benar!');history.back();</script>";
    exit;
}

// Query insert TANPA kolom baik, kurang_baik, rusak
$query = "
INSERT INTO pengadaan 
(nama_barang, merk, tanggal, sumber_dana, satuan_barang, jumlah, harga_satuan, nilai_perolehan, tahun, pengguna_barang, status)
VALUES
('$nama_barang', '$merk', '$tanggal', '$sumber_dana', '$satuan_barang', '$jumlah', '$harga_satuan', '$nilai_perolehan', '$tahun', '$pengguna_barang', 'Diajukan')
";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
        alert('✅ Pengajuan pengadaan berhasil dikirim ke Admin.');
        window.location='pengadaan.php';
    </script>";
} else {
    echo "<script>
        alert('❌ Gagal menyimpan pengajuan: " . addslashes(mysqli_error($koneksi)) . "');
        history.back();
    </script>";
}
?>
