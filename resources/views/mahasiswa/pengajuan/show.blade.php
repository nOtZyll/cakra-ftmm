@extends('layouts.app')
@section('title', 'Detail Pengajuan')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Pengajuan</h2>

<div class="bg-gray-800 p-4 rounded mb-4 text-white">
    <h3 class="font-semibold">Judul: Seminar Nasional</h3>
    <p>Status: <span class="text-yellow-400">Menunggu Tanda Tangan SPTJM</span></p>
    <p>Total RAB: Rp 5.000.000</p>
</div>

<h3 class="font-semibold mb-2">Histori Status</h3>
<ul class="space-y-2 text-gray-300">
    <li>📌 Draft Dibuat - 2025-09-01</li>
    <li>📌 Diajukan ke Fakultas - 2025-09-05</li>
    <li>📌 Menunggu Tanda Tangan SPTJM - 2025-09-10</li>
</ul>

<h3 class="font-semibold mt-6 mb-2">Revisi</h3>
<div class="bg-red-600/20 p-3 rounded text-red-400">
    Mohon lengkapi dokumen RAB lampiran.
</div>
@endsection
