<?php
include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'setuju') {
  $status = "Disetujui";
} elseif ($aksi == 'tolak') {
  $status = "Ditolak";
} else {
  $status = "Diajukan";
}

mysqli_query($koneksi, "UPDATE pengadaan SET status='$status' WHERE id='$id'");

echo "<script>alert('Status pengadaan berhasil diperbarui menjadi $status');
window.location='pengadaan.php';</script>";
?>
