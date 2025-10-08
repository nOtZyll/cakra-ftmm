<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Verifikasi RAB</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Mengambil semua style dari dashboard.blade.php */
        :root {
            --primary: #073763; --accent: #741847; --bg-dark: #0A192F;
            --text-dark: #E0E6F1; --subtext-dark: #94A3B8; --status-menunggu: #ffc107;
            --status-disetujui: #28a745; --status-revisi: #dc3545; --status-default: #6c757d;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); min-height: 100vh; }
        
        /* Layout Utama disederhanakan untuk halaman ini */
        .main-content { padding: 30px; max-width: 1200px; margin: 0 auto; }
        .header { margin-bottom: 30px; }

        /* Komponen Utama dari Dashboard */
        .glass-card { background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .table-container { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { padding: 15px 12px; text-align: left; font-weight: 600; border-bottom: 2px solid rgba(116, 24, 71, 0.5); }
        .table td { padding: 12px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); vertical-align: middle; }
        
        /* Tambahan style untuk tfoot agar serasi */
        .table tfoot td {
            border-top: 2px solid rgba(116, 24, 71, 0.5);
            font-weight: 700;
            font-size: 1.1rem;
            padding-top: 15px;
            border-bottom: none;
        }
        
        /* Kelas Utility Sederhana */
        .grid { display: grid; gap: 20px; }
        .md-grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .font-semibold { font-weight: 600; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    /* Style untuk Form Verifikasi */
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--subtext-dark);
    }
    .form-group textarea {
        width: 100%;
        background: rgba(7, 55, 99, 0.2);
        border: 1px solid rgba(116, 24, 71, 0.2);
        border-radius: 8px;
        padding: 12px;
        color: var(--text-dark);
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    .form-group textarea::placeholder {
        color: var(--subtext-dark);
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }
    .btn { 
        display: inline-flex; align-items: center; padding: 10px 20px;
        border: none; border-radius: 8px; font-weight: 600; cursor: pointer; 
        transition: all 0.3s ease; text-decoration: none; font-size: 0.9rem;
    }
    .btn .material-icons { margin-right: 8px; }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.3); }
    
    .btn-setuju { background-color: #28a745; color: white; }
    .btn-revisi { background-color: #ffc107; color: #212529; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="header">
        <h1 style="font-size: 1.8rem; font-weight: 700;">
            📑 Detail Verifikasi RAB
        </h1>
        <p style="color: var(--subtext-dark);">
            Periksa kesesuaian item dan anggaran yang diajukan oleh mahasiswa.
        </p>
    </div>

    <div class="glass-card">
        <div class="grid md-grid-cols-3">
            <div>
                <p style="color: var(--subtext-dark);">Judul Kegiatan</p>
                <p class="font-semibold">{{ $pengajuan->judul_kegiatan }}</p>
            </div>
            <div>
                <p style="color: var(--subtext-dark);">Ormawa Pengaju</p>
                <p class="font-semibold">{{ $pengajuan->ormawa->nama_ormawa }}</p>
            </div>
            <div>
                <p style="color: var(--subtext-dark);">Tanggal Pengajuan</p>
                <p class="font-semibold">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">Rincian Anggaran</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ITEM</th>
                        <th class="text-center">JUMLAH</th>
                        <th class="text-center">SATUAN</th>
                        <th class="text-right">HARGA SATUAN</th>
                        <th class="text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuan->itemsRab as $item)
                        <tr>
                            <td>{{ $item->nama_item }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ $item->satuan }}</td>
                            <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-right font-semibold">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">Tidak ada item RAB untuk pengajuan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">Total RAB Diajukan:</td>
                        <td class="text-right" style="color: var(--status-disetujui);">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="glass-card">
    <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">Aksi Verifikasi</h2>
    
    <form action="{{ route('staf_fakultas.verifikasi.update', $pengajuan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="komentar">Catatan / Komentar (Opsional)</label>
            <textarea name="komentar" id="komentar" rows="4" placeholder="Tuliskan catatan untuk mahasiswa jika ada revisi..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" name="action" value="revisi" class="btn btn-revisi">
                <span class="material-icons">edit</span> Minta Revisi
            </button>
            <button type="submit" name="action" value="setuju" class="btn btn-setuju">
                <span class="material-icons">check_circle</span> Setujui Pengajuan
            </button>
        </div>
    </form>
</div>

</body>
</html>