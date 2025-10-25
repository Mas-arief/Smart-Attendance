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
      <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#jadwalModal">
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
        <tbody>
          <tr>
            <td>1.</td>
            <td>GU 702</td>
            <td>Basis Data</td>
            <td>19.00</td>
            <td>20.30</td>
            <td class="action-icons">
              <i class="fa-solid fa-pen-to-square edit-btn"></i>
              <i class="fa-solid fa-circle-xmark delete-btn"></i>
            </td>
          </tr>
          <tr>
            <td>2.</td>
            <td>GU 806</td>
            <td>Proyek Agile</td>
            <td>18.30</td>
            <td>20.20</td>
            <td class="action-icons">
              <i class="fa-solid fa-pen-to-square edit-btn"></i>
              <i class="fa-solid fa-circle-xmark delete-btn"></i>
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
            <div class="form-outline mb-3">
              <input type="text" id="ruangan" class="form-control" required />
              <label class="form-label" for="ruangan">Ruangan</label>
            </div>
            <div class="form-outline mb-3">
              <input type="text" id="matkul" class="form-control" required />
              <label class="form-label" for="matkul">Mata Kuliah</label>
            </div>
            <div class="form-outline mb-3">
              <input type="text" id="jamMasuk" class="form-control" required />
              <label class="form-label" for="jamMasuk">Jam Masuk</label>
            </div>
            <div class="form-outline mb-3">
              <input type="text" id="jamKeluar" class="form-control" required />
              <label class="form-label" for="jamKeluar">Jam Keluar</label>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Batal</button>
          <button type="submit" form="formJadwal" class="btn btn-primary" id="saveBtn">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <!-- JS: JQuery + Popper + MDB -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

  <script>
    const tableBody = document.querySelector("#jadwalTable tbody");
    const form = document.getElementById("formJadwal");
    const modalTitle = document.getElementById("jadwalModalLabel");
    let editRow = null;

    // Tambah atau Edit Jadwal
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      const ruangan = document.getElementById("ruangan").value;
      const matkul = document.getElementById("matkul").value;
      const jamMasuk = document.getElementById("jamMasuk").value;
      const jamKeluar = document.getElementById("jamKeluar").value;

      if (editRow) {
        editRow.cells[1].textContent = ruangan;
        editRow.cells[2].textContent = matkul;
        editRow.cells[3].textContent = jamMasuk;
        editRow.cells[4].textContent = jamKeluar;
        editRow = null;
      } else {
        const newRow = tableBody.insertRow();
        newRow.innerHTML = `
          <td>${tableBody.rows.length}.</td>
          <td>${ruangan}</td>
          <td>${matkul}</td>
          <td>${jamMasuk}</td>
          <td>${jamKeluar}</td>
          <td class="action-icons">
            <i class="fa-solid fa-pen-to-square edit-btn"></i>
            <i class="fa-solid fa-circle-xmark delete-btn"></i>
          </td>`;
      }

      form.reset();
      const modalInstance = mdb.Modal.getInstance(document.getElementById("jadwalModal"));
      modalInstance.hide();
      updateEventListeners();
    });

    // Fungsi Edit & Hapus
    function updateEventListeners() {
      document.querySelectorAll(".edit-btn").forEach(btn => {
        btn.onclick = function () {
          const row = this.closest("tr");
          editRow = row;
          document.getElementById("ruangan").value = row.cells[1].textContent;
          document.getElementById("matkul").value = row.cells[2].textContent;
          document.getElementById("jamMasuk").value = row.cells[3].textContent;
          document.getElementById("jamKeluar").value = row.cells[4].textContent;
          modalTitle.textContent = "Edit Jadwal";
          const modal = new mdb.Modal(document.getElementById("jadwalModal"));
          modal.show();
        };
      });

      document.querySelectorAll(".delete-btn").forEach(btn => {
        btn.onclick = function () {
          const row = this.closest("tr");
          row.remove();
          renumberRows();
        };
      });
    }

    function renumberRows() {
      [...tableBody.rows].forEach((row, i) => {
        row.cells[0].textContent = `${i + 1}.`;
      });
    }

    updateEventListeners();
  </script>
</body>

</html>
