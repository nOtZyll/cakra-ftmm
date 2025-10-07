<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
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
        
        /* Shortcut Buttons */
        .shortcut-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .shortcut-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .shortcut-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(116, 24, 71, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .shortcut-btn:hover::before {
            opacity: 1;
        }
        
        .shortcut-btn:hover {
            transform: translateY(-5px);
        }
        
        .shortcut-btn.primary {
            background: rgba(7, 55, 99, 0.2);
            border: 1px solid rgba(7, 55, 99, 0.4);
        }
        
        .shortcut-btn.primary:hover {
            background: rgba(7, 55, 99, 0.3);
            border-color: rgba(7, 55, 99, 0.6);
        }
        
        .shortcut-btn.accent {
            background: rgba(116, 24, 71, 0.2);
            border: 1px solid rgba(116, 24, 71, 0.4);
        }
        
        .shortcut-btn.accent:hover {
            background: rgba(116, 24, 71, 0.3);
            border-color: rgba(116, 24, 71, 0.6);
        }
        
        .shortcut-btn .material-icons {
            font-size: 40px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .shortcut-btn:hover .material-icons {
            transform: scale(1.1);
            color: var(--accent);
        }
        
        .shortcut-btn.primary .material-icons {
            color: var(--primary);
        }
        
        .shortcut-btn.accent .material-icons {
            color: var(--accent);
        }
        
        .shortcut-btn h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .shortcut-btn:hover h3 {
            color: var(--accent);
        }
        
        .shortcut-btn p {
            font-size: 0.9rem;
            color: var(--subtext-dark);
            text-align: center;
        }
        
        /* Section Headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 30px 0 15px;
            animation: fadeIn 0.8s ease;
        }
        
        .section-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .view-all {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .view-all:hover {
            transform: translateX(5px);
            color: var(--text-dark);
        }
        
        .view-all .material-icons {
            font-size: 16px;
            margin-left: 5px;
            transition: all 0.3s ease;
        }
        
        .view-all:hover .material-icons {
            transform: translateX(3px);
        }
        
        /* Pengajuan List */
        .pengajuan-list {
            display: grid;
            gap: 15px;
        }
        
        .pengajuan-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
            animation-fill-mode: both;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        
        .pengajuan-item:nth-child(1) { animation-delay: 0.1s; }
        .pengajuan-item:nth-child(2) { animation-delay: 0.2s; }
        .pengajuan-item:nth-child(3) { animation-delay: 0.3s; }
        
        .pengajuan-item:hover {
            background: rgba(7, 55, 99, 0.1);
            transform: translateX(5px) translateY(-2px);
        }
        
        .pengajuan-info h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .pengajuan-item:hover h4 {
            color: var(--accent);
        }
        
        .pengajuan-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: var(--subtext-dark);
        }
        
        .pengajuan-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .pengajuan-item:hover .status-badge {
            transform: scale(1.05);
        }
        
        .status-waiting {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .status-processing {
            background: rgba(3, 169, 244, 0.2);
            color: #03a9f4;
            border: 1px solid rgba(3, 169, 244, 0.3);
        }
        
        .pengajuan-amount {
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .pengajuan-item:hover .pengajuan-amount {
            color: var(--accent);
        }
        
        /* Notifikasi Revisi */
        .revisi-item {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
            animation-fill-mode: both;
            cursor: pointer;
        }
        
        .revisi-item:nth-child(1) { animation-delay: 0.2s; }
        .revisi-item:nth-child(2) { animation-delay: 0.3s; }
        
        .revisi-item:hover {
            transform: translateX(5px);
            background: rgba(244, 67, 54, 0.15);
        }
        
        .revisi-item.warning {
            background: rgba(244, 67, 54, 0.1);
            border-left: 3px solid #f44336;
        }
        
        .revisi-icon {
            margin-right: 10px;
            color: #f44336;
            transition: all 0.3s ease;
        }
        
        .revisi-item:hover .revisi-icon {
            transform: scale(1.2) rotate(10deg);
        }
        
        .empty-state {
            text-align: center;
            padding: 30px;
            color: var(--subtext-dark);
            animation: fadeIn 0.8s ease;
        }
        
        .empty-state .material-icons {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.5;
            transition: all 0.3s ease;
        }
        
        .empty-state:hover .material-icons {
            opacity: 0.8;
            transform: scale(1.1);
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
            
            .shortcut-grid {
                grid-template-columns: 1fr;
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

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h1>CAKRA</h1>
        </div>
        
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'active' : '' }}">
            <span class="material-icons">description</span>
            <span class="nav-text">Pengajuan</span>
        </a>
        
        {{-- PERBAIKAN: Link LPJ mengarah ke halaman index --}}
        <a href="{{ route('mahasiswa.lpj.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.lpj.*') ? 'active' : '' }}">
            <span class="material-icons">assignment</span>
            <span class="nav-text">LPJ</span>
        </a>
        
        <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
        
        <!-- Form Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-info">
                <div class="avatar">
                    <span class="material-icons">person</span>
                </div>
                <div class="user-details">
                    {{-- PERUBAHAN 1: Menampilkan nama user dari controller --}}
                    <h2>Selamat datang, {{ $user->name }}</h2>
                    <p>Status: Mahasiswa Aktif</p>
                </div>
            </div>
        </div>

        <!-- Tombol Shortcut -->
        <div class="shortcut-grid">
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="shortcut-btn primary card">
                <span class="material-icons">add_circle</span>
                <h3>Buat Pengajuan Baru</h3>
                <p>Ajukan proposal kegiatan atau reimbursement</p>
            </a>
            <a href="{{ route('mahasiswa.lpj.index') }}" class="shortcut-btn accent card">
                <span class="material-icons">assignment</span>
                <h3>Kumpulkan LPJ</h3>
                <p>Laporkan pertanggungjawaban kegiatan</p>
            </a>
        </div>

        <!-- Pengajuan Sedang Berjalan -->
        <div class="section-header">
            <h3>Pengajuan Sedang Berjalan</h3>
            <a href="{{ route('mahasiswa.pengajuan.index') }}" class="view-all">
                Lihat Semua <span class="material-icons">chevron_right</span>
            </a>
        </div>

        <div class="pengajuan-list">
            {{-- PERUBAHAN 2: Menghapus data dummy dan menggunakan data dari controller --}}
            @forelse($pengajuanBerjalan as $p)
                <a href="{{ route('mahasiswa.pengajuan.show', $p->pengajuan_id) }}" class="pengajuan-item card">
                    <div class="pengajuan-info">
                        <h4>{{ $p->judul_kegiatan }}</h4>
                        <div class="pengajuan-meta">
                            <span>{{ $p->ormawa->nama_ormawa ?? 'Individu' }}</span>
                            <span>{{ $p->tanggal_pengajuan ? \Carbon\Carbon::parse($p->tanggal_pengajuan)->diffForHumans() : '' }}</span>
                        </div>
                    </div>
                    <div class="pengajuan-status">
                        <span class="status-badge status-processing">
                            {{ $p->status->nama_status }}
                        </span>
                        <span class="pengajuan-amount">Rp {{ number_format($p->total_rab, 0, ',', '.') }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-state card">
                    <span class="material-icons">inbox</span>
                    <p>Belum ada pengajuan berjalan</p>
                </div>
            @endforelse
        </div>

        <!-- Notifikasi Revisi -->
        <div class="section-header">
            <h3>Notifikasi Revisi</h3>
            <a href="{{ route('mahasiswa.pengajuan.index') }}" class="view-all">
                Lihat Semua <span class="material-icons">chevron_right</span>
            </a>
        </div>

        {{-- PERUBAHAN 3: Mengganti data dummy dengan data dari controller --}}
        @forelse($notifikasiRevisi as $r)
            <a href="{{ route('mahasiswa.pengajuan.show', $r->pengajuan_id) }}" class="revisi-item warning card">
                <span class="material-icons revisi-icon">warning</span>
                <p>Pengajuan '{{ $r->judul_kegiatan }}' memerlukan revisi.</p>
            </a>
        @empty
            <div class="empty-state card">
                <span class="material-icons">check_circle</span>
                <p>Tidak ada revisi</p>
            </div>
        @endforelse
    </div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        
        // Efek hover untuk semua kartu
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transition = 'all 0.3s ease';
            });
        });

        // Animasi scroll-triggered
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });

        const animatedElements = document.querySelectorAll('.card, .section-header, .pengajuan-item, .revisi-item');
        animatedElements.forEach(el => {
            observer.observe(el);
        });
    });
</script>

