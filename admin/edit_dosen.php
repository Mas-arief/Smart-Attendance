<?php
include '../koneksi.php';
$id = $_POST['id_dosen'];
$nik = $_POST['nik'];
$nama = $_POST['nama_dosen'];
$email = $_POST['email'];
$jurusan = $_POST['jurusan'];

// cek duplicate nik
$cek = $conn->prepare("SELECT id_dosen FROM dosen WHERE nik = ? AND id_dosen != ?");
$cek->bind_param("si", $nik, $id);
$cek->execute();
$cek->store_result();
if ($cek->num_rows > 0) {
    echo "<script>alert('NIK sudah digunakan'); window.history.back();</script>";
    exit;
}
$cek->close();

$stmt = $conn->prepare("UPDATE dosen SET nik=?, nama_dosen=?, email=?, jurusan=? WHERE id_dosen=?");
$stmt->bind_param("ssssi", $nik, $nama, $email, $jurusan, $id);
$stmt->execute();
header("Location: datadosen.php");
