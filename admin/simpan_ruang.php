<?php 
include '../config/config.php';

$data = [
  ['Baik', $_POST['baik_a'], $_POST['baik_b'], $_POST['baik_c'], $_POST['baik_d'], $_POST['baik_e'], $_POST['baik_f'], $_POST['baik_ket']],
  ['Rusak Ringan', $_POST['rr_a'], $_POST['rr_b'], $_POST['rr_c'], $_POST['rr_d'], $_POST['rr_e'], $_POST['rr_f'], $_POST['rr_ket']],
  ['Rusak Sedang', $_POST['rs_a'], $_POST['rs_b'], $_POST['rs_c'], $_POST['rs_d'], $_POST['rs_e'], $_POST['rs_f'], $_POST['rs_ket']],
  ['Rusak Berat', $_POST['rb_a'], $_POST['rb_b'], $_POST['rb_c'], $_POST['rb_d'], $_POST['rb_e'], $_POST['rb_f'], $_POST['rb_ket']]
];

foreach ($data as $d) {
  mysqli_query($koneksi, "INSERT INTO data_ruang (kondisi, ukuran_8x9, ukuran_lebih73, ukuran_kurang73, jumlah_d, jumlah_e, jumlah_f, keterangan)
  VALUES ('$d[0]', '$d[1]', '$d[2]', '$d[3]', '$d[4]', '$d[5]', '$d[6]', '$d[7]')");
}

echo "<script>alert('Data ruang berhasil disimpan!'); window.location='data_ruang.php';</script>";
?>
