@extends('layouts.layout')

@section('content')

{{-- 1. LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND ANIMATION --- */
    .bg-blob {
        position: absolute; filter: blur(80px); z-index: 0; opacity: 0.4;
        animation: float 10s infinite ease-in-out;
    }
    .blob-1 { top: -10%; right: -5%; width: 300px; height: 300px; background: #f59e0b; }
    .blob-2 { bottom: 10%; left: -5%; width: 250px; height: 250px; background: #ef4444; }

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
        border-color: #f59e0b; box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
        color: #fff;
    }

    /* --- CARD DESIGN --- */
    .evidence-card {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        position: relative; overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%; display: flex; flex-direction: column;
    }

    .evidence-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(245, 158, 11, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(245, 158, 11, 0.15);
    }

    /* Neon Line Bottom */
    .evidence-card::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px;
        background: linear-gradient(90deg, transparent, #f59e0b, #ef4444, transparent);
        opacity: 0.6;
    }

    /* --- THUMBNAIL STYLE --- */
    .thumb-container {
        width: 80px; aspect-ratio: 1 / 1; 
        border-radius: 20px; overflow: hidden;
        border: 2px solid rgba(255,255,255,0.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        flex-shrink: 0; background: #0f172a; 
    }

    .thumb-img {
        width: 100%; height: 100%; object-fit: cover; 
        transition: transform 0.5s;
    }
    .evidence-card:hover .thumb-img { transform: scale(1.1); }

    /* --- ACTION BUTTONS (BULAT) --- */
    .btn-action-glass {
        width: 38px; height: 38px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        color: #94a3b8; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none; cursor: pointer;
    }
    .btn-action-glass:hover { transform: translateY(-3px) scale(1.1); color: #fff; }
    
    .btn-action-edit:hover { 
        background: rgba(245, 158, 11, 0.2); border-color: #f59e0b; color: #fbbf24;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }
    .btn-action-delete:hover { 
        background: rgba(239, 68, 68, 0.2); border-color: #ef4444; color: #fca5a5;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
    }

    /* --- TEXT & UTILS --- */
    .text-gradient {
        background: linear-gradient(to right, #fff, #fcd34d);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .btn-neon-primary {
        background: linear-gradient(90deg, #f59e0b, #ef4444);
        color: white; border: none; font-weight: 600;
        padding: 10px 25px; border-radius: 50px;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.3); transition: 0.3s;
    }
    .btn-neon-primary:hover {
        box-shadow: 0 0 25px rgba(245, 158, 11, 0.6);
        transform: translateY(-2px); color: white;
    }
    
    /* Pagination */
    .pagination .page-link { background: rgba(15, 23, 42, 0.8); border-color: rgba(255, 255, 255, 0.1); color: #94a3b8; }
    .pagination .active .page-link { background: #f59e0b; border-color: #f59e0b; color: white; }
</style>

<div class="position-relative container-fluid py-4" style="min-height: 80vh;">
    
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 animate__animated animate__fadeInDown">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold display-6 text-gradient mb-1">Daftar Barang Bukti</h2>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-3 py-1 rounded-pill">
                    Total: {{ $bukti->total() ?? 0 }}
                </span>
                <span style="font-size: 0.9rem;">Arsip fisik & digital</span>
            </div>
        </div>
        
        <a href="{{ route('bukti.create') }}" class="btn btn-neon-primary d-flex align-items-center gap-2">
            <i class="ph-bold ph-upload-simple" style="font-size: 1.2rem;"></i>
            <span>Upload Bukti</span>
        </a>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="glass-panel p-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 1.2rem;"></i>
                    <input type="text" name="search" class="form-control search-input" 
                           placeholder="Cari nama bukti, deskripsi..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select search-input ps-4" style="cursor: pointer;">
                    <option value="all">📂 Semua Tipe</option>
                    <option value="image" {{ request('filter') == 'image' ? 'selected' : '' }}>🖼️ Gambar</option>
                    <option value="pdf" {{ request('filter') == 'pdf' ? 'selected' : '' }}>📄 PDF</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-warning w-100 rounded-pill fw-bold" 
                        style="height: 50px; background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: #fbbf24;">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- CONTENT GRID --}}
    @if($bukti->isEmpty())
        <div class="glass-panel p-5 text-center animate__animated animate__zoomIn">
            <div class="mb-3"><i class="ph-duotone ph-package text-secondary" style="font-size: 64px;"></i></div>
            <h4 class="text-white fw-bold">Data Tidak Ditemukan</h4>
            <p class="text-secondary">Belum ada barang bukti yang diupload.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($bukti as $index => $item)
            <div class="col-xl-3 col-lg-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                
                {{-- CARD UTAMA --}}
                <div class="evidence-card p-4">
                    
                    {{-- 1. BAGIAN ATAS (Foto Kiri - Teks Kanan) --}}
                    <div class="d-flex align-items-start gap-3 mb-3">
                        
                        {{-- Thumbnail Box --}}
                        <div class="thumb-container">
                            @if(Str::startsWith($item->file_type, 'image/') && $item->file_path)
                                <img src="{{ asset('storage/' . $item->file_path) }}" 
                                     class="thumb-img" 
                                     alt="{{ $item->nama_bukti }}"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nama_bukti) }}&background=random&color=fff&bold=true';">
                            @elseif($item->file_type == 'application/pdf')
                                <img src="https://ui-avatars.com/api/?name=PDF&background=ef4444&color=fff&bold=true" class="thumb-img" alt="PDF">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama_bukti) }}&background=random&color=fff&bold=true" class="thumb-img" alt="File">
                            @endif
                        </div>

                        {{-- Info Utama (Tanpa ID) --}}
                        <div class="overflow-hidden flex-grow-1">
                            <h6 class="fw-bold text-white mb-2 text-truncate" title="{{ $item->nama_bukti }}">
                                {{ $item->nama_bukti }}
                            </h6>
                            
                            {{-- Tipe File Badge --}}
                            <div class="d-flex align-items-center gap-1">
                                <span class="d-inline-block rounded-circle" 
                                      style="width: 8px; height: 8px; background-color: {{ $item->file_type == 'application/pdf' ? '#ef4444' : '#f59e0b' }}">
                                </span>
                                <span class="text-secondary small text-uppercase" style="font-size: 0.7rem;">
                                    {{ Str::startsWith($item->file_type, 'image/') ? 'Image' : 'Document' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-10 my-2">

                    {{-- 2. Deskripsi --}}
                    <div class="flex-grow-1 mb-3">
                        <small class="text-uppercase text-secondary fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Keterangan</small>
                        <p class="text-secondary small mt-1" style="line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->deskripsi ?? 'Tidak ada keterangan detail.' }}
                        </p>
                        <div class="d-flex align-items-center gap-2 mt-2">
                             <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary" style="font-size: 0.65rem;">
                                {{ number_format($item->file_size / 1024, 0) }} KB
                            </span>
                        </div>
                    </div>

                    {{-- 3. Action Buttons (Tanpa Preview) --}}
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-10">
                        
                        <div class="d-flex align-items-center text-secondary small" style="font-size: 0.75rem;">
                            <i class="ph-duotone ph-calendar-blank me-1"></i>
                            <span>{{ $item->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="d-flex gap-2">
                            {{-- Edit Button --}}
                            <a href="{{ route('bukti.edit', $item->id) }}" class="btn-action-glass btn-action-edit" title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </a>

                            {{-- Delete Button --}}
                            <button type="button" class="btn-action-glass btn-action-delete" onclick="confirmDelete('{{ $item->id }}')" title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('bukti.destroy', $item->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $bukti->withQueryString()->links() }}
        </div>
    @endif
</div>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
            background: '#1e293b', color: '#fff', toast: true, position: 'top-end',
            showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Bukti?', text: "File akan terhapus permanen!",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#334155',
            confirmButtonText: 'Hapus', cancelButtonText: 'Batal',
            background: '#0f172a', color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        })
    }
</script>

@endsection