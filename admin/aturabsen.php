<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Ruangan - Admin Polibatam</title>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

  <!-- MDB UI Kit CSS -->
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
      background-color: #ffffff;
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

  <!-- Modal Tambah/Edit Jadwal -->
  <div class="modal fade" id="jadwalModal" tabindex="-1" aria-labelledby="jadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header">
          <h5 class="modal-title" id="jadwalModalLabel">Tambah Jadwal</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form id="formJadwal">
            <input type="hidden" id="jadwalId" value="">

            <div class="form-outline mb-4">
              <select class="form-select" id="ruangan" required>
                <option value="">Pilih Ruangan</option>
              </select>
              <label class="form-label" for="ruangan">Ruangan</label>
            </div>

            <div class="form-outline mb-4">
              <input type="text" id="matkul" class="form-control" required />
              <label class="form-label" for="matkul">Mata Kuliah</label>
            </div>

            <div class="form-outline mb-4">
              <input type="time" id="jamMasuk" class="form-control" required />
              <label class="form-label" for="jamMasuk">Jam Masuk</label>
            </div>

            <div class="form-outline mb-4">
              <input type="time" id="jamKeluar" class="form-control" required />
              <label class="form-label" for="jamKeluar">Jam Keluar</label>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Batal</button>
          <button type="submit" form="formJadwal" class="btn btn-primary" id="saveBtn">
            <i class="fas fa-save"></i> Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- JS: JQuery + Popper + MDB -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

  <script>
    const API_URL = 'jadwal_api.php';
    const tableBody = document.getElementById("tableBody");
    const form = document.getElementById("formJadwal");
    const modalTitle = document.getElementById("jadwalModalLabel");
    const jadwalModal = document.getElementById("jadwalModal");
    let modalInstance;

    // Inisialisasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      loadRuangan();
      loadJadwal();
      modalInstance = new mdb.Modal(jadwalModal);
    });

    // Load daftar ruangan untuk dropdown
    async function loadRuangan() {
      try {
        const response = await fetch(`${API_URL}?action=ruangan`);
        const result = await response.json();

        if (result.success) {
          const select = document.getElementById('ruangan');
          select.innerHTML = '<option value="">Pilih Ruangan</option>';

          result.data.forEach(ruangan => {
            select.innerHTML += `<option value="${ruangan.id_ruangan}">${ruangan.nama_ruangan}</option>`;
          });
        }
      } catch (error) {
        console.error('Error loading ruangan:', error);
        showAlert('Gagal memuat data ruangan', 'danger');
      }
    }

    // Load semua jadwal
    async function loadJadwal() {
      try {
        const response = await fetch(`${API_URL}?action=list`);
        const result = await response.json();

        if (result.success) {
          displayJadwal(result.data);
        } else {
          tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${result.message}</td></tr>`;
        }
      } catch (error) {
        console.error('Error loading jadwal:', error);
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>';
      }
    }

    // Tampilkan jadwal ke tabel
    function displayJadwal(jadwalList) {
      if (jadwalList.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Belum ada jadwal</td></tr>';
        return;
      }

      tableBody.innerHTML = '';
      jadwalList.forEach((jadwal, index) => {
        const row = tableBody.insertRow();
        row.innerHTML = `
          <td>${index + 1}.</td>
          <td>${jadwal.nama_ruangan}</td>
          <td>${jadwal.mata_kuliah}</td>
          <td>${jadwal.jam_masuk}</td>
          <td>${jadwal.jam_keluar}</td>
          <td class="action-icons">
            <i class="fa-solid fa-pen-to-square edit-btn" onclick="editJadwal(${jadwal.id_jadwal})"></i>
            <i class="fa-solid fa-circle-xmark delete-btn" onclick="deleteJadwal(${jadwal.id_jadwal})"></i>
          </td>
        `;
      });
    }

    // Submit form (tambah atau edit)
    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const jadwalId = document.getElementById('jadwalId').value;
      const data = {
        id_ruangan: document.getElementById('ruangan').value,
        mata_kuliah: document.getElementById('matkul').value,
        jam_masuk: document.getElementById('jamMasuk').value,
        jam_keluar: document.getElementById('jamKeluar').value
      };

      try {
        let url = `${API_URL}?action=create`;
        let method = 'POST';

        if (jadwalId) {
          url = `${API_URL}?action=update&id=${jadwalId}`;
          method = 'PUT';
        }

        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
          showAlert(result.message, 'success');
          modalInstance.hide();
          loadJadwal();
          form.reset();
        } else {
          showAlert(result.message, 'danger');
        }
      } catch (error) {
        console.error('Error saving jadwal:', error);
        showAlert('Gagal menyimpan data', 'danger');
      }
    });

    // Edit jadwal
    async function editJadwal(id) {
      try {
        const response = await fetch(`${API_URL}?action=detail&id=${id}`);
        const result = await response.json();

        if (result.success) {
          const jadwal = result.data;
          document.getElementById('jadwalId').value = jadwal.id_jadwal;
          document.getElementById('ruangan').value = jadwal.id_ruangan;
          document.getElementById('matkul').value = jadwal.mata_kuliah;
          document.getElementById('jamMasuk').value = jadwal.jam_masuk;
          document.getElementById('jamKeluar').value = jadwal.jam_keluar;
          modalTitle.textContent = "Edit Jadwal";

          modalInstance.show();
        }
      } catch (error) {
        console.error('Error loading jadwal detail:', error);
        showAlert('Gagal memuat data jadwal', 'danger');
      }
    }

    // Hapus jadwal
    async function deleteJadwal(id) {
      if (!confirm('Yakin ingin menghapus jadwal ini?')) return;

      try {
        const response = await fetch(`${API_URL}?action=delete&id=${id}`, {
          method: 'DELETE'
        });

        const result = await response.json();

        if (result.success) {
          showAlert(result.message, 'success');
          loadJadwal();
        } else {
          showAlert(result.message, 'danger');
        }
      } catch (error) {
        console.error('Error deleting jadwal:', error);
        showAlert('Gagal menghapus data', 'danger');
      }
    }

    // Reset form
    function resetForm() {
      form.reset();
      document.getElementById('jadwalId').value = '';
      modalTitle.textContent = "Tambah Jadwal";
    }

    // Show alert notification
    function showAlert(message, type) {
      const alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
      alertDiv.style.zIndex = '9999';
      alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-mdb-dismiss="alert"></button>
      `;
      document.body.appendChild(alertDiv);

      setTimeout(() => {
        alertDiv.remove();
      }, 3000);
    }
  </script>
</body>

</html>