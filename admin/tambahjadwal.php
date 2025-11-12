<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Koneksi Database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sistem"; // ganti sesuai database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

// Ambil action dari query string
$action = $_GET['action'] ?? '';

function getJsonInput()
{
    return json_decode(file_get_contents("php://input"), true);
}

/* =====================
   ACTION: LIST JADWAL
===================== */
if ($action === 'list') {
    $query = "SELECT j.id_jadwal, r.nama_ruangan, j.mata_kuliah, j.jam_masuk, j.jam_keluar
            FROM jadwal j
            INNER JOIN ruangan r ON j.id_ruangan = r.id_ruangan
            ORDER BY j.id_jadwal DESC";
    $result = $conn->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(["success" => true, "data" => $data]);
    exit;
}

/* =====================
   ACTION: LIST RUANGAN
===================== */
if ($action === 'ruangan') {
    $query = "SELECT id_ruangan, nama_ruangan FROM ruangan ORDER BY nama_ruangan ASC";
    $result = $conn->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(["success" => true, "data" => $data]);
    exit;
}

/* =====================
   ACTION: DETAIL JADWAL
===================== */
if ($action === 'detail' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM jadwal WHERE id_jadwal = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode(["success" => true, "data" => $result->fetch_assoc()]);
    } else {
        echo json_encode(["success" => false, "message" => "Data tidak ditemukan"]);
    }
    exit;
}

/* =====================
   ACTION: CREATE JADWAL
===================== */
if ($action === 'create') {
    $input = getJsonInput();
    $id_ruangan = $conn->real_escape_string($input['id_ruangan']);
    $mata_kuliah = $conn->real_escape_string($input['mata_kuliah']);
    $jam_masuk = $conn->real_escape_string($input['jam_masuk']);
    $jam_keluar = $conn->real_escape_string($input['jam_keluar']);

    $query = "INSERT INTO jadwal (id_ruangan, mata_kuliah, jam_masuk, jam_keluar)
            VALUES ('$id_ruangan', '$mata_kuliah', '$jam_masuk', '$jam_keluar')";
    if ($conn->query($query)) {
        echo json_encode(["success" => true, "message" => "Jadwal berhasil ditambahkan"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal menambah jadwal: " . $conn->error]);
    }
    exit;
}

/* =====================
   ACTION: UPDATE JADWAL
===================== */
if ($action === 'update' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $input = getJsonInput();
    $id_ruangan = $conn->real_escape_string($input['id_ruangan']);
    $mata_kuliah = $conn->real_escape_string($input['mata_kuliah']);
    $jam_masuk = $conn->real_escape_string($input['jam_masuk']);
    $jam_keluar = $conn->real_escape_string($input['jam_keluar']);

    $query = "UPDATE jadwal SET 
              id_ruangan = '$id_ruangan',
              mata_kuliah = '$mata_kuliah',
              jam_masuk = '$jam_masuk',
              jam_keluar = '$jam_keluar'
            WHERE id_jadwal = $id";

    if ($conn->query($query)) {
        echo json_encode(["success" => true, "message" => "Jadwal berhasil diperbarui"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal mengupdate jadwal: " . $conn->error]);
    }
    exit;
}

/* =====================
   ACTION: DELETE JADWAL
===================== */
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM jadwal WHERE id_jadwal = $id";

    if ($conn->query($query)) {
        echo json_encode(["success" => true, "message" => "Jadwal berhasil dihapus"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal menghapus jadwal: " . $conn->error]);
    }
    exit;
}

// Default jika action tidak dikenali
echo json_encode(["success" => false, "message" => "Aksi tidak valid"]);
exit;
