<?php
ob_start();
session_start();
include '../config/config.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
  header("location:../login.php");
  exit;
}

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Dompdf\Dompdf;

// ===================================================
// 📤 EXPORT EXCEL
// ===================================================
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
  ob_end_clean(); // bersihkan buffer agar tidak error header
  $q = mysqli_query($koneksi, "SELECT * FROM ruang_teori ORDER BY id ASC");
  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setTitle('Ruang Teori');

  $header = [
    'No','Kondisi','8x9 m²','>73 m²','<73 m²','Jumlah','Baik','Rsk. Ringan',
    'Rsk. Sedang','Rsk. Berat','Rsk. Total','Digunakan','Jumlah Keseluruhan'
  ];
  $col = 'A';
  foreach ($header as $h) {
    $sheet->setCellValue($col . '1', $h);
    $col++;
  }

  $no = 2; $i = 1;
  while ($r = mysqli_fetch_assoc($q)) {
    $rusak_total = $r['rusak_ringan'] + $r['rusak_sedang'] + $r['rusak_berat'];
    $sheet->fromArray([
      $i,
      $r['kondisi'],
      $r['ukuran_8x9'],
      $r['ukuran_lebih73'],
      $r['ukuran_kurang73'],
      $r['jumlah_ruang'],
      $r['baik'],
      $r['rusak_ringan'],
      $r['rusak_sedang'],
      $r['rusak_berat'],
      $rusak_total,
      $r['ruang_digunakan'],
      $r['jumlah_keseluruhan']
    ], null, 'A' . $no);
    $i++; $no++;
  }

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment; filename="Data_Ruang_Teori.xlsx"');
  $writer = new Xlsx($spreadsheet);
  $writer->save('php://output');
  exit;
}

// ===================================================
// 📥 IMPORT EXCEL
// ===================================================
if (isset($_POST['import_excel'])) {
  $file = $_FILES['file_excel']['tmp_name'];
  $ext = pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION);
  $allowed = ['xlsx', 'xls'];

  if ($file && in_array(strtolower($ext), $allowed)) {
    $spreadsheet = IOFactory::load($file);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    $baris = 0;
    foreach ($sheetData as $row) {
      if ($baris++ == 0) continue;

      $kondisi = trim($row['B'] ?? '');
      if ($kondisi == '') continue;

      $a = (int)($row['C'] ?? 0);
      $b = (int)($row['D'] ?? 0);
      $c = (int)($row['E'] ?? 0);
      $d = (int)($row['F'] ?? 0);
      $baik = (int)($row['G'] ?? 0);
      $ringan = (int)($row['H'] ?? 0);
      $sedang = (int)($row['I'] ?? 0);
      $berat = (int)($row['J'] ?? 0);
      $digunakan = (int)($row['L'] ?? 0);
      $f = (int)($row['M'] ?? 0);

      mysqli_query($koneksi, "INSERT INTO ruang_teori 
        (kondisi, ukuran_8x9, ukuran_lebih73, ukuran_kurang73, jumlah_ruang, baik, rusak_ringan, rusak_sedang, rusak_berat, ruang_digunakan, jumlah_keseluruhan) 
        VALUES ('$kondisi','$a','$b','$c','$d','$baik','$ringan','$sedang','$berat','$digunakan','$f')");
    }
    header("Location: ruang_teori.php?import=success");
    exit;
  } else {
    header("Location: ruang_teori.php?import=invalid");
    exit;
  }
}

