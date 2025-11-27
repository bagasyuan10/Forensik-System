@extends('layouts.Layout')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Pelaku</h2>
        <a href="{{ route('pelaku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Pelaku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($pelaku->isEmpty())
        <div class="alert alert-info">
            Belum ada data pelaku.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Foto</th>
                        <th>Biodata</th>
                        <th style="width: 200px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pelaku as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>
                                @if($p->foto)
                                    <img src="{{ asset('storage/pelaku/' . $p->foto) }}" 
                                         class="rounded"
                                         style="width:65px; height:65px; object-fit:cover;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($p->biodata, 80) }}</td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pelaku.edit', $p->id) }}" 
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('pelaku.destroy', $p->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
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
@endsection