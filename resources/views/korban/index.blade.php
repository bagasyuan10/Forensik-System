@extends('layouts.layout')

@section('content')

{{-- CSS Custom (Konsisten dengan halaman lain) --}}
<style>
    /* Card Container */
    .custom-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Typography */
    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Search Input */
    .form-control-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 50px;
        padding: 12px 20px 12px 45px; /* Padding left for icon */
    }
    .form-control-glass:focus {
        background: rgba(15, 23, 42, 0.8);
        border-color: #22d3ee;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
    }
    .form-control-glass::placeholder { color: #64748b; }

    /* Table Styling */
    .table-dark-custom {
        --bs-table-bg: transparent;
        --bs-table-color: #e2e8f0;
        --bs-table-border-color: rgba(255, 255, 255, 0.05);
        --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
    }
    .table-dark-custom thead th {
        background-color: rgba(15, 23, 42, 0.5);
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 16px;
    }
    .table-dark-custom tbody td {
        padding: 16px;
        vertical-align: middle;
        font-size: 0.95rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    /* Avatar Circle */
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Action Buttons */
    .btn-action-circle {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-view { background: rgba(56, 189, 248, 0.1); color: #38bdf8; }
    .btn-view:hover { background: #38bdf8; color: #000; transform: translateY(-2px); }

    .btn-edit { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
    .btn-edit:hover { background: #fbbf24; color: #000; transform: translateY(-2px); }

    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; }
    .btn-delete:hover { background: #ef4444; color: #fff; transform: translateY(-2px); }

    /* Main Button */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        transition: transform 0.2s;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 50px;
    }
    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
        color: white;
    }

    /* Alert Glass */
    .alert-glass {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #34d399;
        border-radius: 12px;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Daftar Korban</h2>
            <p class="text-secondary m-0" style="font-size: 0.9rem;">Database informasi korban kasus forensik</p>
        </div>
        <a href="{{ route('korban.create') }}" class="btn btn-glow d-flex align-items-center gap-2">
            <i class="ph-bold ph-user-plus"></i>
            <span>Tambah Korban</span>
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-glass d-flex align-items-center gap-2 mb-4 alert-dismissible fade show" role="alert">
            <i class="ph-fill ph-check-circle" style="font-size: 20px;"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Section --}}
    @if(!$data->isEmpty())
    <div class="custom-card p-4 mb-4">
        <div class="position-relative">
            <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
            <input type="text" id="searchInput" class="form-control form-control-glass" placeholder="Cari nama korban, kontak, atau alamat...">
        </div>
    </div>
    @endif

    {{-- Content Table --}}
    <div class="custom-card p-0 overflow-hidden">
        @if ($data->isEmpty())
            {{-- Empty State --}}
            <div class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <i class="ph-duotone ph-users text-secondary mb-3" style="font-size: 48px; opacity: 0.5;"></i>
                    <h5 class="text-white">Belum ada data korban</h5>
                    <p class="text-secondary mb-0">Klik tombol "Tambah Korban" untuk memulai.</p>
                </div>
            </div>
        @else
            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-dark-custom table-hover m-0" id="korbanTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="25%">Identitas Korban</th>
                            <th width="20%">Kontak Hubung</th>
                            <th width="30%">Alamat</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $k)
                        <tr>
                            <td class="text-center text-secondary">{{ $loop->iteration }}</td>
                            
                            {{-- Nama & Avatar --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ substr($k->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-white">{{ $k->nama }}</span>
                                        <small class="text-secondary">ID: #{{ $k->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Kontak --}}
                            <td>
                                @if($k->kontak)
                                    <div class="d-flex align-items-center gap-2 text-info">
                                        <i class="ph-duotone ph-phone"></i>
                                        <span>{{ $k->kontak }}</span>
                                    </div>
                                @else
                                    <span class="text-secondary fst-italic text-sm">- Tidak ada -</span>
                                @endif
                            </td>

                            {{-- Alamat --}}
                            <td>
                                <div class="text-white text-truncate" style="max-width: 250px;" title="{{ $k->alamat }}">
                                    {{ $k->alamat ?? '-' }}
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('korban.show', $k->id) }}" class="btn-action-circle btn-view" title="Detail">
                                        <i class="ph-bold ph-eye"></i>
                                    </a>
                                    <a href="{{ route('korban.edit', $k->id) }}" class="btn-action-circle btn-edit" title="Edit">
                                        <i class="ph-bold ph-pencil-simple"></i>
                                    </a>
                                    <form action="{{ route('korban.destroy', $k->id) }}" method="POST" 
                                          onsubmit="return confirm('Hapus data korban {{ $k->nama }}? Data tidak bisa dikembalikan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action-circle btn-delete" title="Hapus">
                                            <i class="ph-bold ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination (Jika ada) --}}
            @if(method_exists($data, 'links'))
                <div class="p-3 border-top border-secondary border-opacity-10">
                    {{ $data->links() }}
                </div>
            @endif

        @endif
    </div>
</div>

{{-- Script Pencarian Realtime --}}
@if(!$data->isEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if(searchInput){
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#korbanTable tbody tr');

                rows.forEach(row => {
                    // Cari di kolom Nama (index 1), Kontak (index 2), Alamat (index 3)
                    const textData = row.innerText.toLowerCase();
                    row.style.display = textData.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endif

@endsection