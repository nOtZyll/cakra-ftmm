<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - CAKRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Variabel Warna Global dan semua style CSS lainnya ditempel di sini */
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); min-height: 100vh; display: flex; }
        .sidebar { width: 250px; background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border-right: 1px solid rgba(116, 24, 71, 0.2); padding: 20px 0; height: 100vh; position: fixed; z-index: 100; }
        .logo { padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-item { padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark); text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1)); color: var(--text-dark); border-left-color: var(--accent); }
        .nav-item .material-icons { margin-right: 10px; font-size: 20px; }
        .main-content { flex: 1; margin-left: 250px; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-info { display: flex; align-items: center; }
        .avatar { width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); display: flex; align-items: center; justify-content: center; margin-right: 15px; }
        .user-details h2 { font-size: 1.5rem; font-weight: 600; }
        .user-details p { color: var(--subtext-dark); font-size: 0.9rem; }
        .card { background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px; padding: 20px; }
        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 1.8rem; font-weight: 700; }
        .page-subtitle { color: var(--subtext-dark); }
        .form-title { font-size: 1.3rem; font-weight: 600; }
        .form-link { color: var(--accent); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; }
        .form-link .material-icons { font-size: 16px; margin-right: 5px; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .lg\:grid-cols-2 { @media (min-width: 1024px) { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        .md\:grid-cols-3 { @media (min-width: 768px) { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-8 { margin-top: 2rem; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-lg { font-size: 1.125rem; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-yellow-400 { color: #FBBF24; }
        .text-green-400 { color: #4ADE80; }
        .text-red-400 { color: #F87171; }
        .text-orange-400 { color: #FB923C; }
        .table-container { overflow-x: auto; }
        .form-table { width: 100%; border-collapse: collapse; }
        .form-table th, .form-table td { padding: 12px 15px; border-bottom: 1px solid rgba(116, 24, 71, 0.1); text-align: left;}
        .form-table thead th { background: rgba(7, 55, 99, 0.2); }
        .border-l-2 { border-left-width: 2px; }
        .border-primary\/30 { border-color: rgba(7, 55, 99, 0.3); }
        .pl-4 { padding-left: 1rem; }
        .space-y-4 > :not([hidden]) ~ :not([hidden]) { margin-top: 1rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 12px 20px; border: none; border-radius: 8px; font-weight: 600; text-decoration: none; }
        .btn-outline { background: transparent; border: 1px solid var(--accent); color: var(--accent); }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo"><h1>CAKRA</h1></div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item">
            <span class="material-icons">dashboard</span><span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="nav-item active">
            <span class="material-icons">description</span><span class="nav-text">Pengajuan</span>
        </a>
        <a href="{{ route('mahasiswa.lpj.index') }}" class="nav-item">
            <span class="material-icons">assignment</span><span class="nav-text">LPJ</span>
        </a>
        <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span><span class="nav-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-info">
                <div class="avatar"><span class="material-icons">person</span></div>
                <div class="user-details">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p>Detail Pengajuan Anda</p>
                </div>
            </div>
        </div>

        <div class="page-header">
            <h1 class="page-title">Detail Pengajuan</h1>
        </div>

        {{-- Kartu Ringkasan Utama (DINAMIS) --}}
        <div class="card mb-6">
            <h3 class="form-title">{{ $pengajuan->judul_kegiatan }}</h3>
            <div class="grid md:grid-cols-3 gap-4 text-subtext-dark mt-4">
                <div>
                    <p class="font-semibold text-text-dark">Diajukan oleh</p>
                    <p>{{ $pengajuan->user->name }} ({{ $pengajuan->ormawa->nama_ormawa ?? 'Individu' }})</p>
                </div>
                <div>
                    <p class="font-semibold text-text-dark">Tanggal Pengajuan</p>
                    <p>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y H:i') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-text-dark">Status Saat Ini</p>
                    @php
                        $statusClass = 'text-yellow-400';
                        if (in_array($pengajuan->status->nama_status, ['Disetujui', 'Dana Cair', 'Selesai'])) $statusClass = 'text-green-400';
                        if (in_array($pengajuan->status->nama_status, ['Ditolak'])) $statusClass = 'text-red-400';
                        if (in_array($pengajuan->status->nama_status, ['Revisi'])) $statusClass = 'text-orange-400';
                    @endphp
                    <p class="font-bold text-lg {{ $statusClass }}">{{ $pengajuan->status->nama_status }}</p>
                </div>
                <div>
                    <p class="font-semibold text-text-dark">Total RAB</p>
                    <p class="font-bold">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-text-dark">Jenis Surat</p>
                    <p>{{ $pengajuan->jenisSurat->nama_jenis }}</p>
                </div>
                <div>
                    <p class="font-semibold text-text-dark">Dokumen Proposal</p>
                    <a href="{{ $pengajuan->link_dokumen }}" target="_blank" class="form-link">
                        <span class="material-icons">launch</span>
                        Lihat Dokumen
                    </a>
                </div>
            </div>
        </div>

        {{-- Layout Dua Kolom (DINAMIS) --}}
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="card">
                <h3 class="form-title mb-4">Rincian Anggaran Biaya (RAB)</h3>
                <div class="table-container">
                    <table class="form-table">
                        <thead>
                            <tr>
                                <th>Nama Item</th>
                                <th class="text-right">Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuan->itemsRab as $item)
                            <tr>
                                <td>{{ $item->nama_item }} <span class="text-subtext-dark text-sm">({{ $item->jumlah }} {{ $item->satuan }})</span></td>
                                <td class="text-right">{{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center p-4">Tidak ada rincian anggaran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3 class="form-title mb-4">Histori Status & Catatan</h3>
                <ul class="space-y-4 text-gray-300 border-l-2 border-primary/30 pl-4">
                    @forelse ($pengajuan->historiStatus->sortBy('timestamp') as $histori)
                    <li>
                        <div class="flex justify-between items-center">
                            <p class="font-semibold">{{ $histori->status->nama_status }}</p>
                            <p class="text-xs text-subtext-dark">{{ \Carbon\Carbon::parse($histori->timestamp)->format('d M Y H:i') }}</p>
                        </div>
                        <p class="text-xs text-subtext-dark">Oleh: {{ $histori->diubahOleh->name }}</p>
                        @if ($histori->komentar)
                            <div class="mt-2 p-3 rounded bg-red-600/10 text-red-400 text-sm border border-red-500/30">
                                <span class="font-bold">Catatan:</span> {{ $histori->komentar }}
                            </div>
                        @endif
                    </li>
                    @empty
                    <li class="text-center p-4">Belum ada histori status.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    <div class="mt-8 flex gap-4">
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn btn-outline">
            <span class="material-icons">arrow_back</span>
            Kembali ke Riwayat
        </a>

        {{-- TAMBAHKAN BLOK INI: Tombol hanya muncul jika statusnya 'Revisi' --}}
        @if ($pengajuan->status->nama_status == 'Revisi')
            <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan->pengajuan_id) }}" class="btn btn-accent">
                <span class="material-icons">edit</span>
                Perbaiki Pengajuan
            </a>
        @endif
    </div>
</body>
</html>