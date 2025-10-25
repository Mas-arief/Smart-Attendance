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
            justify-content: flex-start;
            width: 100%;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .sidebar-header img {
            height: 45px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header h5,
        .sidebar.collapsed .sidebar-header p {
            display: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            width: 100%;
            transition: all 0.3s ease;
        }

        .sidebar-menu li {
            width: 100%;
            text-align: left;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            white-space: nowrap;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #ffffff;
        }

        .sidebar-menu a i {
            margin-right: 10px;
            width: 18px;
            text-align: center;
        }

        .sidebar.collapsed a span {
            display: none;
        }

        /* Navbar */
        .navbar {
            background-color: #ffffff;
            position: fixed;
            left: 230px;
            right: 0;
            top: 0;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 900;
            transition: all 0.3s ease;
        }

        .navbar.collapsed {
            left: 70px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #0E2F80;
        }

        .navbar h4 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
            color: #000;
        }

        .navbar p {
            font-size: 13px;
            margin: 0;
            color: #666;
        }

        @media (max-width: 991px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar {
                left: 0;
            }

            .navbar.collapsed {
                left: 0;
            }
        }

        .sidebar-title h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }

        .sidebar-title p {
            margin: 0;
            font-size: 12px;
            color: #dcdcdc;
            letter-spacing: 0.3px;
        }

        .sidebar.collapsed .sidebar-title {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="../image/poli.png" alt="Logo Polibatam">
            <div class="sidebar-title">
                <h5>RKM</h5>
                <p>Rekap Kehadiran Mahasiswa</p>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i><span> Home</span></a></li>
            <hr>
            <li><a href="registrasiface.php"><i class="fas fa-camera"></i><span> Registrasi Wajah</span></a></li>
            <hr>
            <li><a href="rekapabsen.php"><i class="fas fa-clipboard-list"></i><span> Rekap Absen</span></a></li>
            <hr>
            <li><a href="login.php" id="logoutBtn"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
        </ul>
    </div>

    <!-- Navbar -->
    <div class="navbar" id="navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></button>
            <div>
                <h4>Selamat Datang, Mahasiswa</h4>
                <p id="datetime"></p>
            </div>
        </div>
        <i class="fa-solid fa-user fa-lg text-primary"></i>
    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>
    <script>
        // Update waktu realtime
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            const date = now.toLocaleDateString('id-ID', options);
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('datetime').textContent = `${date}, ${time}`;
        }
        updateDateTime();
        setInterval(updateDateTime, 60000);

        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const toggleBtn = document.getElementById('menu-toggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
        });

        // Konfirmasi Logout
        document.getElementById('logoutBtn').addEventListener('click', (e) => {
            e.preventDefault();
            const confirmLogout = confirm('Apakah Anda yakin ingin keluar dari akun mahasiswa?');
            if (confirmLogout) {
                window.location.href = 'login.php';
            }
        });
    </script>
</body>

</html>