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
        <p class="font-semibold text-white">{{ $pengajuan['judul'] }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Pengaju</p>
        <p class="font-semibold text-white">{{ $pengajuan['pengaju'] }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Tanggal</p>
        <p class="font-semibold text-white">{{ $pengajuan['tanggal'] }}</p>
      </div>
      <div>
        <p class="text-gray-400 text-sm">Status</p>
        @if($pengajuan['status'] === 'menunggu')
          <span class="inline-block mt-1 px-3 py-1 rounded-full bg-yellow-400/20 text-yellow-400 text-xs font-medium">
            Menunggu Screening
          </span>
        @elseif($pengajuan['status'] === 'disetujui')
          <span class="inline-block mt-1 px-3 py-1 rounded-full bg-green-400/20 text-green-400 text-xs font-medium">
            Disetujui
          </span>
        @elseif($pengajuan['status'] === 'revisi')
          <span class="inline-block mt-1 px-3 py-1 rounded-full bg-red-400/20 text-red-400 text-xs font-medium">
            Perlu Revisi
          </span>
        @endif
      </div>
      <div>
        <p class="text-gray-400 text-sm">Proposal</p>
        <a href="{{ $pengajuan['proposal'] }}" target="_blank"
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
            <th class="px-4 py-3">Jumlah</th>
            <th class="px-4 py-3">Satuan</th>
            <th class="px-4 py-3">Harga Satuan</th>
            <th class="px-4 py-3">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pengajuan['rab'] as $row)
            <tr class="border-b border-gray-700 hover:bg-[#273549]">
              <td class="px-4 py-2">{{ $row['item'] }}</td>
              <td class="px-4 py-2">{{ $row['jumlah'] }}</td>
              <td class="px-4 py-2">{{ $row['satuan'] }}</td>
              <td class="px-4 py-2">Rp {{ number_format($row['harga'], 0, ',', '.') }}</td>
              <td class="px-4 py-2">Rp {{ number_format($row['total'], 0, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Form Screening -->
  <div class="bg-[#1E293B] rounded-2xl shadow-lg p-6">
    <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
      <i class="bi bi-clipboard-check"></i> Tindakan Screening
    </h4>
    <form method="POST" action="#">
      @csrf
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
