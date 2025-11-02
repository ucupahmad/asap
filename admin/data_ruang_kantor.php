<?php 
include '../config/config.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Ruang Kantor</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="bi bi-building-gear"></i> Data Ruang Kantor</h5>
    </div>
    <div class="card-body">
      <form method="post" action="simpan_ruang_kantor.php">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>Jenis Ruangan</th>
              <th>Jumlah (buah)</th>
              <th>Ukuran (p x l)</th>
              <th>Kondisi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ruangan = [
              "Hallmeet (Pertemuan)",
              "Kepala Sekolah",
              "Wakil Kepala Sekolah",
              "Guru",
              "Gudang Sapras",
              "Bendahara",
              "Tata Usaha",
              "Ruang Progli TKR",
              "Ruang Progli TSM",
              "Ruang Progli TKJ",
              "Ruang Progli DKV",
              "Ruang Progli DPIB",
              "Ruang Progli BD",
              "Ruang Progli Informatika",
              "Unit Produksi",
              "Lainnya"
            ];
            $no = 1;
            foreach ($ruangan as $r) {
              echo "
              <tr>
                <td>{$no}. {$r}</td>
                <td><input type='number' name='jumlah[]' class='form-control text-center'></td>
                <td><input type='text' name='ukuran[]' class='form-control text-center'></td>
                <td><input type='text' name='kondisi[]' class='form-control text-center'></td>
                <input type='hidden' name='jenis[]' value='{$r}'>
              </tr>";
              $no++;
            }
            ?>
          </tbody>
        </table>

        <div class="text-end mt-3">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Data
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
