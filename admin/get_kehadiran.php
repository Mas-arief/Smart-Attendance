<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("Location: login.html");
    exit();
}

// Koneksi Database
include '../koneksi.php';
mysqli_set_charset($conn, "utf8");

// ✅ Ambil Data Mahasiswa
if (isset($_GET['getMahasiswa'])) {
    $nim = $_GET['nim'];

    $mhs = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT nim, nama, kelas, prodi
        FROM mahasiswa
        WHERE nim='$nim'
    "));

    echo json_encode($mhs);
    exit;
}

// ✅ Ambil Mata Kuliah Untuk Dropdown
if (isset($_GET['getMatkul'])) {
    $nim = $_GET['nim'];
    $tahun = $_GET['tahun'];

    $mk = mysqli_query($conn, "
        SELECT mk.kode_mk, mk.nama_mk
        FROM jadwal j
        JOIN mata_kuliah mk ON mk.kode_mk = j.kode_mk
        WHERE j.nim='$nim' AND j.tahun_ajaran='$tahun'
        GROUP BY mk.kode_mk
    ");

    $data = [];
    while ($r = mysqli_fetch_assoc($mk)) {
        $data[] = $r;
    }

    echo json_encode($data);
    exit;
}

// ✅ Ambil Rekap Kehadiran Detail + Summary
if (isset($_GET['getKehadiran'])) {
    $nim = $_GET['nim'];
    $tahun = $_GET['tahun'];
    $mk = $_GET['mk'];

    $filterMk = $mk == "" ? "" : "AND mk.kode_mk='$mk'";

    // ✅ Ambil semua matkul yang diambil mahasiswa
    $sql = "
    SELECT mk.kode_mk AS kode, mk.nama_mk AS nama, mk.jenis
    FROM jadwal j
    JOIN mata_kuliah mk ON mk.kode_mk = j.kode_mk
    WHERE j.nim='$nim' AND j.tahun_ajaran='$tahun' $filterMk
    GROUP BY mk.kode_mk
    ";

    $res = mysqli_query($conn, $sql);
    $detail = [];

    while ($r = mysqli_fetch_assoc($res)) {
        $kode = $r['kode'];
        $r['absen'] = [];

        // ✅ Isi status minggu 1–14
        for ($i = 1; $i <= 14; $i++) {
            $q = mysqli_query($conn, "
                SELECT status 
                FROM kehadiran 
                WHERE nim='$nim' AND kode_mk='$kode' 
                AND minggu='$i' AND tahun_ajaran='$tahun'
                LIMIT 1
            ");

            $status = mysqli_num_rows($q) > 0 ? mysqli_fetch_assoc($q)['status'] : "-";
            $r['absen'][] = $status;
        }

        $detail[] = $r;
    }

    // ✅ Hitung Ringkasan Semua Kehadiran
    $sum = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT
        SUM(status='Hadir') AS hadir,
        SUM(status='Izin') AS izin,
        SUM(status='Sakit') AS sakit,
        SUM(status='Alfa') AS alfa,
        COUNT(*) AS total
        FROM kehadiran
        WHERE nim='$nim' AND tahun_ajaran='$tahun'
    "));

    $sum['total'] = $sum['total'] == 0 ? 1 : $sum['total'];

    echo json_encode([
        "summary" => $sum,
        "detail" => $detail
    ]);
    exit;
}

echo json_encode(["error" => "Invalid request"]);
exit;