// ===================================================
// 🧾 CETAK PDF
// ===================================================
if (isset($_GET['cetak']) && $_GET['cetak'] == 'pdf') {
  ob_end_clean();
  $q = mysqli_query($koneksi, "SELECT * FROM ruang_teori ORDER BY id ASC");
  $html = '
  <h3 style="text-align:center;">Data Kondisi & Ukuran Ruang Teori</h3>
  <table border="1" cellspacing="0" cellpadding="5" width="100%">
  <thead><tr style="background:#eee;">
  <th>No</th><th>Kondisi</th><th>8x9 m²</th><th>>73 m²</th><th><73 m²</th>
  <th>Jumlah</th><th>Baik</th><th>Rsk. Ringan</th><th>Rsk. Sedang</th><th>Rsk. Berat</th>
  <th>Rsk. Total</th><th>Digunakan</th><th>Jumlah Keseluruhan</th></tr></thead><tbody>';

  $no = 1;
  while ($r = mysqli_fetch_assoc($q)) {
    $rusak_total = $r['rusak_ringan'] + $r['rusak_sedang'] + $r['rusak_berat'];
    $html .= "<tr>
      <td>$no</td><td>{$r['kondisi']}</td><td>{$r['ukuran_8x9']}</td>
      <td>{$r['ukuran_lebih73']}</td><td>{$r['ukuran_kurang73']}</td>
      <td>{$r['jumlah_ruang']}</td><td>{$r['baik']}</td><td>{$r['rusak_ringan']}</td>
      <td>{$r['rusak_sedang']}</td><td>{$r['rusak_berat']}</td><td>$rusak_total</td>
      <td>{$r['ruang_digunakan']}</td><td>{$r['jumlah_keseluruhan']}</td></tr>";
    $no++;
  }

  $html .= '</tbody></table>';
  $dompdf = new Dompdf();
  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'landscape');
  $dompdf->render();
  $dompdf->stream('Data_Ruang_Teori.pdf', ['Attachment' => true]);
  exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM ruang_teori ORDER BY id ASC");
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Kondisi & Ukuran Ruang Teori</title>
  <link rel="icon" type="image/png" href="assets/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f8f9fa; }
    .table th, .table td { text-align: center; vertical-align: middle; }
    @media print {
      button, .btn, form, .navbar, .card-header { display: none !important; }
      table { font-size: 12px; }
    }
  </style>
