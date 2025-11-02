<?php
require '../config/config.php';
require '../vendor/autoload.php'; // jika pakai composer
use Dompdf\Dompdf;

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$query = mysqli_query($koneksi, "SELECT * FROM aset WHERE MONTH(tanggal)='$bulan' AND YEAR(tanggal)='$tahun'");
$html = "
<h3 style='text-align:center'>Laporan Aset Bulan ".date('F', mktime(0,0,0,$bulan,10))." $tahun</h3>
<table border='1' width='100%' cellspacing='0' cellpadding='4'>
<tr style='background:#ccc;'>
<th>No</th><th>Nama Barang</th><th>Merk</th><th>Tanggal</th>
<th>Pengguna Barang</th><th>Jumlah</th><th>Nilai</th>
</tr>";
$no=1; $total=0;
while($d=mysqli_fetch_assoc($query)){
  $html.="<tr>
  <td>$no</td><td>$d[nama_barang]</td><td>$d[merk]</td>
  <td>$d[tanggal]</td><td>$d[pengguna_barang]</td>
  <td>$d[jumlah]</td><td>Rp ".number_format($d['nilai_perolehan'],0,',','.')."</td></tr>";
  $total += $d['nilai_perolehan'];
  $no++;
}
$html.="<tr><td colspan='6' align='right'><b>Total Nilai</b></td><td><b>Rp ".number_format($total,0,',','.')."</b></td></tr>";
$html.="</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_aset_{$bulan}_{$tahun}.pdf");
?>
