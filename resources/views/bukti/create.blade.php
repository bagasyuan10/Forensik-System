@extends('layouts.layout')

@section('content')

{{-- Style Khusus Form --}}
<style>
    /* Card Container */
    .custom-card {
        background: #1e293b; /* Slate-800 */
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Page Title */
    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Form Labels */
    .form-label-custom {
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-label-custom i { color: #22d3ee; font-size: 1.1rem; }

    /* Inputs (Glassy) */
    .form-control-dark, .form-select-dark {
        background-color: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control-dark:focus, .form-select-dark:focus {
        background-color: rgba(15, 23, 42, 0.8);
        border-color: #22d3ee;
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
        color: #fff;
    }

    .form-control-dark::placeholder { color: #64748b; }
    
    /* Datetime Input Dark Mode */
    input[type="datetime-local"] { color-scheme: dark; }

    /* Custom File Upload Zone */
    .upload-zone {
        position: relative;
        background: rgba(15, 23, 42, 0.4);
        border: 2px dashed rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
    }
    
    .upload-zone:hover {
        background: rgba(15, 23, 42, 0.6);
        border-color: #22d3ee;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .preview-img {
        max-height: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        margin-top: 15px;
    }

    /* Buttons */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        transition: transform 0.2s;
    }
    .btn-glow:hover { transform: translateY(-2px); color: white; }

    .btn-ghost {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-ghost:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        border-color: #fff;
    }
</style>

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Registrasi Barang Bukti</h2>
            <p class="text-secondary m-0">Input data bukti fisik atau digital ke dalam sistem.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-secondary bg-dark px-3 py-2 rounded-pill border border-secondary border-opacity-10">
                <i class="ph-duotone ph-archive-box"></i>
                <small>Entry Data</small>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('bukti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        {{-- 1. Kasus (Full Width) --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-briefcase"></i> Kasus Terkait
                            </label>
                            <select name="kasus_id" class="form-select form-select-dark" required>
                                <option value="">-- Pilih Kasus --</option>
                                @foreach($kasus as $k)
                                    <option value="{{ $k->id }}">
                                        [#{{ $k->nomor_kasus }}] {{ $k->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 2. Nama Bukti & Kategori --}}
                        <div class="col-md-7">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-tag"></i> Nama Barang Bukti
                            </label>
                            <input type="text" name="nama_bukti" class="form-control form-control-dark" 
                                   placeholder="Contoh: Pistol Glock 19, Flashdisk SanDisk..." required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-squares-four"></i> Kategori
                            </label>
                            <select name="kategori" class="form-select form-select-dark" required>
                                <option value="">-- Pilih --</option>
                                <option value="Senjata">🔫 Senjata</option>
                                <option value="Digital">💻 Digital / Elektronik</option>
                                <option value="Dokumen">📄 Dokumen</option>
                                <option value="Biologis">🧬 Biologis</option>
                                <option value="Sidik Jari">🖐️ Sidik Jari</option>
                                <option value="CCTV">📹 Rekaman CCTV</option>
                                <option value="Lainnya">📦 Lainnya</option>
                            </select>
                        </div>

                        {{-- 3. File Upload Zone (Custom) --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-image"></i> Foto / File Bukti
                            </label>
                            
                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="foto" id="fileInput" accept="image/*,application/pdf" onchange="previewFile(event)">
                                
                                {{-- Placeholder Content --}}
                                <div id="uploadPlaceholder">
                                    <i class="ph-duotone ph-cloud-arrow-up text-secondary" style="font-size: 48px;"></i>
                                    <h6 class="text-white mt-3">Klik atau Tarik file ke sini</h6>
                                    <p class="text-secondary small mb-0">Format: JPG, PNG, PDF (Maks. 5MB)</p>
                                </div>

                                {{-- Preview Content --}}
                                <div id="previewContainer" class="d-none">
                                    <img id="previewImage" class="preview-img" src="">
                                    <p id="fileName" class="text-white mt-2 small"></p>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill mt-2" onclick="resetFile()">
                                        Hapus & Upload Ulang
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Lokasi & Waktu --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-map-pin"></i> Lokasi Ditemukan
                            </label>
                            <input type="text" name="lokasi_ditemukan" class="form-control form-control-dark" 
                                   placeholder="Detail lokasi penemuan...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-clock"></i> Waktu Ditemukan
                            </label>
                            <input type="datetime-local" name="waktu_ditemukan" class="form-control form-control-dark">
                        </div>

                        {{-- 5. Petugas --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-detective"></i> Petugas Penemu
                            </label>
                            <input type="text" name="petugas_menemukan" class="form-control form-control-dark" 
                                   placeholder="Nama petugas yang mengamankan bukti">
                        </div>

                        {{-- 6. Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-notebook"></i> Deskripsi & Kondisi
                            </label>
                            <textarea name="deskripsi" class="form-control form-control-dark" rows="3" 
                                      placeholder="Jelaskan kondisi fisik bukti, nomor seri, atau ciri khusus lainnya..."></textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3">
                            <a href="{{ route('bukti.index') }}" class="btn btn-ghost">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-glow d-flex align-items-center gap-2">
                                <i class="ph-bold ph-check-circle"></i> Simpan Bukti
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- Script Preview File --}}
<script>
    const fileInput = document.getElementById('fileInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');

    function previewFile(event) {
        const file = event.target.files[0];
        
        if (file) {
            uploadPlaceholder.classList.add('d-none');
            previewContainer.classList.remove('d-none');
            fileName.textContent = file.name;

            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewImage.style.display = 'inline-block';
            } else {
                // Jika PDF atau file lain
                previewImage.style.display = 'none';
                fileName.innerHTML = `<i class="ph-duotone ph-file-pdf text-danger" style="font-size:32px;"></i><br>${file.name}`;
            }
        }
    }

    function resetFile() {
        fileInput.value = '';
        uploadPlaceholder.classList.remove('d-none');
        previewContainer.classList.add('d-none');
        previewImage.src = '';
    }
</script>

@endsection