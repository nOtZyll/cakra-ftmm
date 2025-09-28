<header class="bg-[#1e293b] border-b border-gray-700 px-6 py-4 flex justify-between items-center">
    <h1 class="text-lg font-semibold">@yield('title')</h1>

    <div class="flex items-center gap-4">
        <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-sm">Mahasiswa</span>
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">U</div>
            <span>{{ Auth::user()->name ?? 'Nama Mahasiswa' }}</span>
        </div>
    </div>
</header>
