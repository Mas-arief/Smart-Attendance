<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Mahasiswa</title>

    <!-- Font Awesome & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6fb;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        /* Area utama menyesuaikan sidebar */
        .main-content {
            flex: 1;
            margin-left: 250px;
            /* Sesuaikan dengan lebar sidebar di navside.php */
            padding: 90px 30px 40px;
            transition: margin-left 0.3s ease;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            /* Untuk scroll tabel */
        }

        h3 {
            text-align: center;
            color: #0E2F80;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        label {
            font-size: 14px;
        }

        select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-family: 'Poppins';
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 13px;
            min-width: 800px;
            /* agar tabel tidak rusak di layar kecil */
        }

        th {
            background-color: #0E2F80;
            color: white;
            padding: 8px;
            font-weight: 600;
            vertical-align: middle;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #f9fafc;
        }

        .kiri {
            text-align: left;
        }

        /* Status tanpa warna (netral) */
        .hadir,
        .izin,
        .alfa,
        .sakit {
            font-weight: 600;
            color: #333;
        }

        /* Responsif untuk tablet dan HP */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 220px;
                padding: 80px 20px 30px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 80px 15px 20px;
            }

            .container {
                padding: 15px;
            }

            h3 {
                font-size: 18px;
            }

            th,
            td {
                font-size: 12px;
                padding: 6px;
            }

            .top-bar {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            h3 {
                font-size: 16px;
            }

            select {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar & Navbar -->
    <?php include 'navside.php'; ?>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="container">
            <h3><i class="fa-solid fa-calendar-check"></i> Rekap Kehadiran Mahasiswa</h3>

            <div class="top-bar">
                <label for="tahun">Tahun Ajaran:&nbsp;</label>
                <select id="tahun">
                    <option>2024 Ganjil (1)</option>
                    <option>2024 Genap (2)</option>
                </select>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>KODE MK</th>
                            <th class="kiri">MATAKULIAH</th>
                            <th>JENIS</th>
                            <th colspan="14">MINGGU KE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IF101</td>
                            <td class="kiri">Pengantar Proyek Perangkat Lunak</td>
                            <td>TEORI & PRAKTIKUM</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="izin">Izin</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="sakit">Sakit</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                        </tr>

                        <tr>
                            <td>IF102</td>
                            <td class="kiri">Pengantar Teknologi Informasi</td>
                            <td>TEORI & PRAKTIKUM</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="alfa">Alfa</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="sakit">Sakit</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="izin">Izin</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                        </tr>

                        <tr>
                            <td>IF103</td>
                            <td class="kiri">Dasar Pemrograman Web</td>
                            <td>TEORI & PRAKTIKUM</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="izin">Izin</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="sakit">Sakit</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                            <td class="hadir">Hadir</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>