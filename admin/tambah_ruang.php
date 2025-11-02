<?php
include '../config/config.php';
if (!isset($_SESSION['level'])) header("location:../login.php");
$jurusan = strtoupper($_SESSION['level']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Data Ruang - <?= $jurusan ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
  <h4 class="mb-3"><i class="bi bi-building"></i> Tambah Data Ruang - <?= $jurusan ?></h4>
  <form method="post">
    <table class="table table-bordered align-middle">
      <thead class="table-primary text-center">
        <tr>
          <th>Kondisi</th>
          <th>Ukuran 8x9 m²</th>
          <th>Ukuran >73 m²</th>
          <th>Ukuran <73 m²</th>
          <th>Jumlah (d)</th>
          <th>Digunakan utk Ruang Teori (e)</th>
          <th>Jumlah Total (f = d + e)</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $kondisi = ['Baik','Rusak Ringan','Rusak Sedang','Rusak Berat'];
        foreach($kondisi as $k){
          echo "<tr>
            <td>$k<input type='hidden' name='kondisi[]' value='$k'></td>
            <td><input type='number' name='a[]' class='form-control' value='0'></td>
            <td><input type='number' name='b[]' class='form-control' value='0'></td>
            <td><input type='number' name='c[]' class='form-control' value='0'></td>
            <td><input type='number' name='d[]' class='form-control' value='0'></td>
            <td><input type='number' name='e[]' class='form-control' value='0'></td>
            <td><input type='number' name='f[]' class='form-control' value='0'></td>
            <td><input type='text' name='ket[]' class='form-control'></td>
          </tr>";
        }
        ?>
      </tbody>
    </table>
    <button name="simpan" class="btn btn-primary w-100">💾 Simpan Data Ruang</button>
  </form>
</div>

<?php
if(isset($_POST['simpan'])){
  $kondisi = $_POST['kondisi'];
  for($i=0; $i<count($kondisi); $i++){
    $a = $_POST['a'][$i];
    $b = $_POST['b'][$i];
    $c = $_POST['c'][$i];
    $d = $_POST['d'][$i];
    $e = $_POST['e'][$i];
    $f = $_POST['f'][$i];
    $ket = $_POST['ket'][$i];
    mysqli_query($koneksi, "INSERT INTO ruang
      (kondisi, ukuran_8x9, ukuran_lebih73, ukuran_kurang73, jumlah_d, jumlah_e, jumlah_f, keterangan, pengguna_barang)
      VALUES
      ('$kondisi[$i]','$a','$b','$c','$d','$e','$f','$ket','$jurusan')");
  }
  echo "<script>alert('✅ Data ruang berhasil disimpan!');window.location='data_ruang.php';</script>";
}
?>
</body>
</html>
