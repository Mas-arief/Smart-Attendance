<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "rkm_db"; // ganti dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>


<!-- CREATE TABLE registrasi_wajah (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(20) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  foto_path VARCHAR(255) NOT NULL,
  tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-->