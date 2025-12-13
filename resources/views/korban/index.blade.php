@extends('layouts.layout')

@section('content')

{{-- 1. LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND ACCENTS (UNGU/PINK - KORBAN THEME) --- */
    .bg-blob { position: absolute; filter: blur(80px); z-index: 0; opacity: 0.4; animation: float 10s infinite ease-in-out; }
    .blob-1 { top: -10%; right: -5%; width: 300px; height: 300px; background: #a855f7; }
    .blob-2 { bottom: 10%; left: -5%; width: 250px; height: 250px; background: #ec4899; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }

    /* --- GLASS PANEL --- */
    .glass-panel { background: rgba(30, 41, 59, 0.4); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2); position: relative; z-index: 1; }

    .search-input { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; border-radius: 50px; padding: 14px 20px 14px 50px; transition: all 0.3s; }
    .search-input:focus { background: rgba(15, 23, 42, 0.9); border-color: #d946ef; box-shadow: 0 0 15px rgba(217, 70, 239, 0.2); color: #fff; }

    /* --- CARD DESIGN --- */
    .case-card { background: linear-gradient(145deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.8)); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 20px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); height: 100%; display: flex; flex-direction: column; }
    .case-card:hover { transform: translateY(-8px) scale(1.02); border-color: rgba(217, 70, 239, 0.3); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 20px rgba(217, 70, 239, 0.1); }
    .case-card::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, transparent, #d946ef, #8b5cf6, transparent); opacity: 0.6; }

    /* --- FOTO / MUGSHOT --- */
    .mugshot-container { width: 80px; aspect-ratio: 1 / 1; border-radius: 20px; overflow: hidden; border: 2px solid rgba(255,255,255,0.1); box-shadow: 0 4px 15px rgba(0,0,0,0.3); flex-shrink: 0; background: #0f172a; position: relative; }
    .mugshot-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .case-card:hover .mugshot-img { transform: scale(1.1); }

    .id-badge { font-family: 'Courier New', monospace; background: rgba(0, 0, 0, 0.4); padding: 4px 10px; border-radius: 6px; color: #cbd5e1; font-size: 0.75rem; border: 1px dashed rgba(255,255,255,0.15); display: inline-block; }

    /* --- Buttons & Utilities --- */
    .action-btn { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); color: #94a3b8; transition: 0.3s; cursor: pointer; }
    .action-btn:hover { transform: rotate(15deg); color: #fff; }
    .btn-edit:hover { background: #f59e0b; border-color: #f59e0b; }
    .btn-delete:hover { background: #ef4444; border-color: #ef4444; }

    .btn-neon-primary { background: linear-gradient(90deg, #d946ef, #8b5cf6); color: white; border: none; font-weight: 600; padding: 10px 25px; border-radius: 50px; box-shadow: 0 0 15px rgba(217, 70, 239, 0.3); transition: 0.3s; }
    .btn-neon-primary:hover { box-shadow: 0 0 25px rgba(217, 70, 239, 0.6); transform: translateY(-2px); color: white; }
    
    .text-gradient { background: linear-gradient(to right, #fff, #f0abfc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    
    /* Pagination */
    .pagination .page-link { background: rgba(15, 23, 42, 0.8); border-color: rgba(255, 255, 255, 0.1); color: #94a3b8; }
    .pagination .active .page-link { background: #d946ef; border-color: #d946ef; color: white; }

    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 5px; }
</style>

<div class="position-relative container-fluid py-4" style="min-height: 80vh;">
    
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    {{-- HEADER SECTION --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 animate__animated animate__fadeInDown">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold display-6 text-gradient mb-1">Daftar Korban</h2>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-1 rounded-pill">
                    Total: {{ $data->total() ?? 0 }}
                </span>
                <span style="font-size: 0.9rem;">Database identitas & kondisi fisik</span>
            </div>
        </div>
        
        <a href="{{ route('korban.create') }}" class="btn btn-neon-primary d-flex align-items-center gap-2">
            <i class="ph-bold ph-user-plus" style="font-size: 1.2rem;"></i>
            <span>Tambah Korban</span>
        </a>
    </div>

    {{-- SEARCH BAR --}}
    <div class="glass-panel p-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-9">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary" style="font-size: 1.2rem;"></i>
                    <input type="text" name="q" class="form-control search-input" placeholder="Cari nama, NIK, atau nomor telepon..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100 rounded-pill fw-bold" style="height: 50px; background: rgba(217, 70, 239, 0.2); border: 1px solid #d946ef; color: #f0abfc;">
                    <i class="ph-bold ph-magnifying-glass me-2"></i> Cari Data
                </button>
            </div>
        </form>
    </div>

    {{-- CONTENT GRID --}}
    @if($data->isEmpty())
        <div class="glass-panel p-5 text-center animate__animated animate__zoomIn">
            <i class="ph-duotone ph-users-three text-secondary mb-3" style="font-size: 64px;"></i>
            <h4 class="text-white fw-bold">Data Tidak Ditemukan</h4>
            <p class="text-secondary">Belum ada data korban yang tersimpan.</p>
            <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mt-2">Refresh Halaman</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($data as $index => $k)
                <div class="col-xl-4 col-md-6 animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                    
                    <div class="case-card p-4">
                        
                        {{-- HEADER: Foto + Nama + ID --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            {{-- FOTO --}}
                            <div class="mugshot-container">
                                @if($k->foto)
                                    <img src="{{ asset('storage/' . $k->foto) }}" class="mugshot-img" alt="{{ $k->nama }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=random&color=fff&bold=true" class="mugshot-img" alt="Placeholder">
                                @endif
                            </div>

                            {{-- INFO UTAMA --}}
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="fw-bold text-white mb-1 text-truncate" title="{{ $k->nama }}">
                                    {{ $k->nama }}
                                </h5>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="id-badge">NIK: {{ Str::limit($k->nik ?? '-', 6) }}</div>
                                </div>
                            </div>

                            {{-- DROPDOWN (DETAIL PROFIL REMOVED) --}}
                            <div class="dropdown align-self-start">
                                <button class="btn btn-link text-secondary p-0" data-bs-toggle="dropdown">
                                    <i class="ph-bold ph-dots-three-vertical" style="font-size: 1.5rem;"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark shadow-lg border-0">
                                    <li><a class="dropdown-item" href="{{ route('korban.edit', $k->id) }}"><i class="ph-bold ph-pencil me-2"></i> Edit Data</a></li>
                                    <li>
                                        <button class="dropdown-item text-danger" onclick="confirmDelete('{{ $k->id }}')">
                                            <i class="ph-bold ph-trash me-2"></i> Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- STATUS KORBAN (BADGE) --}}
                        <div class="mb-3">
                            @php
                                $statusClass = match($k->status_korban) {
                                    'Meninggal Dunia' => 'bg-danger text-danger',
                                    'Luka Berat' => 'bg-warning text-warning',
                                    'Luka Ringan' => 'bg-info text-info',
                                    'Sehat/Selamat' => 'bg-success text-success',
                                    default => 'bg-secondary text-secondary'
                                };
                            @endphp
                            <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <span class="badge {{ $statusClass }} bg-opacity-10 border border-opacity-20">
                                    {{ $k->status_korban ?? 'Status Tidak Diketahui' }}
                                </span>
                                <small class="text-secondary">
                                    {{ $k->tanggal_lahir ? \Carbon\Carbon::parse($k->tanggal_lahir)->age . ' Thn' : 'Usia -' }} / {{ $k->jenis_kelamin ?? '-' }}
                                </small>
                            </div>
                        </div>

                        {{-- INFO DETAIL (ALAMAT & LUKA) --}}
                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 mb-2">
                                <i class="ph-fill ph-map-pin text-secondary mt-1"></i>
                                <span class="text-secondary small">{{ Str::limit($k->alamat ?? 'Alamat belum diisi.', 50) }}</span>
                            </div>
                            @if($k->keterangan_luka)
                                <div class="d-flex gap-2">
                                    <i class="ph-fill ph-first-aid text-danger mt-1"></i>
                                    <span class="text-white small opacity-75 fst-italic">"{{ Str::limit($k->keterangan_luka, 60) }}"</span>
                                </div>
                            @endif
                        </div>

                        {{-- FOOTER BUTTONS (DETAIL PROFIL REMOVED) --}}
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-secondary border-opacity-10">
                            
                            {{-- Phone/Contact (Updated from Kontak to No_Telp) --}}
                            <span class="text-secondary small d-flex align-items-center gap-2">
                                <i class="ph-bold ph-phone text-success"></i> 
                                {{ $k->no_telp ?? $k->kontak ?? '-' }}
                            </span>

                            <div class="d-flex gap-2">
                                <a href="{{ route('korban.edit', $k->id) }}" class="action-btn btn-edit" title="Edit"><i class="ph-bold ph-pencil-simple"></i></a>
                                <button type="button" class="action-btn btn-delete" title="Hapus" onclick="confirmDelete('{{ $k->id }}')"><i class="ph-bold ph-trash"></i></button>
                                <form id="delete-form-{{ $k->id }}" action="{{ route('korban.destroy', $k->id) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(method_exists($data, 'links'))
        <div class="mt-5 d-flex justify-content-center">
            {{ $data->withQueryString()->links() }}
        </div>
        @endif
    @endif
</div>

{{-- SCRIPT --}}
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
            background: '#1e293b', color: '#fff', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Korban?', text: "Data yang dihapus tidak dapat dikembalikan!", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#334155',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', background: '#0f172a', color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
        })
    }
</script>

<style>
    div:where(.swal2-container) div:where(.swal2-popup) { border: 1px solid rgba(255,255,255,0.1) !important; border-radius: 20px !important; }
</style>

@endsection