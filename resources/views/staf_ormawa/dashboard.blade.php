<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengajuan Dana</title>
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
            z-index: 1000;
        }
        
        .logo {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .menu {
            list-style: none;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: var(--subtext-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
        }
        
        .menu-item:hover, .menu-item.active {
            background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1));
            color: var(--text-dark);
            border-left: 3px solid var(--accent);
            transform: translateX(5px);
        }
        
        .menu-item .material-icons {
            margin-right: 10px;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover .material-icons {
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
            position: relative;
            z-index: 10;
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
        
        /* Glassmorphism Card */
        .glass-card {
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
            border-color: rgba(116, 24, 71, 0.4);
            background: rgba(7, 55, 99, 0.15);
        }
        
        /* Stats Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            text-align: center;
            padding: 20px;
        }
        
        .stat-card h3 {
            font-size: 0.9rem;
            color: var(--subtext-dark);
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .stat-card .number {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid rgba(116, 24, 71, 0.5);
        }
        
        .table td {
            padding: 12px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status.menunggu {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 6px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-dark);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: var(--text-dark);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(116, 24, 71, 0.2);
        }
        
        /* Content Sections */
        .content-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        .content-section.active {
            display: block;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            
            .sidebar .menu-text {
                display: none;
            }
            
            .menu-item {
                justify-content: center;
                padding: 15px 0;
            }
            
            .menu-item .material-icons {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.sidebar-active {
                margin-left: 70px;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
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

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">CAKRA</div>
        <ul class="menu">
            <li class="menu-item active" data-target="dashboard">
                <span class="material-icons">history</span>
                <span class="menu-text">Riwayat</span>
            </li>
            <li class="menu-item" data-target="screening">
                <span class="material-icons">check_circle</span>
                <span class="menu-text">Screening</span>
            </li>
            <li class="menu-item" id="logout-btn">
                <span class="material-icons">logout</span>
                <span class="menu-text">Log Out</span>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Dashboard Section -->
        <div class="content-section active" id="dashboard">
            <div class="header">
                <h1 style="font-size: 1.8rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Antrian Screening Pengajuan
                </h1>
                <div class="user-info">
                    <div class="avatar">
                        <span class="material-icons">person</span>
                    </div>
                    <div>
                        <h2 style="font-size: 1.3rem; font-weight: 600;">Admin</h2>
                        <p style="color: var(--subtext-dark); font-size: 0.9rem;">Role: Admin Screening</p>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats">
                <div class="glass-card stat-card">
                    <h3>Total Pengajuan</h3>
                    <div class="number">24</div>
                </div>
                <div class="glass-card stat-card">
                    <h3>Menunggu Screening</h3>
                    <div class="number">8</div>
                </div>
                <div class="glass-card stat-card">
                    <h3>Disetujui</h3>
                    <div class="number">16</div>
                </div>
            </div>

            <!-- Screening Section -->
            <div class="glass-card">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size: 1.3rem; font-weight: 600; color: var(--text-dark);">
                        Kelola pengajuan dana dari berbagai ORMAWA
                    </h2>
                </div>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>JUDUL KEGIATAN</th>
                                <th>PENGAJU</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Seminar Nasional Teknologi ID: 1</td>
                                <td>HIMA Informatika</td>
                                <td>12 Sept 2025</td>
                                <td><span class="status menunggu">Menunggu</span></td>
                                <td><button class="btn btn-primary" onclick="screeningPengajuan(1)">Screening</button></td>
                            </tr>
                            <tr>
                                <td>Workshop Kewirausahaan</td>
                                <td>HIMA Manajemen</td>
                                <td>15 Sept 2025</td>
                                <td><span class="status menunggu">Menunggu</span></td>
                                <td><button class="btn btn-primary" onclick="screeningPengajuan(2)">Screening</button></td>
                            </tr>
                            <tr>
                                <td>Olahraga Bersama FTMM</td>
                                <td>BEM FTMM</td>
                                <td>18 Sept 2025</td>
                                <td><span class="status menunggu">Menunggu</span></td>
                                <td><button class="btn btn-primary" onclick="screeningPengajuan(3)">Screening</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Screening Section -->
        <div class="content-section" id="screening">
            <div class="header">
                <h1 style="font-size: 1.8rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    Screening Pengajuan
                </h1>
                <div class="user-info">
                    <div class="avatar">
                        <span class="material-icons">person</span>
                    </div>
                    <div>
                        <h2 style="font-size: 1.3rem; font-weight: 600;">Admin</h2>
                        <p style="color: var(--subtext-dark); font-size: 0.9rem;">Role: Admin Screening</p>
                    </div>
                </div>
            </div>

            <div class="glass-card">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size: 1.3rem; font-weight: 600; color: var(--text-dark);">
                        Halaman Screening - Detail Pengajuan
                    </h2>
                </div>
                
                <div style="padding: 20px;">
                    <h3 style="margin-bottom: 15px; font-weight: 600;">Form Screening Pengajuan</h3>
                    <div class="glass-card" style="background: rgba(7, 55, 99, 0.2); padding: 15px; margin-bottom: 20px;">
                        <p><strong>Judul Kegiatan:</strong> Seminar Nasional Teknologi ID: 1</p>
                        <p><strong>Pengaju:</strong> HIMA Informatika</p>
                        <p><strong>Tanggal:</strong> 12 Sept 2025</p>
                        <p><strong>Status:</strong> <span class="status menunggu">Menunggu</span></p>
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Keputusan:</strong></label>
                        <select class="form-control">
                            <option>Setujui</option>
                            <option>Tolak</option>
                            <option>Perlu Revisi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><strong>Komentar:</strong></label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>
                    
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button class="btn btn-primary">Simpan Keputusan</button>
                        <button class="btn btn-secondary" onclick="showSection('dashboard')">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan section yang sesuai
        function showSection(sectionId) {
            // Sembunyikan semua section
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Tampilkan section yang dipilih
            document.getElementById(sectionId).classList.add('active');
            
            // Update menu aktif
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });
            
            const targetItem = document.querySelector(`.menu-item[data-target="${sectionId}"]`);
            if (targetItem) targetItem.classList.add('active');
        }
        
        // Fungsi untuk tombol screening
        function screeningPengajuan(id) {
            showSection('screening');
            console.log(`Memproses screening untuk pengajuan ID: ${id}`);
        }
        
        // Fungsi untuk logout
        document.getElementById('logout-btn').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                alert('Logout berhasil');
            }
        });
        
        // Menambahkan event listener untuk menu items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                if (target) {
                    showSection(target);
                }
            });
        });
        
        // Toggle sidebar untuk mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('sidebar-active');
                this.classList.toggle('click-feedback');
            });
        }
        
        // Feedback klik untuk tombol
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                this.classList.add('click-feedback');
                setTimeout(() => {
                    this.classList.remove('click-feedback');
                }, 300);
            });
        });
    </script>
</body>
</html>