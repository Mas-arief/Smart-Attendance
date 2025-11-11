<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);

    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
        exit();
    }

    // Cek apakah username sudah ada
    $check = mysqli_query($conn, "SELECT id_user FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar']);
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru
    $query = "INSERT INTO users (username, password, role, nama_lengkap) VALUES ('$username', '$hashed_password', '$role', '$nama_lengkap')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan user']);
    }
}
