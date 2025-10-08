<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Detail Screening LPJ - CAKRA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <style>
        :root{
            --primary:#073763; --accent:#741847;
            --bg-dark:#0A192F; --text-dark:#E0E6F1; --subtext:#94A3B8;
            --ok:#4ADE80; --warn:#FBBF24; --danger:#F87171;
        }
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
        body{background:var(--bg-dark);color:var(--text-dark);min-height:100vh}
        .container{
            width: 100%;
            max-width: none;
            margin: 0;
            padding-block: 28px;
            padding-inline: clamp(24px, 6vw, 56px);
            }

        .page-title{font-size:1.8rem;font-weight:700;margin-bottom:8px}
        .page-sub{color:var(--subtext);margin-bottom:22px}

        .card{
            background:rgba(7,55,99,.1);border:1px solid rgba(116,24,71,.2);
            backdrop-filter:blur(10px);border-radius:14px;padding:18px;
        }
        .mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.mt-6{margin-top:1.5rem}

        .grid{display:grid;gap:16px}
        .grid-2{grid-template-columns:1fr}
        @media(min-width:992px){.grid-2{grid-template-columns:1fr 1fr}}
        .grid-3{grid-template-columns:1fr}
        @media(min-width:768px){.grid-3{grid-template-columns:repeat(3,1fr)}}

        .label{color:var(--subtext);font-size:.9rem}
        .value{font-weight:600}
        .row{display:grid;gap:4px}

        .badge{display:inline-flex;align-items:center;gap:8px;font-weight:700;font-size:.9rem;padding:6px 10px;border-radius:999px}
        .badge-warn{background:rgba(251,191,36,.15);color:var(--warn);border:1px solid rgba(251,191,36,.35)}
        .badge-ok{background:rgba(74,222,128,.15);color:var(--ok);border:1px solid rgba(74,222,128,.35)}
        .badge-danger{background:rgba(248,113,113,.15);color:var(--danger);border:1px solid rgba(248,113,113,.35)}

        .card-title{font-size:1.1rem;font-weight:600;margin-bottom:10px}

        .table-wrap{overflow-x:auto}
        table{width:100%;border-collapse:collapse}
        thead th{background:rgba(7,55,99,.18);text-align:left;font-weight:600;padding:12px 14px;white-space:nowrap}
        tbody td{padding:12px 14px;border-bottom:1px solid rgba(116,24,71,.18);vertical-align:top}
        tfoot td{padding:12px 14px;font-weight:700}
        .right{text-align:right}.center{text-align:center}
        .subtle{color:var(--subtext)} .mono{font-variant-numeric:tabular-nums}

        .actions{display:flex;gap:12px;flex-wrap:wrap}
        .btn{
            display:inline-flex;align-items:center;gap:8px;
            padding:10px 14px;border-radius:10px;font-weight:600;
            border:1px solid transparent;background:transparent;color:var(--text-dark);
            cursor:pointer;text-decoration:none;
        }
        .btn:hover{filter:brightness(1.06)}
        .btn-primary{background:linear-gradient(90deg,var(--primary),var(--accent));color:#fff;border-color:rgba(116,24,71,.35)}
        .btn-danger{background:rgba(248,113,113,.12);color:var(--danger);border-color:rgba(248,113,113,.35)}
        .btn-outline{border-color:var(--accent);color:var(--accent)}

        textarea,input[type="text"]{
            width:100%;background:rgba(7,55,99,.12);color:var(--text-dark);
            border:1px solid rgba(116,24,71,.25);border-radius:10px;padding:10px
        }
        label{font-weight:600}
        .material-icons{font-family:'Material Icons'!important;font-size:18px;line-height:1}
    </style>
</head>
<body>
<div class="container">
    <h2 class="page-title">🕵️ Detail Screening LPJ</h2>
    <p class="page-sub">Periksa realisasi LPJ dan sesuaikan dengan RAB yang disetujui. Setujui atau minta revisi bila perlu.</p>

    <div class="card mb-8">
        <div class="grid grid-3">
            <div class="row">
                <span class="label">Judul Kegiatan</span>
                <span class="value">{{ $pengajuan->judul_kegiatan }}</span>
            </div>
            <div class="row">
                <span class="label">Ormawa Pengaju</span>
                <span class="value">{{ $pengajuan->ormawa->nama_ormawa ?? '—' }}</span>
            </div>
            <div class="row">
                <span class="label">Tanggal Lapor</span>
                <span class="value">{{ \Carbon\Carbon::parse($lpj->tanggal_lapor)->format('d M Y H:i') }}</span>
            </div>
        </div>

        <div class="grid grid-3 mt-6">
            <div class="row">
                <span class="label">Total RAB</span>
                <span class="value mono">Rp {{ number_format((float)$pengajuan->total_rab,0,',','.') }}</span>
            </div>
            <div class="row">
                <span class="label">Total Realisasi</span>
                <span class="value mono">Rp {{ number_format((float)$lpj->total_realisasi,0,',','.') }}</span>
            </div>
            <div class="row">
                <span class="label">Status LPJ</span>
                @php
                    $badge = 'badge-warn';
                    if ($lpj->status_lpj === 'Disetujui') $badge = 'badge-ok';
                    if (str_contains($lpj->status_lpj,'Revisi') || str_contains($lpj->status_lpj,'Tolak')) $badge = 'badge-danger';
                @endphp
                <span class="badge {{ $badge }}"><span class="material-icons">flag</span>{{ $lpj->status_lpj }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-2 mb-8">
        <div class="card">
            <div class="card-title">Rencana Anggaran (RAB)</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="center">Jumlah</th>
                            <th class="center">Satuan</th>
                            <th class="right">Harga Satuan</th>
                            <th class="right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan->itemsRab as $rab)
                            @php $tot = (int)$rab->jumlah * (float)$rab->harga_satuan; @endphp
                            <tr>
                                <td>{{ $rab->nama_item }}</td>
                                <td class="center">{{ $rab->jumlah }}</td>
                                <td class="center">{{ $rab->satuan }}</td>
                                <td class="right mono">Rp {{ number_format($rab->harga_satuan,0,',','.') }}</td>
                                <td class="right mono">Rp {{ number_format($tot,0,',','.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="center subtle" style="padding:12px 0">Tidak ada item RAB.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="right">Total RAB</td>
                            <td class="right mono">Rp {{ number_format((float)$pengajuan->total_rab,0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Realisasi (LPJ)</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pengeluaran</th>
                            <th class="center">Jumlah</th>
                            <th class="center">Satuan</th>
                            <th class="right">Harga</th>
                            <th class="right">Total</th>
                            <th class="center">Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lpj->items as $it)
                            @php $t = (int)$it->jumlah_realisasi * (float)$it->harga_realisasi; @endphp
                            <tr>
                                <td><strong>{{ $it->nama_pengeluaran }}</strong></td>
                                <td class="center">{{ $it->jumlah_realisasi }}</td>
                                <td class="center">{{ $it->satuan }}</td>
                                <td class="right mono">Rp {{ number_format($it->harga_realisasi,0,',','.') }}</td>
                                <td class="right mono">Rp {{ number_format($t,0,',','.') }}</td>
                                <td class="center">
                                    @if(!empty($it->path_foto_nota))
                                        <a class="subtle" href="{{ asset('storage/'.$it->path_foto_nota) }}" target="_blank">Lihat Nota</a>
                                    @else
                                        <span class="subtle">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="center subtle" style="padding:12px 0">Belum ada item realisasi.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="right">Total Realisasi</td>
                            <td class="right mono">Rp {{ number_format((float)$lpj->total_realisasi,0,',','.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Tindakan Screening</div>

        <form method="POST" action="{{ route('staf_ormawa.screening.lpj.update', $lpj->lpj_id) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="komentar" class="label" style="display:block;margin-bottom:6px;">Komentar / Revisi</label>
                <textarea id="komentar" name="komentar" rows="4" placeholder="Wajib diisi jika meminta revisi..."></textarea>
            </div>

            <div class="actions">
                <a href="{{ route('staf_ormawa.dashboard') }}" class="btn btn-outline">
                    <span class="material-icons">arrow_back</span> Kembali
                </a>

                <button type="submit" name="aksi" value="setujui" class="btn btn-primary">
                    <span class="material-icons">check_circle</span> Setujui & Teruskan
                </button>

                <button type="submit" name="aksi" value="revisi" class="btn btn-danger">
                    <span class="material-icons">edit_note</span> Minta Revisi
                </button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="card mt-6" style="border-color:rgba(74,222,128,.35);">
            <strong style="color:var(--ok);">Sukses:</strong> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="card mt-6" style="border-color:rgba(248,113,113,.35);">
            <strong style="color:var(--danger);">Error:</strong>
            <ul class="subtle" style="margin-top:8px;padding-left:18px;">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif
</div>
</body>
</html>
