@extends('layouts.layout')

@section('content')

{{-- Style Custom (Konsisten) --}}
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

    /* Search Input */
    .form-control-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 50px;
        padding: 12px 20px 12px 45px;
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
    .table-dark-custom th {
        background-color: rgba(15, 23, 42, 0.5);
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        padding: 16px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .table-dark-custom td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    /* Pelaku Specific Styles */
    .avatar-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

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
    .btn-edit { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
    .btn-edit:hover { background: #fbbf24; color: #000; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; }
    .btn-delete:hover { background: #ef4444; color: #fff; }

    .alert-glass {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #34d399;
        border-radius: 12px;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Daftar Pelaku</h2>
            <p class="text-secondary m-0" style="font-size: 0.9rem;">Database tersangka dan pelaku tindak kriminal</p>
        </div>
        <a href="{{ route('pelaku.create') }}" class="btn btn-glow d-flex align-items-center gap-2">
            <i class="ph-bold ph-fingerprint"></i>
            <span>Tambah Pelaku</span>
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-glass d-flex align-items-center gap-2 mb-4 alert-dismissible fade show" role="alert">
            <i class="ph-fill ph-check-circle" style="font-size: 20px;"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Bar --}}
    @if(!$pelaku->isEmpty())
    <div class="custom-card p-4 mb-4">
        <div class="position-relative">
            <i class="ph-bold ph-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
            <input type="text" id="searchInput" class="form-control form-control-glass" placeholder="Cari nama pelaku atau biodata...">
        </div>
    </div>
    @endif

    {{-- Content --}}
    <div class="custom-card p-0 overflow-hidden">
        @if($pelaku->isEmpty())
            {{-- Empty State --}}
            <div class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <i class="ph-duotone ph-fingerprint text-secondary mb-3" style="font-size: 48px; opacity: 0.5;"></i>
                    <h5 class="text-white">Belum ada data pelaku</h5>
                    <p class="text-secondary mb-0">Silakan tambahkan data baru.</p>
                </div>
            </div>
        @else
            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-dark-custom table-hover m-0" id="pelakuTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="30%">Identitas Pelaku</th>
                            <th width="45%">Biodata / Keterangan</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelaku as $p)
                        <tr>
                            <td class="text-center text-secondary">{{ $loop->iteration }}</td>
                            
                            {{-- Kolom Foto & Nama Digabung --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-wrapper">
                                        @if($p->foto)
                                            <img src="{{ asset('storage/pelaku/' . $p->foto) }}" class="avatar-img" alt="{{ $p->nama }}">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="ph-fill ph-user" style="font-size: 24px;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-white">{{ $p->nama }}</span>
                                        <small class="text-secondary" style="font-size: 11px;">ID: #{{ $p->id }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Biodata --}}
                            <td>
                                <span class="text-secondary text-truncate-2">
                                    {{ Str::limit($p->biodata ?? 'Tidak ada keterangan biodata.', 80) }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pelaku.edit', $p->id) }}" class="btn-action-circle btn-edit" title="Edit Data">
                                        <i class="ph-bold ph-pencil-simple"></i>
                                    </a>

                                    <form action="{{ route('pelaku.destroy', $p->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pelaku {{ $p->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action-circle btn-delete" title="Hapus Data">
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
        @endif
    </div>

</div>

{{-- Script Pencarian --}}
@if(!$pelaku->isEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if(searchInput){
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#pelakuTable tbody tr');

                rows.forEach(row => {
                    // Cari di Nama (index 1) dan Biodata (index 2)
                    const textData = row.innerText.toLowerCase();
                    row.style.display = textData.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endif

@endsection