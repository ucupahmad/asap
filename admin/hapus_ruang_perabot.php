<?php
include '../config/config.php';

$id = $_GET['id'] ?? 0;
if ($id > 0) {
  $hapus = mysqli_query($koneksi, "DELETE FROM ruang_kelas WHERE id='$id'");
  if ($hapus) {
    echo "<script>alert('Data berhasil dihapus!');window.location='data_ruang_lainnya.php';</script>";
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
} else {
  echo "ID tidak valid!";
}
?>
