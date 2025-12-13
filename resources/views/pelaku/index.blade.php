@extends('layouts.layout')

@section('content')

{{-- 1. LIBRARY TAMBAHAN (CDN) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND ACCENTS (Disamakan dengan Kasus) --- */
    .bg-blob {
        position: absolute;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.4;
        animation: float 10s infinite ease-in-out;
    }
    /* Sedikit variasi warna (Ungu/Biru) untuk membedakan konteks Pelaku vs Kasus, 
       tapi tetap satu tema "Glass Dark" */
    .blob-1 { top: -10%; right: -5%; width: 300px; height: 300px; background: #8b5cf6; } 
    .blob-2 { bottom: 10%; left: -5%; width: 250px; height: 250px; background: #06b6d4; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* --- GLASS FORM & PANELS --- */
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
        border-color: #8b5cf6; /* Aksen Ungu */
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.2);
        color: #fff;
    }

    /* --- CARD DESIGN (Base Style dari Kasus) --- */
    .pelaku-card {
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

    .pelaku-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 
                    0 0 20px rgba(139, 92, 246, 0.15);
    }

    /* Neon Line Top (Ungu ke Cyan) */
    .pelaku-card::after {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, transparent, #8b5cf6, #06b6d4, transparent);
        opacity: 0.6;
    }

    /* --- MUGSHOT STYLING (Pengganti Icon Box) --- */
    .mugshot-box {
        width: 60px; height: 60px;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        flex-shrink: 0;
        background: #0f172a;
    }
    
    .mugshot-img {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    .id-badge {
        font-family: 'Courier New', monospace;
        background: rgba(0, 0, 0, 0.3);
        padding: 4px 10px;
        border-radius: 6px;
        color: #94a3b8;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border: 1px solid rgba(255,255,255,0.05);
        display: inline-block;
    }

    /* --- ACTION BUTTONS (Circular Style) --- */
    .action-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.03);
        color: #94a3b8;
        transition: 0.3s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .action-btn:hover { transform: rotate(15deg); color: #fff; }
    .btn-edit:hover { background: #f59e0b; border-color: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.4); }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.4); }

    .btn-neon-primary {
        background: linear-gradient(90deg, #8b5cf6, #3b82f6);
        color: white; border: none; font-weight: 600;
        padding: 10px 25px; border-radius: 50px;
        box-shadow: 0 0 15px rgba(139, 92, 246, 0.3);
        transition: 0.3s;
        text-decoration: none;
    }
    .btn-neon-primary:hover {
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.6);
        transform: translateY(-2px);
        color: white;
    }

    /* Pagination */
    .pagination .page-link {
        background: rgba(15, 23, 42, 0.8);
        border-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }
    .pagination .active .page-link {
        background: #8b5cf6;
        border-color: #8b5cf6;
        color: white;
    }

    .text-gradient {
        background: linear-gradient(to right, #fff, #e879f9);
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
            <h2 class="fw-bold display-6 text-gradient mb-1">Daftar Pelaku</h2>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <span class="badge bg-purple bg-opacity-10 text-white border border-secondary border-opacity-20 px-3 py-1 rounded-pill" style="background-color: rgba(139, 92, 246, 0.2);">
                    Total: {{ $pelaku->total() ?? 0 }} Subjek
                </span>
                <span style="font-size: 0.9rem;">Database Kriminal Terpadu</span>
            </div>
        </div>
        
        <a href="{{ route('pelaku.create') }}" class="btn btn-neon-primary d-flex align-items-center gap-2">
            <i class="ph-bold ph-fingerprint" style="font-size: 1.2rem;"></i>
            <span>Tambah Pelaku</span>
        </a>
    </div>

    {{-- SEARCH & FILTER BAR (Mengikuti Layout Kasus) --}}
    <div class="glass-panel p-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">
        <form method="GET" class="row g-3 align-items-center">
            {{-- Kolom 1: Input Pencarian --}}
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 1.2rem;"></i>
                    <input type="text" name="q" class="form-control search-input" 
                           placeholder="Cari nama, ID, atau ciri fisik..." 
                           value="{{ request('q') }}">
                </div>
            </div>

            {{-- Kolom 2: Filter Dropdown --}}
            <div class="col-md-3">
                <div class="position-relative">
                    <i class="ph-bold ph-funnel position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <select name="status" class="form-select search-input ps-5" style="cursor: pointer;">
                        <option value="">Semua Status</option>
                        <option value="Tahanan" {{ request('status')=='Tahanan' ? 'selected':'' }}>Tahanan</option>
                        <option value="DPO" {{ request('status')=='DPO' ? 'selected':'' }}>DPO (Buron)</option>
                        <option value="Bebas" {{ request('status')=='Bebas' ? 'selected':'' }}>Bebas</option>
                    </select>
                </div>
            </div>

            {{-- Kolom 3: Tombol Submit --}}
            <div class="col-md-3">
                <button class="btn w-100 rounded-pill fw-bold text-white" 
                        style="height: 50px; background: rgba(139, 92, 246, 0.2); border: 1px solid #8b5cf6;">
                    <i class="ph-bold ph-magnifying-glass me-2"></i> Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- CONTENT GRID --}}
    @if($pelaku->isEmpty())
        <div class="glass-panel p-5 text-center animate__animated animate__zoomIn">
            <div class="mb-3">
                <i class="ph-duotone ph-user-minus text-secondary" style="font-size: 64px;"></i>
            </div>
            <h4 class="text-white fw-bold">Database Kosong</h4>
            <p class="text-secondary">Tidak ada data pelaku yang cocok dengan pencarian.</p>
            <a href="{{ route('pelaku.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mt-2">Reset Filter</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($pelaku as $index => $p)
                <div class="col-xl-3 col-lg-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                    
                    <div class="pelaku-card p-4">
                        
                        {{-- Header Card: Photo & Basic Info --}}
                        <div class="d-flex align-items-start gap-3 mb-3">
                            {{-- Foto (Mugshot) --}}
                            <div class="mugshot-box">
                                @if($p->foto)
                                    <img src="{{ asset('storage/' . $p->foto) }}" 
                                         class="mugshot-img" 
                                         alt="{{ $p->nama }}"
                                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=random&color=fff&bold=true';">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=random&color=fff&bold=true" 
                                         class="mugshot-img" alt="Placeholder">
                                @endif
                            </div>

                            {{-- Nama & ID --}}
                            <div class="overflow-hidden">
                                <h6 class="fw-bold text-white mb-1 text-truncate" title="{{ $p->nama }}">{{ $p->nama }}</h6>
                                <div class="id-badge mb-1">ID: {{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
                                
                                {{-- Status Label Kecil --}}
                                <div class="small {{ $p->status_hukum == 'DPO' ? 'text-danger' : 'text-success' }} fw-bold" style="font-size: 0.7rem;">
                                    ● {{ strtoupper($p->status_hukum) }}
                                </div>
                            </div>
                        </div>

                        {{-- Content: Bio --}}
                        <div class="flex-grow-1 mb-3">
                            <hr class="border-secondary border-opacity-10 my-2">
                            <p class="text-secondary small" style="line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 4.8em;">
                                {{ $p->biodata ?? 'Tidak ada keterangan tambahan mengenai subjek ini.' }}
                            </p>
                        </div>

                        {{-- Meta Data (Footer Info) --}}
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary fw-normal py-1 px-2 rounded-pill small">
                                <i class="ph-bold ph-calendar me-1"></i> {{ $p->created_at->format('d/m/y') }}
                            </span>
                        </div>

                        {{-- Action Buttons (Bottom Aligned) --}}
                        <div class="d-flex justify-content-end align-items-center mt-auto pt-3 border-top border-secondary border-opacity-10">
                            <div class="d-flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('pelaku.edit', $p->id) }}" class="action-btn btn-edit" title="Edit Data">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </a>

                                {{-- Delete --}}
                                <button type="button" class="action-btn btn-delete" title="Hapus Data" 
                                        onclick="confirmDelete('{{ $p->id }}', '{{ $p->nama }}')">
                                    <i class="ph-bold ph-trash"></i>
                                </button>

                                {{-- Hidden Form --}}
                                <form id="delete-form-{{ $p->id }}" action="{{ route('pelaku.destroy', $p->id) }}" method="POST" class="d-none">
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
            {{ $pelaku->withQueryString()->links() }}
        </div>
    @endif

</div>

{{-- SCRIPT JAVASCRIPT --}}
<script>
    // 1. Notifikasi Flash Session
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
            timerProgressBar: true
        });
    @endif

    // 2. Konfirmasi Delete (SweetAlert)
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Data Pelaku?',
            html: `Anda akan menghapus data <b>${nama}</b>.<br>Data tidak dapat dikembalikan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#0f172a',
            color: '#fff',
            backdrop: `rgba(0,0,0,0.6)`
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

<style>
    /* Override Style SweetAlert */
    div:where(.swal2-container) div:where(.swal2-popup) {
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 20px !important;
    }
</style>

@endsection