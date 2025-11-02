<?php
include '../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['level'] != 'admin') {
    header("location:../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Persetujuan Pengadaan Barang</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <h2>📦 Persetujuan Pengadaan Barang</h2>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Merk</th>
        <th>Tanggal</th>
        <th>Sumber Dana</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Nilai Perolehan</th>
        <th>Pengaju</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>

      <?php
      $no = 1;
      $result = mysqli_query($koneksi, "SELECT * FROM pengadaan ORDER BY id_pengadaan DESC");
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
              <td>$no</td>
              <td>{$row['nama_barang']}</td>
              <td>{$row['merk']}</td>
              <td>{$row['tanggal']}</td>
              <td>{$row['sumber_dana']}</td>
              <td>{$row['jumlah']}</td>
              <td>{$row['harga_satuan']}</td>
              <td>{$row['nilai_perolehan']}</td>
              <td>{$row['user_pengaju']}</td>
              <td><b>{$row['status_pengadaan']}</b></td>
              <td>";
          if ($row['status_pengadaan'] == 'Menunggu') {
              echo "
              <a href='persetujuan_aksi.php?id={$row['id_pengadaan']}&aksi=setuju' class='btn btn-success btn-sm'>Setujui</a>
              <a href='persetujuan_aksi.php?id={$row['id_pengadaan']}&aksi=tolak' class='btn btn-danger btn-sm'>Tolak</a>";
          } else {
              echo "-";
          }
          echo "</td></tr>";
          $no++;
      }
      ?>
    </table>
  </div>
</body>
</html>
