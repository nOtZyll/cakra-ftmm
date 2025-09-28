@extends('layouts.app')

@section('title', 'Detail RAB')

@section('content')
<div class="container px-4 py-6">
    <h2 class="text-xl font-bold text-yellow-400 mb-6">📑 Detail Rencana Anggaran Biaya (RAB)</h2>

    <div class="bg-[#1e293b] rounded-xl p-6 shadow-lg hover:shadow-xl transition">
        <table class="table-auto w-full text-sm text-gray-300">
            <thead class="text-gray-400 border-b border-gray-600">
                <tr>
                    <th class="py-2">Item</th>
                    <th class="py-2">Jumlah</th>
                    <th class="py-2">Satuan</th>
                    <th class="py-2">Harga</th>
                    <th class="py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-[#334155] transition">
                    <td>Sewa Aula</td>
                    <td class="text-center">1</td>
                    <td class="text-center">Hari</td>
                    <td class="text-right">Rp 2.000.000</td>
                    <td class="text-right text-yellow-400">Rp 2.000.000</td>
                </tr>
                <tr class="hover:bg-[#334155] transition">
                    <td>Konsumsi</td>
                    <td class="text-center">100</td>
                    <td class="text-center">Pax</td>
                    <td class="text-right">Rp 50.000</td>
                    <td class="text-right text-yellow-400">Rp 5.000.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
