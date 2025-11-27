@extends('layouts.Layout')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Pelaku</h2>
        <a href="{{ route('pelaku.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('pelaku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pelaku <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="nama" 
                           class="form-control form-control-lg @error('nama') is-invalid @enderror"
                           placeholder="Masukkan nama pelaku"
                           value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Pelaku</label>
                    <input type="file" 
                           name="foto"
                           accept="image/*"
                           class="form-control form-control-lg @error('foto') is-invalid @enderror">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Opsional, format jpg/png/webp</small>
                </div>

                {{-- Biodata --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Biodata Pelaku</label>
                    <textarea name="biodata" 
                              class="form-control form-control-lg @error('biodata') is-invalid @enderror"
                              placeholder="Tuliskan biodata pelaku"
                              rows="4">{{ old('biodata') }}</textarea>
                    @error('biodata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Runtutan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Runtutan Kejadian Perkara</label>
                    <textarea name="runtutan" 
                              class="form-control form-control-lg @error('runtutan') is-invalid @enderror"
                              placeholder="Jelaskan runtutan kejadian perkara"
                              rows="6">{{ old('runtutan') }}</textarea>
                    @error('runtutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection