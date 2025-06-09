<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email sudah digunakan menggunakan PREPARED STATEMENT
    $stmt = $conn->prepare("SELECT id FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        $stmt->close();
        
        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Simpan user baru dengan PREPARED STATEMENT
        $stmt_insert = $conn->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $nama, $email, $hash);

        if ($stmt_insert->execute()) {
            // Jika registrasi berhasil, langsung login
            $user_id = $conn->insert_id;
            $_SESSION['user'] = $nama;
            $_SESSION['user_id'] = $user_id;

            header("Location: index.php");
            exit;
        } else {
            $error_message = "Terjadi kesalahan saat registrasi.";
        }
        $stmt_insert->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - ADROWIIZ Store</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="#">
                    <img src="style/logoo.png" alt="ADROWIIZ Logo" class="auth-logo">
                </a>
                <h1>ADROWIIZ</h1>
                <p>Buat akun baru untuk memulai</p>
            </div>
            
            <form method="POST" action="register.php" class="auth-form">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                </div>
                
                <?php if (!empty($error_message)): ?>
                    <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                
                <button type="submit">Daftar Sekarang</button>
            </form>
            
            <div class="auth-footer">
                <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>