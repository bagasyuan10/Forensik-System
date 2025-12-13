<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ForensicSys</title>

    {{-- Bootstrap 5 & Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* --- 1. THEME VARIABLES --- */
        :root {
            --bg-dark: #0f172a;
            --accent: #22d3ee;       /* Cyan Neon */
            --accent-glow: rgba(34, 211, 238, 0.4);
            --glass-bg: rgba(30, 41, 59, 0.70);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }

        /* --- 2. GLOBAL STYLES --- */
        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Segoe UI', system-ui, sans-serif;
            margin: 0; overflow-x: hidden;
        }

        /* Ambient Background Light (Efek Cahaya Bergerak) */
        .ambient-light {
            position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
            background: 
                radial-gradient(circle at 10% 20%, rgba(34, 211, 238, 0.08), transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.08), transparent 40%);
            z-index: -1; pointer-events: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        /* --- 3. SIDEBAR (GLASSMORPHISM) --- */
        aside {
            position: fixed; top: 0; left: 0; height: 100vh;
            width: var(--sidebar-width);
            background: var(--glass-bg);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            padding: 24px 16px;
            display: flex; flex-direction: column;
            transition: width 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            z-index: 1000;
        }

        /* Sidebar Header */
        .sidebar-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 30px; padding: 0 5px; height: 50px;
        }
        .logo-wrapper { display: flex; align-items: center; gap: 12px; overflow: hidden; white-space: nowrap; }
        .logo-box {
            min-width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, #06b6d4, #6366f1);
            display: grid; place-items: center;
            font-weight: 800; color: white; font-size: 18px;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.4);
        }
        .brand-name {
            font-size: 18px; font-weight: 700; letter-spacing: -0.5px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            opacity: 1; transition: opacity 0.2s;
        }

        /* Sidebar Toggle Button */
        .toggle-btn {
            background: transparent; border: none; color: var(--text-muted);
            cursor: pointer; padding: 6px; border-radius: 8px; transition: 0.2s;
        }
        .toggle-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* Navigation Links */
        .nav-link {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 16px; margin-bottom: 6px;
            border-radius: 12px; color: var(--text-muted);
            text-decoration: none; font-weight: 500; font-size: 0.95rem;
            transition: all 0.3s; position: relative;
            white-space: nowrap; overflow: hidden; border: 1px solid transparent;
        }
        .nav-link i { font-size: 22px; min-width: 22px; transition: 0.3s; }
        
        .nav-link:hover { 
            background: rgba(255, 255, 255, 0.05); color: #fff; 
            border-color: rgba(255,255,255,0.05);
        }
        
        .nav-link.active {
            background: linear-gradient(90deg, rgba(34, 211, 238, 0.1), transparent);
            color: var(--accent);
            border-left: 3px solid var(--accent);
            border-color: rgba(34, 211, 238, 0.1);
        }
        .nav-link.active i { 
            filter: drop-shadow(0 0 8px var(--accent-glow)); transform: scale(1.1); 
        }

        /* --- SUBMENU STYLING (NEW) --- */
        .submenu-container {
            overflow: hidden; transition: max-height 0.4s ease;
            background: rgba(15, 23, 42, 0.4); 
            border-radius: 12px; margin: 2px 0 10px 0;
        }
        .submenu-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 10px 10px 24px;
            font-size: 0.9rem; color: #94a3b8; text-decoration: none;
            transition: all 0.2s; border-left: 2px solid transparent;
        }
        .submenu-link i { font-size: 18px; min-width: 18px; opacity: 0.7; transition: 0.2s; }
        
        .submenu-link:hover { color: #fff; background: rgba(255,255,255,0.02); }
        .submenu-link:hover i { opacity: 1; color: #e2e8f0; transform: translateX(2px); }
        
        .submenu-link.active { 
            color: var(--accent); font-weight: 600; 
            background: rgba(34, 211, 238, 0.05);
            border-left-color: var(--accent);
        }
        .submenu-link.active i { 
            opacity: 1; color: var(--accent); 
            filter: drop-shadow(0 0 5px rgba(34, 211, 238, 0.4)); 
        }

        /* Section Title */
        .menu-title {
            font-size: 11px; color: #64748b; font-weight: 700; 
            text-transform: uppercase; margin: 15px 16px 8px; letter-spacing: 0.5px;
        }

        /* Collapsed State Handling */
        aside.collapsed { width: var(--sidebar-collapsed-width); }
        aside.collapsed .brand-name, aside.collapsed .caret-icon, aside.collapsed .menu-title,
        aside.collapsed .nav-link span { display: none !important; }
        aside.collapsed .submenu-container { display: none !important; }
        aside.collapsed .sidebar-header { justify-content: center; padding: 0; }
        aside.collapsed .nav-link { justify-content: center; padding: 12px 0; }
        aside.collapsed .logo-wrapper { gap: 0; }

        /* --- 4. MAIN WRAPPER & HEADER --- */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            min-height: 100vh; display: flex; flex-direction: column;
        }
        aside.collapsed + .main-wrapper { margin-left: var(--sidebar-collapsed-width); }

        header {
            height: 70px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 30px; position: sticky; top: 0; z-index: 900;
        }

        /* Search Bar */
        .search-bar {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 50px; padding: 8px 20px;
            display: flex; align-items: center; gap: 10px; width: 320px;
            transition: 0.3s;
        }
        .search-bar:focus-within {
            border-color: var(--accent); box-shadow: 0 0 15px rgba(34, 211, 238, 0.15);
        }
        .search-bar input {
            background: transparent; border: none; outline: none;
            color: #fff; width: 100%; font-size: 0.9rem;
        }

        /* Profile & Icons */
        .icon-btn {
            width: 40px; height: 40px; border-radius: 50%;
            display: grid; place-items: center; color: var(--text-muted);
            cursor: pointer; transition: 0.2s; position: relative;
            background: rgba(255,255,255,0.03); border: 1px solid transparent;
        }
        .icon-btn:hover { background: var(--accent); color: #000; }
        .notification-dot {
            position: absolute; top: 8px; right: 8px; width: 8px; height: 8px;
            background: #ef4444; border-radius: 50%; border: 1px solid #0f172a;
        }

        .user-profile {
            display: flex; align-items: center; gap: 12px;
            padding: 5px 12px; border-radius: 50px; cursor: pointer;
            transition: 0.2s; border: 1px solid transparent;
        }
        .user-profile:hover { background: rgba(255,255,255,0.05); border-color: var(--glass-border); }
        .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: #cbd5e1; object-fit: cover;
            border: 2px solid rgba(255,255,255,0.1);
        }

        /* Main Content */
        main { padding: 30px; flex: 1; }
        
        /* Utility for Cards (Use this in your views) */
        .card-glass {
            background: var(--glass-bg); border: 1px solid var(--glass-border);
            border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body>

    <div class="ambient-light"></div>

    <aside id="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper">
                <div class="logo-box">FS</div>
                <div class="brand-name">ForensicSys</div>
            </div>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="ph-bold ph-list" id="toggleIcon"></i>
            </button>
        </div>

        <nav style="flex: 1; overflow-y: auto; padding-right: 4px;">
            <div class="menu-title">Menu Utama</div>
            
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ph-duotone ph-squares-four"></i>
                <span>Dashboard</span>
            </a>

            <div>
                <a href="javascript:void(0)" class="nav-link" onclick="toggleSubmenu('kasusSubmenu', this)">
                    <i class="ph-duotone ph-briefcase"></i>
                    <span>Manajemen Kasus</span>
                    <i class="ph-bold ph-caret-down caret-icon ms-auto" style="font-size: 14px;"></i>
                </a>
                <div id="kasusSubmenu" class="submenu-container" style="max-height: 0px;">
                    {{-- 1. Data Kasus --}}
                    <a href="{{ route('kasus.index') }}" class="submenu-link {{ request()->is('kasus*') ? 'active' : '' }}">
                        <i class="ph-duotone ph-files"></i> 
                        <span>Data Kasus</span>
                    </a>

                    {{-- 2. Data Pelaku --}}
                    <a href="{{ route('pelaku.index') }}" class="submenu-link {{ request()->is('pelaku*') ? 'active' : '' }}">
                        <i class="ph-duotone ph-fingerprint"></i> 
                        <span>Data Pelaku</span>
                    </a>

                    {{-- 3. Barang Bukti (POSISI DITUKAR KE ATAS) --}}
                    <a href="{{ route('bukti.index') }}" class="submenu-link {{ request()->is('bukti*') ? 'active' : '' }}">
                        <i class="ph-duotone ph-package"></i> 
                        <span>Barang Bukti</span>
                    </a>

                    {{-- 4. Data Korban (POSISI DITUKAR KE BAWAH) --}}
                    <a href="{{ route('korban.index') }}" class="submenu-link {{ request()->is('korban*') ? 'active' : '' }}">
                        <i class="ph-duotone ph-user-focus"></i> 
                        <span>Data Korban</span>
                    </a>

                    {{-- 5. Tindakan Hukum --}}
                    <a href="{{ route('tindakan.index') }}" class="submenu-link {{ request()->is('tindakan*') ? 'active' : '' }}">
                        <i class="ph-duotone ph-gavel"></i> 
                        <span>Tindakan Hukum</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                <i class="ph-duotone ph-clipboard-text"></i>
                <span>Laporan & Analisis</span>
            </a>

            <div class="menu-title">System</div>

            <a href="#" class="nav-link">
                <i class="ph-duotone ph-gear"></i>
                <span>Pengaturan</span>
            </a>
            
             <a href="#" class="nav-link">
                <i class="ph-duotone ph-users-three"></i>
                <span>Admin User</span>
            </a>
        </nav>

        <div style="padding-top: 15px; border-top: 1px solid var(--glass-border);">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="button" class="nav-link w-100" onclick="confirmLogout()" 
                        style="color: #fca5a5; background: rgba(239,68,68,0.05); justify-content: flex-start; border: 1px solid rgba(239,68,68,0.1);">
                    <i class="ph-bold ph-sign-out"></i>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        
        <header>
            <div class="search-bar">
                <i class="ph-bold ph-magnifying-glass text-secondary"></i>
                <input type="text" placeholder="Cari kasus, nama, atau ID...">
            </div>

            <div class="d-flex align-items-center gap-4">
                <div class="icon-btn">
                    <i class="ph-bold ph-bell"></i>
                    <span class="notification-dot"></span>
                </div>

                <div class="user-profile">
                    <div class="text-end d-none d-sm-block lh-1">
                        <div style="font-size: 14px; font-weight: 600; color: #fff; margin-bottom: 2px;">
                            {{ Auth::user()->name ?? 'Administrator' }}
                        </div>
                        <div style="font-size: 11px; color: var(--accent);">Forensic Unit</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=22d3ee&color=0f172a&bold=true" class="avatar" alt="User">
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        
        // 1. Sidebar Toggle Logic
        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.replace('ph-list', 'ph-caret-right');
                // Tutup semua submenu saat sidebar mengecil
                document.querySelectorAll('.submenu-container').forEach(el => el.style.maxHeight = '0px');
            } else {
                toggleIcon.classList.replace('ph-caret-right', 'ph-list');
            }
        }

        // 2. Submenu Accordion Logic
        function toggleSubmenu(id, element) {
            const submenu = document.getElementById(id);
            const arrow = element.querySelector('.caret-icon');
            
            // Jika sidebar collapsed, buka dulu
            if (sidebar.classList.contains('collapsed')) {
                toggleSidebar();
                setTimeout(() => { openMenuLogic(submenu, arrow); }, 300);
            } else {
                openMenuLogic(submenu, arrow);
            }
        }

        function openMenuLogic(submenu, arrow) {
            if (submenu.style.maxHeight === '0px' || submenu.style.maxHeight === '') {
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                if(arrow) arrow.style.transform = "rotate(180deg)";
            } else {
                submenu.style.maxHeight = '0px';
                if(arrow) arrow.style.transform = "rotate(0deg)";
            }
        }

        // 3. Auto-Open Submenu if Active
        document.addEventListener("DOMContentLoaded", function() {
            const activeLink = document.querySelector('.submenu-link.active');
            if(activeLink) {
                const parentSubmenu = activeLink.closest('.submenu-container');
                const parentToggle = parentSubmenu.previousElementSibling;
                const arrow = parentToggle.querySelector('.caret-icon');
                
                parentSubmenu.style.maxHeight = parentSubmenu.scrollHeight + "px";
                if(arrow) arrow.style.transform = "rotate(180deg)";
            }
        });

        // 4. Logout Confirmation (SweetAlert)
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar?',
                text: "Sesi Anda akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#22d3ee', // Cyan
                cancelButtonColor: '#334155',  // Slate
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
</body>
</html>