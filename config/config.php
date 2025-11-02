<?php
// Jalankan session hanya jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "db_aset");



// Cek koneksi
if (mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
<?php
// === BACKUP & RESTORE DATABASE ===
$backup_dir = "../backup/"; // folder backup di luar admin
if (!file_exists($backup_dir)) mkdir($backup_dir, 0777, true);

// --- Backup database ---
if (isset($_POST['backup'])) {
  $filename = $backup_dir . "backup_" . date('Y-m-d_H-i-s') . ".sql";
  $command = "mysqldump --user={$admin} --password={$admin123} --host={$db_aset} {$db_aset} > $db_aset";
  system($command, $output);

  if (file_exists($filename)) {
    echo "<script>alert('✅ Backup berhasil! File tersimpan di $filename');</script>";
  } else {
    echo "<script>alert('❌ Gagal membuat backup. Pastikan mysqldump tersedia dan folder backup bisa ditulis.');</script>";
  }
}

// --- Restore database ---
if (isset($_POST['restore'])) {
  if (!empty($_FILES['file_sql']['tmp_name'])) {
    $file_tmp = $_FILES['file_sql']['tmp_name'];
    $sql_content = file_get_contents($file_tmp);
    if (mysqli_multi_query($koneksi, $sql_content)) {
      echo "<script>alert('✅ Database berhasil di-restore!');</script>";
    } else {
      echo "<script>alert('❌ Gagal restore database: " . mysqli_error($koneksi) . "');</script>";
    }
  } else {
    echo "<script>alert('⚠️ Pilih file SQL terlebih dahulu!');</script>";
  }
}
?>