</head>
<body>
<div class="container my-4">

  <div class="card shadow mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between flex-wrap align-items-center">
      <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard Admin</a>
      <div class="d-flex flex-wrap gap-2">
        <a href="tambah_ruang_teori.php" class="btn btn-light btn-sm"><i class="bi bi-plus-circle"></i> Tambah Data</a>
        <a href="?export=excel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
        <a href="?cetak=pdf" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> Cetak PDF</a>
        <button onclick="window.print()" class="btn btn-secondary btn-sm"><i class="bi bi-printer"></i> Print</button>
      </div>
    </div>

    <div class="card-body table-responsive">
      <form method="POST" enctype="multipart/form-data" class="mb-3">
        <div class="input-group" style="max-width:400px;">
          <input type="file" name="file_excel" accept=".xlsx,.xls" class="form-control" required>
          <button type="submit" name="import_excel" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i> Import Excel</button>
        </div>
      </form>

      <?php if (isset($_GET['import']) && $_GET['import'] == 'success'): ?>
        <div class="alert alert-success">✅ Data berhasil diimpor!</div>
      <?php elseif (isset($_GET['import']) && $_GET['import'] == 'invalid'): ?>
        <div class="alert alert-danger">❌ Format file tidak valid. Harus .xls atau .xlsx</div>
      <?php endif; ?>

      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kondisi</th>
            <th colspan="4">Jumlah dan Ukuran</th>
            <th colspan="5">Kondisi Ruang</th>
            <th rowspan="2">Digunakan utk Ruang Teori (e)</th>
            <th rowspan="2">Jumlah Keseluruhan (f)</th>
            <th rowspan="2">Aksi</th>
          </tr>
          <tr>
            <th>8x9 m²</th><th>>73 m²</th><th><73 m²</th><th>Jumlah</th>
            <th>Baik</th><th>Ringan</th><th>Sedang</th><th>Berat</th><th>Rsk Total</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no=1; 
        $total = ['a'=>0,'b'=>0,'c'=>0,'d'=>0,'baik'=>0,'ringan'=>0,'sedang'=>0,'berat'=>0,'rusak_total'=>0,'e'=>0,'f'=>0];
        while($r=mysqli_fetch_assoc($q)){
          $rTotal=$r['rusak_ringan']+$r['rusak_sedang']+$r['rusak_berat'];
          echo "<tr>
            <td>$no</td><td>{$r['kondisi']}</td><td>{$r['ukuran_8x9']}</td>
            <td>{$r['ukuran_lebih73']}</td><td>{$r['ukuran_kurang73']}</td>
            <td>{$r['jumlah_ruang']}</td><td>{$r['baik']}</td>
            <td>{$r['rusak_ringan']}</td><td>{$r['rusak_sedang']}</td>
            <td>{$r['rusak_berat']}</td><td>$rTotal</td>
            <td>{$r['ruang_digunakan']}</td><td>{$r['jumlah_keseluruhan']}</td>
            <td>
              <a href='edit_ruang_teori.php?id={$r['id']}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
              <a href='hapus_ruang_teori.php?id={$r['id']}' onclick=\"return confirm('Hapus data ini?');\" class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></a>
            </td>
          </tr>";
          $total['a'] += $r['ukuran_8x9'];
          $total['b'] += $r['ukuran_lebih73'];
          $total['c'] += $r['ukuran_kurang73'];
          $total['d'] += $r['jumlah_ruang'];
          $total['baik'] += $r['baik'];
          $total['ringan'] += $r['rusak_ringan'];
          $total['sedang'] += $r['rusak_sedang'];
          $total['berat'] += $r['rusak_berat'];
          $total['rusak_total'] += $rTotal;
          $total['e'] += $r['ruang_digunakan'];
          $total['f'] += $r['jumlah_keseluruhan'];
          $no++;
        }
        ?>
        </tbody>
        <tfoot class="table-secondary fw-bold">
          <tr>
            <td colspan="2">Total</td>
            <td><?= $total['a'] ?></td><td><?= $total['b'] ?></td><td><?= $total['c'] ?></td><td><?= $total['d'] ?></td>
            <td><?= $total['baik'] ?></td><td><?= $total['ringan'] ?></td><td><?= $total['sedang'] ?></td><td><?= $total['berat'] ?></td>
            <td><?= $total['rusak_total'] ?></td><td><?= $total['e'] ?></td><td><?= $total['f'] ?></td><td>-</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- GRAFIK -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-success text-white"><i class="bi bi-bar-chart"></i> Grafik Kondisi Ruang</div>
        <div class="card-body"><canvas id="grafikRuang"></canvas></div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-info text-white"><i class="bi bi-pie-chart"></i> Diagram Lingkaran</div>
        <div class="card-body"><canvas id="pieRuang"></canvas></div>
      </div>
    </div>
  </div>

</div>

<script>
const dataKondisi={baik:<?= $total['baik']?>,ringan:<?= $total['ringan']?>,sedang:<?= $total['sedang']?>,berat:<?= $total['berat']?>,total:<?= $total['rusak_total']?>};
new Chart(document.getElementById('grafikRuang'),{
  type:'bar',
  data:{labels:['Baik','Rsk. Ringan','Rsk. Sedang','Rsk. Berat','Rsk. Total'],
  datasets:[{label:'Jumlah Ruang',data:[dataKondisi.baik,dataKondisi.ringan,dataKondisi.sedang,dataKondisi.berat,dataKondisi.total]}]},
  options:{responsive:true,scales:{y:{beginAtZero:true}}}});
new Chart(document.getElementById('pieRuang'),{
  type:'pie',
  data:{labels:['Baik','Rsk. Ringan','Rsk. Sedang','Rsk. Berat'],
  datasets:[{data:[dataKondisi.baik,dataKondisi.ringan,dataKondisi.sedang,dataKondisi.berat]}]},
  options:{plugins:{legend:{position:'bottom'},title:{display:true,text:'Persentase Kondisi Ruang Teori'}}}});
</script>
</body>
</html>
