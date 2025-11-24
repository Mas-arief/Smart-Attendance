<?php
session_start();
include "../koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
  header("Location: ../login.php");
  exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data mahasiswa
$query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id_user='$id_user' LIMIT 1");
$mahasiswa = mysqli_fetch_assoc($query);

// Jika gagal ambil data
if (!$mahasiswa) {
  $mahasiswa = [
    'nama_mahasiswa' => 'Mahasiswa'
  ];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Mahasiswa - RKM</title>

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- MDB UI Kit -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet" />

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f7f7f7;
      transition: all 0.3s ease;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 230px;
      height: 100vh;
      background-color: #0E2F80;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      z-index: 999;
      transition: all 0.3s ease;
    }

    .sidebar.collapsed {
      width: 70px;
      align-items: center;
      padding: 20px 10px;
    }

    .sidebar-header {
      display: flex;
      align-items: center;
      width: 100%;
      margin-bottom: 30px;
    }

    .sidebar-header img {
      height: 45px;
      margin-right: 10px;
    }

    .sidebar.collapsed .sidebar-title {
      display: none;
    }

    .sidebar-title h5 {
      margin: 0;
      font-size: 18px;
      font-weight: 700;
    }

    .sidebar-title p {
      margin: 0;
      font-size: 12px;
      color: #dcdcdc;
    }

    .sidebar-menu {
      list-style: none;
      padding: 0;
      width: 100%;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      font-weight: 500;
      border-left: 4px solid transparent;
      transition: 0.3s;
    }

    .sidebar-menu a:hover {
      background-color: rgba(255, 255, 255, 0.15);
      border-left: 4px solid #fff;
    }

    .sidebar-menu a span {
      white-space: nowrap;
    }

    .sidebar-menu a i {
      margin-right: 12px;
      width: 18px;
    }

    .sidebar.collapsed a span {
      display: none;
    }

    /* NAVBAR BARU */
    .navbar {
      position: fixed;
      top: 0;
      left: 230px;
      right: 0;
      height: 65px;
      background: #ffffff;
      display: flex;
      align-items: center;
      padding: 0 25px;
      gap: 15px;
      border-bottom: 1px solid #e5e5e5;
      z-index: 900;
      transition: 0.3s ease;
    }

    .navbar.collapsed {
      left: 70px;
    }

    .menu-toggle {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #0E2F80;
    }

    /* Agar nama mahasiswa tidak melebar dan lebih rapat */
    .navbar-text {
      display: flex;
      flex-direction: column;
      justify-content: center;
      line-height: 1.2;
    }

    .navbar-text h4 {
      margin: 0;
      font-size: 19px;
      font-weight: 700;
      white-space: nowrap;
      /* supaya nama tidak turun ke bawah */
    }

    .navbar-text p {
      margin: 0;
      font-size: 12.5px;
      color: #6d6d6d;
      margin-top: -2px;
      /* rapetin */
    }



    /* Profil Dropdown */
    .nav-icons {
      display: flex;
      align-items: center;
      gap: 20px;
      position: relative;
    }

    .icon-btn {
      font-size: 20px;
      color: #0E2F80;
      cursor: pointer;
    }

    .dropdown-menu-custom {
      position: absolute;
      top: 45px;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      min-width: 200px;
      display: none;
      overflow: hidden;
    }

    .dropdown-menu-custom.show {
      display: block;
      animation: fadeIn .2s ease;
    }

    .dropdown-item-custom {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #333;
      transition: 0.2s;
    }

    .dropdown-item-custom:hover {
      background: #eee;
    }

    .dropdown-item-custom i {
      margin-right: 12px;
      color: #0E2F80;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="../image/poli.png">
      <div class="sidebar-title">
        <h5>RKM</h5>
        <p>Rekap Kehadiran Mahasiswa</p>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
      <hr>
      <li><a href="registrasiface.php"><i class="fas fa-camera"></i> <span>Registrasi Wajah</span></a></li>
      <hr>
      <li><a href="rekapabsen.php"><i class="fas fa-clipboard-list"></i> <span>Rekap Absen</span></a></li>
    </ul>
  </div>

  <!-- Navbar -->
  <div class="navbar" id="navbar">
    <div class="d-flex align-items-center gap-3">
      <button class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars"></i>
      </button>

      <div class="navbar-text">
        <h4>Selamat Datang, <?= $mahasiswa['nama_mahasiswa'] ?></h4>
        <p id="datetime"></p>
      </div>
    </div>

    <div class="nav-icons">
      <i class="fa-solid fa-user icon-btn" id="userIcon"></i>
      <div class="dropdown-menu-custom" id="userDropdown">
        <a href="ganti_password.php" class="dropdown-item-custom">
          <i class="fas fa-key"></i> Ganti Password
        </a>
        <a class="dropdown-menu-custom">
          <i class="fa-solid fa-right-from-bracket icon-btn" id="logoutBtn"></i>Logout
        </a>  
      </div>
    </div>
  </div>


  <!-- Script -->
  <script>
    // Waktu realtime
    function updateDateTime() {
      const now = new Date();
      const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });
      const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
      });
      document.getElementById('datetime').textContent = `${date}, ${time}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 60000);

    // Sidebar Toggle
    document.getElementById('menu-toggle').addEventListener('click', () => {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('navbar').classList.toggle('collapsed');
    });

    // Dropdown Profil
    const userIcon = document.getElementById('userIcon');
    const dropdown = document.getElementById('userDropdown');

    userIcon.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdown.classList.toggle('show');
    });

    document.addEventListener('click', () => {
      dropdown.classList.remove('show');
    });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', () => {
      if (confirm("Keluar dari akun mahasiswa?")) {
        window.location.href = "../logout.php";
      }
    });
  </script>

</body>

</html>