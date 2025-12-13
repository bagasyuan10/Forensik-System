@extends('layouts.layout')

@section('content')

{{-- 1. LIBRARY TAMBAHAN (CDN) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND ACCENTS --- */
    .bg-blob {
        position: absolute;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.4;
        animation: float 10s infinite ease-in-out;
    }
    .blob-1 { top: -10%; right: -5%; width: 300px; height: 300px; background: #06b6d4; }
    .blob-2 { bottom: 10%; left: -5%; width: 250px; height: 250px; background: #6366f1; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* --- GLASS FORM & CARDS --- */
    .glass-panel {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .search-input {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        border-radius: 50px;
        padding: 14px 20px 14px 50px;
        transition: all 0.3s;
    }
    .search-input:focus {
        background: rgba(15, 23, 42, 0.9);
        border-color: #22d3ee;
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.2);
        color: #fff;
    }

    /* --- REPORT CARD DESIGN (Adapted from Case Card) --- */
    .report-card {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .report-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(34, 211, 238, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 
                    0 0 20px rgba(34, 211, 238, 0.1);
    }

    /* Neon Line Top */
    .report-card::after {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, transparent, #22d3ee, #818cf8, transparent);
        opacity: 0.6;
    }

    .card-icon-box {
        width: 45px; height: 45px;
        background: rgba(34, 211, 238, 0.1);
        border: 1px solid rgba(34, 211, 238, 0.2);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #22d3ee;
        font-size: 22px;
    }

    .reporter-badge {
        font-family: 'Courier New', monospace;
        background: rgba(0, 0, 0, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        color: #94a3b8;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border: 1px solid rgba(255,255,255,0.05);
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Buttons Actions */
    .action-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.03);
        color: #94a3b8;
        transition: 0.3s;
        cursor: pointer;
    }
    
    .action-btn:hover { transform: rotate(15deg); color: #fff; }
    .btn-edit:hover { background: #f59e0b; border-color: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.4); }

    .btn-neon-primary {
        background: linear-gradient(90deg, #06b6d4, #3b82f6);
        color: white; border: none; font-weight: 600;
        padding: 10px 25px; border-radius: 50px;
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.3);
        transition: 0.3s;
    }
    .btn-neon-primary:hover {
        box-shadow: 0 0 25px rgba(6, 182, 212, 0.6);
        transform: translateY(-2px);
        color: white;
    }

    /* Custom Pagination Dark Mode */
    .pagination .page-link {
        background: rgba(15, 23, 42, 0.8);
        border-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }
    .pagination .active .page-link {
        background: #06b6d4;
        border-color: #06b6d4;
        color: white;
    }

    /* Title Gradient */
    .text-gradient {
        background: linear-gradient(to right, #fff, #a5f3fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="position-relative container-fluid py-4" style="min-height: 80vh;">
    
    {{-- Background Blobs --}}
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    {{-- HEADER SECTION --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 animate__animated animate__fadeInDown">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold display-6 text-gradient mb-1">Daftar Pengaduan</h2>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-1 rounded-pill">
                    Total: {{ $laporan->total() ?? 0 }}
                </span>
                <span style="font-size: 0.9rem;">Laporan warga masuk</span>
            </div>
        </div>
        
        <a href="{{ route('laporan.create') }}" class="btn btn-neon-primary d-flex align-items-center gap-2">
            <i class="ph-bold ph-megaphone" style="font-size: 1.2rem;"></i>
            <span>Buat Aduan Baru</span>
        </a>
    </div>

    {{-- SEARCH & FILTER BAR --}}
    <div class="glass-panel p-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 1.2rem;"></i>
                    <input type="text" name="q" class="form-control search-input" 
                           placeholder="Cari judul aduan atau nama pelapor..." 
                           value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="position-relative">
                    <i class="ph-bold ph-faders position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <select name="filter" class="form-select search-input ps-5" style="cursor: pointer;">
                        <option value="all" {{ request('filter')=='all' ? 'selected':'' }}>Semua Data</option>
                        <option value="recent" {{ request('filter')=='recent' ? 'selected':'' }}>Terbaru</option>
                        <option value="oldest" {{ request('filter')=='oldest' ? 'selected':'' }}>Terlama</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100 rounded-pill fw-bold" 
                        style="height: 50px; background: rgba(59, 130, 246, 0.2); border: 1px solid #3b82f6; color: #60a5fa;">
                    <i class="ph-bold ph-funnel me-2"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- CONTENT GRID --}}
    @if($laporan->isEmpty())
        <div class="glass-panel p-5 text-center animate__animated animate__zoomIn">
            <div class="mb-3">
                <i class="ph-duotone ph-inbox text-secondary" style="font-size: 64px;"></i>
            </div>
            <h4 class="text-white fw-bold">Belum Ada Aduan</h4>
            <p class="text-secondary">Tidak ada laporan yang cocok dengan pencarian Anda.</p>
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mt-2">Reset Pencarian</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($laporan as $index => $item)
                {{-- Animation delay staggered based on index --}}
                <div class="col-xl-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="report-card p-4">
                        
                        {{-- Header Card --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="card-icon-box">
                                    {{-- Menggunakan icon megaphone untuk laporan --}}
                                    <i class="ph-duotone ph-megaphone"></i>
                                </div>
                                <div>
                                    {{-- Menampilkan nama pelapor sebagai 'ID' visual --}}
                                    <div class="reporter-badge" title="Pelapor: {{ $item->penyusun }}">
                                        <i class="ph-bold ph-user me-1" style="font-size: 0.7rem;"></i>
                                        {{ $item->penyusun ?? 'Anonim' }}
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Dropdown / Status --}}
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary p-0" data-bs-toggle="dropdown">
                                    <i class="ph-bold ph-dots-three-vertical" style="font-size: 1.5rem;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0">
                                    <li><a class="dropdown-item" href="{{ route('laporan.edit', $item->id) }}"><i class="ph-bold ph-pencil me-2"></i> Edit Aduan</a></li>
                                </ul>
                            </div>
                        </div>

                        {{-- Content --}}
                        <h5 class="fw-bold text-white mb-2 text-truncate" title="{{ $item->judul_laporan }}">
                            {{ $item->judul_laporan }}
                        </h5>
                        <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6; min-height: 40px;">
                            {{ Str::limit($item->isi_laporan, 85, '...') }}
                        </p>

                        {{-- Meta Tags --}}
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            {{-- Badge Kasus Terkait --}}
                            @if($item->kasus)
                                <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-2 px-3 rounded-pill" title="Kasus Terkait">
                                    <i class="ph-bold ph-folder-open me-1 text-info"></i> {{ Str::limit($item->kasus->judul, 15) }}
                                </span>
                            @else
                                <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-2 px-3 rounded-pill fst-italic">
                                    <i class="ph-bold ph-warning-circle me-1 text-warning"></i> Tanpa Kasus
                                </span>
                            @endif

                            {{-- Badge Tanggal --}}
                            <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-2 px-3 rounded-pill">
                                <i class="ph-bold ph-calendar me-1 text-info"></i> 
                                {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d M Y') }}
                            </span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end align-items-center mt-auto pt-3 border-top border-secondary border-opacity-10">
                            <div class="d-flex gap-2">
                                <a href="{{ route('laporan.edit', $item->id) }}" class="action-btn btn-edit" title="Edit">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </a>
                                
                                {{-- Tombol Delete dengan SweetAlert --}}
                                <button type="button" class="action-btn btn-delete" title="Hapus" 
                                        onclick="confirmDelete('{{ $item->id }}')">
                                    <i class="ph-bold ph-trash"></i>
                                </button>
                                
                                {{-- Form Hidden untuk Delete --}}
                                <form id="delete-form-{{ $item->id }}" action="{{ route('laporan.destroy', $item->id) }}" method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            @if($laporan->hasPages())
                {{ $laporan->withQueryString()->links() }}
            @endif
        </div>
    @endif
</div>

{{-- SCRIPT KHUSUS --}}
<script>
    // 1. Notifikasi Flash Session (Jika ada pesan sukses dari Controller)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            background: '#1e293b',
            color: '#fff',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'colored-toast'
            }
        });
    @endif

    // 2. Fungsi Pop-up Konfirmasi Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Aduan?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah
            cancelButtonColor: '#334155',  // Abu-abu
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#fff',
            backdrop: `
                rgba(0,0,0,0.6)
                left top
                no-repeat
            `
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

<style>
    /* Custom Style untuk SweetAlert agar sesuai tema */
    div:where(.swal2-container) div:where(.swal2-popup) {
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 20px !important;
    }
</style>

@endsection