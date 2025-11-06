<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Mahasiswa belum dipilih"]);
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT nim, nama, prodi FROM mahasiswa WHERE nim='$id'");
$data = mysqli_fetch_assoc($query);

echo json_encode($data);
