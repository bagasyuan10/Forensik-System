@extends('layouts.Layout')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Pelaku</h2>
        <a href="{{ route('pelaku.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('pelaku.update', $pelaku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pelaku</label>
                    <input type="text" 
                           name="nama" 
                           class="form-control form-control-lg @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $pelaku->nama) }}"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Pelaku</label>
                    @if($pelaku->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/pelaku/' . $pelaku->foto) }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 180px">
                        </div>
                    @endif
                    <input type="file"
                           name="foto"
                           accept="image/*"
                           class="form-control form-control-lg @error('foto') is-invalid @enderror">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Biodata --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Biodata Pelaku</label>
                    <textarea name="biodata"
                              class="form-control form-control-lg"
                              rows="4">{{ old('biodata', $pelaku->biodata) }}</textarea>
                </div>

                {{-- Runtutan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Runtutan Kejadian Perkara</label>
                    <textarea name="runtutan"
                              class="form-control form-control-lg"
                              rows="6">{{ old('runtutan', $pelaku->runtutan) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>

        </div>
    </div>

</div>
@endsection
