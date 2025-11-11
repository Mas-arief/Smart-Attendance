<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get counts for each role
$admin_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'"))['total'];
$dosen_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'dosen'"))['total'];
$mahasiswa_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'mahasiswa'"))['total'];

$stats = [
    'admin' => $admin_count,
    'dosen' => $dosen_count,
    'mahasiswa' => $mahasiswa_count,
    'total' => $admin_count + $dosen_count + $mahasiswa_count
];

header('Content-Type: application/json');
echo json_encode($stats);
