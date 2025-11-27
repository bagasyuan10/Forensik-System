<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>ForensicSys</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            display: flex;
            background: #0f172a;
            color: #e6eef8;
            font-family: Arial, sans-serif;
        }

        aside {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg,#0b1220,#111827);
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 12px;
            box-sizing: border-box;
            transition: width .25s ease;
            overflow: hidden;
        }

        /* Saat collapse */
        .collapsed {
            width: 70px !important;
        }

        /* Hilangkan teks saat collapse */
        .collapsed .brand-text,
        .collapsed nav a span {
            display: none !important;
        }

        .collapsed nav a {
            justify-content: center;
        }

        .collapsed nav .icon-box {
            margin: auto;
        }

        /* Tombol collapse rotate */
        #collapseBtn.rotate {
            transform: rotate(180deg);
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: linear-gradient(135deg,#06b6d4,#7c3aed);
            display: grid;
            place-items: center;
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin-right: 10px;
        }

        .brand-text {
            font-size: 15px;
            font-weight: 700;
            white-space: nowrap;
        }

        nav a {
            display: flex;
            gap: 14px;
            padding: 12px 14px;
            align-items: center;
            border-radius: 10px;
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 600;
            margin-bottom: 6px;
            transition: background .2s;
        }

        nav a.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        nav a:hover {
            background: rgba(255,255,255,0.08);
        }

        .icon-box {
            width: 26px;
            height: 26px;
            display: grid;
            place-items: center;
            font-size: 18px;
        }

        main {
            flex: 1;
            padding: 20px;
            color: white;
        }

        #collapseBtn {
            transition: transform .25s ease;
        }
    </style>
</head>

<body>

{{-- SIDEBAR --}}
<aside id="sidebar">
    <div class="sidebar-header">
        <div style="display:flex; align-items:center;">
            <div class="logo">FS</div>
            <div class="brand-text">ForensicSys</div>
        </div>

        <button id="collapseBtn" onclick="toggleSidebar()" style="
            background: transparent; 
            border:1px solid rgba(255,255,255,0.1); 
            padding:4px 10px;
            border-radius:8px;
            color:#cfe8ff;
            cursor:pointer;
            font-weight:600;">
            ‹
        </button>
    </div>

    <nav>
        <a href="/dashboard" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
            <div class="icon-box">🏠</div>
            <span>Dashboard</span>
        </a>

        <a href="/kasus" class="{{ request()->is('kasus*') ? 'active' : '' }}">
            <div class="icon-box">📁</div>
            <span>Kasus</span>
        </a>

        <a href="/bukti" class="{{ request()->is('bukti*') ? 'active' : '' }}">
            <div class="icon-box">📤</div>
            <span>Bukti</span>
        </a>

        <a href="/korban" class="{{ request()->is('korban*') ? 'active' : '' }}">
            <div class="icon-box">🧍</div>
            <span>Korban</span>
        </a>

        <a href="/pelaku" class="{{ request()->is('pelaku*') ? 'active' : '' }}">
            <div class="icon-box">👤</div>
            <span>Pelaku</span>
        </a>

        <a href="/tindakan" class="{{ request()->is('tindakan*') ? 'active' : '' }}">
            <div class="icon-box">✔️</div>
            <span>Tindakan</span>
        </a>

        <a href="/laporan" class="{{ request()->is('laporan*') ? 'active' : '' }}">
            <div class="icon-box">📄</div>
            <span>Laporan</span>
        </a>
    </nav>
</aside>

<main>
    @yield('content')
</main>


<script>
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const btn = document.getElementById("collapseBtn");

    sidebar.classList.toggle("collapsed");
    btn.classList.toggle("rotate");
}
</script>

</body>
</html>