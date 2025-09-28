<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            background-image: radial-gradient(circle at 20% 80%, rgba(116, 24, 71, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(7, 55, 99, 0.15) 0%, transparent 50%);
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(116, 24, 71, 0.2);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
            margin-bottom: 20px;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: var(--subtext-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
        }
        
        .nav-item:hover, .nav-item.active {
            background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1));
            color: var(--text-dark);
            border-left: 3px solid var(--accent);
            transform: translateX(5px);
        }
        
        .nav-item .material-icons {
            margin-right: 10px;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover .material-icons {
            color: var(--accent);
            transform: scale(1.1);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            border: 2px solid var(--accent);
            position: relative;
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }
        
        .avatar:hover {
            transform: scale(1.05);
            animation: rotate-glow 3s linear infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(116, 24, 71, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(116, 24, 71, 0); }
            100% { box-shadow: 0 0 0 0 rgba(116, 24, 71, 0); }
        }
        
        @keyframes rotate-glow {
            0% { 
                box-shadow: 0 0 10px rgba(116, 24, 71, 0.7), 
                           0 0 20px rgba(116, 24, 71, 0.5),
                           0 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(0deg);
            }
            25% { 
                box-shadow: 10px 0 10px rgba(116, 24, 71, 0.7), 
                           20px 0 20px rgba(116, 24, 71, 0.5),
                           30px 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(90deg);
            }
            50% { 
                box-shadow: 0 10px 10px rgba(116, 24, 71, 0.7), 
                           0 20px 20px rgba(116, 24, 71, 0.5),
                           0 30px 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(180deg);
            }
            75% { 
                box-shadow: -10px 0 10px rgba(116, 24, 71, 0.7), 
                           -20px 0 20px rgba(116, 24, 71, 0.5),
                           -30px 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(270deg);
            }
            100% { 
                box-shadow: 0 0 10px rgba(116, 24, 71, 0.7), 
                           0 0 20px rgba(116, 24, 71, 0.5),
                           0 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(360deg);
            }
        }
        
        .user-details h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .user-details p {
            color: var(--subtext-dark);
            font-size: 0.9rem;
        }
        
        /* Glassmorphism Cards */
        .card {
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
            border-color: rgba(116, 24, 71, 0.4);
            background: rgba(7, 55, 99, 0.15);
        }
        
        /* Animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .page-subtitle {
            color: var(--subtext-dark);
            margin-bottom: 20px;
        }
        
        /* Filter Section */
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }
        
        .filter-label {
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .filter-select {
            background: rgba(7, 55, 99, 0.15);
            border: 1px solid rgba(116, 24, 71, 0.3);
            border-radius: 8px;
            padding: 10px 15px;
            color: var(--text-dark);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(116, 24, 71, 0.2);
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-dark);
        }
        
        .data-table th {
            background: rgba(7, 55, 99, 0.2);
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
        }
        
        .data-table td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(116, 24, 71, 0.1);
            transition: all 0.3s ease;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover td {
            background: rgba(7, 55, 99, 0.05);
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .status-approved {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }
        
        .status-rejected {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }
        
        .status-revision {
            background: rgba(255, 152, 0, 0.2);
            color: #ff9800;
            border: 1px solid rgba(255, 152, 0, 0.3);
        }
        
        /* Action Buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .action-detail {
            background: rgba(7, 55, 99, 0.2);
            color: var(--primary);
            border: 1px solid rgba(7, 55, 99, 0.3);
        }
        
        .action-detail:hover {
            background: rgba(7, 55, 99, 0.3);
            transform: translateY(-2px);
        }
        
        .action-download {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
            border: 1px solid rgba(76, 175, 80, 0.3);
            margin-left: 5px;
        }
        
        .action-download:hover {
            background: rgba(76, 175, 80, 0.3);
            transform: translateY(-2px);
        }
        
        .action-btn .material-icons {
            font-size: 16px;
            margin-right: 5px;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--subtext-dark);
        }
        
        .empty-state .material-icons {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.5;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            gap: 10px;
        }
        
        .pagination-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(7, 55, 99, 0.1);
            border: 1px solid rgba(116, 24, 71, 0.2);
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .pagination-btn:hover, .pagination-btn.active {
            background: rgba(7, 55, 99, 0.2);
            border-color: var(--accent);
        }
        
        /* Modal untuk konfirmasi navigasi */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }
        
        .modal-content {
            background: var(--bg-dark);
            padding: 30px;
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 1px solid var(--accent);
            animation: fadeInUp 0.4s ease;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .modal-btn.primary {
            background: var(--primary);
            color: white;
        }
        
        .modal-btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-dark);
        }
        
        .modal-btn:hover {
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar .logo h1, .sidebar .nav-text {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: 15px 0;
            }
            
            .nav-item .material-icons {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.sidebar-active {
                margin-left: 70px;
            }
            
            .filter-section {
                flex-direction: column;
            }
            
            .filter-group {
                min-width: 100%;
            }
            
            .data-table {
                font-size: 0.8rem;
            }
            
            .data-table th, .data-table td {
                padding: 10px 15px;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1000;
                background: var(--primary);
                color: white;
                border: none;
                border-radius: 5px;
                padding: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .menu-toggle:hover {
                transform: scale(1.1);
            }
        }
        
        /* Menu toggle untuk mobile */
        .menu-toggle {
            display: none;
        }
        
        /* Feedback animasi saat mengklik */
        .click-feedback {
            animation: clickEffect 0.3s ease;
        }
        
        @keyframes clickEffect {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Menu Toggle untuk Mobile -->
    <button class="menu-toggle material-icons" id="menuToggle">menu</button>

    <!-- Modal untuk konfirmasi navigasi -->
    <div class="modal" id="navigationModal">
        <div class="modal-content">
            <h3 id="modalTitle">Konfirmasi Navigasi</h3>
            <p id="modalMessage">Anda akan diarahkan ke halaman tertentu.</p>
            <div class="modal-buttons">
                <button class="modal-btn secondary" id="modalCancel">Batal</button>
                <button class="modal-btn primary" id="modalConfirm">Lanjutkan</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h1>CAKRA</h1>
        </div>
        <a href="#" class="nav-item" data-page="dashboard">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item" data-page="pengajuan">
            <span class="material-icons">description</span>
            <span class="nav-text">Pengajuan</span>
        </a>
        <a href="#" class="nav-item" data-page="lpj">
            <span class="material-icons">assignment</span>
            <span class="nav-text">LPJ</span>
        </a>
        <a href="#" class="nav-item active" data-page="riwayat">
            <span class="material-icons">history</span>
            <span class="nav-text">Riwayat</span>
        </a>
        <a href="#" class="nav-item" data-page="notifikasi">
            <span class="material-icons">notifications</span>
            <span class="nav-text">Notifikasi</span>
        </a>
        <a href="#" class="nav-item" data-page="pengaturan">
            <span class="material-icons">settings</span>
            <span class="nav-text">Pengaturan</span>
        </a>
        <a href="#" class="nav-item" data-page="keluar">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-info">
                <div class="avatar">
                    <span class="material-icons">person</span>
                </div>
                <div class="user-details">
                    <h2>Riwayat Pengajuan</h2>
                    <p>Lihat dan kelola semua pengajuan yang telah dibuat</p>
                </div>
            </div>
        </div>

        <div class="page-header">
            <h1 class="page-title">Riwayat Pengajuan</h1>
            <p class="page-subtitle">Daftar lengkap semua pengajuan kegiatan dan reimbursement yang telah Anda buat</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section card">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="statusFilter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu Validasi</option>
                    <option value="approved">Disetujui</option>
                    <option value="revision">Perlu Revisi</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Bulan</label>
                <select class="filter-select" id="monthFilter">
                    <option value="all">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Tahun</label>
                <select class="filter-select" id="yearFilter">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>
            </div>
            
            <div class="filter-group" style="align-self: flex-end;">
                <button class="filter-select" style="background: var(--accent); color: white; cursor: pointer;">
                    Terapkan Filter
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul Kegiatan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Total RAB</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="font-semibold">Seminar Nasional Teknologi</div>
                            <div class="text-sm text-gray-400">HIMA Teknik Informatika</div>
                        </td>
                        <td>15 September 2025</td>
                        <td>Rp 5.000.000</td>
                        <td>
                            <span class="status-badge status-pending">
                                <span class="material-icons" style="font-size: 14px; margin-right: 5px;">schedule</span>
                                Menunggu Validasi
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-btn action-detail" data-action="detail-pengajuan">
                                <span class="material-icons">visibility</span>
                                Detail
                            </a>
                            <a href="#" class="action-btn action-download" data-action="download-pengajuan">
                                <span class="material-icons">download</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-semibold">Pelatihan Leadership</div>
                            <div class="text-sm text-gray-400">BEM Fakultas</div>
                        </td>
                        <td>10 Agustus 2025</td>
                        <td>Rp 3.000.000</td>
                        <td>
                            <span class="status-badge status-approved">
                                <span class="material-icons" style="font-size: 14px; margin-right: 5px;">check_circle</span>
                                Disetujui
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-btn action-detail" data-action="detail-pengajuan">
                                <span class="material-icons">visibility</span>
                                Detail
                            </a>
                            <a href="#" class="action-btn action-download" data-action="download-pengajuan">
                                <span class="material-icons">download</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-semibold">Lomba Robotik Nasional</div>
                            <div class="text-sm text-gray-400">UKM Robotika</div>
                        </td>
                        <td>5 Juli 2025</td>
                        <td>Rp 7.500.000</td>
                        <td>
                            <span class="status-badge status-revision">
                                <span class="material-icons" style="font-size: 14px; margin-right: 5px;">warning</span>
                                Perlu Revisi
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-btn action-detail" data-action="detail-pengajuan">
                                <span class="material-icons">visibility</span>
                                Detail
                            </a>
                            <a href="#" class="action-btn action-download" data-action="download-pengajuan">
                                <span class="material-icons">download</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-semibold">Kunjungan Industri</div>
                            <div class="text-sm text-gray-400">HIMA Sistem Informasi</div>
                        </td>
                        <td>20 Juni 2025</td>
                        <td>Rp 4.200.000</td>
                        <td>
                            <span class="status-badge status-rejected">
                                <span class="material-icons" style="font-size: 14px; margin-right: 5px;">cancel</span>
                                Ditolak
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-btn action-detail" data-action="detail-pengajuan">
                                <span class="material-icons">visibility</span>
                                Detail
                            </a>
                            <a href="#" class="action-btn action-download" data-action="download-pengajuan">
                                <span class="material-icons">download</span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <a href="#" class="pagination-btn" data-action="pagination-prev">
                <span class="material-icons">chevron_left</span>
            </a>
            <a href="#" class="pagination-btn active" data-action="pagination-1">1</a>
            <a href="#" class="pagination-btn" data-action="pagination-2">2</a>
            <a href="#" class="pagination-btn" data-action="pagination-3">3</a>
            <a href="#" class="pagination-btn" data-action="pagination-next">
                <span class="material-icons">chevron_right</span>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const modal = document.getElementById('navigationModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const modalCancel = document.getElementById('modalCancel');
            const modalConfirm = document.getElementById('modalConfirm');
            
            let currentAction = null;
            
            // Toggle sidebar untuk mobile
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('sidebar-active');
                    this.classList.toggle('click-feedback');
                });
            }
            
            // Fungsi untuk menampilkan modal
            function showModal(title, message, action) {
                modalTitle.textContent = title;
                modalMessage.textContent = message;
                currentAction = action;
                modal.style.display = 'flex';
            }
            
            // Fungsi untuk menyembunyikan modal
            function hideModal() {
                modal.style.display = 'none';
                currentAction = null;
            }
            
            // Event listener untuk tombol modal
            modalCancel.addEventListener('click', hideModal);
            modalConfirm.addEventListener('click', function() {
                if (currentAction) {
                    // Simulasi navigasi (dalam implementasi nyata, ini akan mengarahkan ke halaman yang sesuai)
                    alert(`Akan mengarahkan ke: ${currentAction}`);
                    hideModal();
                    
                    // Jika navigasi ke halaman lain, update menu aktif
                    if (currentAction.startsWith('navigate-')) {
                        const targetPage = currentAction.replace('navigate-', '');
                        updateActiveNavItem(targetPage);
                    }
                }
            });
            
            // Fungsi untuk mengupdate menu aktif
            function updateActiveNavItem(page) {
                const navItems = document.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('data-page') === page) {
                        item.classList.add('active');
                    }
                });
            }
            
            // Event listener untuk item navigasi sidebar
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    
                    // Efek feedback klik
                    this.classList.add('click-feedback');
                    setTimeout(() => {
                        this.classList.remove('click-feedback');
                    }, 300);
                    
                    // Tampilkan modal konfirmasi
                    if (page === 'keluar') {
                        showModal('Konfirmasi Keluar', 'Apakah Anda yakin ingin keluar dari sistem?', 'logout');
                    } else {
                        showModal(`Navigasi ke ${page.charAt(0).toUpperCase() + page.slice(1)}`, 
                                 `Anda akan diarahkan ke halaman ${page}.`, `navigate-${page}`);
                    }
                });
            });
            
            // Event listener untuk tombol aksi di tabel
            const actionButtons = document.querySelectorAll('.action-btn, .pagination-btn');
            actionButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.getAttribute('data-action');
                    
                    this.classList.add('click-feedback');
                    setTimeout(() => {
                        this.classList.remove('click-feedback');
                    }, 300);
                    
                    if (action === 'detail-pengajuan') {
                        showModal('Detail Pengajuan', 'Menampilkan detail pengajuan yang dipilih.', action);
                    } else if (action === 'download-pengajuan') {
                        showModal('Download Berkas', 'Mengunduh berkas pengajuan.', action);
                    } else if (action.startsWith('pagination-')) {
                        showModal('Pindah Halaman', `Menampilkan halaman ${action.replace('pagination-', '')}.`, action);
                    }
                });
            });
            
            // Filter functionality
            const statusFilter = document.getElementById('statusFilter');
            const monthFilter = document.getElementById('monthFilter');
            const yearFilter = document.getElementById('yearFilter');
            
            // Simulasi filter (dalam implementasi nyata akan ada request ke server)
            function applyFilters() {
                // Di sini akan ada logika untuk memfilter data
                console.log('Filter diterapkan:', {
                    status: statusFilter.value,
                    month: monthFilter.value,
                    year: yearFilter.value
                });
            }
            
            // Event listeners untuk filter
            statusFilter.addEventListener('change', applyFilters);
            monthFilter.addEventListener('change', applyFilters);
            yearFilter.addEventListener('change', applyFilters);
            
            // Tutup modal saat klik di luar konten modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    hideModal();
                }
            });
        });
    </script>
</body>
</html>