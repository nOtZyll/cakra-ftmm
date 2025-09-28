<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf Fakultas - CAKRA</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Orbitron + Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* VARIABEL WARNA DAN TEMA CAKRA */
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
            --card-bg: rgba(7, 55, 99, 0.1);
        }

        /* STYLING DASAR CAKRA */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 0;
        }

        /* LAYOUT SIDEBAR DAN KONTEN UTAMA */
        .main-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 280px;
            background: rgba(7, 55, 99, 0.15);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(116, 24, 71, 0.2);
            padding: 1.5rem 1rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }

        .brand-wrap { 
            display: flex; 
            align-items: center; 
            gap: 12px;
            text-decoration: none;
            margin-bottom: 2rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .brand-wrap:hover {
            background: rgba(7, 55, 99, 0.2);
        }

        .brand-text { 
            display: flex; 
            flex-direction: column; 
            line-height: 1.2;
        }

        .brand-text .title { 
            font-weight: 700;
            font-size: 1.4rem;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
            animation: colorSweep 3s ease-in-out infinite;
        }

        .brand-text .subtitle { 
            font-size: 0.75rem; 
            color: var(--subtext-dark);
            font-weight: 400;
        }

        .nav-sidebar {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-sidebar .nav-link {
            color: var(--subtext-dark);
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(7, 55, 99, 0.2);
            color: var(--text-dark);
        }

        .nav-sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 4px 12px rgba(7, 55, 99, 0.3);
        }

        .nav-sidebar .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .toggle-sidebar {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            background: rgba(7, 55, 99, 0.2);
            border: 1px solid rgba(116, 24, 71, 0.2);
            color: var(--subtext-dark);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: rgba(7, 55, 99, 0.3);
            color: var(--text-dark);
        }

        /* KONTEN UTAMA */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* GLASSMORPHISM EFFECT */
        .glass-card {
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
        }

        /* BUTTON STYLING CAKRA */
        .btn-custom {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-family: 'Orbitron', sans-serif;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* ANIMATIONS */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* COLOR SWEEP ANIMATION */
        @keyframes colorSweep {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* STYLING KHUSUS DASHBOARD */
        .dashboard-container {
            padding: 0;
        }

        .dashboard-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: colorSweep 5s ease-in-out infinite;
        }

        .dashboard-subtitle {
            color: var(--subtext-dark);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            border-color: rgba(116, 24, 71, 0.4);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
            font-family: 'Orbitron', sans-serif;
            font-size: 1.3rem;
        }

        .table-custom {
            width: 100%;
            color: var(--text-dark);
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead th {
            background: rgba(7, 55, 99, 0.2);
            color: var(--subtext-dark);
            font-weight: 600;
            border-bottom: 1px solid rgba(116, 24, 71, 0.3);
            padding: 0.75rem;
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: rgba(7, 55, 99, 0.1);
        }

        .table-custom tbody td {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(116, 24, 71, 0.1);
        }

        .badge-custom {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            font-weight: 500;
            border-radius: 6px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .futuristic-icon {
            font-size: 2.4rem;
            color: #7ca2c5;
            text-shadow: 0 0 12px rgba(124, 162, 197, 0.7),
                         0 0 24px rgba(124, 162, 197, 0.5);
        }

        .futuristic-title {
            color: #7ca2c5;
            font-size: 1.3rem;
            text-shadow: 0 0 10px rgba(124, 162, 197, 0.8),
                         0 0 20px rgba(124, 162, 197, 0.4);
            letter-spacing: 0.5px;
            font-family: 'Orbitron', sans-serif;
        }

        .futuristic-subtitle {
            color: var(--subtext-dark);
            font-size: 0.95rem;
        }

        .futuristic-btn {
            background: linear-gradient(135deg, #7ca2c5, #a3c2e0);
            color: var(--bg-dark);
            font-weight: 600;
            border: none;
            border-radius: 0.5rem;
            padding: 6px 16px;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(124, 162, 197, 0.3);
            font-family: 'Orbitron', sans-serif;
            text-decoration: none;
            display: inline-block;
        }

        .futuristic-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(124, 162, 197, 0.6);
            color: var(--bg-dark);
        }

        .highlight-text {
            color: #7ca2c5;
            font-weight: 600;
        }

        .text-accent {
            color: var(--accent);
            font-weight: 600;
        }

        .action-btn {
            background: rgba(116, 24, 71, 0.2);
            color: var(--text-dark);
            border: 1px solid rgba(116, 24, 71, 0.3);
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn:hover {
            background: rgba(116, 24, 71, 0.3);
            color: var(--text-dark);
            transform: translateY(-1px);
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar .brand-text,
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link {
                justify-content: center;
                padding: 0.75rem;
            }
            
            .main-content {
                margin-left: 80px;
            }
            
            .toggle-sidebar {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 1.8rem;
            }
            
            .dashboard-subtitle {
                font-size: 1rem;
            }
            
            .sidebar {
                width: 60px;
            }
            
            .main-content {
                margin-left: 60px;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a class="brand-wrap" href="#">
                <div style="width: 42px; height: 42px; background: linear-gradient(135deg, var(--primary), var(--accent)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-calculator text-white"></i>
                </div>
                <span class="brand-text">
                    <span class="title">CAKRA</span>
                    <span class="subtitle">Staf Fakultas</span>
                </span>
            </a>

            <ul class="nav-sidebar">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('staf_fakultas.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staf_fakultas.verifikasi.rab', 1) }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Verifikasi RAB</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staf_fakultas.verifikasi.lpj', 1) }}">
                        <i class="bi bi-folder-check"></i>
                        <span>Verifikasi LPJ</span>
                    </a>
                </li>
            </ul>

            <div class="toggle-sidebar" id="toggleSidebar">
                <i class="bi bi-chevron-left"></i>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Dashboard Content -->
            <div id="dashboard-content">
                <h2 class="dashboard-title">Dashboard Staf Keuangan Fakultas</h2>
                <p class="dashboard-subtitle">Selamat datang kembali, <span class="highlight-text">{{ $user['name'] ?? 'Agus Fakultas' }}</span>!</p>

                <!-- Antrian -->
                <div class="row g-4">
                    <!-- RAB -->
                    <div class="col-lg-6">
                        <div class="dashboard-card h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-file-earmark-text me-2"></i> Antrian Verifikasi RAB
                                </h5>
                                <a href="{{ route('staf_fakultas.verifikasi.rab', 1) }}" class="action-btn">
                                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Pengajuan</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>Proposal Dies Natalis</div>
                                                <small class="text-muted">ORMAWA HMTI</small>
                                            </td>
                                            <td class="text-center">2 hari lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.rab', 1) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Reimbursement Lomba Robotik</div>
                                                <small class="text-muted">ORMAWA Robotika</small>
                                            </td>
                                            <td class="text-center">5 hari lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.rab', 2) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Kegiatan PKKMB 2024</div>
                                                <small class="text-muted">BEM Fakultas</small>
                                            </td>
                                            <td class="text-center">1 minggu lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.rab', 3) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- LPJ -->
                    <div class="col-lg-6">
                        <div class="dashboard-card h-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-folder-check me-2"></i> Antrian Verifikasi LPJ
                                </h5>
                                <a href="{{ route('staf_fakultas.verifikasi.lpj', 1) }}" class="action-btn">
                                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Pengajuan</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>Workshop IoT Mahasiswa</div>
                                                <small class="text-muted">ORMAWA HMTK</small>
                                            </td>
                                            <td class="text-center">3 hari lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.lpj', 1) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Seminar Energi Terbarukan</div>
                                                <small class="text-muted">BEM FTMM</small>
                                            </td>
                                            <td class="text-center">1 minggu lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.lpj', 2) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>Pelatihan Kewirausahaan</div>
                                                <small class="text-muted">HMJ Manajemen</small>
                                            </td>
                                            <td class="text-center">4 hari lalu</td>
                                            <td class="text-right">
                                                <a href="{{ route('staf_fakultas.verifikasi.lpj', 3) }}" class="action-btn">
                                                    Verifikasi
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cepat -->
                <div class="row mt-4 g-4">
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="bi bi-clock-history futuristic-icon mb-2"></i>
                            <h4 class="highlight-text">12</h4>
                            <p class="mb-0 futuristic-subtitle">Menunggu Verifikasi</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="bi bi-check-circle futuristic-icon mb-2"></i>
                            <h4 class="highlight-text">28</h4>
                            <p class="mb-0 futuristic-subtitle">Terverifikasi Bulan Ini</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="bi bi-currency-exchange futuristic-icon mb-2"></i>
                            <h4 class="highlight-text">Rp 245Jt</h4>
                            <p class="mb-0 futuristic-subtitle">Total Dana Disetujui</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="bi bi-building futuristic-icon mb-2"></i>
                            <h4 class="highlight-text">15</h4>
                            <p class="mb-0 futuristic-subtitle">ORMAWA Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = this.querySelector('i');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
            } else {
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-left');
            }
        });

        // Update active state di sidebar berdasarkan halaman saat ini
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Default active untuk dashboard jika di root
            if (currentPath === '/' || currentPath === '') {
                document.querySelector('.nav-link[href="{{ route('staf_fakultas.dashboard') }}"]').classList.add('active');
            }
        });
    </script>
</body>
</html>