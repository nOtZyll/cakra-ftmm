@extends('layouts.app')
@section('title', 'Dashboard Stakeholder')

@section('content')
  {{-- Filter Bar sederhana (pakai GET agar URL shareable) --}}
  <form method="GET" class="mb-4 grid gap-3 md:flex md:items-end">
    <div>
      <label class="block text-sm font-medium text-slate-200 mb-1">Tahun</label>
      <select name="tahun" class="border rounded px-3 py-2 text-slate-800">
        @foreach($filterOptions['tahun'] as $t)
          <option value="{{ $t }}" {{ request('tahun')==$t ? 'selected' : '' }}>{{ $t }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-200 mb-1">ORMAWA</label>
      <select name="ormawa" class="border rounded px-3 py-2 text-slate-800">
        @foreach($filterOptions['ormawa'] as $o)
          <option value="{{ $o }}" {{ request('ormawa')==$o ? 'selected' : '' }}>{{ $o }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-200 mb-1">Periode</label>
      <input type="month" name="periode" value="{{ request('periode') }}" class="border rounded px-3 py-2 text-slate-800">
    </div>

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Terapkan</button>
      <a href="{{ route('stakeholder.dashboard') }}"
        class="px-4 py-2 rounded border border-slate-400 text-slate-200 hover:bg-slate-700">
        Reset
      </a>
    </div>
  </form>


  {{-- KPI Cards --}}
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
    <x-kpi-card title="Total Dana Cair" :value="number_format($kpi['dana_cair'],0,',','.')" prefix="Rp " :delta="$kpi['delta_dana']"/>
    <x-kpi-card title="Pengajuan Selesai" :value="$kpi['done']"/>
    <x-kpi-card title="Rata-rata Waktu" :value="number_format($kpi['lead_time'],1)" suffix=" hari"/>
    <x-kpi-card title="LPJ First-Pass" :value="$kpi['fp_rate']" suffix=" %"/>
  </div>

  {{-- ...potongan di bagian Charts... --}}
  <div class="grid gap-4 lg:grid-cols-2">
    <x-chart-card title="Total Dana Cair per Bulan" subtitle="(dalam juta rupiah)">
      <canvas id="chartDanaCair" style="min-height:300px"></canvas>
    </x-chart-card>

    <x-chart-card title="Pengeluaran per ORMAWA" subtitle="(dalam juta rupiah)">
      <canvas id="chartPerOrmawa" style="min-height:320px"></canvas>
    </x-chart-card>

    <x-chart-card title="Rata-rata Waktu Proses Pengajuan">
      <canvas id="chartLeadTime" style="min-height:300px"></canvas>
    </x-chart-card>
  </div>


  {{-- Ringkasan tabel --}}
  <div class="mt-6">
    @include('stakeholder.partials.summary-table', ['rows' => $summary])
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script>window.__charts = @json($charts);</script>
  <script src="{{ asset('js/stakeholder-dashboard.js') }}"></script>
@endpush
