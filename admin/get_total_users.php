<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$data = mysqli_fetch_assoc($result);

echo $data['total'];
