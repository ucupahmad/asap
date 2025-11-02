<?php
include '../config/config.php';
if ($_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $query = mysqli_query($koneksi, "DELETE FROM pengadaan WHERE id='$id'");
  if ($query) {
    echo "<script>
      alert('Data pengajuan berhasil dihapus!');
      window.location='pengadaan.php';
    </script>";
  } else {
    echo "<script>
      alert('Gagal menghapus data!');
      window.location='pengadaan.php';
    </script>";
  }
}
?>
