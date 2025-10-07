<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengajuan Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            background-image: radial-gradient(circle at 20% 80%, rgba(116, 24, 71, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(7, 55, 99, 0.15) 0%, transparent 50%);
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(116, 24, 71, 0.2);
            padding: 20px 0;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
            margin-bottom: 20px;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: var(--subtext-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
        }
        
        .nav-item:hover, .nav-item.active {
            background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1));
            color: var(--text-dark);
            border-left: 3px solid var(--accent);
            transform: translateX(5px);
        }
        
        .nav-item .material-icons {
            margin-right: 10px;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover .material-icons {
            color: var(--accent);
            transform: scale(1.1);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            border: 2px solid var(--accent);
            position: relative;
            animation: pulse 2s infinite;
            transition: all 0.3s ease;
        }
        
        .avatar:hover {
            transform: scale(1.05);
            animation: rotate-glow 3s linear infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(116, 24, 71, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(116, 24, 71, 0); }
            100% { box-shadow: 0 0 0 0 rgba(116, 24, 71, 0); }
        }
        
        @keyframes rotate-glow {
            0% { 
                box-shadow: 0 0 10px rgba(116, 24, 71, 0.7), 
                           0 0 20px rgba(116, 24, 71, 0.5),
                           0 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(0deg);
            }
            25% { 
                box-shadow: 10px 0 10px rgba(116, 24, 71, 0.7), 
                           20px 0 20px rgba(116, 24, 71, 0.5),
                           30px 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(90deg);
            }
            50% { 
                box-shadow: 0 10px 10px rgba(116, 24, 71, 0.7), 
                           0 20px 20px rgba(116, 24, 71, 0.5),
                           0 30px 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(180deg);
            }
            75% { 
                box-shadow: -10px 0 10px rgba(116, 24, 71, 0.7), 
                           -20px 0 20px rgba(116, 24, 71, 0.5),
                           -30px 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(270deg);
            }
            100% { 
                box-shadow: 0 0 10px rgba(116, 24, 71, 0.7), 
                           0 0 20px rgba(116, 24, 71, 0.5),
                           0 0 30px rgba(116, 24, 71, 0.3);
                transform: scale(1.05) rotate(360deg);
            }
        }
        
        .user-details h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .user-details p {
            color: var(--subtext-dark);
            font-size: 0.9rem;
        }
        
        /* Glassmorphism Cards */
        .card {
            background: rgba(7, 55, 99, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
            border-color: rgba(116, 24, 71, 0.4);
            background: rgba(7, 55, 99, 0.15);
        }
        
        /* Animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Form Styles */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .form-subtitle {
            color: var(--subtext-dark);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .form-input, .form-select {
            width: 100%;
            background: rgba(7, 55, 99, 0.15);
            border: 1px solid rgba(116, 24, 71, 0.3);
            border-radius: 8px;
            padding: 12px 15px;
            color: var(--text-dark);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(116, 24, 71, 0.2);
            background: rgba(7, 55, 99, 0.2);
        }
        
        .form-input::placeholder {
            color: var(--subtext-dark);
        }
        
        .form-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        
        .form-link:hover {
            color: var(--text-dark);
            transform: translateX(3px);
        }
        
        .form-link .material-icons {
            font-size: 16px;
            margin-right: 5px;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-bottom: 20px;
        }
        
        .form-table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(7, 55, 99, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .form-table th {
            background: rgba(7, 55, 99, 0.2);
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 1px solid rgba(116, 24, 71, 0.2);
        }
        
        .form-table td {
            padding: 10px 15px;
            border-bottom: 1px solid rgba(116, 24, 71, 0.1);
        }
        
        .form-table tr:last-child td {
            border-bottom: none;
        }
        
        .form-table input {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--text-dark);
            padding: 5px;
            font-size: 0.9rem;
        }
        
        .form-table input:focus {
            outline: none;
            background: rgba(116, 24, 71, 0.1);
            border-radius: 4px;
        }
        
        .table-total {
            background: rgba(7, 55, 99, 0.2);
            font-weight: 600;
            padding: 12px 15px;
            border-radius: 0 0 8px 8px;
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: #052a52;
            transform: translateY(-2px);
        }
        
        .btn-accent {
            background: var(--accent);
            color: white;
        }
        
        .btn-accent:hover {
            background: #5a1439;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
        }
        
        .btn-outline:hover {
            background: rgba(116, 24, 71, 0.1);
        }
        
        .btn-danger {
            background: rgba(244, 67, 54, 0.2);
            color: #f44336;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }
        
        .btn-danger:hover {
            background: rgba(244, 67, 54, 0.3);
        }
        
        .btn .material-icons {
            margin-right: 5px;
            font-size: 18px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar .logo h1, .sidebar .nav-text {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: 15px 0;
            }
            
            .nav-item .material-icons {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .main-content.sidebar-active {
                margin-left: 70px;
            }
            
            .form-table {
                font-size: 0.8rem;
            }
            
            .form-table th, .form-table td {
                padding: 8px 10px;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1000;
                background: var(--primary);
                color: white;
                border: none;
                border-radius: 5px;
                padding: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .menu-toggle:hover {
                transform: scale(1.1);
            }
        }
        
        /* Menu toggle untuk mobile */
        .menu-toggle {
            display: none;
        }
        
        /* Feedback animasi saat mengklik */
        .click-feedback {
            animation: clickEffect 0.3s ease;
        }
        
        @keyframes clickEffect {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Menu Toggle untuk Mobile -->
    <button class="menu-toggle material-icons" id="menuToggle">menu</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h1>CAKRA</h1>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="nav-item active">
            <span class="material-icons">description</span>
            <span class="nav-text">Pengajuan</span>
        </a>
        <a href="{{ route('mahasiswa.lpj.index') }}" class="nav-item">
            <span class="material-icons">assignment</span>
            <span class="nav-text">LPJ</span>
        </a>
        <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-info">
                <div class="avatar">
                    <span class="material-icons">person</span>
                </div>
                <div class="user-details">
                    <h2>Buat Pengajuan Baru</h2>
                    <p>Isi formulir pengajuan kegiatan atau reimbursement</p>
                </div>
            </div>
        </div>

        <div class="form-container">
            <h1 class="form-title">Buat Pengajuan Baru</h1>
            <p class="form-subtitle">Ajukan proposal kegiatan atau reimbursement untuk organisasi Anda</p>

            {{-- Menampilkan pesan error validasi jika ada --}}
            @if ($errors->any())
                <div class="card bg-red-500/20 text-red-400 mb-4 p-4">
                    <p class="font-bold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PERUBAHAN 1: Tag form dihubungkan ke backend --}}
            <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}" class="space-y-6 card">
                @csrf
                <!-- Step 1: ORMAWA + Jenis Surat -->
                <div class="form-group">
                    <label class="form-label" for="ormawa_id">Pilih ORMAWA</label>
                    {{-- PERUBAHAN 2: Dropdown diisi dari controller --}}
                    <select class="form-select" name="ormawa_id" id="ormawa_id" required>
                        <option value="">-- Pilih ORMAWA --</option>
                        @foreach ($ormawas as $ormawa)
                            <option value="{{ $ormawa->ormawa_id }}" {{ old('ormawa_id') == $ormawa->ormawa_id ? 'selected' : '' }}>
                                {{ $ormawa->nama_ormawa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="jenis_surat_id">Jenis Surat</label>
                    <select class="form-select" name="jenis_surat_id" id="jenis_surat_id" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach ($jenisSurats as $jenis)
                            <option value="{{ $jenis->jenis_surat_id }}" {{ old('jenis_surat_id') == $jenis->jenis_surat_id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Step 2: Detail Kegiatan -->
                <div class="form-group">
                    <label class="form-label" for="judul_kegiatan">Judul Kegiatan</label>
                    {{-- PERUBAHAN 3: Tambah atribut 'name' dan 'value' --}}
                    <input type="text" class="form-input" name="judul_kegiatan" id="judul_kegiatan" placeholder="Masukkan judul kegiatan" required value="{{ old('judul_kegiatan') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="link_dokumen">Link Google Docs Proposal</label>
                    <input type="url" class="form-input" name="link_dokumen" id="link_dokumen" placeholder="https://docs.google.com/document/d/..." required value="{{ old('link_dokumen') }}">
                </div>

                <!-- Step 3: Input RAB -->
                <div class="form-group">
                    <label class="form-label">Rencana Anggaran Biaya (RAB)</label>
                    <div class="table-container">
                        <table class="form-table" id="rabTable">
                            <thead>
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan (Rp)</th>
                                    <th>Total (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- PERUBAHAN 4: Tambah atribut 'name' ke setiap input di tabel --}}
                                <tr>
                                    <td><input type="text" name="items[0][nama_item]" placeholder="Nama item" class="item-name" required></td>
                                    <td><input type="number" name="items[0][jumlah]" class="jumlah" value="1" min="1" required></td>
                                    <td><input type="text" name="items[0][satuan]" placeholder="Satuan" value="Unit" required></td>
                                    <td><input type="number" name="items[0][harga_satuan]" class="harga" value="0" min="0" required></td>
                                    <td class="total">0</td>
                                    <td><button type="button" onclick="hapusBaris(this)" class="btn btn-danger">Hapus</button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="table-total">Total Keseluruhan</td>
                                    <td colspan="2" class="table-total" id="grandTotal">Rp 0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="button" onclick="tambahBaris()" class="btn btn-outline mt-3">
                        <span class="material-icons">add</span>
                        Tambah Item
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 mt-8">
                    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn btn-outline flex-1">
                        <span class="material-icons">arrow_back</span>
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-accent flex-1">
                        <span class="material-icons">save</span>
                        Simpan Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let rowIndex = 1;
        
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Kode toggle sidebar Anda)
            hitungTotal();
            pasangListener();
        });

        function hitungTotal() {
            let grandTotal = 0;
            document.querySelectorAll("#rabTable tbody tr").forEach(row => {
                let jumlah = parseInt(row.querySelector(".jumlah").value) || 0;
                let harga = parseInt(row.querySelector(".harga").value) || 0;
                let total = jumlah * harga;
                row.querySelector(".total").innerText = total.toLocaleString('id-ID');
                grandTotal += total;
            });
            document.getElementById("grandTotal").innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        function tambahBaris() {
            // PERUBAHAN 5: Sesuaikan 'name' pada baris baru yang dibuat
            let rowHTML = `
            <tr>
                <td><input type="text" name="items[${rowIndex}][nama_item]" placeholder="Nama item" class="item-name" required></td>
                <td><input type="number" name="items[${rowIndex}][jumlah]" class="jumlah" value="1" min="1" required></td>
                <td><input type="text" name="items[${rowIndex}][satuan]" placeholder="Satuan" value="Unit" required></td>
                <td><input type="number" name="items[${rowIndex}][harga_satuan]" class="harga" value="0" min="0" required></td>
                <td class="total">0</td>
                <td><button type="button" onclick="hapusBaris(this)" class="btn btn-danger">Hapus</button></td>
            </tr>`;
            document.querySelector("#rabTable tbody").insertAdjacentHTML("beforeend", rowHTML);
            pasangListener();
            rowIndex++;
        }

        function hapusBaris(btn) {
            // ... (Fungsi hapusBaris Anda tidak perlu diubah)
            if (document.querySelectorAll("#rabTable tbody tr").length > 1) {
                btn.closest("tr").remove();
                hitungTotal();
            } else {
                alert("Minimal harus ada satu item dalam RAB");
            }
        }

    function pasangListener() {
        document.querySelectorAll(".jumlah, .harga").forEach(input => {
            input.removeEventListener("input", hitungTotal);
            input.addEventListener("input", hitungTotal);
        });
    }
</script>
