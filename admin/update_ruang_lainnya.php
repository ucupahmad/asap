<?php
include '../config/config.php';
session_start();

$id = $_POST['id'];
$jenis = mysqli_real_escape_string($koneksi, $_POST['jenis_ruangan']);
$jumlah = (int) $_POST['jumlah'];
$ukuran = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
$kondisi = mysqli_real_escape_string($koneksi, $_POST['kondisi']);

$query = "UPDATE ruang_lainnya SET 
          jenis_ruangan='$jenis', jumlah='$jumlah', ukuran='$ukuran', kondisi='$kondisi'
          WHERE id='$id'";
mysqli_query($koneksi, $query);

header("Location: data_ruang_lainnya.php?msg=update_sukses");
exit;
?>
