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
            --primary: #073763; --accent: #741847; --bg-dark: #0A192F;
            --text-dark: #E0E6F1; --subtext-dark: #94A3B8; --status-menunggu: #ffc107;
            --status-disetujui: #28a745; --status-revisi: #dc3545; --status-default: #6c757d;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); min-height: 100vh; display: flex; }
        .sidebar { width: 250px; background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border-right: 1px solid rgba(116, 24, 71, 0.2); padding: 20px 0; height: 100vh; position: fixed; }
        .logo { text-align: center; padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .menu { list-style: none; }
        .menu-item { padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark); text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; cursor: pointer; }
        .menu-item:hover, .menu-item.active { background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1)); color: var(--text-dark); border-left: 3px solid var(--accent); transform: translateX(5px); }
        .menu-item .material-icons { margin-right: 10px; }
        .main-content { flex: 1; margin-left: 250px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-info { display: flex; align-items: center; }
        .avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; margin-right: 15px; border: 2px solid var(--accent); }
        .glass-card { background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { text-align: center; padding: 20px; }
        .stat-card h3 { font-size: 0.9rem; color: var(--subtext-dark); margin-bottom: 10px; font-weight: 500; }
        .stat-card .number { font-size: 1.8rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .table-container { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 15px 12px; text-align: left; font-weight: 600; border-bottom: 2px solid rgba(116, 24, 71, 0.5); }
        .table td { padding: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; text-align: center; display: inline-block; }
        .status.menunggu { background: rgba(255, 193, 7, 0.2); color: var(--status-menunggu); }
        .status.disetujui { background: rgba(40, 167, 69, 0.2); color: var(--status-disetujui); }
        .status.revisi { background: rgba(220, 53, 69, 0.2); color: var(--status-revisi); }
        .status.default { background: rgba(108, 117, 125, 0.2); color: var(--status-default); }
        .btn { display: inline-flex; align-items: center; padding: 8px 15px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; text-decoration: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">CAKRA</div>
        <ul class="menu">
            <li class="menu-item active">
                <span class="material-icons">history</span>
                <span>Riwayat Pengajuan</span>
            </li>
            <li class="menu-item" onclick="document.getElementById('logout-form').submit();">
                <span class="material-icons">logout</span>
                <span>Log Out</span>
            </li>
        </ul>
        {{-- Form logout yang tersembunyi --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 style="font-size: 1.8rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Antrian Screening Pengajuan
            </h1>
            <div class="user-info">
                <div class="avatar"><span class="material-icons">person</span></div>
                <div>
                    {{-- Menampilkan nama user yang login --}}
                    <h2 style="font-size: 1.3rem; font-weight: 600;">{{ Auth::user()->name }}</h2>
                    {{-- Menampilkan nama ormawa dari user yang login --}}
                    <p style="color: var(--subtext-dark); font-size: 0.9rem;">
                        {{ Auth::user()->ormawa->nama_ormawa ?? 'Staff Ormawa' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="stats">
            <div class="glass-card stat-card">
                <h3>Total Pengajuan</h3>
                {{-- Menghitung jumlah semua item di variabel $daftarPengajuan --}}
                <div class="number">{{ $daftarPengajuan->count() }}</div>
            </div>
            <div class="glass-card stat-card">
                <h3>Menunggu Screening</h3>
                {{-- Menghitung hanya pengajuan dengan status tertentu --}}
                <div class="number">{{ $daftarPengajuan->where('status.nama_status', 'Screening Ormawa')->count() }}</div>
            </div>
            <div class="glass-card stat-card">
                <h3>Disetujui</h3>
                 {{-- Menghitung hanya pengajuan dengan status tertentu --}}
                <div class="number">{{ $daftarPengajuan->where('status.nama_status', 'Disetujui')->count() }}</div>
            </div>
        </div>

        <div class="glass-card">
            <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>JUDUL KEGIATAN</th>
                            <th>PENGAJU</th>
                            <th>TANGGAL PENGAJUAN</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Memulai perulangan data --}}
                        @forelse ($daftarPengajuan as $pengajuan)
                        <tr>
                            {{-- Menampilkan data dari setiap kolom pengajuan --}}
                            <td>{{ $pengajuan->judul_kegiatan }}</td>
                            <td>{{ $pengajuan->user->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}</td>
                            <td>
                                {{-- Logika untuk memberikan warna status yang berbeda --}}
                                @php
                                    $statusClass = 'default';
                                    $namaStatus = strtolower($pengajuan->status->nama_status ?? '');
                                    if (str_contains($namaStatus, 'screening') || str_contains($namaStatus, 'verifikasi')) $statusClass = 'menunggu';
                                    elseif (str_contains($namaStatus, 'disetujui')) $statusClass = 'disetujui';
                                    elseif (str_contains($namaStatus, 'revisi') || str_contains($namaStatus, 'ditolak')) $statusClass = 'revisi';
                                @endphp
                                <span class="status {{ $statusClass }}">{{ $pengajuan->status->nama_status ?? 'Tanpa Status' }}</span>
                            </td>
                            <td>
                                {{-- Membuat link dinamis ke halaman detail screening --}}
                                <a href="{{ route('staf_ormawa.screening.show', $pengajuan->pengajuan_id) }}" class="btn btn-primary">Screening</a>
                            </td>
                        </tr>
                        @empty
                        {{-- Ini akan ditampilkan jika $daftarPengajuan kosong --}}
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">Belum ada data pengajuan untuk ormawa Anda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>