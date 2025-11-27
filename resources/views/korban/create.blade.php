@extends('layouts.Layout')

@section('content')
<div class="container mt-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tambah Korban</h2>
        <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('korban.store') }}" method="POST" novalidate>
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person-fill"></i> Nama <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama"
                           class="form-control form-control-lg @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kontak --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-telephone-fill"></i> Kontak
                    </label>
                    <input type="text"
                           name="kontak"
                           class="form-control form-control-lg"
                           value="{{ old('kontak') }}"
                           placeholder="Telepon / email">
                    <small class="text-muted">Opsional, bisa diisi untuk menghubungi korban.</small>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-geo-alt-fill"></i> Alamat
                    </label>
                    <textarea name="alamat"
                              class="form-control form-control-lg"
                              rows="4"
                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                </div>

                {{-- Error Server --}}
                @if ($errors->has('server'))
                    <div class="alert alert-danger d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ $errors->first('server') }}
                    </div>
                @endif

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                    <a href="{{ route('korban.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection