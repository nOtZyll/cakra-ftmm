@props(['status' => 'diajukan'])
@php
  $map = [
    'diajukan'=>'bg-warning text-dark',
    'diproses'=>'bg-info text-white',
    'revisi'=>'bg-secondary text-white',
    'disetujui'=>'bg-success text-white',
    'ditolak'=>'bg-danger text-white',
    'cair'=>'bg-primary text-white'
  ];
  $cls = $map[$status] ?? 'bg-light text-dark';
@endphp
<span class="badge {{ $cls }} py-2 px-2" style="font-weight:600; font-size:.85rem">{{ ucfirst($status) }}</span>
