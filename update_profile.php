<?php
session_start();
include 'koneksi.php'; // Pastikan file ini menggunakan variabel $conn

// Keamanan: Cek jika pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Hanya proses jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $new_nama = $_POST['nama'];
    $new_email = $_POST['email'];
    $password_to_verify = $_POST['password_verify'];

    // Validasi dasar
    if (empty($new_nama) || empty($new_email) || empty($password_to_verify)) {
        $_SESSION['profile_message'] = "Semua kolom harus diisi.";
        $_SESSION['profile_error'] = true;
        header('Location: profile.php');
        exit();
    }

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['profile_message'] = "Format email tidak valid.";
        $_SESSION['profile_error'] = true;
        header('Location: profile.php');
        exit();
    }

    // --- Verifikasi Password Pengguna ---
    $stmt_verify = $conn->prepare("SELECT password FROM `users` WHERE `id` = ?");
    $stmt_verify->bind_param("i", $user_id);
    $stmt_verify->execute();
    $result = $stmt_verify->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password_to_verify, $user['password'])) {
            // Jika password benar, lanjutkan proses update

            // --- Cek apakah email baru sudah digunakan oleh orang lain ---
            $stmt_email = $conn->prepare("SELECT id FROM `users` WHERE `email` = ? AND `id` != ?");
            $stmt_email->bind_param("si", $new_email, $user_id);
            $stmt_email->execute();
            $stmt_email->store_result();

            if ($stmt_email->num_rows > 0) {
                // Email sudah digunakan
                $_SESSION['profile_message'] = "Email ini sudah digunakan oleh akun lain.";
                $_SESSION['profile_error'] = true;
            } else {
                // Email tersedia, lakukan update
                $stmt_update = $conn->prepare("UPDATE `users` SET `nama` = ?, `email` = ? WHERE `id` = ?");
                $stmt_update->bind_param("ssi", $new_nama, $new_email, $user_id);

                if ($stmt_update->execute()) {
                    // Update berhasil
                    $_SESSION['profile_message'] = "Informasi profil berhasil diperbarui.";
                    $_SESSION['user'] = $new_nama; // Update juga session nama untuk sapaan
                } else {
                    $_SESSION['profile_message'] = "Terjadi kesalahan saat memperbarui profil.";
                    $_SESSION['profile_error'] = true;
                }
                $stmt_update->close();
            }
            $stmt_email->close();

        } else {
            // Jika password verifikasi salah
            $_SESSION['profile_message'] = "Password yang Anda masukkan salah.";
            $_SESSION['profile_error'] = true;
        }
    }
    $stmt_verify->close();

} else {
    // Jika halaman diakses langsung
    $_SESSION['profile_message'] = "Aksi tidak diizinkan.";
    $_SESSION['profile_error'] = true;
}

$conn->close();
// Redirect kembali ke halaman profil untuk menampilkan pesan
header('Location: profile.php');
exit();
?>