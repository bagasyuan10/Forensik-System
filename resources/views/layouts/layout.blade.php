<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForensicSys - Digital Investigation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* --- 1. GLOBAL VARIABLES & THEME --- */
        :root {
            --bg-dark: #0f172a;       /* Background Utama */
            --bg-sidebar: #1e293b;    /* Background Sidebar */
            --accent: #22d3ee;        /* Warna Cyan Neon */
            --text-main: #e2e8f0;     /* Putih Terang */
            --text-muted: #94a3b8;    /* Abu-abu */
            --border: rgba(255, 255, 255, 0.05);
            --glass: rgba(15, 23, 42, 0.6);
        }

        body {
            margin: 0;
            display: flex;
            background: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* --- 2. GLOBAL COMPONENTS (Bisa dipakai di semua halaman) --- */
        
        /* Typography Title */
        .page-title {
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Premium Card */
        .custom-card {
            background: #1e293b;
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Glassy Inputs & Selects */
        .form-control-dark, .form-select-dark, .form-control, .form-select {
            background-color: var(--glass) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #e2e8f0 !important;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(15, 23, 42, 0.9) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1) !important;
            color: #fff !important;
        }
        
        /* Placeholder Color */
        ::placeholder { color: #64748b !important; opacity: 1; }

        /* Dark Table Style */
        .table-dark-custom {
            --bs-table-bg: transparent;
            --bs-table-color: #e2e8f0;
            --bs-table-border-color: rgba(255, 255, 255, 0.05);
            --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
        }
        .table-dark-custom th {
            background-color: rgba(15, 23, 42, 0.5);
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            padding: 16px;
        }
        .table-dark-custom td { padding: 16px; vertical-align: middle; }

        /* Neon Buttons */
        .btn-glow {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border: none;
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-glow:hover { transform: translateY(-2px); color: white; box-shadow: 0 0 15px rgba(6, 182, 212, 0.6); }

        /* Action Buttons Circle */
        .btn-action-circle {
            width: 32px; height: 32px; border-radius: 8px;
            display: inline-flex; align-items: center; justify-content: center;
            border: none; transition: all 0.2s; text-decoration: none;
        }
        .btn-view { background: rgba(56, 189, 248, 0.1); color: #38bdf8; }
        .btn-view:hover { background: #38bdf8; color: #000; }
        .btn-edit { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
        .btn-edit:hover { background: #fbbf24; color: #000; }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; }
        .btn-delete:hover { background: #ef4444; color: #fff; }

        /* --- 3. SIDEBAR STYLING --- */
        aside {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0b1120 0%, #1e293b 100%);
            border-right: 1px solid var(--border);
            padding: 24px 12px;
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Header Logo */
        .sidebar-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; padding: 0 8px; height: 50px;
        }
        .logo-wrapper { display: flex; align-items: center; gap: 12px; overflow: hidden; }
        .logo {
            min-width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, #06b6d4, #7c3aed);
            display: grid; place-items: center; color: white;
            font-size: 20px; font-weight: 800;
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.3);
        }
        .brand-text {
            font-size: 18px; font-weight: 700; white-space: nowrap;
            background: linear-gradient(to right, #fff, #cbd5e1);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* Toggle Button */
        #collapseBtn {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);
            width: 32px; height: 32px; display: grid; place-items: center;
            border-radius: 8px; color: var(--text-muted); cursor: pointer; transition: all 0.2s;
        }
        #collapseBtn:hover { background: var(--accent); color: #0f172a; }
        #collapseBtn.rotate { transform: rotate(180deg); }

        /* Nav Links */
        nav a {
            position: relative; display: flex; gap: 14px; padding: 12px 16px;
            align-items: center; border-radius: 12px; text-decoration: none;
            color: var(--text-muted); font-weight: 600; font-size: 14px;
            margin-bottom: 6px; transition: all 0.2s ease; border: 1px solid transparent;
            white-space: nowrap;
        }
        nav a:hover { background: rgba(255,255,255,0.05); color: #fff; }
        nav a.active {
            background: linear-gradient(90deg, rgba(34, 211, 238, 0.15), rgba(34, 211, 238, 0.05));
            color: var(--accent); border-color: rgba(34, 211, 238, 0.2);
        }
        nav a.active::before {
            content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            height: 20px; width: 3px; background: var(--accent);
            border-radius: 0 4px 4px 0; box-shadow: 0 0 8px var(--accent);
        }

        /* Icon Styling */
        .icon-box { min-width: 24px; display: grid; place-items: center; }
        .icon-box i { font-size: 24px; transition: transform 0.2s; }
        nav a.active .icon-box i { filter: drop-shadow(0 0 5px rgba(34, 211, 238, 0.6)); transform: scale(1.1); }
        .ph-duotone { --secondary-opacity: 0.4; }

        /* Submenu */
        .submenu {
            background: rgba(0,0,0,0.2); border-radius: 12px; margin: 5px 0 10px 0;
            border: 1px solid rgba(255,255,255,0.03); overflow: hidden;
        }
        .submenu.hide { display: none; }
        .submenu a {
            padding: 10px 10px 10px 20px; margin-left: 20px; margin-right: 10px;
            font-size: 13px; color: #64748b; margin-bottom: 2px;
        }
        .submenu i { font-size: 18px; min-width: 18px; flex-shrink: 0; opacity: 0.7; }
        .submenu a:hover { color: #cbd5e1; background: rgba(255,255,255,0.03); }
        .submenu a:hover i { opacity: 1; color: #fff; }
        .submenu a.active { background: transparent; color: var(--accent); }
        .submenu a.active i { opacity: 1; color: var(--accent); filter: drop-shadow(0 0 4px rgba(34, 211, 238, 0.4)); }
        .submenu a.active::before { display: none; }

        /* Sidebar Footer (Logout) */
        .sidebar-footer {
            margin-top: auto; padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .logout-btn {
            width: 100%; display: flex; gap: 14px; padding: 12px 16px;
            align-items: center; border-radius: 12px;
            background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1);
            color: #fca5a5; font-weight: 600; font-size: 14px; cursor: pointer;
            transition: all 0.2s ease;
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.15); color: #fff;
            border-color: rgba(239, 68, 68, 0.3); box-shadow: 0 0 15px rgba(239, 68, 68, 0.15);
        }

        /* Collapsed State */
        .collapsed { width: 80px !important; padding: 24px 10px; }
        .collapsed .brand-text, .collapsed nav a span, .collapsed .arrow-icon, 
        .collapsed .submenu, .collapsed .logout-btn span { display: none !important; }
        .collapsed .sidebar-header { justify-content: center; padding: 0; }
        .collapsed .logo-wrapper { width: 40px; }
        .collapsed nav a, .collapsed .logout-btn { justify-content: center; padding: 12px 0; }
        .collapsed nav a.active::before { display: none; }
        .collapsed .sidebar-footer { border-top: none; }

        /* Main Content */
        main { flex: 1; padding: 30px; background-color: var(--bg-dark); transition: margin-left 0.3s; }
    </style>
</head>

<body>

    <aside id="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <div class="logo">FS</div>
                <div class="brand-text">ForensicSys</div>
            </div>
            <button id="collapseBtn" onclick="toggleSidebar()">
                <i class="ph-bold ph-caret-left"></i>
            </button>
        </div>

        <nav style="flex: 1;">
            <a href="/dashboard" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                <div class="icon-box"><i class="ph-duotone ph-squares-four"></i></div>
                <span>Dashboard</span>
            </a>

            <a href="javascript:void(0)" onclick="toggleKasusMenu()" id="kasusToggle">
                <div class="icon-box"><i class="ph-duotone ph-briefcase"></i></div>
                <span>Manajemen Kasus</span>
                <i class="ph-bold ph-caret-down arrow-icon ms-auto" id="kasusArrow" style="font-size: 14px;"></i>
            </a>

            <div id="kasusMenu" class="submenu {{ request()->is('kasus*') || request()->is('pelaku*') || request()->is('korban*') || request()->is('bukti*') || request()->is('tindakan*') ? '' : 'hide' }}">
                <a href="/kasus" class="{{ request()->is('kasus*') ? 'active' : '' }}">
                    <i class="ph-duotone ph-files"></i> <span>Data Kasus</span>
                </a>
                <a href="/pelaku" class="{{ request()->is('pelaku*') ? 'active' : '' }}">
                    <i class="ph-duotone ph-fingerprint"></i> <span>Data Pelaku</span>
                </a>
                <a href="/korban" class="{{ request()->is('korban*') ? 'active' : '' }}">
                    <i class="ph-duotone ph-first-aid"></i> <span>Data Korban</span>
                </a>
                <a href="/bukti" class="{{ request()->is('bukti*') ? 'active' : '' }}">
                    <i class="ph-duotone ph-package"></i> <span>Barang Bukti</span>
                </a>
                <a href="/tindakan" class="{{ request()->is('tindakan*') ? 'active' : '' }}">
                    <i class="ph-duotone ph-gavel"></i> <span>Tindakan Hukum</span>
                </a>
            </div>

            <a href="/laporan" class="{{ request()->is('laporan*') ? 'active' : '' }}">
                <div class="icon-box"><i class="ph-duotone ph-clipboard-text"></i></div>
                <span>Laporan</span>
            </a>
            
            <a href="/settings" class="{{ request()->is('settings*') ? 'active' : '' }}">
                <div class="icon-box"><i class="ph-duotone ph-gear"></i></div>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                    <i class="ph-bold ph-sign-out"></i>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <main>
        @yield('content')
    </main>

    <script>
        const sidebar = document.getElementById("sidebar");
        const collapseBtn = document.getElementById("collapseBtn");
        const kasusMenu = document.getElementById("kasusMenu");
        const kasusArrow = document.getElementById("kasusArrow");

        function toggleSidebar() {
            sidebar.classList.toggle("collapsed");
            
            if (sidebar.classList.contains("collapsed")) {
                collapseBtn.style.transform = "rotate(180deg)";
                if (!kasusMenu.classList.contains("hide")) {
                    kasusMenu.classList.add("hide");
                    kasusArrow.classList.remove("ph-caret-up");
                    kasusArrow.classList.add("ph-caret-down");
                }
            } else {
                collapseBtn.style.transform = "rotate(0deg)";
            }
        }

        function toggleKasusMenu() {
            if (sidebar.classList.contains("collapsed")) {
                toggleSidebar();
                setTimeout(() => { openKasusMenu(); }, 200); 
            } else {
                openKasusMenu();
            }
        }

        function openKasusMenu() {
            kasusMenu.classList.toggle("hide");
            if (kasusMenu.classList.contains("hide")) {
                kasusArrow.classList.remove("ph-caret-up");
                kasusArrow.classList.add("ph-caret-down");
            } else {
                kasusArrow.classList.remove("ph-caret-down");
                kasusArrow.classList.add("ph-caret-up");
            }
        }
    </script>
</body>
</html>