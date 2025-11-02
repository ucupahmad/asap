<?php
include '../config/config.php';
header('Content-Type: application/json');

// Hitung jumlah pengadaan menunggu
$q = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM pengadaan WHERE status='Menunggu'");
$d = mysqli_fetch_assoc($q);

// Kirim hasil dalam format JSON
echo json_encode(['jumlah' => $d['jml']]);
?>
