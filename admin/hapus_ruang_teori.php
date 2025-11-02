<?php
include '../config/config.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM ruang_teori WHERE id='$id'");
header("location:ruang_teori.php");
?>
