@extends('layouts.layout')

@section('content')

{{-- Style Tambahan (Sama dengan halaman Tindakan) --}}
<style>
    /* Card Container */
    .custom-card {
        background: #1e293b; /* Slate-800 */
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Typography */
    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Table Styling */
    .table-dark-custom {
        --bs-table-bg: transparent;
        --bs-table-color: #e2e8f0;
        --bs-table-border-color: rgba(255, 255, 255, 0.05);
        --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
    }
    
    .table-dark-custom thead th {
        background-color: rgba(15, 23, 42, 0.5); /* Slate-900 transparent */
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

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
    }
    
    .btn-edit { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
    .btn-edit:hover { background: #fbbf24; color: #000; transform: translateY(-2px); }

    .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; }
    .btn-delete:hover { background: #ef4444; color: #fff; transform: translateY(-2px); }

    /* Button Primary Glow */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        transition: transform 0.2s;
        color: white;
        font-weight: 600;
        padding: 10px 20px;
    }
    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
        color: white;
    }

    /* Badge Style */
    .badge-case {
        background: rgba(168, 85, 247, 0.1); /* Ungu untuk laporan agar beda dikit */
        color: #c084fc;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        border: 1px solid rgba(168, 85, 247, 0.2);
    }
    
    /* Custom Alert */
    .alert-glass {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #34d399;
        border-radius: 12px;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Daftar Laporan</h2>
            <p class="text-secondary m-0" style="font-size: 0.9rem;">Arsip dokumentasi dan hasil analisis forensik</p>
        </div>
        
        <a href="{{ route('laporan.create') }}" class="btn btn-glow rounded-pill d-flex align-items-center gap-2">
            <i class="ph-bold ph-plus"></i>
            <span>Buat Laporan</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-glass d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ph-fill ph-check-circle" style="font-size: 20px;"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="custom-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-custom table-hover m-0">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="30%">Judul Laporan</th>
                        <th width="20%">Kasus Terkait</th>
                        <th width="20%">Penyusun</th>
                        <th width="15%">Tanggal</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td class="text-center text-secondary">
                            {{ $loop->iteration + ($laporan->currentPage() - 1) * $laporan->perPage() }}
                        </td>
                        
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: rgba(255,255,255,0.05);">
                                    <i class="ph-duotone ph-file-text" style="font-size: 20px; color: #cbd5e1;"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-white">{{ $item->judul_laporan }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($item->kasus)
                                <span class="badge-case">
                                    <i class="ph-duotone ph-folder me-1"></i>
                                    {{ Str::limit($item->kasus->judul, 20) }}
                                </span>
                            @else
                                <span class="text-secondary fst-italic">- Tidak ada kasus -</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2 text-gray-300">
                                <i class="ph-duotone ph-user-pen text-secondary"></i>
                                {{ $item->penyusun ?? '-' }}
                            </div>
                        </td>

                        <td>
                            <span class="text-white" style="font-size: 0.9rem;">
                                @if($item->tanggal_laporan)
                                    {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('laporan.edit', $item->id) }}" 
                                   class="btn-action btn-edit" 
                                   title="Edit Laporan">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </a>

                                <form action="{{ route('laporan.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini? Data yang dihapus tidak dapat dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete" title="Hapus Laporan">
                                        <i class="ph-bold ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="ph-duotone ph-folder-dashed text-secondary mb-3" style="font-size: 48px; opacity: 0.5;"></i>
                                <h5 class="text-white">Belum ada laporan</h5>
                                <p class="text-secondary mb-0">Klik tombol "Buat Laporan" untuk menambahkan data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($laporan->hasPages())
        <div class="p-3 border-top border-secondary border-opacity-10">
            {{ $laporan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection