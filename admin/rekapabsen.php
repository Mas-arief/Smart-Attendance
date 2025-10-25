<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rekap Absensi Mahasiswa</title>

    <!-- Font Awesome & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- MDB UI Kit -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6fb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 80px auto;
            background: white;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #0E2F80;
            font-weight: 700;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #0E2F80;
            color: white;
            padding: 10px;
            font-weight: 600;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f3f9;
        }

        img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }

        .top-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .btn-custom {
            background-color: #0E2F80;
            color: #fff;
            border-radius: 6px;
            font-weight: 500;
            padding: 8px 16px;
        }

        .btn-custom:hover {
            background-color: #0b2564;
        }

        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .date-input {
            border-radius: 6px;
            padding: 8px;
            border: 1px solid #ccc;
        }

        .btn-success {
            border-radius: 6px;
        }

        .btn-secondary {
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3><i class="fa-solid fa-list"></i> Rekap Absensi Mahasiswa</h3>

        <div class="top-bar">
            <form class="filter-form">
                <label>Dari:</label>
                <input type="date" class="date-input">
                <label>Sampai:</label>
                <input type="date" class="date-input">
                <button type="button" class="btn btn-custom"><i class="fa-solid fa-filter"></i> Filter</button>
                <button type="button" class="btn btn-secondary"><i class="fa-solid fa-rotate"></i> Reset</button>
            </form>

            <div>
                <button class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Export Excel</button>
                <a href="registrasiwajah.html" class="btn btn-custom"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Foto Wajah</th>
                    <th>Tanggal & Waktu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>230101001</td>
                    <td>Rizky Setiawan</td>
                    <td><img src="https://i.pravatar.cc/100?img=1" alt="wajah"></td>
                    <td>18 Oktober 2025, 07:55</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>230101002</td>
                    <td>Dinda Pratiwi</td>
                    <td><img src="https://i.pravatar.cc/100?img=2" alt="wajah"></td>
                    <td>18 Oktober 2025, 07:58</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>230101003</td>
                    <td>Arif Maulana</td>
                    <td><img src="https://i.pravatar.cc/100?img=3" alt="wajah"></td>
                    <td>18 Oktober 2025, 08:01</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
</body>

</html>