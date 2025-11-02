<?php
include '../config/config.php';
session_start();

$jenis = mysqli_real_escape_string($koneksi, $_POST['jenis_ruangan']);
$jumlah = (int) $_POST['jumlah'];
$ukuran = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
$kondisi = mysqli_real_escape_string($koneksi, $_POST['kondisi']);

$query = "INSERT INTO ruang_penunjang (jenis_ruangan, jumlah, ukuran, kondisi)
          VALUES ('$jenis', '$jumlah', '$ukuran', '$kondisi')";
mysqli_query($koneksi, $query);

header("Location: data_ruang_lainnya.php?msg=tambah_sukses");
exit;
?>
