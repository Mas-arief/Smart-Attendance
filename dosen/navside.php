<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Dosen - RKM</title>

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

        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-icon {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .user-icon:hover {
            transform: scale(1.1);
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
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-menu-custom.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .dropdown-item-custom:hover {
            background-color: #f0f0f0;
        }

        .dropdown-item-custom i {
            margin-right: 10px;
            width: 18px;
            text-align: center;
            color: #0E2F80;
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
                <h4>Selamat Datang, Dosen</h4>
                <p id="datetime"></p>
            </div>
        </div>
        
        <!-- User Dropdown -->
        <div class="user-dropdown">
            <i class="fa-solid fa-user fa-lg text-primary user-icon" id="userIcon"></i>
            <div class="dropdown-menu-custom" id="userDropdown">
                <a href="ganti_password.php" class="dropdown-item-custom">
                    <i class="fas fa-key"></i>
                    <span>Ganti Password</span>
                </a>
            </div>
        </div>
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

        // User Dropdown Toggle
        const userIcon = document.getElementById('userIcon');
        const userDropdown = document.getElementById('userDropdown');

        userIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userIcon.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
    </script>
</body>

</html>