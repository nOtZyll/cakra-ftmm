<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf Fakultas - CAKRA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        /* --- CSS Mandiri yang Konsisten --- */
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); min-height: 100vh; display: flex; }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(116, 24, 71, 0.2);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            z-index: 100;
        }
        .logo { padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-item { padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark); text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1)); color: var(--text-dark); border-left-color: var(--accent); }
        .nav-item .material-icons { margin-right: 10px; font-size: 20px; }
        .nav-text { font-size: 0.9rem; }

        /* Main Content Styling */
        .main-content { flex: 1; margin-left: 250px; padding: 30px; }
        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 1.8rem; font-weight: 700; }
        .page-subtitle { color: var(--subtext-dark); }
        .highlight-text { color: #7ca2c5; font-weight: 600; }

        /* Komponen */
        .card {
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
        }
        .form-title { font-size: 1.3rem; font-weight: 600; color: var(--text-dark); display: flex; align-items: center; gap: 10px; }
        
        /* Tabel */
        .table-container { overflow-x: auto; }
        .form-table { width: 100%; border-collapse: collapse; }
        .form-table th, .form-table td { padding: 12px 15px; border-bottom: 1px solid rgba(116, 24, 71, 0.1); text-align: left; }
        .form-table thead th { background: rgba(7, 55, 99, 0.2); }
        .form-table tbody tr:hover { background: rgba(7, 55, 99, 0.15); }
        
        /* Tombol */
        .btn { display: inline-block; text-decoration: none; padding: 6px 14px; border-radius: 6px; font-size: 0.85rem; transition: all 0.3s ease; }
        .btn-outline { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
        .btn-outline:hover { background: var(--accent); color: white; }

        /* Utility & Grid */
        .grid { display: grid; }
        .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .d-flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .align-center { align-items: center; }
        .mb-4 { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo"><h1>CAKRA</h1></div>
        
        <a href="{{ route('staf_fakultas.dashboard') }}" class="nav-item active">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        
        {{-- Menu Logout --}}
        <a href="{{ route('logout') }}" class="nav-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content" id="mainContent">
        <div class="page-header">
            <h1 class="page-title">Dashboard Staf Keuangan</h1>
            <p class="page-subtitle">Selamat datang kembali, <span class="highlight-text">{{ $user->name }}</span>!</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="d-flex justify-between align-center mb-4">
                    <h3 class="form-title"><span class="material-icons">description</span> Antrian Verifikasi RAB</h3>
                </div>
                <div class="table-container">
                    <table class="form-table">
                        <tbody>
                            @forelse ($antrianRab as $pengajuan)
                            <tr>
                                <td>
                                    <div>{{ $pengajuan->judul_kegiatan }}</div>
                                    <small style="color: var(--subtext-dark);">{{ $pengajuan->ormawa->nama_ormawa ?? 'Individu' }}</small>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->diffForHumans() }}</td>
                                <td class="text-right">
                                   <a href="{{ route('staf_fakultas.verifikasi.rab', $pengajuan->pengajuan_id) }}" class="btn btn-outline">Verifikasi</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Tidak ada antrian verifikasi RAB.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="d-flex justify-between align-center mb-4">
                    <h3 class="form-title"><span class="material-icons">task_alt</span> Antrian Verifikasi LPJ</h3>
                </div>
                <div class="table-container">
                    <table class="form-table">
                        <tbody>
                            @forelse ($antrianLpj as $pengajuan)
                            <tr>
                                <td>
                                    <div>{{ $pengajuan->judul_kegiatan }}</div>
                                    <small style="color: var(--subtext-dark);">{{ $pengajuan->ormawa->nama_ormawa ?? 'Individu' }}</small>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($pengajuan->lpj->tanggal_lapor)->diffForHumans() }}</td>
                                <td class="text-right">
                                    <a href="{{ route('staf_fakultas.verifikasi.lpj.show', $pengajuan->lpj->lpj_id) }}" class="btn btn-outline">Verifikasi</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Tidak ada antrian verifikasi LPJ.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-4 gap-6 mt-6">
            <div class="card text-center">
                <h2 class="highlight-text" style="font-size: 2rem;">{{ $stats['menunggu_verifikasi'] }}</h2>
                <p style="color: var(--subtext-dark);">Total Antrian</p>
            </div>
            <div class="card text-center">
                <h2 class="highlight-text" style="font-size: 2rem;">{{ $stats['total_ormawa'] }}</h2>
                <p style="color: var(--subtext-dark);">ORMAWA Terdaftar</p>
            </div>
            </div>
    </div>
</body>
</html>