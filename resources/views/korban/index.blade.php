@extends('layouts.layout')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Daftar Korban</h2>
        <a href="{{ route('korban.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i> Tambah Korban
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan: {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search --}}
    @if(!$data->isEmpty())
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama korban...">
    </div>
    @endif

    {{-- Jika kosong --}}
    @if ($data->isEmpty())
        <div class="alert alert-info d-flex align-items-center gap-2">
            <i class="bi bi-info-circle"></i> Belum ada data korban.
        </div>
    @else
    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="korbanTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th style="width: 180px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $k)
                <tr>
                    <td>{{ $k->id }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>
                        @if($k->kontak)
                            <span class="badge bg-info text-dark">{{ $k->kontak }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td style="white-space: pre-wrap">{{ $k->alamat ?? '—' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('korban.show', $k->id) }}" 
                               class="btn btn-sm btn-outline-primary" title="Lihat">
                               <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('korban.edit', $k->id) }}" 
                               class="btn btn-sm btn-outline-secondary" title="Edit">
                               <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('korban.destroy', $k->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Hapus korban ini? Tindakan tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
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

{{-- Search Script --}}
@if(!$data->isEmpty())
<script>
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#korbanTable tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });
</script>
@endif
@endsection