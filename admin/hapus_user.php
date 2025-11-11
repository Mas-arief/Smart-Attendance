<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "error";
    exit();
}

if (isset($_POST['id_user'])) {
    $id = intval($_POST['id_user']);

    // Cek apakah user yang akan dihapus adalah admin terakhir
    $check_admin = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $admin_count = mysqli_fetch_assoc($check_admin)['total'];

    $user_query = mysqli_query($conn, "SELECT role FROM users WHERE id_user = $id");
    $user_role = mysqli_fetch_assoc($user_query)['role'];

    if ($user_role == 'admin' && $admin_count <= 1) {
        echo "last_admin";
        exit();
    }

    $query = "DELETE FROM users WHERE id_user = $id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
