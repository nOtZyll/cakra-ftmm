<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CAKRA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- CSS SAMA PERSIS DENGAN MAHASISWA --}}
    <style>
        :root {
            --primary: #073763;
            --accent: #741847;
            --bg-dark: #0A192F;
            --text-dark: #E0E6F1;
            --subtext-dark: #94A3B8;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            background-image: radial-gradient(circle at 20% 80%, rgba(116, 24, 71, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(7, 55, 99, 0.15) 0%, transparent 50%);
        }
    
        /* Sidebar & Layout Styles (Sama Persis) */
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
    
        .main-content { flex: 1; margin-left: 250px; padding: 30px; overflow-y: auto; transition: all 0.3s ease; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; animation: fadeIn 0.8s ease; }
        .user-info { display: flex; align-items: center; }
        
        .avatar {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex; align-items: center; justify-content: center;
            margin-right: 15px; border: 2px solid var(--accent);
        }
        
        .user-details h2 { font-size: 1.5rem; font-weight: 600; }
        .user-details p { color: var(--subtext-dark); font-size: 0.9rem; }
        
        .card {
            background: rgba(7, 55, 99, 0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(116, 24, 71, 0.2); border-radius: 12px; padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.3s ease;
        }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

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
                    <h2>Halo, {{ $user->name }}</h2>
                    <p>Status: Administrator</p>
                </div>
            </div>
        </div>

        <div class="card" style="min-height: 400px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
            <span class="material-icons" style="font-size: 64px; color: var(--accent); opacity: 0.5;">admin_panel_settings</span>
            <h3 style="margin-top: 20px; font-size: 1.2rem; color: var(--subtext-dark);">Selamat Datang di Panel Admin</h3>
            <p style="color: var(--subtext-dark); font-size: 0.9rem;">Pilih menu di sebelah kiri untuk mengelola sistem.</p>
        </div>
    </div>
</body>
</html>