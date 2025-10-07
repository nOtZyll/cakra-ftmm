@extends('layouts.app')

@section('title', 'Detail RAB')

@section('content')
<div class="container px-4 py-6">
    <h2 class="text-xl font-bold text-yellow-400 mb-4">📑 Detail Verifikasi RAB</h2>
    <p class="text-gray-400 mb-6">Periksa kesesuaian item dan anggaran yang diajukan oleh mahasiswa.</p>

    {{-- Info Pengajuan --}}
    <div class="bg-[#1e293b] rounded-xl p-6 shadow-lg mb-8">
         <div class="grid md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Judul Kegiatan</p>
                <p class="font-semibold text-white">{{ $pengajuan->judul_kegiatan }}</p>
            </div>
            <div>
                <p class="text-gray-400">Ormawa Pengaju</p>
                <p class="font-semibold text-white">{{ $pengajuan->ormawa->nama_ormawa }}</p>
            </div>
             <div>
                <p class="text-gray-400">Tanggal Pengajuan</p>
                <p class="font-semibold text-white">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Tabel RAB --}}
    <div class="bg-[#1e293b] rounded-xl p-6 shadow-lg">
        <h4 class="text-yellow-400 font-semibold mb-4">Rincian Anggaran</h4>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm text-gray-300">
                <thead class="text-gray-400 border-b border-gray-600">
                    <tr>
                        <th class="py-2 text-left">Item</th>
                        <th class="py-2 text-center">Jumlah</th>
                        <th class="py-2 text-center">Satuan</th>
                        <th class="py-2 text-right">Harga Satuan</th>
                        <th class="py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Mengganti data statis dengan loop dari controller --}}
                    @forelse ($pengajuan->itemsRab as $item)
                        <tr class="hover:bg-[#334155] transition border-b border-gray-700">
                            <td class="py-3">{{ $item->nama_item }}</td>
                            <td class="py-3 text-center">{{ $item->jumlah }}</td>
                            <td class="py-3 text-center">{{ $item->satuan }}</td>
                            <td class="py-3 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-3 text-right text-yellow-400">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada item RAB untuk pengajuan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="font-bold">
                    <tr>
                        <td colspan="4" class="pt-4 text-right">Total RAB Diajukan:</td>
                        <td class="pt-4 text-right text-yellow-400 text-lg">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
