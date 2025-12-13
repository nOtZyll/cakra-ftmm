<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin CAKRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* --- ROOT VARIABLES --- */
        :root { --primary: #073763; --accent: #741847; --bg-dark: #0A192F; --text-dark: #E0E6F1; --subtext-dark: #94A3B8; }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            background-image: radial-gradient(circle at 20% 80%, rgba(116, 24, 71, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(7, 55, 99, 0.15) 0%, transparent 50%);
        }
    
        /* --- SIDEBAR STYLE --- */
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
        
        .logo { padding: 0 20px 20px; border-bottom: 1px solid rgba(116, 24, 71, 0.2); margin-bottom: 20px; }
        .logo h1 {
            font-size: 1.5rem; font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        
        .nav-item {
            padding: 12px 20px; display: flex; align-items: center; color: var(--subtext-dark);
            text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; cursor: pointer;
        }
        .nav-item:hover, .nav-item.active {
            background: linear-gradient(90deg, rgba(7, 55, 99, 0.2), rgba(116, 24, 71, 0.1));
            color: var(--text-dark); border-left: 3px solid var(--accent); transform: translateX(5px);
        }
        .nav-item .material-icons { margin-right: 10px; font-size: 20px; transition: all 0.3s ease; }
        .nav-item:hover .material-icons { color: var(--accent); transform: scale(1.1); }
    
        /* --- CONTENT STYLE --- */
        .main-content { flex: 1; margin-left: 250px; padding: 30px; overflow-y: auto; transition: all 0.3s ease; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-info { display: flex; align-items: center; }
        
        .avatar {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            margin-right: 15px; border: 2px solid var(--accent);
        }
        
        .user-details h2 { font-size: 1.5rem; font-weight: 600; }
        .user-details p { color: var(--subtext-dark); font-size: 0.9rem; }
        
        /* --- TABLE CARD STYLE --- */
        .card {
            background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        th {
            background: rgba(7, 55, 99, 0.3);
            color: var(--text-dark); padding: 15px; text-align: left; font-size: 0.9rem;
            border-bottom: 1px solid rgba(116, 24, 71, 0.3);
        }
        td {
            padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--subtext-dark); font-size: 0.9rem;
        }
        tr:hover { background: rgba(255, 255, 255, 0.05); }

        /* --- BADGES & BUTTONS --- */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-admin { background: rgba(220, 38, 38, 0.2); color: #fca5a5; border: 1px solid rgba(220, 38, 38, 0.3); }
        .badge-mahasiswa { background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); }
        .badge-staf { background: rgba(147, 51, 234, 0.2); color: #d8b4fe; border: 1px solid rgba(147, 51, 234, 0.3); }

        .btn-edit { 
            background: transparent; border: 1px solid var(--accent); color: var(--accent); 
            padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.3s; 
        }
        .btn-edit:hover { background: var(--accent); color: white; }

        /* --- MODAL ANIMATIONS & STYLE --- */
        .modal {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; overflow: hidden;
            background-color: rgba(10, 25, 47, 0.8); backdrop-filter: blur(8px);
            transition: all 0.3s ease; opacity: 0;
        }

        .modal.show {
            display: flex; align-items: center; justify-content: center; opacity: 1;
        }

        .modal-content {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 1px solid rgba(116, 24, 71, 0.3); width: 90%; max-width: 480px;
            border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: scale(0.7); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal.show .modal-content { transform: scale(1); }

        /* Dropdown Slide Animation */
        #ormawaField {
            max-height: 0; opacity: 0; overflow: hidden;
            transition: all 0.4s ease-in-out; transform: translateY(-10px);
        }
        #ormawaField.visible {
            max-height: 200px; opacity: 1; transform: translateY(0); margin-top: 1rem;
        }

        /* Input Focus Glow */
        .input-interactive:focus {
            border-color: #741847; box-shadow: 0 0 0 4px rgba(116, 24, 71, 0.2); transform: translateY(-2px);
        }

        /* Mobile Toggle */
        .menu-toggle { display: none; }
        @media (max-width: 768px) {
            .sidebar { width: 70px; transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .sidebar .logo h1, .sidebar .nav-text { display: none; }
            .nav-item { justify-content: center; padding: 15px 0; }
            .nav-item .material-icons { margin-right: 0; }
            .main-content { margin-left: 0; padding: 15px; }
            .menu-toggle {
                display: block; position: fixed; top: 15px; left: 15px; z-index: 1000;
                background: var(--primary); color: white; border: none; border-radius: 5px; padding: 8px;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle material-icons" onclick="document.querySelector('.sidebar').classList.toggle('active')">menu</button>

    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h1>CAKRA ADMIN</h1>
        </div>
        
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="material-icons">dashboard</span>
            <span class="nav-text">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="material-icons">people</span>
            <span class="nav-text">Kelola User</span>
        </a>

        <a href="#" class="nav-item">
            <span class="material-icons">groups</span>
            <span class="nav-text">Data Ormawa</span>
        </a>
        <a href="#" class="nav-item">
            <span class="material-icons">settings</span>
            <span class="nav-text">Pengaturan</span>
        </a>
        
        <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            <span class="nav-text">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-info">
                <div class="avatar">
                    <span class="material-icons">admin_panel_settings</span>
                </div>
                <div class="user-details">
                    <h2>Kelola Pengguna</h2>
                    <p>Manajemen Hak Akses & Role</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-600/20 border border-green-500/50 text-green-300 flex items-center shadow-lg">
                <span class="material-icons mr-2">check_circle</span>{{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role Saat Ini</th>
                            <th>Ormawa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="font-semibold text-white">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <span class="badge {{ $u->role->role_name == 'admin' ? 'badge-admin' : ($u->role->role_name == 'mahasiswa' ? 'badge-mahasiswa' : 'badge-staf') }}">
                                    {{ ucfirst(str_replace('_', ' ', $u->role->role_name)) }}
                                </span>
                            </td>
                            <td>{{ $u->ormawa->nama_ormawa ?? '-' }}</td>
                            <td class="text-center">
                                <button onclick="openEditModal('{{ $u->user_id }}', '{{ $u->name }}', '{{ $u->role_id }}', '{{ $u->ormawa_id }}')" class="btn-edit">
                                    Edit Role
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-5">{{ $users->links() }}</div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="p-6 border-b border-white/10 flex justify-between items-center bg-[#073763]/20 rounded-t-xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#741847]/20 rounded-lg text-[#741847]">
                        <span class="material-icons text-xl">manage_accounts</span>
                    </div>
                    <h3 class="text-lg font-bold text-white tracking-wide">Edit Role User</h3>
                </div>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-transform hover:rotate-90">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <form id="editForm" method="POST" class="p-6" onsubmit="startLoading()">
                @csrf
                @method('PUT')

                <div class="mb-4 group">
                    <label class="block text-xs font-semibold text-[#94A3B8] uppercase tracking-wider mb-2">Nama Pengguna</label>
                    <div class="flex items-center bg-[#0A192F] border border-white/10 rounded-lg px-3 py-3">
                        <span class="material-icons text-slate-500 mr-3 text-sm">person</span>
                        <input type="text" id="modalUserName" class="w-full bg-transparent text-white font-medium outline-none cursor-not-allowed opacity-70" readonly>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-semibold text-[#94A3B8] uppercase tracking-wider mb-2">Pilih Role</label>
                    <div class="relative">
                        <select name="role_id" id="roleSelect" class="input-interactive w-full bg-[#0A192F] border border-white/20 rounded-lg px-4 py-3 text-white appearance-none outline-none transition-all cursor-pointer">
                            @foreach($roles as $role)
                                <option value="{{ $role->role_id }}">{{ ucfirst(str_replace('_', ' ', $role->role_name)) }}</option>
                            @endforeach
                        </select>
                        <span class="material-icons absolute right-3 top-3.5 text-slate-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div id="ormawaField">
                    <div class="p-4 bg-[#741847]/10 border border-[#741847]/30 rounded-lg">
                        <label class="block text-xs font-bold text-[#741847] uppercase mb-2 flex items-center gap-2">
                            <span class="material-icons text-sm">groups</span> Ormawa
                        </label>
                        <div class="relative">
                            <select name="ormawa_id" id="ormawaSelect" class="input-interactive w-full bg-[#0A192F] border border-white/20 rounded-lg px-4 py-3 text-white appearance-none outline-none transition-all cursor-pointer">
                                <option value="">-- Pilih Ormawa --</option>
                                @foreach($ormawas as $ormawa)
                                    <option value="{{ $ormawa->ormawa_id }}">{{ $ormawa->nama_ormawa }}</option>
                                @endforeach
                            </select>
                            <span class="material-icons absolute right-3 top-3.5 text-slate-400 pointer-events-none">expand_more</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2 italic">*User ini akan memiliki akses penuh sebagai perwakilan ormawa tersebut.</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-2 border-t border-white/5">
                    <button type="button" onclick="closeModal()" class="flex-1 py-3 border border-white/20 rounded-lg text-slate-300 font-medium hover:bg-white/5 transition-colors">Batal</button>
                    <button type="submit" id="btnSimpan" class="flex-1 py-3 bg-gradient-to-r from-[#741847] to-[#9d2262] rounded-lg text-white font-bold shadow-lg hover:shadow-[#741847]/50 hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                        <span>Simpan</span>
                        <span class="material-icons text-sm">save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const ID_STAF_ORMAWA = 2;
        const modal = document.getElementById('editModal');
        const editForm = document.getElementById('editForm');
        const modalUserName = document.getElementById('modalUserName');
        const roleSelect = document.getElementById('roleSelect');
        const ormawaSelect = document.getElementById('ormawaSelect');
        const ormawaField = document.getElementById('ormawaField');
        const btnSimpan = document.getElementById('btnSimpan');

        function openEditModal(userId, userName, roleId, ormawaId) {
            editForm.action = `/admin/users/${userId}`;
            modalUserName.value = userName;
            roleSelect.value = roleId;
            ormawaSelect.value = ormawaId || "";
            checkRole(); 
            modal.classList.add('show');
        }

        function closeModal() {
            modal.classList.remove('show');
        }

        function checkRole() {
            if (parseInt(roleSelect.value) === ID_STAF_ORMAWA) {
                ormawaField.classList.add('visible');
                ormawaSelect.setAttribute('required', 'required');
            } else {
                ormawaField.classList.remove('visible');
                ormawaSelect.removeAttribute('required');
                setTimeout(() => { ormawaSelect.value = ""; }, 300);
            }
        }

        function startLoading() {
            btnSimpan.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...`;
            btnSimpan.classList.add('opacity-75', 'cursor-not-allowed');
        }

        roleSelect.addEventListener('change', checkRole);
        window.onclick = function(event) { if (event.target == modal) closeModal(); }
    </script>
</body>
</html>