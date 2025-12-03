<?php
session_start();
header("Content-Type: application/json");
include "koneksi.php";

// ===============================
// CEK ROLE LOGIN
// ===============================
if (isset($_SESSION['mahasiswa'])) {
    $role = "mahasiswa";
    $id = $_SESSION['mahasiswa']['nim'];
    $fieldId = "nim";
    $table = "mahasiswa";
} elseif (isset($_SESSION['dosen'])) {
    $role = "dosen";
    $id = $_SESSION['dosen']['nik'];
    $fieldId = "nik";
    $table = "dosen";
} else {
    echo json_encode([
        "success" => false,
        "message" => "Akses ditolak. Silakan login."
    ]);
    exit;
}

// ===============================
// AMBIL INPUT FRONTEND
// ===============================
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Password tidak boleh kosong."
    ]);
    exit;
}

$password_baru = password_hash($data['password'], PASSWORD_DEFAULT);

// ===============================
// UPDATE PASSWORD
// ===============================
$query = "UPDATE $table SET password = ? WHERE $fieldId = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $password_baru, $id);

if (mysqli_stmt_execute($stmt)) {
    session_destroy(); // paksa logout
    echo json_encode([
        "success" => true,
        "message" => "Password berhasil diperbarui."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal memperbarui password!"
    ]);
}
