<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin Polibatam</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- MDB UI Kit -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            gap: 30px;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding-top: 100px;
        }

        .stat-card {
            background-color: #e0e0e0;
            border-radius: 20px;
            width: 250px;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-title {
            font-size: 18px;
            color: #000;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stat-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #000;
        }

        .stat-icon {
            font-size: 28px;
            color: #000;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
                align-items: center;
                padding-top: 80px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'navsideadmin.php'; ?>

    <!-- Konten utama -->
    <div class="stat-card">
        <div class="stat-title">Total Mahasiswa</div>
        <div class="stat-bottom">
            <div class="stat-number">240</div>
            <i class="fa-solid fa-user-graduate stat-icon"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Total Dosen</div>
        <div class="stat-bottom">
            <div class="stat-number">15</div>
            <i class="fa-solid fa-chalkboard-teacher stat-icon"></i>
        </div>
    </div>

    <!-- Card baru: Total Ruangan -->
    <div class="stat-card" id="ruanganCard">
        <div class="stat-title">Total Ruangan</div>
        <div class="stat-bottom">
            <div class="stat-number" id="totalRuangan">12</div>
            <i class="fa-solid fa-door-open stat-icon"></i>
        </div>
    </div>

    <!-- Modal Daftar Ruangan -->
    <div class="modal fade" id="ruanganModal" tabindex="-1" aria-labelledby="ruanganModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="ruanganModalLabel"><i class="fa-solid fa-door-open me-2"></i>Daftar Ruangan</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tombol Tambah -->
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="fw-bold">List Ruangan</h6>
                        <button class="btn btn-success btn-sm" id="btnTambahRuangan"><i class="fa-solid fa-plus me-1"></i>Tambah
                            Ruangan</button>
                    </div>

                    <!-- Tabel Ruangan -->
                    <table class="table table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Ruangan</th>
                            </tr>
                        </thead>
                        <tbody id="tabelRuangan">
                            <tr>
                                <td>1</td>
                                <td>Lab Komputer 1</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Lab Komputer 2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Ruang Kelas A201</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Form Tambah Ruangan (disembunyikan awalnya) -->
                    <div id="formTambahRuangan" class="mt-4" style="display:none;">
                        <h6 class="fw-bold mb-3">Tambah Ruangan Baru</h6>
                        <div class="form-outline mb-3">
                            <input type="text" id="namaRuangan" class="form-control" />
                            <label class="form-label" for="namaRuangan">Nama Ruangan</label>
                        </div>
                        <button class="btn btn-primary btn-sm" id="simpanRuangan"><i
                                class="fa-solid fa-save me-1"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
    <script>
        const ruanganCard = document.getElementById("ruanganCard");
        const ruanganModal = new mdb.Modal(document.getElementById("ruanganModal"));
        const btnTambah = document.getElementById("btnTambahRuangan");
        const formTambah = document.getElementById("formTambahRuangan");
        const simpanBtn = document.getElementById("simpanRuangan");
        const tabelRuangan = document.getElementById("tabelRuangan");
        const totalRuangan = document.getElementById("totalRuangan");

        // Klik card membuka modal
        ruanganCard.addEventListener("click", () => {
            ruanganModal.show();
        });

        // Klik tombol "Tambah Ruangan"
        btnTambah.addEventListener("click", () => {
            formTambah.style.display = formTambah.style.display === "none" ? "block" : "none";
        });

        // Simpan data ruangan baru
        simpanBtn.addEventListener("click", () => {
            const nama = document.getElementById("namaRuangan").value.trim();

            if (!nama) {
                alert("Mohon isi nama ruangan sebelum menyimpan!");
                return;
            }

            const newRow = document.createElement("tr");
            const rowCount = tabelRuangan.rows.length + 1;

            newRow.innerHTML = `
        <td>${rowCount}</td>
        <td>${nama}</td>
      `;

            tabelRuangan.appendChild(newRow);
            document.getElementById("namaRuangan").value = "";
            formTambah.style.display = "none";

            // Update total ruangan
            totalRuangan.textContent = tabelRuangan.rows.length;
        });
    </script>

</body>

</html>