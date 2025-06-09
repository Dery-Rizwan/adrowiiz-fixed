<?php
session_start();
include 'koneksi.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "Password baru dan konfirmasi tidak cocok.";
    } 
    elseif (strlen($new_password) < 8) {
        $error_message = "Password baru harus memiliki minimal 8 karakter.";
    } 
    else {

        $stmt = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashed_password_from_db = $user['password'];

            if (password_verify($current_password, $hashed_password_from_db)) {
                
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_stmt = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    $success_message = "Password Anda berhasil diperbarui!";
                } else {
                    $error_message = "Terjadi kesalahan saat memperbarui password.";
                }
                $update_stmt->close();

            } else {
                $error_message = "Password saat ini yang Anda masukkan salah.";
            }
        }
        $stmt->close();
    }

    if (!empty($error_message)) {
        $_SESSION['error_message'] = $error_message;
    }
    if (!empty($success_message)) {
        $_SESSION['success_message'] = $success_message;
    }

    header('Location: profile.php');
    exit();
}

$conn->close();
?>