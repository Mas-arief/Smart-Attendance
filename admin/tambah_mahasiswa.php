<?php
include '../koneksi.php';

$nim = $_POST['nim'];
$nama = $_POST['nama_mahasiswa'];
$email = $_POST['email'];
$jurusan = $_POST['jurusan'];
$angkatan = $_POST['angkatan'];

$stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama_mahasiswa, email, jurusan, angkatan) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nim, $nama, $email, $jurusan, $angkatan);
$stmt->execute();

header("Location: datamahasiswa.php");
