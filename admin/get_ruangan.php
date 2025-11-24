<?php
header('Content-Type: application/json');
require_once '../koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

function sendResponse($success, $message, $data = null)
{
    echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
    exit;
}

try {
    switch ($method) {
        case 'GET':
            $stmt = $conn->prepare("SELECT * FROM ruangan ORDER BY id_ruangan DESC");
            $stmt->execute();

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['nama_ruangan'])) sendResponse(false, 'Nama ruangan wajib diisi');

            $stmt = $conn->prepare("INSERT INTO ruangan (nama_ruangan) VALUES (?)");
            $stmt->execute([$data['nama_ruangan']]);
            sendResponse(true, 'Ruangan berhasil ditambahkan');
            break;

        case 'DELETE':
            if (!isset($_GET['id'])) sendResponse(false, 'ID ruangan tidak ditemukan');
            $stmt = $conn->prepare("DELETE FROM ruangan WHERE id_ruangan = ?");
            $stmt->execute([$_GET['id']]);
            sendResponse(true, 'Ruangan berhasil dihapus');
            break;

        default:
            sendResponse(false, 'Method tidak diizinkan');
    }
} catch (PDOException $e) {
    sendResponse(false, 'Database error: ' . $e->getMessage());
}
