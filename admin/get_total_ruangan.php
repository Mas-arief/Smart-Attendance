<?php
require '../koneksi.php';

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM ruangan");
$data = mysqli_fetch_assoc($result);

echo $data['total'];
