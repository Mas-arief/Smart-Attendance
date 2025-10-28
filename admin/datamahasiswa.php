<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Admin Polibatam</title>

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet" />

    <!-- MDB UI Kit -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css"
        rel="stylesheet" />

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        /* Konten utama di kanan */
        .content {
            margin-left: 230px;
            /* menyesuaikan lebar sidebar */
            margin-top: 90px;
            /* menyesuaikan tinggi navbar */
            padding: 30px;
            transition: 0.3s;
        }

        /* Container tabel */
        .table-container {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }

        h3 {
            color: #0E2F80;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* Tabel */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            border-radius: 10px;
            overflow: hidden;
        }

        thead tr {
            background-color: #eaeaea;
        }

        th,
        td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            font-size: 15px;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .foto-icon {
            font-size: 20px;
            color: #000;
            cursor: pointer;
            transition: 0.2s;
        }

        .foto-icon:hover {
            color: #0E2F80;
            transform: scale(1.15);
        }

        /* Responsif */
        @media (max-width: 991px) {
            .content {
                margin-left: 0;
                margin-top: 120px;
                padding: 20px;
            }

            .table-container {
                max-width: 100%;
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar & Navbar -->
    <?php include 'navsideadmin.php'; ?>


    <!-- Konten utama -->
    <div class="content">
        <div class="table-container">
            <h3>Daftar Mahasiswa</h3>
            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#exampleModal">
                <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
            </button>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID Mahasiswa</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Foto Wajah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>3312411065</td>
                        <td>Diky Sulisetyo</td>
                        <td>TI-2A</td>
                        <td>Teknik Informatika</td>
                        <td><i class="fa-solid fa-file foto-icon"></i></td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>3312411080</td>
                        <td>Arief Rafi</td>
                        <td>TI-2A</td>
                        <td>Teknik Informatika</td>
                        <td><i class="fa-solid fa-file foto-icon"></i></td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>3312411057</td>
                        <td>Nafisah Nurul</td>
                        <td>TI-2B</td>
                        <td>Teknik Informatika</td>
                        <td><i class="fa-solid fa-file foto-icon"></i></td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>3312411042</td>
                        <td>Angelica Jolie</td>
                        <td>TI-2B</td>
                        <td>Teknik Informatika</td>
                        <td><i class="fa-solid fa-file foto-icon"></i></td>
                    </tr>
                    <tr>
                        <td>005</td>
                        <td>3312311119</td>
                        <td>Mahesa</td>
                        <td>TI-1A</td>
                        <td>Teknik Informatika</td>
                        <td><i class="fa-solid fa-file foto-icon"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMahasiswaLabel">Tambah Mahasiswa</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="formTambahMahasiswa">
                        <div class="form-outline mb-4">
                            <input type="text" id="nim" class="form-control" required />
                            <label class="form-label" for="nim">NIM</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="nama" class="form-control" required />
                            <label class="form-label" for="nama">Nama Lengkap</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="kelas" class="form-control" required />
                            <label class="form-label" for="kelas">Kelas</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="jurusan" class="form-control" required />
                            <label class="form-label" for="jurusan">Jurusan</label>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Batal</button>
                    <button type="submit" form="formTambahMahasiswa" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
</body>

</html>