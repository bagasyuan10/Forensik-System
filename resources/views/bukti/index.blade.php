@extends('layouts.layout')

@section('content')

{{-- Style Khusus Halaman Ini --}}
<style>
    /* Base Elements */
    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Cards */
    .custom-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Evidence Item Card */
    .evidence-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .evidence-card:hover {
        transform: translateY(-5px);
        border-color: rgba(34, 211, 238, 0.3);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.3);
    }

    /* Thumbnail Area */
    .thumb-wrapper {
        height: 180px;
        width: 100%;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .evidence-card:hover .thumb-img {
        transform: scale(1.05);
    }

    /* Form Elements (Glassy) */
    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 50px; /* Pill shape */
        padding: 10px 20px;
    }
    
    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.8);
        border-color: #22d3ee;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
    }
    
    .form-control-glass::placeholder { color: #64748b; }

    /* Buttons */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        color: white;
        font-weight: 600;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        transition: transform 0.2s;
    }
    .btn-glow:hover {
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
    }

    .btn-action-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
    }

    .btn-view { background: rgba(56, 189, 248, 0.1); color: #38bdf8; }
    .btn-view:hover { background: #38bdf8; color: #000; }

    .btn-download { background: rgba(16, 185, 129, 0.1); color: #34d399; }
    .btn-download:hover { background: #10b981; color: #fff; }

    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    /* Badge Type */
    .badge-type {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Modal Customization */
    .modal-content-dark {
        background-color: #1e293b;
        color: #e2e8f0;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .modal-header { border-bottom: 1px solid rgba(255,255,255,0.05); }
    .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Manajemen Bukti</h2>
            <p class="text-secondary m-0" style="font-size: 0.9rem;">Kelola arsip digital dan barang bukti fisik</p>
        </div>
        
        <a href="{{ route('bukti.create') }}" class="btn btn-glow rounded-pill d-flex align-items-center gap-2 px-4 py-2">
            <i class="ph-bold ph-upload-simple"></i>
            <span>Upload Bukti</span>
        </a>
    </div>

    <div class="custom-card p-4 mb-4">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                    <input type="text" name="search" class="form-control form-control-glass ps-5" 
                           placeholder="Cari nama bukti atau deskripsi..." 
                           value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <select name="filter" class="form-select form-select-glass">
                    <option value="all">📂 Semua Tipe</option>
                    <option value="image" {{ request('filter') == 'image' ? 'selected' : '' }}>🖼️ Gambar (JPG/PNG)</option>
                    <option value="pdf" {{ request('filter') == 'pdf' ? 'selected' : '' }}>📄 Dokumen (PDF)</option>
                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100 rounded-pill fw-bold" 
                        style="background: #3b82f6; border: none; padding: 10px;">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    @if($bukti->count() == 0)
        <div class="d-flex flex-column align-items-center justify-content-center py-5 custom-card">
            <div class="rounded-circle bg-dark p-4 mb-3 border border-secondary border-opacity-25">
                <i class="ph-duotone ph-magnifying-glass text-secondary" style="font-size: 48px;"></i>
            </div>
            <h5 class="text-white fw-bold">Tidak ada bukti ditemukan</h5>
            <p class="text-secondary">Coba ubah kata kunci pencarian atau upload bukti baru.</p>
        </div>
    @endif

    <div class="row g-4">
        @foreach($bukti as $item)
        <div class="col-md-3 col-sm-6">
            <div class="evidence-card">
                
                <div class="thumb-wrapper">
                    <span class="badge-type">
                        {{ strtoupper($item->file_type == 'application/pdf' ? 'PDF' : (Str::startsWith($item->file_type, 'image/') ? 'IMG' : 'FILE')) }}
                    </span>

                    @if(Str::startsWith($item->file_type, 'image/'))
                        <img src="{{ asset('storage/'.$item->file_path) }}" class="thumb-img" alt="{{ $item->nama_bukti }}">
                    @elseif($item->file_type == 'application/pdf')
                        <i class="ph-duotone ph-file-pdf text-danger" style="font-size: 64px;"></i>
                    @else
                        <i class="ph-duotone ph-file text-info" style="font-size: 64px;"></i>
                    @endif

                    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 50px; background: linear-gradient(to top, rgba(30,41,59,1), transparent);"></div>
                </div>

                <div class="p-3">
                    <h6 class="fw-bold text-white mb-1 text-truncate" title="{{ $item->nama_bukti }}">{{ $item->nama_bukti }}</h6>
                    <p class="text-secondary small mb-3 text-truncate">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded bg-dark border border-secondary border-opacity-10">
                        <div class="d-flex align-items-center gap-1 text-secondary" style="font-size: 0.75rem;">
                            <i class="ph-bold ph-hard-drives"></i>
                            <span>{{ number_format($item->file_size / 1024, 2) }} KB</span>
                        </div>
                        <div class="text-secondary" style="font-size: 0.75rem;">
                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn-action-circle btn-view" 
                                data-bs-toggle="modal" 
                                data-bs-target="#previewModal{{ $item->id }}" 
                                title="Lihat Preview">
                            <i class="ph-bold ph-eye"></i>
                        </button>

                        <a href="{{ asset('storage/'.$item->file_path) }}" 
                           target="_blank" 
                           class="btn-action-circle btn-download" 
                           title="Download File">
                            <i class="ph-bold ph-download-simple"></i>
                        </a>

                        <form action="{{ route('bukti.destroy', $item->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus bukti ini secara permanen?')">
                            @csrf @method('DELETE')
                            <button class="btn-action-circle btn-delete" title="Hapus Bukti">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="previewModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content modal-content-dark rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <i class="ph-duotone ph-file-magnifying-glass text-info"></i>
                            {{ $item->nama_bukti }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 text-center bg-black rounded-bottom-4" style="min-height: 400px; display: grid; place-items: center;">
                        
                        @if(Str::startsWith($item->file_type, 'image/'))
                            <img src="{{ asset('storage/'.$item->file_path) }}" class="img-fluid" style="max-height: 80vh;">
                        
                        @elseif($item->file_type == 'application/pdf')
                            <iframe src="{{ asset('storage/'.$item->file_path) }}" 
                                    width="100%" height="600px" 
                                    style="border:none;"></iframe>
                        @else
                            <div class="text-center py-5">
                                <i class="ph-duotone ph-file-x text-secondary" style="font-size: 64px;"></i>
                                <p class="mt-3 text-secondary">Preview tidak tersedia untuk format file ini.</p>
                                <a href="{{ asset('storage/'.$item->file_path) }}" class="btn btn-primary rounded-pill mt-2">
                                    Download File
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $bukti->links() }}
    </div>

</div>
@endsection