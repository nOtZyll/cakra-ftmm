<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat LPJ - CAKRA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Alpine.js (untuk baris dinamis) --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        :root{
            --primary:#073763;
            --accent:#741847;
            --bg-dark:#0A192F;
            --text-dark:#E0E6F1;
            --subtext-dark:#94A3B8;
        }
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{background:var(--bg-dark);color:var(--text-dark);min-height:100vh}

        .main-content{padding:30px;max-width:1200px;margin:0 auto}
        .page-header{margin-bottom:24px}
        .page-title{font-size:1.8rem;font-weight:700}
        .page-subtitle{color:var(--subtext-dark)}

        .card{
            background:rgba(7,55,99,.10);
            border:1px solid rgba(116,24,71,.20);
            border-radius:12px;
            backdrop-filter:blur(10px);
            padding:20px;
        }
        .mb-4{margin-bottom:1rem}
        .mb-6{margin-bottom:1.5rem}
        .grid{display:grid}
        .gap-4{gap:1rem}
        .text-subtext-dark{color:var(--subtext-dark)}
        .font-semibold{font-weight:600}
        .font-bold{font-weight:700}

        /* Tabel */
        .table-container{overflow-x:auto}
        .form-table{width:100%;border-collapse:collapse}
        .form-table th,.form-table td{
            padding:12px 14px;border-bottom:1px solid rgba(116,24,71,.12);text-align:left
        }
        .form-table thead th{
            background:rgba(7,55,99,.20);font-weight:600
        }
        .text-center{text-align:center}
        .text-right{text-align:right}

        /* Inputs */
        input[type="text"],input[type="number"],input[type="url"],textarea{
            width:100%;background:#111827;border:1px solid #374151;color:#E5E7EB;
            border-radius:10px;padding:10px 12px;outline:none
        }
        input[type="file"]{
            width:100%;background:transparent;color:#E5E7EB
        }
        input:focus,textarea:focus{border-color:rgba(116,24,71,.45)}

        /* Buttons */
        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:10px;
             font-weight:600;text-decoration:none;border:1px solid transparent;cursor:pointer}
        .btn-primary{background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff}
        .btn-primary:hover{filter:brightness(1.1)}
        .btn-outline{background:transparent;border-color:var(--accent);color:var(--accent)}
        .btn-outline:hover{background:rgba(116,24,71,.12)}
        .btn-ghost{background:transparent;border-color:transparent;color:var(--text-dark)}
        .btn-ghost:hover{background:rgba(255,255,255,.06)}

        .alert{border-radius:12px;padding:12px 14px}
        .alert-success{background:rgba(16,185,129,.10);border:1px solid rgba(16,185,129,.35);color:#10B981}
        .alert-error{background:rgba(239,68,68,.10);border:1px solid rgba(239,68,68,.35);color:#EF4444}

        .form-title{font-size:1.2rem;font-weight:600;margin-bottom:8px}
        .muted{color:var(--subtext-dark);font-size:.9rem}
        .warning{color:#F87171;font-weight:600}
        .tag{display:inline-flex;align-items:center;background:rgba(7,55,99,.25);border:1px solid rgba(116,24,71,.25);padding:4px 8px;border-radius:999px;color:#E5E7EB;font-size:.85rem}
        .material-icons{font-size:18px;vertical-align:middle}
        @media(min-width:768px){.md\:grid-cols-3{grid-template-columns:repeat(3,minmax(0,1fr))}}
    </style>
</head>
<body>
<div class="main-content">
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">Buat Laporan Pertanggungjawaban (LPJ)</h1>
        <p class="page-subtitle">Lengkapi realisasi biaya sesuai bukti/nota. Pastikan total tidak melebihi RAB.</p>
    </div>

    {{-- Ringkasan Pengajuan --}}
    <div class="card mb-6">
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <p class="text-subtext-dark">Judul Kegiatan</p>
                <p class="font-semibold">{{ $pengajuan->judul_kegiatan }}</p>
            </div>
            <div>
                <p class="text-subtext-dark">Ormawa Pengaju</p>
                <p class="font-semibold">{{ $pengajuan->ormawa->nama_ormawa ?? '—' }}</p>
            </div>
            <div>
                <p class="text-subtext-dark">Total RAB Disetujui</p>
                <span class="tag">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Notifikasi Validasi Server --}}
    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <strong>Periksa kembali input Anda:</strong>
            <ul style="margin-top:8px;padding-left:18px" class="muted">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM LPJ --}}
    <div
        class="card"
        x-data="lpjCreate({ totalRab: {{ (float) $pengajuan->total_rab }} })"
    >
        <div class="form-title">Rincian Realisasi</div>
        <p class="muted mb-4">Unggah nota untuk setiap pengeluaran (Gambar/PDF, maksimal 5MB). Link GDocs opsional (satu untuk seluruh LPJ).</p>

        <form method="POST"
              action="{{ route('mahasiswa.lpj.store', $pengajuan->pengajuan_id) }}"
              enctype="multipart/form-data"
              x-on:submit="return beforeSubmit()">
            @csrf

            {{-- Link GDocs global (opsional) --}}
            <div class="mb-4">
                <label for="link_gdocs" class="font-semibold">Link Google Docs</label>
                <input type="url"
                       id="link_gdocs"
                       name="link_gdocs"
                       value="{{ old('link_gdocs') }}"
                       placeholder="https://docs.google.com/..."
                       pattern="https?://.*">
                <p class="muted" style="margin-top:6px">Satu link untuk keseluruhan LPJ. Pastikan aksesnya terbuka (viewer).</p>
            </div>

            <div class="table-container">
                <table class="form-table">
                    <thead>
                        <tr>
                            <th>Nama Pengeluaran</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-right">Harga Satuan</th>
                            <th class="text-center">Nota</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, i) in rows" :key="i">
                            <tr>
                                {{-- Nama --}}
                                <td>
                                    <input type="text"
                                           :name="`items[${i}][nama_item]`"
                                           x-model="row.nama_item"
                                           placeholder="Mis. Konsumsi Panitia"
                                           required>
                                </td>

                                {{-- Jumlah --}}
                                <td class="text-center">
                                    <input type="number"
                                           min="1"
                                           :name="`items[${i}][jumlah]`"
                                           x-model.number="row.jumlah"
                                           required>
                                </td>

                                {{-- Satuan --}}
                                <td class="text-center">
                                    <input type="text"
                                           :name="`items[${i}][satuan]`"
                                           x-model="row.satuan"
                                           placeholder="Box/Unit/Lbr"
                                           required>
                                </td>

                                {{-- Harga Satuan --}}
                                <td class="text-right">
                                    <input type="number"
                                           min="0"
                                           step="0.01"
                                           :name="`items[${i}][harga_satuan]`"
                                           x-model.number="row.harga_satuan"
                                           required>
                                    <div class="muted" style="font-size:.8rem;margin-top:6px" x-text="formatRupiah(row.jumlah * row.harga_satuan)"></div>
                                </td>

                                {{-- Nota (file) --}}
                                <td class="text-center">
                                    <input type="file"
                                           :name="`items[${i}][nota]`"
                                           accept="image/*,application/pdf"
                                           required>
                                    <div class="muted" style="font-size:.8rem;margin-top:6px">max 5MB</div>
                                </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline" x-on:click="remove(i)" x-show="rows.length > 1">
                                        <span class="material-icons">delete</span> Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <button type="button" class="btn btn-outline" x-on:click="add()">
                                    <span class="material-icons">add</span> Tambah Baris
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Total Realisasi Sementara</td>
                            <td class="text-right font-bold" colspan="2" x-text="formatRupiah(grandTotal())"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Warning jika over-budget --}}
            <div class="mb-4" x-show="grandTotal() > totalRab">
                <span class="warning">Total realisasi melebihi RAB sebesar <span x-text="formatRupiah(grandTotal() - totalRab)"></span>.</span>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button type="submit" class="btn btn-primary">
                    <span class="material-icons">send</span> Kirim LPJ
                </button>
                <a href="{{ route('mahasiswa.lpj.index') }}" class="btn btn-ghost">
                    <span class="material-icons">arrow_back</span> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function lpjCreate({ totalRab }) {
    return {
        totalRab,
        rows: [
            { nama_item: '', jumlah: 1, satuan: '', harga_satuan: 0 }
        ],
        add() {
            this.rows.push({ nama_item: '', jumlah: 1, satuan: '', harga_satuan: 0 });
        },
        remove(i) {
            if (this.rows.length > 1) this.rows.splice(i, 1);
        },
        grandTotal() {
            return this.rows.reduce((sum, r) => {
                const j = Number(r.jumlah || 0);
                const h = Number(r.harga_satuan || 0);
                return sum + (j * h);
            }, 0);
        },
        formatRupiah(n) {
            n = Number(n || 0);
            return 'Rp ' + n.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        },
        beforeSubmit() {
            return true;
        }
    }
}
</script>
</body>
</html>
