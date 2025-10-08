<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi LPJ - CAKRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary: #073763; --accent: #741847; --bg-dark: #0A192F;
            --text-dark: #E0E6F1; --subtext-dark: #94A3B8; --success: #28a745; --danger: #dc3545;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-dark); color: var(--text-dark); display: flex; }

        .sidebar { width: 250px; background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border-right: 1px solid rgba(116, 24, 71, 0.2); padding: 20px 0; height: 100vh; position: fixed; z-index: 1056; }
        .logo { padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; }
        .logo h1 { font-size: 1.5rem; font-weight: 700; background: linear-gradient(90deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-item { padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark); text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; }
        .nav-item:hover, .nav-item.active { background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1)); color: var(--text-dark); border-left-color: var(--accent); }
        .nav-item .material-icons { margin-right: 10px; font-size: 20px; }
        .main-content { flex: 1; margin-left: 250px; padding: 30px; }

        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 1.8rem; font-weight: 700; }
        .page-subtitle { color: var(--subtext-dark); }
        .card { background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px; padding: 20px; height: 100%; }
        .form-title { color: var(--text-dark); font-size: 1.3rem; font-weight: 600; display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; }
        .table-container { overflow-x: auto; }
        
        /* ================================================= */
        /* ==> PERBAIKAN 1: Teks Tabel & Total Menjadi Terang <== */
        .form-table { width: 100%; border-collapse: collapse; color: var(--text-dark) !important; /* Tambahkan ini */ }
        .form-table th, .form-table td { padding: 12px 15px; border-bottom: 1px solid rgba(116, 24, 71, 0.1); text-align: left; vertical-align: middle; }
        .form-table thead th { background: rgba(7, 55, 99, 0.2); }
        tfoot td { font-weight: bold; border-bottom: none !important; }
        /* ================================================= */

        textarea.form-control { width: 100%; background: rgba(7, 55, 99, 0.2); border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 8px; padding: 12px; color: var(--text-dark); font-family: 'Poppins', sans-serif; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; gap: 8px; flex: 1; }
        .btn-success { background: var(--success); color: white; }
        .btn-danger { background: var(--danger); color: white; }
        .btn-link { background: none; border: none; color: var(--accent); padding: 0; cursor: pointer; text-decoration: underline; font-weight: 500; font-size: 0.9rem; }
        
        .modal-content { background: var(--bg-dark); border: 1px solid rgba(116, 24, 71, 0.3); color: var(--text-dark); }
        .modal-header { border-bottom: 1px solid rgba(116, 24, 71, 0.2); }
        .modal-body img { max-height: 70vh; width: 100%; object-fit: contain; }
        
        .grid { display: grid; }
        .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .d-flex { display: flex; }
        .gap-4 { gap: 1rem; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><h1>CAKRA</h1></div>
        <a href="{{ route('staf_fakultas.dashboard') }}" class="nav-item">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item active">
            <span class="material-icons">task_alt</span>
            <span class="nav-text">Verifikasi LPJ</span>
        </a>
        <a href="{{ route('logout') }}" class="nav-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Verifikasi Laporan Pertanggungjawaban (LPJ)</h1>
            <p class="page-subtitle">Periksa kesesuaian realisasi anggaran dengan nota yang dilampirkan.</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="card">
                <h3 class="form-title"><span class="material-icons">description</span> Rencana Anggaran (RAB)</h3>
                <div class="table-container">
                    <table class="form-table">
                        <thead> <tr> <th>Item</th> <th class="text-right">Total Diajukan</th> </tr> </thead>
                        <tbody>
                            @forelse($pengajuan->itemsRab as $item)
                            <tr> <td>{{ $item->nama_item }}</td> <td class="text-right">Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td> </tr>
                            @empty
                            <tr><td colspan="2" class="text-center">Tidak ada data RAB.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot> <tr> <td class="text-right">Total RAB Disetujui:</td> <td class="text-right">Rp {{ number_format($pengajuan->total_rab, 0, ',', '.') }}</td> </tr> </tfoot>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3 class="form-title"><span class="material-icons">task_alt</span> Realisasi Anggaran (LPJ)</h3>
                <div class="table-container">
                    <table class="form-table">
                        <thead> <tr> <th>Item Realisasi</th> <th class="text-center">Nota</th> <th class="text-right">Total Realisasi</th> </tr> </thead>
                        <tbody>
                             @forelse($lpj->itemsLpj as $item)
                            <tr>
                                <td>{{ $item->nama_pengeluaran }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn-link" data-bs-toggle="modal" data-bs-target="#notaModal{{ $item->item_lpj_id }}">
                                        Lihat
                                    </button>
                                </td>
                                <td class="text-right">Rp {{ number_format($item->harga_realisasi * $item->jumlah_realisasi, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Tidak ada data realisasi LPJ.</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot> <tr> <td colspan="2" class="text-right">Total Realisasi Dilaporkan:</td> <td class="text-right">Rp {{ number_format($lpj->total_realisasi, 0, ',', '.') }}</td> </tr> </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-6">
            <h3 class="form-title"><span class="material-icons">gavel</span> Aksi Verifikasi</h3>
            @if ($errors->any())
                <div style="color: var(--danger); margin-bottom: 1rem;">
                    <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
                </div>
            @endif
            <form action="{{ route('staf_fakultas.verifikasi.lpj.update', $lpj) }}" method="POST">
                @csrf
                @method('PUT')
    
                <div class="d-flex gap-4 mt-6">
                    <button type="submit" name="action" value="setuju" class="btn btn-success">Setujui LPJ</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($lpj->itemsLpj as $item)
    <div class="modal fade" id="notaModal{{ $item->item_lpj_id }}" tabindex="-1" aria-labelledby="notaModalLabel{{ $item->item_lpj_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notaModalLabel{{ $item->item_lpj_id }}">Nota: {{ $item->nama_pengeluaran }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ Storage::url($item->path_foto_nota) }}" class="img-fluid rounded" alt="Nota untuk {{ $item->nama_pengeluaran }}">
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = this.querySelector('i');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
            } else {
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-left');
            }
        });

        // Fungsi untuk menangani persetujuan LPJ
        document.getElementById('btnSetujui').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.checkbox-custom');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            
            if (allChecked) {
                if (confirm('Apakah Anda yakin ingin menyetujui LPJ ini?')) {
                    alert('LPJ berhasil disetujui!');
                    // Redirect ke dashboard setelah persetujuan
                    window.location.href = "{{ route('staf_fakultas.dashboard') }}";
                }
            } else {
                alert('Harap centang semua item yang valid sebelum menyetujui LPJ.');
            }
        });

        // Fungsi untuk mengirim revisi
        document.getElementById('btnRevisi').addEventListener('click', function() {
            const comment = document.querySelector('textarea').value;
            if (comment.trim() === '') {
                alert('Harap isi komentar/revisi sebelum mengirim.');
                return;
            }
            
            if (confirm('Apakah Anda yakin ingin mengirim revisi?')) {
                alert('Revisi berhasil dikirim!');
                // Tetap di halaman ini setelah mengirim revisi
            }
        });

        // Update active state di sidebar berdasarkan halaman saat ini
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath || 
                    (currentPath.includes('lpi_show') && link.getAttribute('href').includes('lpi_show'))) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>