@props(['title' => 'Chart', 'subtitle' => null])

{{-- Paksa warna teks card agar tidak ikut mewarisi text-white dari parent --}}
<div class="rounded-lg border bg-white shadow-sm p-4 text-slate-800 dark:bg-slate-800 dark:text-slate-100">
  <div class="mb-3">
    <div class="font-semibold text-slate-900 dark:text-slate-50">{{ $title }}</div>
    @if($subtitle)
      <div class="text-xs text-slate-500 dark:text-slate-300">{{ $subtitle }}</div>
    @endif
  </div>
  <div>
    {{ $slot }}
  </div>
</div>
