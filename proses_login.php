<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Cek user di database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Jika password cocok
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['nama']     = $user['nama_lengkap'];

        // Redirect sesuai role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin/dashboardadmin.php");
                exit;
            case 'dosen':
                header("Location: dosen/dashboard.php");
                exit;
            case 'mahasiswa':
                header("Location: mahasiswa/dashboard.php");
                exit;
        }
    } else {
        echo "<script>alert('Password salah!'); window.location='login.php';</script>";
    }
} else {
    echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
}
