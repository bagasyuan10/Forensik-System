@extends('layouts.Layout')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">🗂️ Manajemen Bukti</h2>
            <small class="text-muted">Lihat, filter, upload, dan kelola bukti kasus.</small>
        </div>

        <a href="{{ route('bukti.create') }}" class="btn btn-success shadow-sm px-3">
            <i class="bi bi-plus-lg"></i> Tambah Bukti
        </a>
    </div>

    {{-- FILTER / SEARCH --}}
    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control form-control-lg rounded-pill"
                           placeholder="🔍 Cari bukti..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="filter" class="form-select form-select-lg rounded-pill">
                        <option value="all">Semua</option>
                        <option value="image" {{ request('filter') == 'image' ? 'selected' : '' }}>Gambar</option>
                        <option value="pdf" {{ request('filter') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary w-100 btn-lg rounded-pill shadow-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Jika kosong --}}
    @if($bukti->count() == 0)
        <div class="alert alert-secondary rounded-4 shadow-sm p-4 text-center">
            <h5 class="fw-bold mb-1">Tidak ada bukti ditemukan</h5>
            <p class="text-muted mb-0">Coba ubah filter pencarian atau tambahkan bukti baru.</p>
        </div>
    @endif

    {{-- GRID LIST --}}
    <div class="row">
        @foreach($bukti as $item)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bukti-card">

                {{-- THUMBNAIL --}}
                <div class="position-relative">
                    @if(Str::startsWith($item->file_type, 'image/'))
                        <img src="{{ asset('storage/'.$item->file_path) }}"
                             class="card-img-top rounded-top-4"
                             style="height:180px; object-fit:cover">
                    @else
                        <div class="d-flex justify-content-center align-items-center bg-light rounded-top-4"
                             style="height:180px;">
                            <i class="bi bi-file-earmark-text" style="font-size:48px;"></i>
                        </div>
                    @endif

                    {{-- FILE TYPE TAG --}}
                    <span class="badge file-type-badge position-absolute top-0 start-0 m-2 px-3 py-2 rounded-pill">
                        {{ strtoupper($item->file_type == 'application/pdf' ? 'PDF' : (Str::startsWith($item->file_type, 'image/') ? 'IMG' : 'FILE')) }}
                    </span>
                </div>

                {{-- CONTENT --}}
                <div class="card-body">
                    <h6 class="fw-bold mb-1">{{ $item->nama_bukti }}</h6>
                    <p class="text-muted mb-2" style="font-size:14px;">{{ $item->deskripsi }}</p>

                    <div class="d-flex justify-content-between text-muted small mb-3">
                        <span><i class="bi bi-hdd"></i> {{ number_format($item->file_size / 1024, 2) }} KB</span>
                        <span><i class="bi bi-tag"></i> {{ $item->file_type }}</span>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#previewModal{{ $item->id }}">
                            <i class="bi bi-eye"></i>
                        </button>

                        <a href="{{ asset('storage/'.$item->file_path) }}"
                           target="_blank"
                           class="btn btn-secondary btn-sm rounded-pill">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>

                        <form action="{{ route('bukti.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus bukti ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-pill">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL PREVIEW --}}
        <div class="modal fade" id="previewModal{{ $item->id }}">
            <div class="modal-dialog modal-xl">
                <div class="modal-content rounded-4 p-3">

                    <h5 class="fw-bold">{{ $item->nama_bukti }}</h5>
                    <p class="text-muted">{{ strtoupper($item->file_type) }}</p>

                    @if(Str::startsWith($item->file_type, 'image/'))
                        <img src="{{ asset('storage/'.$item->file_path) }}" class="img-fluid rounded-3 shadow-sm">
                    @elseif($item->file_type == 'application/pdf')
                        <iframe src="{{ asset('storage/'.$item->file_path) }}"
                                width="100%" height="600"
                                class="rounded-3 border shadow-sm"></iframe>
                    @else
                        <p class="text-center p-4 bg-light rounded-3">
                            Tidak dapat melakukan preview.  
                            <a href="{{ asset('storage/'.$item->file_path) }}">Download file</a>
                        </p>
                    @endif

                </div>
            </div>
        </div>

        @endforeach
    </div>

    <div class="mt-3">
        {{ $bukti->links() }}
    </div>

</div>

{{-- EXTRA STYLE --}}
<style>
    .bukti-card {
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .bukti-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 30px rgba(0,0,0,.12);
    }

    .file-type-badge {
        background: #0d6efd;
        color: white;
        font-weight: bold;
    }
</style>
@endsection