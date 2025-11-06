<?php
include '../koneksi.php';

$id = $_POST['id_mahasiswa'];
$nim = $_POST['nim'];
$nama = $_POST['nama_mahasiswa'];
$email = $_POST['email'];
$jurusan = $_POST['jurusan'];
$angkatan = $_POST['angkatan'];

// Cek apakah NIM sudah digunakan oleh mahasiswa lain
$cek = $conn->prepare("SELECT id_mahasiswa FROM mahasiswa WHERE nim = ? AND id_mahasiswa != ?");
$cek->bind_param("si", $nim, $id);
$cek->execute();
$cek->store_result();

if ($cek->num_rows > 0) {
    // Jika NIM sudah ada, beri pesan error dan hentikan proses
    echo "<script>
        alert('NIM sudah digunakan oleh mahasiswa lain!');
        window.history.back();
    </script>";
    exit;
}

$cek->close();

// Lanjut update data
$stmt = $conn->prepare("UPDATE mahasiswa SET nim=?, nama_mahasiswa=?, email=?, jurusan=?, angkatan=? WHERE id_mahasiswa=?");
$stmt->bind_param("sssssi", $nim, $nama, $email, $jurusan, $angkatan, $id);

if ($stmt->execute()) {
    header("Location: datamahasiswa.php");
    exit;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
