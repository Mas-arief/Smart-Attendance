<?php
include '../koneksi.php';

// Pastikan request berasal dari form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form
    $nik = isset($_POST['nik']) ? trim($_POST['nik']) : '';
    $nama_dosen = isset($_POST['nama_dosen']) ? trim($_POST['nama_dosen']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $jurusan = isset($_POST['jurusan']) ? trim($_POST['jurusan']) : '';

    // Validasi data wajib diisi
    if (empty($nik) || empty($nama_dosen) || empty($email) || empty($jurusan)) {
        echo "<script>
            alert('Semua field harus diisi!');
            window.history.back();
        </script>";
        exit;
    }

    // Cek apakah NIK sudah terdaftar
    $cek = $conn->prepare("SELECT id_dosen FROM dosen WHERE nik = ?");
    $cek->bind_param("s", $nik);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "<script>
            alert('NIK sudah terdaftar!');
            window.history.back();
        </script>";
        $cek->close();
        $conn->close();
        exit;
    }
    $cek->close();

    // Tambahkan data baru
    $stmt = $conn->prepare("INSERT INTO dosen (nik, nama_dosen, email, jurusan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nik, $nama_dosen, $email, $jurusan);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data dosen berhasil ditambahkan!');
            window.location.href = 'datadosen.php';
        </script>";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Jika bukan dari POST, arahkan kembali ke halaman data dosen
    header("Location: datadosen.php");
    exit;
}
