@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="header">
        <div class="user-info">
            <div class="avatar">
                <span class="material-icons">person</span>
            </div>
            <div class="user-details">
                <h2>Detail Pengajuan</h2>
                <p>Lihat rincian lengkap dari pengajuan Anda.</p>
            </div>
        </div>
    </div>

    {{-- Kartu Ringkasan Utama --}}
    <div class="card mb-6">
        <h3 class="form-title">{{ $pengajuan->judul_kegiatan }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-subtext-dark mt-4">
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
                    $statusClass = 'text-yellow-400'; // Default
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

    {{-- Layout Dua Kolom --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Kolom Kiri: Rincian Anggaran --}}
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
                        <tr>
                            <td colspan="2" class="text-center p-4">Tidak ada rincian anggaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Kolom Kanan: Histori Status & Revisi --}}
        <div class="card">
            <h3 class="form-title mb-4">Histori Status & Catatan</h3>
            <ul class="space-y-4 text-gray-300 border-l-2 border-primary/30 pl-4">
                @forelse ($pengajuan->historiStatus->sortBy('timestamp') as $histori)
                <li>
                    <div class="flex justify-between items-center">
                        <p class="font-semibold">{{ $histori->status->nama_status }}</p>
                        <p class="text-xs text-subtext-dark">{{ \Carbon\Carbon::parse($histori->timestamp)->format('d M Y H:i') }}</p>
                    </div>
                    <p class="text-xs text-subtext-dark">Oleh: {{ $histori->user->name }}</p>
                    
                    {{-- Menampilkan komentar/catatan revisi jika ada --}}
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

    <div class="mt-8">
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn btn-outline">
            <span class="material-icons">arrow_back</span>
            Kembali ke Riwayat
        </a>
    </div>
@endsection
