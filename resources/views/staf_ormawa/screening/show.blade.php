<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Screening - CAKRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); min-height: 100vh; display: flex; }
        .sidebar { width: 250px; background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border-right: 1px solid rgba(116, 24, 71, 0.2); padding: 20px 0; height: 100vh; position: fixed; z-index: 100; }
        .logo { padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-item { padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark); text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1)); color: var(--text-dark); border-left-color: var(--accent); }
        .nav-item .material-icons { margin-right: 10px; font-size: 20px; }
        .main-content { flex: 1; margin-left: 250px; padding: 30px; }
        .bg-\[\#1E293B\] { background-color: #1E293B; }
        .rounded-2xl { border-radius: 1rem; }
        .p-6 { padding: 1.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-4 { margin-bottom: 1rem; }
        .text-2xl { font-size: 1.5rem; }
        .font-bold { font-weight: 700; }
        .text-white { color: #fff; }
        .text-yellow-400 { color: #facc15; }
        .font-semibold { font-weight: 600; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .grid { display: grid; }
        .md\:grid-cols-2 { @media (min-width: 768px) { grid-template-columns: repeat(2, 1fr); } }
        .gap-6 { gap: 1.5rem; }
        .text-gray-400 { color: #9ca3af; }
        .text-sm { font-size: 0.875rem; }
        .inline-block { display: inline-block; }
        .mt-1 { margin-top: 0.25rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .rounded-full { border-radius: 9999px; }
        .bg-yellow-400\/20 { background-color: rgba(250, 204, 21, 0.2); }
        .text-xs { font-size: 0.75rem; }
        .font-medium { font-weight: 500; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .bg-yellow-500 { background-color: #eab308; }
        .text-black { color: #000; }
        .hover\:bg-yellow-400:hover { background-color: #facc15; }
        .transition { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
        .overflow-x-auto { overflow-x: auto; }
        .w-full { width: 100%; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .border { border-width: 1px; }
        .border-gray-700 { border-color: #374151; }
        .rounded-lg { border-radius: 0.5rem; }
        .bg-\[\#111827\] { background-color: #111827; }
        .uppercase { text-transform: uppercase; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .border-b { border-bottom-width: 1px; }
        .hover\:bg-\[\#273549\]:hover { background-color: #273549; }
        .bg-green-500 { background-color: #22c55e; }
        .hover\:bg-green-600:hover { background-color: #16a34a; }
        .bg-red-500 { background-color: #ef4444; }
        .hover\:bg-red-600:hover { background-color: #dc2626; }
        .w-full { width: 100%; }
        .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
        .focus\:ring-yellow-500:focus { --tw-ring-color: #eab308; }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo"><h1>CAKRA</h1></div>
        @auth
            @if(Auth::user()->role->role_name == 'staf_ormawa')
                <a href="{{ route('staf_ormawa.dashboard') }}" class="nav-item active">
                    <span class="material-icons">checklist</span>
                    <span class="nav-text">Screening Proposal</span>
                </a>
            @endif
            <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="material-icons">logout</span>
                <span class="nav-text">Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @endauth
    </div>

    <div class="main-content" id="mainContent">
        <h2 class="text-2xl font-bold text-white mb-6">📑 Detail Screening Pengajuan</h2>

        <div class="bg-[#1E293B] rounded-2xl p-6 mb-8">
            <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
                <i class="bi bi-journal-text"></i> Informasi Pengajuan
            </h4>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-400 text-sm">Judul Kegiatan</p>
                    <p class="font-semibold text-white">{{ $pengajuan->judul_kegiatan }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Ormawa Pengaju</p>
                    <p class="font-semibold text-white">{{ $pengajuan->ormawa->nama_ormawa }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Tanggal Pengajuan</p>
                    <p class="font-semibold text-white">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Status Saat Ini</p>
                    <span class="inline-block mt-1 px-3 py-1 rounded-full bg-yellow-400/20 text-yellow-400 text-xs font-medium">
                        {{ $pengajuan->status->nama_status }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Proposal</p>
                    <a href="{{ $pengajuan->link_dokumen }}" target="_blank"
                       class="inline-block mt-1 px-4 py-2 bg-yellow-500 text-black rounded-full text-sm font-semibold hover:bg-yellow-400 transition">
                        <i class="bi bi-box-arrow-up-right"></i> Lihat Proposal
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-[#1E293B] rounded-2xl p-6 mb-8">
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
                        @forelse($pengajuan->itemsRab as $item)
                            <tr class="border-b border-gray-700 hover:bg-[#273549]">
                                <td class="px-4 py-2">{{ $item->nama_item }}</td>
                                <td class="px-4 py-2 text-center">{{ $item->jumlah }}</td>
                                <td class="px-4 py-2">{{ $item->satuan }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4">Tidak ada item RAB.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-[#111827] font-semibold">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right">Total RAB Diajukan:</td>
                            <td class="px-4 py-3 text-right text-yellow-400">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="bg-[#1E293B] rounded-2xl p-6">
            <h4 class="text-yellow-400 font-semibold mb-4 flex items-center gap-2">
                <i class="bi bi-clipboard-check"></i> Tindakan Screening
            </h4>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
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
</body>
</html>