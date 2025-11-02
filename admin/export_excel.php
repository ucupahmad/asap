<?php
include '../config/config.php';

// Pastikan tidak ada output sebelum header
ob_start();

// Set header agar Excel langsung terdeteksi
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=data_ruang_kelas_perabot.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1' cellspacing='0' cellpadding='5'>";
echo "<tr style='background-color:#dce6f1; font-weight:bold; text-align:center;'>
<th>No</th>
<th>Nama Ruang</th>
<th>Jumlah Ruang</th>

<th>Meja Jml</th><th>Meja Baik</th><th>Meja Rsk Rng</th><th>Meja Rsk Brt</th>
<th>Kursi Jml</th><th>Kursi Baik</th><th>Kursi Rsk Rng</th><th>Kursi Rsk Brt</th>
<th>Almari Jml</th><th>Almari Baik</th><th>Almari Rsk Rng</th><th>Almari Rsk Brt</th>
<th>Papan Jml</th><th>Papan Baik</th><th>Papan Rsk Rng</th><th>Papan Rsk Brt</th>
</tr>";

$q = mysqli_query($koneksi, "SELECT * FROM ruang_kelas_perabot ORDER BY id ASC");
$no = 1;
while ($r = mysqli_fetch_assoc($q)) {
    echo "<tr>
    <td align='center'>$no</td>
    <td>{$r['nama_ruang']}</td>
    <td align='center'>{$r['jumlah_ruang']}</td>

    <td align='center'>{$r['meja_jml']}</td>
    <td align='center'>{$r['meja_baik']}</td>
    <td align='center'>{$r['meja_ringan']}</td>
    <td align='center'>{$r['meja_berat']}</td>

    <td align='center'>{$r['kursi_jml']}</td>
    <td align='center'>{$r['kursi_baik']}</td>
    <td align='center'>{$r['kursi_ringan']}</td>
    <td align='center'>{$r['kursi_berat']}</td>

    <td align='center'>{$r['almari_jml']}</td>
    <td align='center'>{$r['almari_baik']}</td>
    <td align='center'>{$r['almari_ringan']}</td>
    <td align='center'>{$r['almari_berat']}</td>

    <td align='center'>{$r['papan_jml']}</td>
    <td align='center'>{$r['papan_baik']}</td>
    <td align='center'>{$r['papan_ringan']}</td>
    <td align='center'>{$r['papan_berat']}</td>
    </tr>";
    $no++;
}
echo "</table>";

// Bersihkan output buffer
ob_end_flush();
?>
