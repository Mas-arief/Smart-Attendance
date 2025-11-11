<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password harus diisi.";
        header("Location: login.php");
        exit();
    }

    // Cek user di database menggunakan prepared statement (lebih aman)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan data ke session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = isset($user['nama_lengkap']) ? $user['nama_lengkap'] : $username;

            // Redirect sesuai role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin/dashboardadmin.php");
                    exit();
                case 'dosen':
                    header("Location: dosen/dashboard.php");
                    exit();
                case 'mahasiswa':
                    header("Location: mahasiswa/dashboard.php");
                    exit();
                default:
                    $_SESSION['error'] = "Role tidak dikenali.";
                    header("Location: login.php");
                    exit();
            }
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

    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}
