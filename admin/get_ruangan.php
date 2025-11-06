<?php
require '../koneksi.php';

$result = mysqli_query($conn, "SELECT * FROM ruangan ORDER BY id_ruangan DESC");
$no = 1;

while ($row = mysqli_fetch_assoc($result)) {
    echo "
    <tr>
        <td>{$no}</td>
        <td>{$row['nama_ruangan']}</td>
        <td>
            <button onclick='hapusRuangan({$row['id_ruangan']})' 
                class='btn btn-danger btn-sm'>
                <i class='fa-solid fa-trash'></i>
            </button>
        </td>
    </tr>";
    $no++;
}
