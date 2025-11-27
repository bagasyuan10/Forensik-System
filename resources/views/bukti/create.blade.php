@extends('layouts.Layout')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <h2 class="fw-bold mb-0">➕ Tambah Bukti</h2>
    </div>

    <div class="card shadow-sm rounded-4 p-4">

        <form action="{{ route('bukti.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Bukti --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Bukti</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text rounded-start-pill bg-primary text-white">
                        <i class="bi bi-file-earmark-text"></i>
                    </span>
                    <input type="text" name="nama_bukti"
                           class="form-control rounded-end-pill"
                           placeholder="Masukan nama bukti..."
                           required>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control rounded-4"
                          rows="4"
                          placeholder="Masukan deskripsi bukti..."></textarea>
            </div>

            {{-- Upload File --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Upload File Bukti</label>

                <input type="file" name="file"
                       class="form-control form-control-lg rounded-pill"
                       accept="image/*,application/pdf"
                       required
                       onchange="previewFile(event)">

                {{-- Preview gambar --}}
                <div id="previewContainer" class="mt-3 d-none">
                    <p class="fw-semibold">Preview:</p>
                    <img id="previewImage" class="img-fluid rounded-4 shadow-sm" style="max-height: 250px;">
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-3 mt-4">
                <button class="btn btn-primary px-4 btn-lg rounded-pill shadow-sm">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>

                <a href="{{ route('bukti.index') }}"
                   class="btn btn-secondary px-4 btn-lg rounded-pill shadow-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>
</div>

{{-- JavaScript Preview --}}
<script>
function previewFile(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    if (!file) {
        previewContainer.classList.add('d-none');
        return;
    }

    if (file.type.startsWith('image/')) {
        previewImage.src = URL.createObjectURL(file);
        previewContainer.classList.remove('d-none');
    } else {
        previewContainer.classList.add('d-none');
    }
}
</script>
@endsection