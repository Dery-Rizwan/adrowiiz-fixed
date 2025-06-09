<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan Prepared Statement untuk keamanan
    $stmt = $conn->prepare("SELECT id, nama, password FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika berhasil, simpan session dan redirect
            $_SESSION['user'] = $user['nama'];
            $_SESSION['user_id'] = $user['id'];
            
            header("Location: index.php");
            exit;
        } else {
            // Jika password salah
            $error_message = "Email atau password yang Anda masukkan salah.";
        }
    } else {
        // Jika email tidak ditemukan
        $error_message = "Email atau password yang Anda masukkan salah.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ADROWIIZ Store</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="index.php">
                    <img src="style/logoo.png" alt="ADROWIIZ Logo" class="auth-logo">
                </a>
                <h1>ADROWIIZ</h1>
                <p>Masuk untuk melanjutkan ke akun Anda</p>
            </div>
            
            <form method="POST" action="login.php" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>
                
                <?php if (!empty($error_message)): ?>
                    <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
                
                <button type="submit">Masuk</button>
            </form>
            
            <div class="auth-footer">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>