@extends('layouts.Layout')

@section('content')
<style>
    .case-card {
        transition: 0.25s ease;
        border-radius: 14px !important;
    }

    .case-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 18px rgba(0,0,0,0.15) !important;
    }

    .case-header {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: white;
        padding: 18px;
        border-radius: 14px;
        box-shadow: 0 6px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-pill {
        border-radius: 50px;
    }

    .search-box {
        border-radius: 50px;
        padding-left: 18px;
    }
</style>

<div class="container mt-4">

    {{-- Header --}}
    <div class="case-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">📁 Daftar Kasus</h2>
            <small class="opacity-75">Manajemen data kasus — lihat, ubah, dan kelola laporan.</small>
        </div>

        <a href="{{ route('kasus.create') }}" class="btn btn-light btn-pill shadow-sm px-4 fw-semibold">
            + Tambah Kasus
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-5">
            <input type="text"
                name="q"
                class="form-control search-box shadow-sm"
                placeholder="🔍 Cari judul, nomor kasus, atau lokasi..."
                value="{{ request('q') }}">
        </div>

        <div class="col-md-3">
            <select name="filter" class="form-control btn-pill shadow-sm">
                <option value="all" {{ request('filter')=='all' ? 'selected':'' }}>Semua</option>
                <option value="withBukti" {{ request('filter')=='withBukti' ? 'selected':'' }}>Dengan Bukti</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary btn-pill w-100 shadow-sm">Filter</button>
        </div>
    </form>

    {{-- Kosong --}}
    @if($kasus->isEmpty())
        <div class="alert alert-info text-center py-4 shadow-sm rounded-3">
            <strong>😕 Tidak ada data.</strong><br>
            Coba ubah pencarian atau tambahkan kasus baru.
        </div>
    @else

        <div class="row">
            @foreach ($kasus as $k)
                <div class="col-md-4 mb-4">
                    <div class="card case-card border-0 shadow-sm">

                        {{-- Card Body --}}
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $k->judul }}</h5>

                            <p class="text-muted small mb-2">
                                <i class="bi bi-hash"></i> {{ $k->nomor_kasus ?? '—' }} <br>
                                <i class="bi bi-geo-alt"></i> {{ $k->lokasi ?? '—' }} <br>
                                <i class="bi bi-calendar-date"></i>
                                {{ $k->created_at->format('d M Y - H:i') }}
                            </p>

                            <p class="card-text small" style="min-height: 55px;">
                                {{ Str::limit($k->deskripsi, 110, '...') }}
                            </p>

                            {{-- Buttons --}}
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('kasus.show', $k->id) }}"
                                   class="btn btn-outline-secondary btn-sm btn-pill">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>

                                <a href="{{ route('kasus.edit', $k->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-pill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('kasus.destroy', $k->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kasus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm btn-pill">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $kasus->links('pagination::bootstrap-5') }}
        </div>

    @endif
</div>

@endsection