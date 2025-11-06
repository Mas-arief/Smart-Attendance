<?php
include '../koneksi.php';

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$jurusan = $_POST['jurusan'];

// Cek apakah NIP sudah ada
$cek = $conn->prepare("SELECT id_dosen FROM dosen WHERE nip = ?");
$cek->bind_param("s", $nip);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    echo "<script>
        alert('NIP sudah terdaftar!');
        window.history.back();
    </script>";
    exit;
}
$cek->close();

// Tambah data baru
$stmt = $conn->prepare("INSERT INTO dosen (nip, nama, email, jurusan) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nip, $nama, $email, $jurusan);

if ($stmt->execute()) {
    header("Location: datadosen.php");
    exit;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
