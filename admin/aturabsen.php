<?php include 'navsideadmin.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Ruangan - Admin Polibatam</title>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

  <!-- MDB UI Kit -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f7f7f7;
    }

    .content {
      margin-left: 230px;
      margin-top: 90px;
      padding: 30px;
    }

    .table-container {
      background-color: #fff;
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      max-width: 950px;
      margin: 0 auto;
    }

    h3 {
      color: #0E2F80;
      font-weight: 600;
      margin-bottom: 25px;
    }

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

    .action-icons i {
      margin: 0 5px;
      cursor: pointer;
      color: #444;
      transition: 0.2s;
    }

    .action-icons i:hover {
      color: #0E2F80;
      transform: scale(1.15);
    }

    .loading {
      text-align: center;
      padding: 20px;
      color: #666;
    }

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

  <div class="content">
    <div class="table-container">
      <h3>Jadwal Ruangan</h3>
      <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#jadwalModal" onclick="resetForm()">
        <i class="fa-solid fa-plus"></i> Tambah Jadwal
      </button>

      <table class="table" id="jadwalTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Ruangan</th>
            <th>Mata Kuliah</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr>
            <td colspan="6" class="loading">
              <i class="fas fa-spinner fa-spin"></i> Memuat data...
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah/Edit -->
  <div class="modal fade" id="jadwalModal" tabindex="-1" aria-labelledby="jadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title" id="jadwalModalLabel">Tambah Jadwal</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <form id="formJadwal">
            <input type="hidden" id="jadwalId">

            <div class="mb-4">
              <label class="form-label" for="ruangan">Ruangan</label>
              <select class="form-select" id="ruangan" required>
                <option value="">Pilih Ruangan</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="form-label" for="matkul">Mata Kuliah</label>
              <input type="text" id="matkul" class="form-control" required />
            </div>

            <div class="mb-4">
              <label class="form-label" for="jamMasuk">Jam Masuk</label>
              <input type="time" id="jamMasuk" class="form-control" required />
            </div>

            <div class="mb-4">
              <label class="form-label" for="jamKeluar">Jam Keluar</label>
              <input type="time" id="jamKeluar" class="form-control" required />
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Batal</button>
          <button type="submit" form="formJadwal" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

  <script>
    const API_URL = "jadwal_api.php";
    const tableBody = document.getElementById("tableBody");
    const form = document.getElementById("formJadwal");
    const modalTitle = document.getElementById("jadwalModalLabel");
    const jadwalModal = document.getElementById("jadwalModal");
    let modalInstance;

    document.addEventListener("DOMContentLoaded", () => {
      modalInstance = new mdb.Modal(jadwalModal);
      loadRuangan();
      loadJadwal();
    });

    // ✅ Load daftar ruangan
    async function loadRuangan() {
      try {
        const res = await fetch(`${API_URL}?action=ruangan`);
        const result = await res.json();

        const select = document.getElementById("ruangan");
        select.innerHTML = '<option value="">Pilih Ruangan</option>';

        if (result.success) {
          result.data.forEach(r => {
            select.innerHTML += `<option value="${r.id_ruangan}">${r.nama_ruangan}</option>`;
          });
        } else {
          select.innerHTML = '<option disabled>Tidak ada ruangan</option>';
        }
      } catch (err) {
        console.error("Gagal load ruangan:", err);
        showAlert("Gagal memuat data ruangan", "danger");
      }
    }

    // ✅ Load daftar jadwal
    async function loadJadwal() {
      try {
        const res = await fetch(`${API_URL}?action=list`);
        const result = await res.json();

        if (result.success) displayJadwal(result.data);
        else tableBody.innerHTML = `<tr><td colspan="6" class="text-center">${result.message}</td></tr>`;
      } catch (err) {
        console.error("Gagal load jadwal:", err);
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>';
      }
    }

    function displayJadwal(data) {
      if (!data.length) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Belum ada jadwal</td></tr>';
        return;
      }

      tableBody.innerHTML = "";
      data.forEach((j, i) => {
        tableBody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${j.nama_ruangan}</td>
            <td>${j.mata_kuliah}</td>
            <td>${j.jam_masuk}</td>
            <td>${j.jam_keluar}</td>
            <td class="action-icons">
              <i class="fa-solid fa-pen-to-square" onclick="editJadwal(${j.id_jadwal})"></i>
              <i class="fa-solid fa-trash" onclick="deleteJadwal(${j.id_jadwal})"></i>
            </td>
          </tr>`;
      });
    }

    // ✅ Tambah / Update Jadwal
    form.addEventListener("submit", async e => {
      e.preventDefault();

      const id = document.getElementById("jadwalId").value;
      const data = {
        id_ruangan: document.getElementById("ruangan").value,
        mata_kuliah: document.getElementById("matkul").value,
        jam_masuk: document.getElementById("jamMasuk").value,
        jam_keluar: document.getElementById("jamKeluar").value,
      };

      const method = id ? "PUT" : "POST";
      const url = id ? `${API_URL}?action=update&id=${id}` : `${API_URL}?action=create`;

      try {
        const res = await fetch(url, {
          method,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data),
        });
        const result = await res.json();
        showAlert(result.message, result.success ? "success" : "danger");
        if (result.success) {
          modalInstance.hide();
          form.reset();
          loadJadwal();
        }
      } catch (err) {
        console.error("Error simpan jadwal:", err);
        showAlert("Gagal menyimpan data", "danger");
      }
    });

    // ✅ Edit Jadwal
    async function editJadwal(id) {
      try {
        const res = await fetch(`${API_URL}?action=detail&id=${id}`);
        const result = await res.json();
        if (result.success) {
          const j = result.data;
          document.getElementById("jadwalId").value = j.id_jadwal;
          document.getElementById("ruangan").value = j.id_ruangan;
          document.getElementById("matkul").value = j.mata_kuliah;
          document.getElementById("jamMasuk").value = j.jam_masuk;
          document.getElementById("jamKeluar").value = j.jam_keluar;
          modalTitle.textContent = "Edit Jadwal";
          modalInstance.show();
        }
      } catch (err) {
        console.error("Error edit:", err);
        showAlert("Gagal memuat data jadwal", "danger");
      }
    }

    // ✅ Delete Jadwal
    async function deleteJadwal(id) {
      if (!confirm("Yakin ingin menghapus jadwal ini?")) return;
      try {
        const res = await fetch(`${API_URL}?action=delete&id=${id}`, {
          method: "DELETE"
        });
        const result = await res.json();
        showAlert(result.message, result.success ? "success" : "danger");
        if (result.success) loadJadwal();
      } catch (err) {
        console.error("Error hapus:", err);
        showAlert("Gagal menghapus data", "danger");
      }
    }

    // ✅ Reset Form
    function resetForm() {
      form.reset();
      document.getElementById("jadwalId").value = "";
      modalTitle.textContent = "Tambah Jadwal";
    }

    // ✅ Alert notifikasi
    function showAlert(message, type) {
      const alert = document.createElement("div");
      alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
      alert.style.zIndex = "9999";
      alert.innerHTML = `${message}
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>`;
      document.body.appendChild(alert);
      setTimeout(() => alert.remove(), 3000);
    }
  </script>
</body>

</html>