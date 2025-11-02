<?php include '../config/config.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Ruang Kelas</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f7fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 30px auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-weight: 600;
      color: #333;
    }

    input[type="text"], input[type="number"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      font-size: 15px;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #3498db;
      outline: none;
    }

    .group {
      background: #f9fafc;
      border-radius: 10px;
      padding: 15px;
      box-shadow: inset 0 0 4px rgba(0,0,0,0.05);
    }

    .group h4 {
      color: #2c3e50;
      margin-top: 0;
      margin-bottom: 10px;
      font-size: 17px;
    }

    .flex-input {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .flex-input input {
      flex: 1;
      min-width: 120px;
    }

    button {
      background-color: #3498db;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      padding: 12px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #2980b9;
    }

    @media (max-width: 600px) {
      .container {
        padding: 15px;
      }
      h2 {
        font-size: 20px;
      }
      .flex-input input {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Tambah Data Ruang Kelas</h2>
    <form method="post">
      <div>
        <label>Nama Ruang:</label>
        <input type="text" name="nama_ruang" required>
      </div>

      <div>
        <label>Jumlah Ruang:</label>
        <input type="number" name="jumlah_ruang" required>
      </div>

      <div class="group">
        <h4>Meja Siswa</h4>
        <div class="flex-input">
          <input type="number" name="meja_jumlah" placeholder="Jumlah">
          <input type="number" name="meja_baik" placeholder="Baik">
          <input type="number" name="meja_rusak_ringan" placeholder="Rusak Ringan">
          <input type="number" name="meja_rusak_berat" placeholder="Rusak Berat">
        </div>
      </div>

      <div class="group">
        <h4>Kursi Siswa</h4>
        <div class="flex-input">
          <input type="number" name="kursi_jumlah" placeholder="Jumlah">
          <input type="number" name="kursi_baik" placeholder="Baik">
          <input type="number" name="kursi_rusak_ringan" placeholder="Rusak Ringan">
          <input type="number" name="kursi_rusak_berat" placeholder="Rusak Berat">
        </div>
      </div>

      <div class="group">
        <h4>Almari + Rak Buku</h4>
        <div class="flex-input">
          <input type="number" name="almari_jumlah" placeholder="Jumlah">
          <input type="number" name="almari_baik" placeholder="Baik">
          <input type="number" name="almari_rusak_ringan" placeholder="Rusak Ringan">
          <input type="number" name="almari_rusak_berat" placeholder="Rusak Berat">
        </div>
      </div>

      <div class="group">
        <h4>Papan Tulis</h4>
        <div class="flex-input">
          <input type="number" name="papan_jumlah" placeholder="Jumlah">
          <input type="number" name="papan_baik" placeholder="Baik">
          <input type="number" name="papan_rusak_ringan" placeholder="Rusak Ringan">
          <input type="number" name="papan_rusak_berat" placeholder="Rusak Berat">
        </div>
      </div>

      <button type="submit" name="simpan">💾 Simpan</button>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
      $fields = array_map(fn($k) => mysqli_real_escape_string($koneksi, $_POST[$k] ?? ''), array_keys($_POST));
      extract($fields);

      $sql = "INSERT INTO ruang_kelas_perabot 
      (nama_ruang, jumlah_ruang, meja_jumlah, meja_baik, meja_rusak_ringan, meja_rusak_berat,
      kursi_jumlah, kursi_baik, kursi_rusak_ringan, kursi_rusak_berat,
      almari_jumlah, almari_baik, almari_rusak_ringan, almari_rusak_berat,
      papan_jumlah, papan_baik, papan_rusak_ringan, papan_rusak_berat)
      VALUES ('$nama_ruang','$jumlah_ruang','$meja_jumlah','$meja_baik','$meja_rusak_ringan','$meja_rusak_berat',
      '$kursi_jumlah','$kursi_baik','$kursi_rusak_ringan','$kursi_rusak_berat',
      '$almari_jumlah','$almari_baik','$almari_rusak_ringan','$almari_rusak_berat',
      '$papan_jumlah','$papan_baik','$papan_rusak_ringan','$papan_rusak_berat')";

      if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil disimpan!');window.location='ruang_kelas_perabot.php';</script>";
      } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($koneksi) . "</p>";
      }
    }
    ?>
  </div>
</body>
</html>
