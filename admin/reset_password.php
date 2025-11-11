<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = intval($_POST['id_user']);
    $new_password = $_POST['new_password'];

    // Validasi input
    if (empty($new_password) || strlen($new_password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password minimal 6 karakter']);
        exit();
    }

    // Hash password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $query = "UPDATE users SET password = '$hashed_password' WHERE id_user = $id_user";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Password berhasil direset']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mereset password']);
    }
}
