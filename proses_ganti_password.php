<?php
session_start();
require 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($new_password) || empty($confirm_password)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
        exit();
    }

    // Validasi password match
    if ($new_password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Password baru dan konfirmasi tidak cocok']);
        exit();
    }

    // Validasi panjang password
    if (strlen($new_password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password minimal 6 karakter']);
        exit();
    }

    // Jika ada old_password (verifikasi password lama)
    if (!empty($old_password)) {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($old_password, $user['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Password lama salah']);
            exit();
        }
        $stmt->close();
    }

    // Hash password baru
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id_user = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password berhasil diubah']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengubah password']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
