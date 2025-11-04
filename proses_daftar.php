<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // NIK/NIM
    $password = $_POST['password'];

    // Cek apakah input kosong
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password harus diisi.";
        header("Location: login.php");
        exit();
    }

    // Ambil data user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika username ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {
            // Simpan data user ke session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Arahkan berdasarkan role
            switch ($user['role']) {
                case 'admin':
                    header("Location: dashboardadmin.php");
                    break;
                case 'dosen':
                    header("Location: dashboarddosen.php");
                    break;
                case 'mahasiswa':
                    header("Location: dashboardmahasiswa.php");
                    break;
                default:
                    $_SESSION['error'] = "Role tidak dikenali.";
                    header("Location: login.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
