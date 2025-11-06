<?php
include '../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$id_mhs = isset($_GET['id_mhs']) ? intval($_GET['id_mhs']) : 0;
$id_tahun = isset($_GET['id_tahun']) ? intval($_GET['id_tahun']) : 0;
$kode_mk = isset($_GET['kode_mk']) ? mysqli_real_escape_string($conn, $_GET['kode_mk']) : '';

$where = [];
if ($id_mhs) $where[] = "k.id_mahasiswa = $id_mhs";
if ($id_tahun) $where[] = "k.id_tahun = $id_tahun";
if ($kode_mk) $where[] = "k.kode_mk = '$kode_mk'";

$w = $where ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT status, COUNT(*) AS cnt FROM kehadiran k $w GROUP BY status";
$res = mysqli_query($conn, $sql);

$counts = ['Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alfa' => 0];
$total = 0;
while ($r = mysqli_fetch_assoc($res)) {
    $st = $r['status'];
    $counts[$st] = intval($r['cnt']);
    $total += intval($r['cnt']);
}

$percent = [];
foreach ($counts as $k => $v) {
    $percent[$k] = $total ? round(($v / $total) * 100, 1) : 0;
}

echo json_encode([
    'total_pertemuan' => $total,
    'counts' => $counts,
    'percent' => $percent
]);
