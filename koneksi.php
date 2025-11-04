<?php
$host = "localhost";
$user = "root"; // Ganti dengan username DB Anda
$pass = "";     // Ganti dengan password DB Anda
$db   = "sistem_absensi";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
