@extends('layouts.layout')

@section('content')

{{-- Style Khusus Halaman Ini --}}
<style>
    /* Card & Typography */
    .custom-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Form Elements (Glassy) */
    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 50px;
        padding: 12px 20px;
    }
    
    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.8);
        border-color: #22d3ee;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
    }
    
    .form-control-glass::placeholder { color: #64748b; }

    /* Case Card Styling */
    .case-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .case-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        border-color: rgba(34, 211, 238, 0.2);
    }

    /* Decorative Top Border */
    .case-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #06b6d4, #8b5cf6);
        opacity: 0.7;
    }

    /* Meta Info Items */
    .meta-item {
        font-size: 0.85rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .meta-item i { color: #22d3ee; }

    /* Buttons */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 50px;
        transition: transform 0.2s;
    }
    .btn-glow:hover { transform: translateY(-2px); color: white; }

    /* Circular Action Buttons */
    .btn-action-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.03);
        color: #94a3b8;
        transition: all 0.2s;
    }
    
    .btn-view:hover { background: #38bdf8; color: #0f172a; border-color: #38bdf8; }
    .btn-edit:hover { background: #fbbf24; color: #0f172a; border-color: #fbbf24; }
    .btn-delete:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

    /* Case Number Badge */
    .badge-case-num {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 10px;
        border-radius: 8px;
        font-family: monospace;
        color: #e2e8f0;
        font-size: 0.8rem;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Daftar Kasus</h2>
            <p class="text-secondary m-0" style="font-size: 0.9rem;">Manajemen data investigasi dan laporan kasus.</p>
        </div>
        
        <a href="{{ route('kasus.create') }}" class="btn btn-glow d-flex align-items-center gap-2">
            <i class="ph-bold ph-folder-plus"></i>
            <span>Tambah Kasus</span>
        </a>
    </div>

    {{-- Search & Filter Section --}}
    <div class="custom-card p-4 mb-4">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input type="text" name="q" class="form-control form-control-glass ps-5" 
                           placeholder="Cari judul, nomor kasus, atau lokasi..." 
                           value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="position-relative">
                    <i class="ph-bold ph-funnel position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <select name="filter" class="form-select form-select-glass ps-5">
                        <option value="all" {{ request('filter')=='all' ? 'selected':'' }}>📂 Semua Status</option>
                        <option value="withBukti" {{ request('filter')=='withBukti' ? 'selected':'' }}>📎 Dengan Bukti</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100 rounded-pill fw-bold h-100" 
                        style="background: #3b82f6; border: none; padding: 12px;">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Content Grid --}}
    @if($kasus->isEmpty())
        <div class="custom-card p-5 text-center">
            <div class="d-inline-flex align-items-center justify-content-center bg-dark rounded-circle p-4 mb-3 border border-secondary border-opacity-25">
                <i class="ph-duotone ph-folder-open text-secondary" style="font-size: 48px;"></i>
            </div>
            <h5 class="text-white fw-bold">Tidak ada data kasus</h5>
            <p class="text-secondary">Coba ubah kata kunci pencarian atau buat kasus baru.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach ($kasus as $k)
                <div class="col-md-4 col-sm-6">
                    <div class="case-card p-4">
                        
                        {{-- Card Header --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="ph-duotone ph-briefcase text-primary" style="font-size: 20px;"></i>
                                </div>
                                <div>
                                    <span class="badge-case-num">{{ $k->nomor_kasus ?? 'NO-ID' }}</span>
                                </div>
                            </div>
                            {{-- Dropdown Menu (Optional) or Status --}}
                            <div class="text-secondary small">
                                {{ $k->created_at->diffForHumans() }}
                            </div>
                        </div>

                        {{-- Card Title --}}
                        <h5 class="fw-bold text-white mb-2 text-truncate" title="{{ $k->judul }}">
                            {{ $k->judul }}
                        </h5>

                        {{-- Description --}}
                        <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                            {{ Str::limit($k->deskripsi, 90, '...') }}
                        </p>

                        {{-- Meta Info --}}
                        <div class="mb-4 pt-3 border-top border-secondary border-opacity-10">
                            <div class="meta-item">
                                <i class="ph-bold ph-map-pin"></i>
                                <span>{{ $k->lokasi ?? 'Lokasi tidak diketahui' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="ph-bold ph-calendar-blank"></i>
                                <span>{{ $k->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <a href="{{ route('kasus.show', $k->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-bold" style="font-size: 0.8rem;">
                                Detail Kasus
                            </a>

                            <div class="d-flex gap-2">
                                <a href="{{ route('kasus.edit', $k->id) }}" class="btn-action-circle btn-edit" title="Edit">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </a>

                                <form action="{{ route('kasus.destroy', $k->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus kasus ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-action-circle btn-delete" title="Hapus">
                                        <i class="ph-bold ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $kasus->links() }}
        </div>
    @endif
</div>

@endsection