<?php
include '../config/config.php';

// Pastikan Dompdf sudah tersedia di vendor atau folder dompdf
if (file_exists('../vendor/autoload.php')) {
    require_once '../vendor/autoload.php';
} elseif (file_exists('../config/dompdf/autoload.inc.php')) {
    require_once '../config/dompdf/autoload.inc.php';
} else {
    die('❌ Dompdf tidak ditemukan! Pastikan sudah diinstal atau file autoload tersedia.');
}

use Dompdf\Dompdf;

// Ambil data dari database
$q = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");

// Buat HTML untuk PDF
$html = '
<h3 style="text-align:center;">DATA RUANG KELAS DAN PERABOT</h3>
<table border="1" cellspacing="0" cellpadding="4" width="100%">
<tr style="background-color:#f2f2f2; text-align:center; font-weight:bold;">
<th>No</th>
<th>Nama Ruang</th>
<th>Jumlah Ruang</th>
<th>Meja (Jml/Baik/Rsk Rng/Rsk Brt)</th>
<th>Kursi (Jml/Baik/Rsk Rng/Rsk Brt)</th>
<th>Almari (Jml/Baik/Rsk Rng/Rsk Brt)</th>
<th>Papan (Jml/Baik/Rsk Rng/Rsk Brt)</th>
</tr>';

$no = 1;
while ($r = mysqli_fetch_assoc($q)) {
    $html .= "
    <tr>
        <td style='text-align:center;'>$no</td>
        <td>{$r['nama_ruang']}</td>
        <td style='text-align:center;'>{$r['jumlah_ruang']}</td>
        <td style='text-align:center;'>{$r['meja_jml']} / {$r['meja_baik']} / {$r['meja_ringan']} / {$r['meja_berat']}</td>
        <td style='text-align:center;'>{$r['kursi_jml']} / {$r['kursi_baik']} / {$r['kursi_ringan']} / {$r['kursi_berat']}</td>
        <td style='text-align:center;'>{$r['almari_jml']} / {$r['almari_baik']} / {$r['almari_ringan']} / {$r['almari_berat']}</td>
        <td style='text-align:center;'>{$r['papan_jml']} / {$r['papan_baik']} / {$r['papan_ringan']} / {$r['papan_berat']}</td>
    </tr>";
    $no++;
}

$html .= '</table>';

// Konversi ke PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Unduh otomatis
$dompdf->stream("data_ruang_kelas_perabot.pdf", ["Attachment" => true]);
exit;
?>
