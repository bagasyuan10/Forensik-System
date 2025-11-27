@extends('layouts.Layout')

@section('content')

<div class="container mt-4">

    <div class="mb-3">
        <h2 class="fw-bold mb-0">Edit Kasus</h2>
        <small class="text-muted">Perbarui data kasus dengan informasi terbaru.</small>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="{{ route('kasus.update', $kasus->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul Kasus</label>
                    <input type="text" name="judul" class="form-control form-control-lg"
                        value="{{ $kasus->judul }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Kasus</label>
                    <input type="text" name="nomor_kasus" class="form-control"
                        value="{{ $kasus->nomor_kasus }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                        value="{{ $kasus->lokasi }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ $kasus->deskripsi }}</textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">

                    <a href="{{ route('kasus.index') }}" class="btn btn-light border">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        ✔ Update Kasus
                    </button>

                </div>
            </form>

        </div>
    </div>

</div>

@endsection