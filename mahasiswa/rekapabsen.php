<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Mahasiswa</title>

    <!-- Font Awesome & Google Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #1f2937;
            line-height: 1.6;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 100px 40px 40px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(135deg, #0E2F80 0%, #1e40af 100%);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 32px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .page-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header p {
            color: #e0e7ff;
            font-size: 14px;
            font-weight: 400;
        }

        /* Filter Section */
        .filter-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .filter-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-group label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            white-space: nowrap;
        }

        .filter-group select {
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            background-color: #ffffff;
            color: #1f2937;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 200px;
        }

        .filter-group select:hover {
            border-color: #0E2F80;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #0E2F80;
            box-shadow: 0 0 0 3px rgba(14, 47, 128, 0.1);
        }

        /* Legend Section */
        .legend-section {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .legend-title {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 12px;
        }

        .legend-items {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-dot.hadir {
            background-color: #10b981;
        }

        .legend-dot.izin {
            background-color: #f59e0b;
        }

        .legend-dot.sakit {
            background-color: #8b5cf6;
        }

        .legend-dot.alfa {
            background-color: #ef4444;
        }

        /* Table Container */
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 600px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 1200px;
        }

        thead {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #0E2F80;
        }

        th {
            background-color: #0E2F80;
            color: #ffffff;
            padding: 16px 12px;
            font-weight: 600;
            text-align: center;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th:last-child {
            border-right: none;
        }

        th.kiri {
            text-align: left;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #f3f4f6;
            text-align: center;
            font-size: 13px;
        }

        td:last-child {
            border-right: none;
        }

        td.kiri {
            text-align: left;
            font-weight: 500;
        }

        td.kode-mk {
            font-weight: 600;
            color: #0E2F80;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 12px;
            white-space: nowrap;
        }

        .hadir {
            background-color: #d1fae5;
            color: #065f46;
        }

        .izin {
            background-color: #fed7aa;
            color: #92400e;
        }

        .sakit {
            background-color: #e9d5ff;
            color: #5b21b6;
        }

        .alfa {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Week Headers Styling */
        .week-header {
            font-size: 11px;
            padding: 12px 8px !important;
            min-width: 70px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 220px;
                padding: 90px 24px 32px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            table {
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 80px 16px 24px;
            }

            .page-header {
                padding: 24px;
                border-radius: 12px;
            }

            .page-header h1 {
                font-size: 20px;
            }

            .filter-section {
                padding: 16px;
            }

            .filter-group select {
                min-width: 150px;
            }

            .legend-items {
                gap: 16px;
            }

            th,
            td {
                padding: 10px 8px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .page-header h1 {
                font-size: 18px;
            }

            .filter-group {
                width: 100%;
            }

            .filter-group select {
                width: 100%;
                min-width: auto;
            }

            .legend-items {
                flex-direction: column;
                gap: 8px;
            }
        }

        /* Scrollbar Styling */
        .table-wrapper::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body>
    <!-- Sidebar & Navbar -->
    <?php include 'navside.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>
                <i class="fa-solid fa-calendar-check"></i>
                Rekap Kehadiran Mahasiswa
            </h1>
            <p>Pantau kehadiran Anda di setiap pertemuan mata kuliah per semester</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="tahun">
                        <i class="fa-solid fa-calendar"></i> Tahun Ajaran
                    </label>
                    <select id="tahun">
                        <option value="2024-1" selected>2024 Ganjil (1)</option>
                        <option value="2024-2">2024 Genap (2)</option>
                        <option value="2023-2">2023 Genap (2)</option>
                        <option value="2023-1">2023 Ganjil (1)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Legend Section -->
        <div class="legend-section">
            <div class="legend-title">Keterangan Status:</div>
            <div class="legend-items">
                <div class="legend-item">
                    <span class="legend-dot hadir"></span>
                    <span>Hadir</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot izin"></span>
                    <span>Izin</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot sakit"></span>
                    <span>Sakit</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot alfa"></span>
                    <span>Alfa (Tanpa Keterangan)</span>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="min-width: 100px;">KODE MK</th>
                            <th class="kiri" style="min-width: 250px;">MATA KULIAH</th>
                            <th style="min-width: 150px;">JENIS</th>
                            <th class="week-header">W1</th>
                            <th class="week-header">W2</th>
                            <th class="week-header">W3</th>
                            <th class="week-header">W4</th>
                            <th class="week-header">W5</th>
                            <th class="week-header">W6</th>
                            <th class="week-header">W7</th>
                            <th class="week-header">W8</th>
                            <th class="week-header">W9</th>
                            <th class="week-header">W10</th>
                            <th class="week-header">W11</th>
                            <th class="week-header">W12</th>
                            <th class="week-header">W13</th>
                            <th class="week-header">W14</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="kode-mk">IF101</td>
                            <td class="kiri">Pengantar Proyek Perangkat Lunak</td>
                            <td>Teori & Praktikum</td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge izin">Izin</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge sakit">Sakit</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                        </tr>

                        <tr>
                            <td class="kode-mk">IF102</td>
                            <td class="kiri">Pengantar Teknologi Informasi</td>
                            <td>Teori & Praktikum</td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge alfa">Alfa</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge sakit">Sakit</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge izin">Izin</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                        </tr>

                        <tr>
                            <td class="kode-mk">IF103</td>
                            <td class="kiri">Dasar Pemrograman Web</td>
                            <td>Teori & Praktikum</td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge izin">Izin</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge sakit">Sakit</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                            <td><span class="status-badge hadir">Hadir</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>