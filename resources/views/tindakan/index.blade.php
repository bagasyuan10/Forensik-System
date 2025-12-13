@extends('layouts.layout')

@section('content')

{{-- 1. LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND ACCENTS --- */
    .bg-blob {
        position: absolute; filter: blur(80px); z-index: 0; opacity: 0.4;
        animation: float 10s infinite ease-in-out;
    }
    .blob-1 { top: -10%; right: -5%; width: 300px; height: 300px; background: #8b5cf6; /* Violet */ }
    .blob-2 { bottom: 10%; left: -5%; width: 250px; height: 250px; background: #06b6d4; /* Cyan */ }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* --- GLASS PANEL & SEARCH --- */
    .glass-panel {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        position: relative; z-index: 1;
    }

    .search-input {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff; border-radius: 50px;
        padding: 14px 20px 14px 50px; transition: all 0.3s;
    }
    .search-input:focus {
        background: rgba(15, 23, 42, 0.9);
        border-color: #8b5cf6; /* Violet focus */
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.2);
        color: #fff;
    }

    /* --- CARD DESIGN --- */
    .action-card {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        position: relative; overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%; display: flex; flex-direction: column;
    }

    .action-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(139, 92, 246, 0.1);
    }

    /* Neon Line Top (Violet to Cyan) */
    .action-card::after {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, transparent, #8b5cf6, #06b6d4, transparent);
        opacity: 0.6;
    }

    .card-icon-box {
        width: 45px; height: 45px;
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.2);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #a78bfa; font-size: 22px;
    }

    .id-badge {
        font-family: 'Courier New', monospace;
        background: rgba(0, 0, 0, 0.3);
        padding: 4px 10px; border-radius: 6px;
        color: #94a3b8; font-size: 0.8rem; letter-spacing: 1px;
        border: 1px solid rgba(255,255,255,0.05);
    }

    /* --- BUTTONS & UTILS --- */
    .action-btn {
        width: 38px; height: 38px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.03);
        color: #94a3b8; transition: 0.3s; cursor: pointer;
    }
    .action-btn:hover { transform: rotate(15deg); color: #fff; }
    
    .btn-edit:hover { background: #f59e0b; border-color: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.4); }

    .btn-neon-primary {
        background: linear-gradient(90deg, #8b5cf6, #3b82f6);
        color: white; border: none; font-weight: 600;
        padding: 10px 25px; border-radius: 50px;
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.3); transition: 0.3s;
    }
    .btn-neon-primary:hover {
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.6);
        transform: translateY(-2px); color: white;
    }

    .text-gradient {
        background: linear-gradient(to right, #fff, #a78bfa);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    
    /* Pagination */
    .pagination .page-link { background: rgba(15, 23, 42, 0.8); border-color: rgba(255, 255, 255, 0.1); color: #94a3b8; }
    .pagination .active .page-link { background: #8b5cf6; border-color: #8b5cf6; color: white; }
</style>

<div class="position-relative container-fluid py-4" style="min-height: 80vh;">
    
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 animate__animated animate__fadeInDown">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold display-6 text-gradient mb-1">Daftar Tindakan</h2>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-1 rounded-pill">
                    Total: {{ $tindakan->total() ?? 0 }}
                </span>
                <span style="font-size: 0.9rem;">Aktivitas forensik & investigasi</span>
            </div>
        </div>
        
        <a href="{{ route('tindakan.create') }}" class="btn btn-neon-primary d-flex align-items-center gap-2">
            <i class="ph-bold ph-plus-circle" style="font-size: 1.2rem;"></i>
            <span>Tambah Tindakan</span>
        </a>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="glass-panel p-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 1.2rem;"></i>
                    <input type="text" name="q" class="form-control search-input" 
                           placeholder="Cari judul tindakan, nama petugas..." 
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
                        style="height: 50px; background: rgba(139, 92, 246, 0.2); border: 1px solid #8b5cf6; color: #a78bfa;">
                    <i class="ph-bold ph-funnel me-2"></i> Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- CONTENT GRID --}}
    @if($tindakan->isEmpty())
        <div class="glass-panel p-5 text-center animate__animated animate__zoomIn">
            <div class="mb-3"><i class="ph-duotone ph-clipboard-text text-secondary" style="font-size: 64px;"></i></div>
            <h4 class="text-white fw-bold">Belum Ada Tindakan</h4>
            <p class="text-secondary">Tidak ada data tindakan yang cocok dengan pencarian Anda.</p>
            <a href="{{ route('tindakan.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mt-2">Reset Filter</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($tindakan as $index => $td)
            <div class="col-xl-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                <div class="action-card p-4">
                    
                    {{-- Card Header --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="card-icon-box">
                                <i class="ph-duotone ph-gavel"></i>
                            </div>
                            <div>
                                {{-- Menampilkan ID Tindakan atau Nomor Kasus Terkait --}}
                                <div class="id-badge">
                                    {{ $td->kasus ? $td->kasus->nomor_kasus : '#'.$td->id }}
                                </div>
                            </div>
                        </div>

                        {{-- Dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary p-0" data-bs-toggle="dropdown">
                                <i class="ph-bold ph-dots-three-vertical" style="font-size: 1.5rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0">
                                <li><a class="dropdown-item" href="{{ route('tindakan.edit', $td->id) }}"><i class="ph-bold ph-pencil me-2"></i> Edit Data</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Content Title --}}
                    <h5 class="fw-bold text-white mb-2 text-truncate" title="{{ $td->judul_tindakan }}">
                        {{ $td->judul_tindakan }}
                    </h5>

                    {{-- Description Area (Menampilkan Kasus Terkait) --}}
                    <div class="text-secondary small mb-4 flex-grow-1" style="min-height: 40px;">
                        @if($td->kasus)
                            <div class="d-flex align-items-start gap-2">
                                <i class="ph-duotone ph-folder-open mt-1 text-info"></i>
                                <span>
                                    <span class="opacity-50">Kasus:</span><br>
                                    <span class="text-gray-300">{{ Str::limit($td->kasus->judul, 60) }}</span>
                                </span>
                            </div>
                        @else
                            <span class="fst-italic opacity-50">- Tidak terhubung ke kasus -</span>
                        @endif
                    </div>

                    {{-- Meta Badges --}}
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-2 px-3 rounded-pill">
                            <i class="ph-bold ph-user-circle me-1 text-primary"></i> {{ Str::limit($td->petugas, 15) }}
                        </span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-2 px-3 rounded-pill">
                            <i class="ph-bold ph-clock me-1 text-warning"></i> 
                            {{ \Carbon\Carbon::parse($td->waktu_tindakan)->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    {{-- Footer Actions (REVISED: Removed View Link) --}}
                    <div class="d-flex justify-content-end align-items-center mt-auto pt-3 border-top border-secondary border-opacity-10">
                        <div class="d-flex gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('tindakan.edit', $td->id) }}" class="action-btn btn-edit" title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </a>
                            
                            {{-- Delete --}}
                            <button type="button" class="action-btn btn-delete" onclick="confirmDelete('{{ $td->id }}')" title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                            <form id="delete-form-{{ $td->id }}" action="{{ route('tindakan.destroy', $td->id) }}" method="POST" class="d-none">
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
            {{ $tindakan->withQueryString()->links() }}
        </div>
    @endif
</div>

<script>
    // 1. Notifikasi Sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
            background: '#1e293b', color: '#fff', toast: true, position: 'top-end',
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif

    // 2. Konfirmasi Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Tindakan?', text: "Data tidak bisa dikembalikan!",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#334155',
            confirmButtonText: 'Hapus', cancelButtonText: 'Batal',
            background: '#0f172a', color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        })
    }
</script>

<style>
    div:where(.swal2-container) div:where(.swal2-popup) {
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 20px !important;
    }
</style>

@endsection