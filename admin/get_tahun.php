<?php
include '../koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$res = [];
$q = mysqli_query($conn, "SELECT id_tahun, CONCAT(tahun_ajaran,' ', ' - ', semester) AS label FROM tahun_ajaran ORDER BY id_tahun DESC");
while ($r = mysqli_fetch_assoc($q)) $res[] = $r;
echo json_encode($res);
