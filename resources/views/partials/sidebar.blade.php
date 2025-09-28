<aside class="w-64 bg-[#0f172a] border-r border-gray-700 p-4 flex flex-col">
    <div class="text-yellow-400 font-bold text-xl mb-8">CAKRA FTMM</div>

    <nav class="flex-1">
        {{-- Sidebar Mahasiswa --}}
        @if ($role === 'mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Dashboard
            </a>

            <a href="{{ route('mahasiswa.pengajuan.create') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('mahasiswa.pengajuan.create') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Buat Pengajuan Baru
            </a>

            <a href="{{ route('mahasiswa.pengajuan.index') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('mahasiswa.pengajuan.index') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Riwayat Pengajuan
            </a>

            <a href="{{ route('mahasiswa.lpj.create') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('mahasiswa.lpj.create') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Kumpulkan LPJ
            </a>
        
        {{-- Sidebar Staf Ormawa --}}
        @elseif ($role === 'staf_ormawa')
            <a href="{{ route('staf_ormawa.dashboard') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('staf_ormawa.dashboard') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Dashboard
            </a>

            <a href="{{ route('staf_ormawa.screening.show', 1) }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('staf_ormawa.screening.*') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Screening Pengajuan
            </a>
        
        {{-- Sidebar Staf Fakultas --}}
        @elseif ($role === 'staf_fakultas')
            <a href="{{ route('staf_fakultas.dashboard') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('staf_fakultas.dashboard') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Dashboard
            </a>

            <a href="{{ route('staf_fakultas.verifikasi.lpj', 1) }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('staf_fakultas.verifikasi.*') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Verifikasi LPJ
            </a>
        
        {{-- Sidebar Stakeholder/Dekan --}}
        @elseif ($role === 'stakeholder')
            <a href="{{ route('stakeholder.dashboard') }}" 
               class="block py-2 px-3 rounded-lg mb-2 hover:bg-[#1e293b] 
               {{ request()->routeIs('stakeholder.dashboard') ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">
               Dashboard
            </a>
        @endif
    </nav>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="mt-auto block w-full text-left py-2 px-3 rounded-lg bg-red-600 hover:bg-red-700">
            Logout
        </button>
    </form>
</aside>
