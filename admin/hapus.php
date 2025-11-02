<?php
include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM aset WHERE id='$id'");
header("location:aset.php");
?>
