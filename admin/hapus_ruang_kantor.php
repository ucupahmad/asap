<?php
include '../config/config.php';
session_start();

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM ruang_kantor WHERE id='$id'");
header("Location: data_ruang_lainnya.php?msg=hapus_sukses");
exit;
?>
