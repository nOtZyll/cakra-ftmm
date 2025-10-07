@extends('layouts.app')

@section('title', 'Detail Screening')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold text-white mb-6">📑 Detail Screening Pengajuan</h2>

  <!-- Info Pengajuan -->
  <div class="bg-[#1E293B] rounded-2xl shadow-lg p-6 mb-8">
    <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
      <i class="bi bi-journal-text"></i> Informasi Pengajuan
    </h4>
    <div class="grid md:grid-cols-2 gap-6">
      <div>
        <p class="text-gray-400 text-sm">Judul Kegiatan</p>
        {{-- Diubah dari $pengajuan['judul'] menjadi data dari objek --}}
        <p class="font-semibold text-white">{{ $pengajuan->judul_kegiatan }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Ormawa Pengaju</p>
        {{-- Diubah dari $pengajuan['pengaju'] menjadi data dari relasi ormawa --}}
        <p class="font-semibold text-white">{{ $pengajuan->ormawa->nama_ormawa }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Tanggal Pengajuan</p>
        {{-- Diubah dari $pengajuan['tanggal'] dan diformat --}}
        <p class="font-semibold text-white">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Status Saat Ini</p>
        {{-- Diubah dari $pengajuan['status'] menjadi data dari relasi status --}}
        <span class="inline-block mt-1 px-3 py-1 rounded-full bg-yellow-400/20 text-yellow-400 text-xs font-medium">
          {{ $pengajuan->status->nama_status }}
        </span>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Proposal</p>
        {{-- Diubah dari $pengajuan['proposal'] menjadi link_dokumen --}}
        <a href="{{ $pengajuan->link_dokumen }}" target="_blank"
           class="inline-block mt-1 px-4 py-2 bg-yellow-500 text-black rounded-full text-sm font-semibold hover:bg-yellow-400 transition">
          <i class="bi bi-box-arrow-up-right"></i> Lihat Proposal
        </a>
      </div>
    </div>
  </div>

  <!-- Tabel RAB -->
  <div class="bg-[#1E293B] rounded-2xl shadow-lg p-6 mb-8">
    <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
      <i class="bi bi-cash-stack"></i> Rencana Anggaran Biaya (RAB)
    </h4>
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-300 border border-gray-700 rounded-lg">
        <thead class="bg-[#111827] text-gray-400 text-xs uppercase">
          <tr>
            <th class="px-4 py-3">Item</th>
            <th class="px-4 py-3 text-center">Jumlah</th>
            <th class="px-4 py-3">Satuan</th>
            <th class="px-4 py-3 text-right">Harga Satuan</th>
            <th class="px-4 py-3 text-right">Total</th>
          </tr>
        </thead>
        <tbody>
          {{-- Diubah untuk melakukan perulangan dari relasi itemsRab --}}
          @forelse($pengajuan->itemsRab as $item)
            <tr class="border-b border-gray-700 hover:bg-[#273549]">
              <td class="px-4 py-2">{{ $item->nama_item }}</td>
              <td class="px-4 py-2 text-center">{{ $item->jumlah }}</td>
              <td class="px-4 py-2">{{ $item->satuan }}</td>
              <td class="px-4 py-2 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
              {{-- Menghitung total otomatis --}}
              <td class="px-4 py-2 text-right">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-4">Tidak ada item RAB untuk pengajuan ini.</td>
            </tr>
          @endforelse
        </tbody>
        <tfoot class="bg-[#111827] font-semibold">
            <tr>
                <td colspan="4" class="px-4 py-3 text-right">Total RAB Diajukan:</td>
                {{-- Menampilkan total RAB dari data pengajuan utama --}}
                <td class="px-4 py-3 text-right text-yellow-400">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- Form Screening -->
  <div class="bg-[#1E293B] rounded-2xl shadow-lg p-6">
    <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
      <i class="bi bi-clipboard-check"></i> Tindakan Screening
    </h4>
    {{-- Menambahkan action ke rute yang sesuai (perlu dibuat nanti) --}}
    <form method="POST" action="#">
      @csrf
      @method('PUT') {{-- Menggunakan metode PUT untuk update status --}}
      <div class="mb-4">
        <label for="komentar" class="block text-sm text-gray-400 mb-1">Komentar / Revisi</label>
        <textarea id="komentar" name="komentar" rows="3"
                  class="w-full rounded-lg bg-[#111827] text-white border border-gray-700 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                  placeholder="Tuliskan komentar jika ada revisi..."></textarea>
      </div>
      <div class="flex gap-3">
        <button type="submit" name="aksi" value="setujui"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold flex items-center gap-2">
          <i class="bi bi-check-circle"></i> Setujui
        </button>
        <button type="submit" name="aksi" value="revisi"
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold flex items-center gap-2">
          <i class="bi bi-x-circle"></i> Minta Revisi
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
