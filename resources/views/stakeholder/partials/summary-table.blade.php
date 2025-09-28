{{-- resources/views/stakeholder/partials/summary-table.blade.php --}}
<div class="rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
  <table class="w-full text-sm text-slate-800 dark:text-slate-100">
    <thead class="bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
      <tr class="[&>th]:p-3 [&>th]:font-semibold [&>th]:text-left [&>th]:border-b [&>th]:border-slate-200 dark:[&>th]:border-slate-600">
        <th>ORMAWA</th>
        <th># Pengajuan</th>
        <th>Dana Disetujui</th>
        <th>Dana Cair</th>
        <th>Rata2 Waktu (hari)</th>
        <th>% LPJ Valid</th>
      </tr>
    </thead>

    <tbody>
      @forelse($rows as $r)
        <tr class="odd:bg-white even:bg-slate-50 dark:odd:bg-slate-800 dark:even:bg-slate-900 [&>td]:p-3 [&>td]:border-b [&>td]:border-slate-200 dark:[&>td]:border-slate-700">
          <td class="font-medium">{{ $r['ormawa'] }}</td>
          <td>{{ $r['count'] }}</td>
          <td>Rp {{ number_format($r['disetujui'],0,',','.') }}</td>
          <td>Rp {{ number_format($r['cair'],0,',','.') }}</td>
          <td>{{ number_format($r['lead'],1) }}</td>
          <td>{{ $r['fp'] }}%</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="p-4 text-center text-slate-500 dark:text-slate-400">Tidak ada data</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
