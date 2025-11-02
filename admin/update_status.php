<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $status = $_POST['status'];

  $update = mysqli_query($koneksi, "UPDATE pengadaan SET status='$status' WHERE id='$id'");

  // Jika disetujui → otomatis pindahkan ke tabel aset
  if ($status === 'Disetujui' && $update) {
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pengadaan WHERE id='$id'"));
    mysqli_query($koneksi, "INSERT INTO aset 
      (nama_barang, merk, tanggal, sumber_dana, satuan_barang, jumlah, harga_satuan, nilai_perolehan, tahun, no_inv, pengguna_barang, baik, kurang_baik, rusak) 
      VALUES (
        '{$data['nama_barang']}',
        '{$data['merk']}',
        '{$data['tanggal']}',
        '{$data['sumber_dana']}',
        '{$data['satuan_barang']}',
        '{$data['jumlah']}',
        '{$data['harga_satuan']}',
        '{$data['nilai_perolehan']}',
        '{$data['tahun']}',
        '{$data['no_inv']}',
        '{$data['pengguna_barang']}',
        '{$data['baik']}',
        '{$data['kurang_baik']}',
        '{$data['rusak']}'
      )
    ");
  }

  echo $update ? 'ok' : 'error';
}
?>
