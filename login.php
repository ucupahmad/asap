<?php
include 'config/config.php'; // ini mungkin sudah jalankan session_start()


// Hapus baris session_start() di sini
// Cukup tambahkan konfigurasi cookie jika session belum aktif

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 1,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// 🧾 Fungsi mencatat log login
function catatLog($koneksi, $username, $ip, $agent, $status) {
    $stmt = $koneksi->prepare("INSERT INTO login_log (username, ip_address, user_agent, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $ip, $agent, $status);
    $stmt->execute();
}

// 🔒 Konfigurasi keamanan login
$MAX_ATTEMPTS = 5;     // maksimal percobaan
$LOCKOUT_TIME = 10;   // 15 menit

$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$agent = $_SERVER['HTTP_USER_AGENT'] ?? '-';

// Cek apakah IP diblok
$cek = $koneksi->prepare("SELECT attempts, last_attempt, locked_until FROM login_attempts WHERE ip_address = ?");
$cek->bind_param("s", $ip);
$cek->execute();
$hasil = $cek->get_result()->fetch_assoc();

if ($hasil && $hasil['locked_until'] && strtotime($hasil['locked_until']) > time()) {
    $sisa = strtotime($hasil['locked_until']) - time();
    die("<center style='font-family: Poppins, sans-serif; margin-top:100px;'>
    <h2>🚫 IP Anda diblok sementara</h2>
    <p>Silakan coba lagi dalam <b>" . ceil($sisa/60) . " menit</b>.</p></center>");
}

// 🧩 Jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username == '' || $password == '') {
        echo "<script>alert('Masukkan username dan password!');</script>";
    } else {
        $stmt = $koneksi->prepare("SELECT id, password, level FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        $login_berhasil = false;
        if ($data = $res->fetch_assoc()) {
            if (password_verify($password, $data['password'])) {
                $login_berhasil = true;
                session_regenerate_id(true);
                $_SESSION['id_user'] = $data['id'];
                $_SESSION['username'] = $username;
                $_SESSION['level'] = $data['level'];

                // Reset percobaan gagal
                $hapus = $koneksi->prepare("DELETE FROM login_attempts WHERE ip_address = ?");
                $hapus->bind_param("s", $ip);
                $hapus->execute();

                catatLog($koneksi, $username, $ip, $agent, 'BERHASIL');
                header("Location: admin/index.php");
                exit;
            }
        }

        // ❌ Gagal login
        catatLog($koneksi, $username, $ip, $agent, 'GAGAL');

        if ($hasil) {
            $attempts = $hasil['attempts'] + 1;
            $lock = null;
            if ($attempts >= $MAX_ATTEMPTS) {
                $lock = date('Y-m-d H:i:s', time() + $LOCKOUT_TIME);
                echo "<script>alert('Terlalu banyak percobaan gagal! IP diblok selama 15 menit.');</script>";
            } else {
                echo "<script>alert('Login gagal! Percobaan ke-$attempts dari $MAX_ATTEMPTS');</script>";
            }
            $upd = $koneksi->prepare("UPDATE login_attempts SET attempts=?, last_attempt=NOW(), locked_until=? WHERE ip_address=?");
            $upd->bind_param("iss", $attempts, $lock, $ip);
            $upd->execute();
        } else {
            $ins = $koneksi->prepare("INSERT INTO login_attempts (ip_address, attempts, last_attempt) VALUES (?, 1, NOW())");
            $ins->bind_param("s", $ip);
            $ins->execute();
            echo "<script>alert('Username atau password salah!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Aset Sekolah</title>
  <link rel="icon" type="image/png" href="assets/img/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  body {
    height: 100vh;
    margin: 0;
    background: linear-gradient(135deg, #007bff, #6610f2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
  }

  .card-login {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    color: white;
    width: 100%;
    max-width: 400px;
    padding: 40px 35px;
    animation: fadeIn 0.6s ease-in-out;
  }

  .card-login h4 {
    text-align: center;
    font-weight: 600;
    margin-bottom: 10px;
    color: #fff;
  }

  .logo {
    width: 90px;
    height: 90px;
    object-fit: contain;
    border-radius: 50%;
    background: white;
    padding: 5px;
    margin-bottom: 10px;
  }

  .form-control {
    border-radius: 10px;
    border: none;
    background: rgba(255, 255, 255, 0.25);
    color: white;
  }

  .form-control::placeholder {
    color: rgba(255, 255, 255, 0.8);
  }

  .btn-login {
    background-color: #00b4d8;
    border: none;
    color: white;
    border-radius: 10px;
    width: 100%;
    padding: 12px;
    font-weight: 600;
    transition: 0.3s;
  }

  .btn-login:hover {
    background-color: #0096c7;
    transform: scale(1.02);
  }

  .footer {
    text-align: center;
    margin-top: 15px;
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .alert {
    border-radius: 10px;
    font-weight: 500;
  }
</style>
</head>
<body>

<div class="card-login text-center">
  <!-- ✅ Logo Sekolah -->
  <img src="assets/img/logo.png" alt="Logo Sekolah" class="logo">

  <h4>Login</h4>
  <h4>SMK DARUT TAQWA</h4>

  <form method="post">
    <div class="mb-3 text-start">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
    </div>
    <div class="mb-3 text-start">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
    </div>
    <button name="login" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Login</button>
  </form>

  <?php
  if (isset($_POST['login'])) {
      $u = $_POST['username'];
      $p = $_POST['password'];
      $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$u' AND password='$p'");
      $data = mysqli_fetch_array($sql);

      if ($data) {
          $_SESSION['username'] = $data['username'];
          $_SESSION['level'] = $data['level'];
          if ($data['level'] == 'admin') {
              header("location:admin/index.php");
              exit;
          } else {
              header("location:user/dashboard.php");
              exit;
          }
      } else {
          echo "<div class='alert alert-danger mt-3 text-center'>❌ Login gagal! Username atau password salah.</div>";
      }
  }
  ?>

  <div class="footer">
    © <?= date('Y') ?> Aplikasi Aset Sekolah
  </div>
</div>

</body>
</html>

