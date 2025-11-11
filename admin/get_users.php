<?php
session_start();
require '../koneksi.php';

// Cek authorization
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$result = mysqli_query($conn, "SELECT id_user, username, role, nama_lengkap FROM users ORDER BY id_user DESC");
$no = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $badge_color = '';
    switch($row['role']) {
        case 'admin':
            $badge_color = 'bg-danger';
            break;
        case 'dosen':
            $badge_color = 'bg-primary';
            break;
        case 'mahasiswa':
            $badge_color = 'bg-success';
            break;
    }

    echo "
    <tr>
        <td>{$no}</td>
        <td>{$row['username']}</td>
        <td>{$row['nama_lengkap']}</td>
        <td><span class='badge {$badge_color}'>" . strtoupper($row['role']) . "</span></td>
        <td>
            <button onclick='resetPassword({$row['id_user']})'
                class='btn btn-warning btn-sm' title='Reset Password'>
                <i class='fa-solid fa-key'></i>
            </button>
            <button onclick='hapusUser({$row['id_user']})'
                class='btn btn-danger btn-sm' title='Hapus User'>
                <i class='fa-solid fa-trash'></i>
            </button>
        </td>
    </tr>";
    $no++;
}
