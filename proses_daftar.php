<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role']; // dosen atau mahasiswa
    $nik_nim = $_POST['nik_nim']; // NIK untuk dosen, NIM untuk mahasiswa
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($role) || empty($nik_nim) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field harus diisi.";
        header("Location: daftar.php");
        exit();
    }

    // Validasi password match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
        header("Location: daftar.php");
        exit();
    }

    // Validasi panjang password
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password minimal 6 karakter.";
        header("Location: daftar.php");
        exit();
    }

    // Cek apakah username sudah terdaftar
    $stmt = $conn->prepare("SELECT id_user FROM users WHERE username = ?");
    $stmt->bind_param("s", $nik_nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "NIK/NIM sudah terdaftar.";
        header("Location: daftar.php");
        exit();
    }
    $stmt->close();

    // Validasi apakah NIK/NIM ada di tabel dosen atau mahasiswa
    if ($role == 'dosen') {
        $stmt = $conn->prepare("SELECT nik, nama_dosen FROM dosen WHERE nik = ?");
        $stmt->bind_param("s", $nik_nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $_SESSION['error'] = "NIK tidak ditemukan di database dosen. Hubungi admin.";
            header("Location: daftar.php");
            exit();
        }

        $data = $result->fetch_assoc();
        $nama_lengkap = $data['nama_dosen'];
        $stmt->close();
    } elseif ($role == 'mahasiswa') {
        $stmt = $conn->prepare("SELECT nim, nama_mahasiswa FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nik_nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $_SESSION['error'] = "NIM tidak ditemukan di database mahasiswa. Hubungi admin.";
            header("Location: daftar.php");
            exit();
        }

        $data = $result->fetch_assoc();
        $nama_lengkap = $data['nama_mahasiswa'];
        $stmt->close();
    } else {
        $_SESSION['error'] = "Role tidak valid.";
        header("Location: daftar.php");
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user baru ke database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, nama_lengkap) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nik_nim, $hashed_password, $role, $nama_lengkap);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        header("Location: daftar.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: daftar.php");
    exit();
}
