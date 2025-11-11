<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND is_active = 1 LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user']  = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama']     = $user['nama_lengkap'];
            $_SESSION['role']     = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboardadmin.php");
                exit;
            } elseif ($user['role'] === 'dosen') {
                header("Location: dosen/dashboard.php");
                exit;
            } elseif ($user['role'] === 'mahasiswa') {
                header("Location: mahasiswa/dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Role tidak dikenali!";
            }
        } else {
            $_SESSION['error'] = "Password salah!";
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan atau akun nonaktif!";
    }

    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
