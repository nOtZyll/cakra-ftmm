<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumpulan LPJ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
            --success: #4CAF50;
            --warning: #FFC107;
            --error: #F44336;
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
        }
        
        /* Sidebar - DIPERBAIKI: z-index dinaikkan */
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
            z-index: 1000; /* 👈 DIPERBAIKI: dari 100 ke 1000 */
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
        
        /* Main Content - DIPERBAIKI: tambah position & z-index */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            overflow-y: auto;
            transition: all 0.3s ease;
            position: relative; /* 👈 Tambahkan */
            z-index: 10;       /* 👈 Lebih rendah dari sidebar */
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease;
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
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
        }
        
        /* Ringkasan Pengajuan */
        .summary-card {
            background: rgba(7, 55, 99, 0.2);
            border-left: 4px solid var(--accent);
        }
        
        .summary-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
        }
        
        .summary-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
            color: var(--subtext-dark);
        }
        
        .detail-item .material-icons {
            font-size: 18px;
            color: var(--accent);
        }
        
        .amount {
            font-weight: 600;
            color: var(--warning);
        }
        
        /* Form Styles */
        .form-section {
            margin-bottom: 30px;
            animation: fadeInUp 0.6s ease;
            animation-fill-mode: both;
        }
        
        .form-section:nth-child(1) { animation-delay: 0.1s; }
        .form-section:nth-child(2) { animation-delay: 0.2s; }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title .material-icons {
            color: var(--accent);
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .data-table thead {
            background: rgba(116, 24, 71, 0.3);
        }
        
        .data-table th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid rgba(116, 24, 71, 0.5);
        }
        
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .data-table tbody tr {
            transition: all 0.3s ease;
        }
        
        .data-table tbody tr:hover {
            background: rgba(7, 55, 99, 0.2);
        }
        
        /* Input Styles */
        .form-input {
            width: 100%;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: var(--text-dark);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(116, 24, 71, 0.2);
        }
        
        .form-input::placeholder {
            color: var(--subtext-dark);
        }
        
        /* File Input */
        .file-input-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            display: block;
            padding: 8px 12px;
            background: rgba(7, 55, 99, 0.3);
            border: 1px dashed rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            color: var(--subtext-dark);
        }
        
        .file-input-label:hover {
            background: rgba(7, 55, 99, 0.5);
            border-color: var(--accent);
            color: var(--text-dark);
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-accent {
            background: var(--accent);
            color: white;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-warning {
            background: var(--warning);
            color: black;
        }
        
        .btn-error {
            background: var(--error);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        /* Total Realisasi */
        .total-card {
            background: rgba(7, 55, 99, 0.3);
            border-left: 4px solid var(--warning);
            padding: 15px;
            margin-top: 20px;
        }
        
        .total-amount {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--warning);
            margin: 5px 0;
        }
        
        .warning-text {
            color: var(--error);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
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
                position: relative;
                z-index: 10;
            }
            
            .main-content.sidebar-active {
                margin-left: 70px;
            }
            
            .data-table {
                font-size: 0.85rem;
            }
            
            .data-table th, .data-table td {
                padding: 8px 6px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001; /* Lebih tinggi dari sidebar */
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
        
        /* Utility Classes */
        .text-center {
            text-align: center;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--subtext-dark);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .breadcrumb-item:not(:last-child)::after {
            content: "chevron_right";
            font-family: 'Material Icons';
            font-size: 16px;
        }
        
        .breadcrumb-item.active {
            color: var(--accent);
            font-weight: 500;
        }

        /* Link breadcrumb agar bisa diklik */
        .breadcrumb-link {
            color: var(--subtext-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-link:hover {
            color: var(--accent);
        }
    </style>
</head>
   <body>
        @include('layouts.partials.sidebar') {{-- Asumsi Anda punya sidebar --}}

        <div class="main-content">
            <h1 class="page-title">Pilih Pengajuan untuk Dilaporkan</h1>
            <p class="page-subtitle">Berikut adalah daftar pengajuan yang sudah disetujui dan siap untuk dibuatkan Laporan Pertanggungjawaban (LPJ).</p>
            
            <div class="pengajuan-list">
                @forelse ($pengajuans as $p)
                    <div class="glass-card">
                        <h4>{{ $p->judul_kegiatan }}</h4>
                        <p>Total Dana Disetujui: Rp {{ number_format($p->total_rab, 0, ',', '.') }}</p>
                        <a href="{{ route('mahasiswa.lpj.create', $p->pengajuan_id) }}" class="btn btn-primary mt-4">
                            Buat LPJ
                        </a>
                    </div>
                @empty
                    <div class="empty-state card">
                        <p>Tidak ada pengajuan yang siap untuk dilaporkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </body>
    </html>