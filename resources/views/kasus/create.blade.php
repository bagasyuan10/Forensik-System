@extends('layouts.Layout')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-bold mb-0">➕ Tambah Kasus Baru</h2>
    </div>

    <div class="card shadow-sm rounded-4 p-4">
        <form action="{{ route('kasus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nomor Kasus --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Nomor Kasus (Opsional)</label>
                <input type="text" name="nomor"
                       value="{{ old('nomor') }}"
                       class="form-control form-control-lg rounded-pill"
                       placeholder="Nomor atau ID kasus">
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Judul Kasus</label>
                <input type="text" name="judul"
                       value="{{ old('judul') }}"
                       class="form-control form-control-lg rounded-pill @error('judul') is-invalid @enderror"
                       placeholder="Judul kasus..." required>

                @error('judul')
                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Tanggal Kejadian</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal') }}"
                       class="form-control form-control-lg rounded-pill @error('tanggal') is-invalid @enderror"
                       required>

                @error('tanggal')
                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Lokasi Kejadian</label>
                <input type="text" name="lokasi"
                       value="{{ old('lokasi') }}"
                       class="form-control form-control-lg rounded-pill"
                       placeholder="Lokasi kejadian...">
            </div>

            {{-- Pelaku --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Pelaku</label>
                <input type="text" name="pelaku"
                       value="{{ old('pelaku') }}"
                       class="form-control form-control-lg rounded-pill"
                       placeholder="Nama / Identitas pelaku...">
            </div>

            {{-- Korban --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Korban</label>
                <input type="text" name="korban"
                       value="{{ old('korban') }}"
                       class="form-control form-control-lg rounded-pill"
                       placeholder="Nama / Identitas korban...">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi Kasus</label>
                <textarea name="deskripsi"
                          rows="5"
                          class="form-control rounded-4 @error('deskripsi') is-invalid @enderror"
                          placeholder="Ringkasan kejadian...">{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <div class="invalid-feedback ms-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Upload Bukti --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Upload Bukti (opsional)</label>
                <input type="file"
                       name="bukti"
                       accept="image/*,application/pdf"
                       class="form-control form-control-lg rounded-pill"
                       onchange="previewBukti(event)">

                {{-- Preview Gambar --}}
                <div id="previewContainer" class="mt-3 d-none">
                    <p class="fw-semibold">Preview:</p>
                    <img id="previewImage" class="img-fluid rounded-4 shadow-sm" style="max-height:250px;">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary px-4 btn-lg rounded-pill shadow-sm">
                    <i class="bi bi-check-lg"></i> Simpan Kasus
                </button>

                <a href="{{ route('kasus.index') }}"
                   class="btn btn-secondary px-4 btn-lg rounded-pill shadow-sm">
                   <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

{{-- JavaScript Preview --}}
<script>
function previewBukti(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('previewContainer');
    const img = document.getElementById('previewImage');

    if (!file || !file.type.startsWith("image/")) {
        previewContainer.classList.add("d-none");
        return;
    }

    img.src = URL.createObjectURL(file);
    previewContainer.classList.remove("d-none");
}
</script>

@endsection