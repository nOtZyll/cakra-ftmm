<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi LPJ - CAKRA FTMM</title>
    
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
            padding: 0;
            margin: 0;
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

        /* STYLING KHUSUS VERIFIKASI LPJ */
        .verifikasi-container {
            padding: 0;
        }

        .verifikasi-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .verifikasi-subtitle {
            color: var(--subtext-dark);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .verifikasi-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .verifikasi-card:hover {
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

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 12px 30px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
        }

        .modal-custom {
            background: rgba(7, 55, 99, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.3);
            border-radius: 12px;
        }

        .modal-header-custom {
            background: rgba(7, 55, 99, 0.3);
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
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
            .verifikasi-title {
                font-size: 1.8rem;
            }
            
            .verifikasi-subtitle {
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
                    <span class="subtitle">Staff Fakultas</span>
                </span>
            </a>

            <ul class="nav-sidebar">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staf_fakultas.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>☑ Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>📌 Verifikasi RAB</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('lpi_show') }}">
                        <i class="bi bi-folder-check"></i>
                        <span>📌 Verifikasi LPJ</span>
                    </a>
                </li>
            </ul>

            <div class="toggle-sidebar" id="toggleSidebar">
                <i class="bi bi-chevron-left"></i>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Verifikasi LPJ Content -->
            <div class="verifikasi-container">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        <i class="bi bi-folder-check" style="font-size: 2.4rem; color: #7ca2c5;"></i>
                    </div>
                    <div>
                        <h2 class="verifikasi-title mb-0">Verifikasi Laporan Pertanggungjawaban (LPJ)</h2>
                        <p class="verifikasi-subtitle mb-0">CAKRA FTMM - Sistem Verifikasi Keuangan</p>
                    </div>
                </div>

                <!-- RAB dan LPJ Cards -->
                <div class="row g-4">
                    <!-- RAB -->
                    <div class="col-lg-6">
                        <div class="verifikasi-card h-100">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-file-earmark-text me-2"></i> Rencana Anggaran (RAB)
                            </h5>
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Item</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sewa Aula</td>
                                            <td class="text-center">1</td>
                                            <td class="text-right text-accent">Rp 2.000.000</td>
                                        </tr>
                                        <tr>
                                            <td>Konsumsi</td>
                                            <td class="text-center">100</td>
                                            <td class="text-right text-accent">Rp 5.000.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- LPJ -->
                    <div class="col-lg-6">
                        <div class="verifikasi-card h-100">
                            <h5 class="card-title mb-4">
                                <i class="bi bi-folder-check me-2"></i> Realisasi (LPJ)
                            </h5>
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Item</th>
                                            <th class="text-right">Total</th>
                                            <th class="text-center">Nota</th>
                                            <th class="text-center">Valid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sewa Aula</td>
                                            <td class="text-right text-accent">Rp 2.000.000</td>
                                            <td class="text-center">
                                                <button class="action-btn" data-bs-toggle="modal" data-bs-target="#notaAulaModal">
                                                    Lihat Nota
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="checkbox-custom">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Konsumsi</td>
                                            <td class="text-right text-accent">Rp 4.800.000</td>
                                            <td class="text-center">
                                                <button class="action-btn" data-bs-toggle="modal" data-bs-target="#notaKonsumsiModal">
                                                    Lihat Nota
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="checkbox-custom">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Komentar / Revisi -->
                <div class="verifikasi-card mt-4">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-chat-left-text me-2"></i> Komentar / Revisi
                    </h5>
                    <div class="mb-4">
                        <textarea class="form-control glass-card" rows="4" placeholder="Tuliskan komentar atau revisi yang diperlukan..." style="background: rgba(7, 55, 99, 0.1); color: var(--text-dark); border: 1px solid rgba(116, 24, 71, 0.2);"></textarea>
                    </div>
                    <div class="d-flex gap-3">
                        <button class="btn-success-custom flex-fill" id="btnSetujui">
                            <i class="bi bi-check-circle me-2"></i> Setujui LPJ
                        </button>
                        <button class="btn-danger-custom flex-fill" id="btnRevisi">
                            <i class="bi bi-send me-2"></i> Kirim Revisi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nota Aula -->
    <div class="modal fade" id="notaAulaModal" tabindex="-1" aria-labelledby="notaAulaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="notaAulaModalLabel" style="color: #7ca2c5; font-family: 'Orbitron', sans-serif;">
                        <i class="bi bi-receipt me-2"></i> Nota Sewa Aula
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/300x200/073763/ffffff?text=NOTA+AULA" class="img-fluid rounded" alt="Nota Sewa Aula">
                    </div>
                    <p style="color: var(--subtext-dark);">Total: <span class="text-accent">Rp 2.000.000</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="action-btn" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nota Konsumsi -->
    <div class="modal fade" id="notaKonsumsiModal" tabindex="-1" aria-labelledby="notaKonsumsiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="notaKonsumsiModalLabel" style="color: #7ca2c5; font-family: 'Orbitron', sans-serif;">
                        <i class="bi bi-receipt me-2"></i> Nota Konsumsi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/300x200/741847/ffffff?text=NOTA+KONSUMSI" class="img-fluid rounded" alt="Nota Konsumsi">
                    </div>
                    <p style="color: var(--subtext-dark);">Total: <span class="text-accent">Rp 4.800.000</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="action-btn" data-bs-dismiss="modal">Tutup</button>
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

        // Fungsi untuk menangani persetujuan LPJ
        document.getElementById('btnSetujui').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.checkbox-custom');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            
            if (allChecked) {
                if (confirm('Apakah Anda yakin ingin menyetujui LPJ ini?')) {
                    alert('LPJ berhasil disetujui!');
                    // Redirect ke dashboard setelah persetujuan
                    window.location.href = "{{ route('staf_fakultas.dashboard') }}";
                }
            } else {
                alert('Harap centang semua item yang valid sebelum menyetujui LPJ.');
            }
        });

        // Fungsi untuk mengirim revisi
        document.getElementById('btnRevisi').addEventListener('click', function() {
            const comment = document.querySelector('textarea').value;
            if (comment.trim() === '') {
                alert('Harap isi komentar/revisi sebelum mengirim.');
                return;
            }
            
            if (confirm('Apakah Anda yakin ingin mengirim revisi?')) {
                alert('Revisi berhasil dikirim!');
                // Tetap di halaman ini setelah mengirim revisi
            }
        });

        // Update active state di sidebar berdasarkan halaman saat ini
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath || 
                    (currentPath.includes('lpi_show') && link.getAttribute('href').includes('lpi_show'))) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>