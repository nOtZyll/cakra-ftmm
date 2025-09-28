@props([
  'title' => 'KPI',
  'value' => '-',
  'delta' => null,   {{-- bisa + atau - (persen) --}}
  'prefix' => '',    {{-- mis. Rp --}}
  'suffix' => '',    {{-- mis. % atau ' hari' --}}
])

{{-- Paksa warna teks gelap di atas card putih, tapi tetap support dark mode --}}
<div class="rounded-lg border p-4 bg-white shadow-sm text-slate-800 dark:text-slate-100">
  <div class="text-sm text-slate-500 dark:text-slate-300">{{ $title }}</div>

  {{-- ANGKA UTAMA: paksa warna gelap/terang eksplisit --}}
  <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-slate-50">
    {{ $prefix }}{{ $value }}{{ $suffix }}
  </div>

  @if(!is_null($delta))
    <div class="mt-1 text-xs {{ $delta >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
      {{ $delta >= 0 ? '▲' : '▼' }} {{ number_format($delta, 1) }}%
      <span class="text-slate-400 dark:text-slate-400"> vs periode lalu</span>
    </div>
  @endif
</div>
