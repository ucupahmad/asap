<?php
include '../config/config.php';
if ($_SESSION['level'] != 'admin') header("location:../login.php");

$id = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';

if ($id == '' || ($status != 'Disetujui' && $status != 'Ditolak')) {
    echo "<script>alert('❌ Data tidak valid!'); window.location='pengadaan.php';</script>";
    exit;
}

// Update status
$update = mysqli_query($koneksi, "UPDATE pengadaan SET status='$status' WHERE id='$id'");

if ($update) {
    echo "<script>alert('✅ Status pengadaan berhasil diperbarui menjadi: $status'); window.location='pengadaan.php';</script>";
} else {
    echo "<script>alert('❌ Gagal memperbarui status: " . addslashes(mysqli_error($koneksi)) . "'); history.back();</script>";
}
?>
