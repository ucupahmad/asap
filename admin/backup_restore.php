<?php
include 'config/config.php';
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:login.php");
  exit;
}

$backup_dir = "backup/"; // Folder tempat file backup disimpan
if (!file_exists($backup_dir)) mkdir($backup_dir, 0777, true);

// ===============================
// 🔹 Proses Backup Database
// ===============================
if (isset($_POST['backup'])) {
  $filename = $backup_dir . "backup_" . date('Y-m-d_H-i-s') . ".sql";
  $command = "mysqldump --user={$dbuser} --password={$dbpass} --host={$dbhost} {$dbname} > $filename";

  system($command, $output);

  if (file_exists($filename)) {
    echo "<script>alert('Backup berhasil disimpan di: $filename');</script>";
  } else {
    echo "<script>alert('Gagal membuat backup! Pastikan mysqldump tersedia dan folder backup bisa ditulis.');</script>";
  }
}

// ===============================
// 🔹 Proses Upload / Restore Database
// ===============================
if (isset($_POST['restore'])) {
  $file_tmp = $_FILES['file_sql']['tmp_name'];
  if (is_uploaded_file($file_tmp)) {
    $sql_content = file_get_contents($file_tmp);
    $multi_query = mysqli_multi_query($koneksi, $sql_content);

    if ($multi_query) {
      echo "<script>alert('Database berhasil di-restore.');</script>";
    } else {
      echo "<script>alert('Gagal restore database: " . mysqli_error($koneksi) . "');</script>";
    }
  } else {
    echo "<script>alert('Pilih file SQL terlebih dahulu!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Backup & Restore Database</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
  <h2 class="mb-4">🔐 Backup & Restore Database</h2>

  <div class="card mb-3">
    <div class="card-body">
      <h5>Backup Database</h5>
      <form method="post">
        <button type="submit" name="backup" class="btn btn-primary">💾 Backup Sekarang</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5>Upload / Restore Database</h5>
      <form method="post" enctype="multipart/form-data">
        <input type="file" name="file_sql" accept=".sql" class="form-control mb-3" required>
        <button type="submit" name="restore" class="btn btn-success">📤 Upload & Restore</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
