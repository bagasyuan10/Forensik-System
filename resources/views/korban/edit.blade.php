@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Korban</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('korban.update', $korban->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama *</label>
            <input
                type="text"
                name="nama"
                id="nama"
                class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $korban->nama) }}"
                required
            >
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kontak" class="form-label">Kontak</label>
            <input
                type="text"
                name="kontak"
                id="kontak"
                class="form-control @error('kontak') is-invalid @enderror"
                value="{{ old('kontak', $korban->kontak) }}"
                placeholder="Telepon / email"
            >
            @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea
                name="alamat"
                id="alamat"
                class="form-control @error('alamat') is-invalid @enderror"
                rows="4"
            >{{ old('alamat', $korban->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

            <a href="{{ route('korban.index') }}" class="btn btn-secondary">Batal</a>

            <form action="{{ route('korban.destroy', $korban->id) }}" method="POST" class="ms-auto" onsubmit="return confirm('Hapus korban ini? Tindakan tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus Korban</button>
            </form>
        </div>
    </form>
</div>
@endsection