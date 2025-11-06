<?php
// jadwal_api.php - API untuk CRUD jadwal ruangan

header('Content-Type: application/json');
require_once 'config.php';

// Ambil metode request dan action
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Response helper
function sendResponse($success, $message, $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

try {
    switch ($method) {
        case 'GET':
            if ($action === 'list' || $action === '') {
                // Ambil semua jadwal
                $stmt = $conn->prepare("
                    SELECT j.*, r.nama_ruangan 
                    FROM jadwal j
                    INNER JOIN ruangan r ON j.id_ruangan = r.id_ruangan
                    ORDER BY j.jam_masuk ASC
                ");
                $stmt->execute();
                $jadwal = $stmt->fetchAll();
                sendResponse(true, 'Data berhasil diambil', $jadwal);
            } elseif ($action === 'detail' && isset($_GET['id'])) {
                // Ambil detail jadwal berdasarkan ID
                $id = $_GET['id'];
                $stmt = $conn->prepare("
                    SELECT j.*, r.nama_ruangan 
                    FROM jadwal j
                    INNER JOIN ruangan r ON j.id_ruangan = r.id_ruangan
                    WHERE j.id_jadwal = ?
                ");
                $stmt->execute([$id]);
                $jadwal = $stmt->fetch();

                if ($jadwal) {
                    sendResponse(true, 'Data ditemukan', $jadwal);
                } else {
                    sendResponse(false, 'Data tidak ditemukan');
                }
            } elseif ($action === 'ruangan') {
                // Ambil daftar ruangan untuk dropdown
                $stmt = $conn->prepare("SELECT id_ruangan, nama_ruangan FROM ruangan ORDER BY nama_ruangan");
                $stmt->execute();
                $ruangan = $stmt->fetchAll();
                sendResponse(true, 'Data ruangan berhasil diambil', $ruangan);
            }
            break;

        case 'POST':
            if ($action === 'create') {
                // Tambah jadwal baru
                $data = json_decode(file_get_contents('php://input'), true);

                // Validasi input
                if (
                    empty($data['id_ruangan']) || empty($data['mata_kuliah']) ||
                    empty($data['jam_masuk']) || empty($data['jam_keluar'])
                ) {
                    sendResponse(false, 'Semua field harus diisi');
                }

                // Cek konflik jadwal (ruangan yang sama pada waktu yang bersamaan)
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total FROM jadwal 
                    WHERE id_ruangan = ? 
                    AND (
                        (jam_masuk <= ? AND jam_keluar > ?) OR
                        (jam_masuk < ? AND jam_keluar >= ?) OR
                        (jam_masuk >= ? AND jam_keluar <= ?)
                    )
                ");
                $stmt->execute([
                    $data['id_ruangan'],
                    $data['jam_masuk'],
                    $data['jam_masuk'],
                    $data['jam_keluar'],
                    $data['jam_keluar'],
                    $data['jam_masuk'],
                    $data['jam_keluar']
                ]);
                $conflict = $stmt->fetch();

                if ($conflict['total'] > 0) {
                    sendResponse(false, 'Ruangan sudah digunakan pada waktu tersebut');
                }

                // Insert jadwal baru
                $stmt = $conn->prepare("
                    INSERT INTO jadwal (id_ruangan, mata_kuliah, jam_masuk, jam_keluar, created_at)
                    VALUES (?, ?, ?, ?, NOW())
                ");
                $stmt->execute([
                    $data['id_ruangan'],
                    $data['mata_kuliah'],
                    $data['jam_masuk'],
                    $data['jam_keluar']
                ]);

                sendResponse(true, 'Jadwal berhasil ditambahkan', ['id' => $conn->lastInsertId()]);
            }
            break;

        case 'PUT':
            if ($action === 'update' && isset($_GET['id'])) {
                // Update jadwal
                $id = $_GET['id'];
                $data = json_decode(file_get_contents('php://input'), true);

                // Validasi input
                if (
                    empty($data['id_ruangan']) || empty($data['mata_kuliah']) ||
                    empty($data['jam_masuk']) || empty($data['jam_keluar'])
                ) {
                    sendResponse(false, 'Semua field harus diisi');
                }

                // Cek konflik jadwal (kecuali jadwal yang sedang diedit)
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as total FROM jadwal 
                    WHERE id_ruangan = ? 
                    AND id_jadwal != ?
                    AND (
                        (jam_masuk <= ? AND jam_keluar > ?) OR
                        (jam_masuk < ? AND jam_keluar >= ?) OR
                        (jam_masuk >= ? AND jam_keluar <= ?)
                    )
                ");
                $stmt->execute([
                    $data['id_ruangan'],
                    $id,
                    $data['jam_masuk'],
                    $data['jam_masuk'],
                    $data['jam_keluar'],
                    $data['jam_keluar'],
                    $data['jam_masuk'],
                    $data['jam_keluar']
                ]);
                $conflict = $stmt->fetch();

                if ($conflict['total'] > 0) {
                    sendResponse(false, 'Ruangan sudah digunakan pada waktu tersebut');
                }

                // Update jadwal
                $stmt = $conn->prepare("
                    UPDATE jadwal 
                    SET id_ruangan = ?, mata_kuliah = ?, jam_masuk = ?, jam_keluar = ?, updated_at = NOW()
                    WHERE id_jadwal = ?
                ");
                $stmt->execute([
                    $data['id_ruangan'],
                    $data['mata_kuliah'],
                    $data['jam_masuk'],
                    $data['jam_keluar'],
                    $id
                ]);

                sendResponse(true, 'Jadwal berhasil diupdate');
            }
            break;

        case 'DELETE':
            if ($action === 'delete' && isset($_GET['id'])) {
                // Hapus jadwal
                $id = $_GET['id'];

                $stmt = $conn->prepare("DELETE FROM jadwal WHERE id_jadwal = ?");
                $stmt->execute([$id]);

                if ($stmt->rowCount() > 0) {
                    sendResponse(true, 'Jadwal berhasil dihapus');
                } else {
                    sendResponse(false, 'Jadwal tidak ditemukan');
                }
            }
            break;

        default:
            sendResponse(false, 'Method tidak diizinkan');
    }
} catch (PDOException $e) {
    sendResponse(false, 'Database error: ' . $e->getMessage());
} catch (Exception $e) {
    sendResponse(false, 'Error: ' . $e->getMessage());
}
