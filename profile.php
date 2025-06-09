<?php
session_start();

// 1. Keamanan: Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 2. Sertakan file koneksi dan ambil data pengguna
include 'koneksi.php';
$user_id = $_SESSION['user_id'];
$nama = 'Data Tidak Ditemukan';
$email = 'Data Tidak Ditemukan';

$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nama = $user['nama'];
    $email = $user['email'];
}
$stmt->close();
$conn->close();

// Variabel untuk sapaan di header
$nama_sapaan = isset($_SESSION['user']) ? $_SESSION['user'] : 'Pengunjung';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - ADROWIIZ STORE</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/profile.css" />
</head>
<body>

<header>
  <div class="header-container">
    <div class="brand-area">
      <img src="style/logoo.png" alt="ADROWIIZ Logo" class="header-logo">
      <h1>ADROWIIZ</h1>
    </div>
    <div class="user-menu">
        <button class="user-menu-trigger">
            <i class="fas fa-user-circle"></i>
            <span>Hai, <?= htmlspecialchars($nama_sapaan) ?>!</span>
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="index.php"><i class="fas fa-reply"></i> Kembali</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
  </div>
</header>
<main class="profile-page-main">
    <div class="profile-container">
        
        <div class="profile-header">
            <i class="fas fa-shield-alt"></i>
            <h2>Profil & Keamanan</h2>
        </div>
        
        <div class="profile-section">
    <h3>Informasi Akun</h3>
    
    <?php
        if (isset($_SESSION['profile_message'])) {
            $message_type = isset($_SESSION['profile_error']) ? 'error' : 'success';
            echo '<div class="message ' . $message_type . '">' . htmlspecialchars($_SESSION['profile_message']) . '</div>';
            unset($_SESSION['profile_message']);
            unset($_SESSION['profile_error']);
        }
    ?>

    <form action="update_profile.php" method="POST" class="profile-form">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="password_verify">Konfirmasi Password Anda</label>
            <input type="password" id="password_verify" name="password_verify" placeholder="Masukkan password untuk menyimpan perubahan" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
    </div>

        <hr class="profile-divider">

        <div class="profile-section">
            <h3>Ganti Password</h3>
            <form action="update_password.php" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" required placeholder="Masukkan password Anda saat ini">
                </div>
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" required placeholder="Minimal 8 karakter">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password baru">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Password Baru</button>
            </form>
        </div>

        <hr class="profile-divider">

        <div class="profile-section danger-zone">
            <h3>Hapus Akun</h3>
            <p>Tindakan ini bersifat permanen dan tidak dapat diurungkan. Semua data produk dan riwayat Anda akan dihapus selamanya.</p>
            <form action="delete_account.php" method="POST" onsubmit="return confirm('APAKAH ANDA BENAR-BENAR YAKIN INGIN MENGHAPUS AKUN INI SECARA PERMANEN?');">
                <button type="submit" class="btn btn-danger">Ya, Hapus Akun Saya</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <section id="kontak">
      <p>&copy; <?= date('Y') ?> ADROWIIZ Store. All rights reserved.</p>
    </section>
</footer>
<script src="main.js"></script>

</body>
</html>