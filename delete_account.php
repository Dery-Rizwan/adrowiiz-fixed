<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("DELETE FROM `users` WHERE `id` = ?");
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header('Location: landing.php?status=account_deleted');
        exit();

    } else {
        echo "Error: Gagal menghapus akun. Silakan coba lagi.";
    }

    $stmt->close();
    
} else {
    header('Location: profile.php');
    exit();
}

$conn->close();
?>