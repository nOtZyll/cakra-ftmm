<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <h1>CAKRA</h1>
    </div>

    {{-- =============================================== --}}
    {{-- ==        MENU UNTUK ROLE MAHASISWA          == --}}
    {{-- =============================================== --}}
    @if (Auth::user()->role->role_name == 'mahasiswa')
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'active' : '' }}">
            <span class="material-icons">description</span>
            <span class="nav-text">Pengajuan</span>
        </a>
        <a href="{{ route('mahasiswa.lpj.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.lpj.*') ? 'active' : '' }}">
            <span class="material-icons">assignment</span>
            <span class="nav-text">LPJ</span>
        </a>
    @endif

    {{-- =============================================== --}}
    {{-- ==      MENU UNTUK ROLE STAF ORMAWA          == --}}
    {{-- =============================================== --}}
    @if (Auth::user()->role->role_name == 'staf_ormawa')
        <a href="#" class="nav-item">
            <span class="material-icons">checklist</span>
            <span class="nav-text">Screening Proposal</span>
        </a>
        <a href="#" class="nav-item">
            <span class="material-icons">rule</span>
            <span class="nav-text">Verifikasi LPJ</span>
        </a>
    @endif

    {{-- =============================================== --}}
    {{-- ==   MENU UNTUK ROLE STAF KEUANGAN FAKULTAS  == --}}
    {{-- =============================================== --}}
    @if (Auth::user()->role->role_name == 'staf_fakultas')
        <a href="#" class="nav-item">
            <span class="material-icons">account_balance_wallet</span>
            <span class="nav-text">Validasi Anggaran</span>
        </a>
        <a href="#" class="nav-item">
            <span class="material-icons">receipt_long</span>
            <span class="nav-text">Validasi LPJ</span>
        </a>
        <a href="#" class="nav-item">
            <span class="material-icons">history</span>
            <span class="nav-text">Histori Pengeluaran</span>
        </a>
    @endif


    {{-- =============================================== --}}
    {{-- ==          MENU UMUM UNTUK SEMUA ROLE       == --}}
    {{-- =============================================== --}}
    <a href="{{ route('logout') }}" class="nav-item"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="material-icons">logout</span>
        <span class="nav-text">Keluar</span>
    </a>

    <!-- Form Logout (tersembunyi) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

