@extends('layouts.layout')

@section('content')

{{-- LIBRARY --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND DECORATION (WARM THEME) --- */
    .bg-blob-form {
        position: absolute; filter: blur(90px); z-index: 0; opacity: 0.3;
        animation: floatBlob 12s infinite ease-in-out;
    }
    .blob-orange { top: -10%; right: 20%; width: 400px; height: 400px; background: #f59e0b; }
    .blob-red { bottom: -10%; left: 10%; width: 300px; height: 300px; background: #ef4444; }

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 20px); }
    }

    /* --- GLASS CARD --- */
    .form-card {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(245, 158, 11, 0.15);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative; z-index: 1; overflow: hidden;
    }

    /* --- INPUT STYLES --- */
    .input-group-text-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-right: none; color: #cbd5e1;
        border-top-left-radius: 12px; border-bottom-left-radius: 12px;
    }

    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff; padding: 12px 16px;
        transition: all 0.3s ease;
    }
    
    .input-group .form-control-glass, .input-group .form-select-glass { 
        border-top-right-radius: 12px; border-bottom-right-radius: 12px; 
    }
    .standalone-input { border-radius: 12px !important; }

    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.85);
        border-color: #f59e0b;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
        color: #fff; z-index: 2; outline: none;
    }
    
    /* File Input Styling */
    .form-control-glass[type="file"] { padding: 10px; }
    .form-control-glass::file-selector-button {
        background-color: rgba(245, 158, 11, 0.2); color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px;
        padding: 6px 12px; margin-right: 12px; cursor: pointer; transition: 0.3s;
    }
    .form-control-glass::file-selector-button:hover {
        background-color: rgba(245, 158, 11, 0.4);
    }

    /* --- TEXT & LABELS --- */
    .section-divider {
        display: flex; align-items: center; gap: 15px; margin: 30px 0 20px;
    }
    .section-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(245, 158, 11, 0.2), transparent); }
    .section-title {
        color: #f59e0b; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;
    }
    .form-label-glow { color: #cbd5e1; font-weight: 500; font-size: 0.9rem; margin-bottom: 8px; }

    /* --- PREVIEW BOX (GLASS STYLE) --- */
    .file-preview-glass {
        background: rgba(0, 0, 0, 0.2); 
        border: 1px dashed rgba(255, 255, 255, 0.2);
        border-radius: 12px; padding: 15px; 
        display: flex; align-items: center; gap: 15px; margin-bottom: 15px;
    }
    .preview-thumb {
        width: 60px; height: 60px; object-fit: cover; border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    
    /* --- BUTTONS --- */
    .btn-neon-update {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none; color: white; padding: 12px 35px;
        border-radius: 50px; font-weight: 600; letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        transition: 0.3s;
    }
    .btn-neon-update:hover {
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5); color: white;
    }
    .btn-glass-cancel {
        background: transparent; border: 1px solid rgba(255,255,255,0.2);
        color: #94a3b8; padding: 12px 30px; border-radius: 50px; transition: 0.3s;
    }
    .btn-glass-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; border-color: #fff; }

    .badge-edit-mode {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;
    }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    {{-- Background Lights --}}
    <div class="bg-blob-form blob-orange"></div>
    <div class="bg-blob-form blob-red"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Edit Barang Bukti</h2>
                <span class="badge-edit-mode"><i class="ph-fill ph-pencil-simple me-1"></i> Mode Edit</span>
            </div>
            <p class="text-secondary m-0">Perbarui informasi, kategori, atau upload ulang foto bukti.</p>
        </div>
        <a href="{{ route('bukti.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                <form id="editBuktiForm" action="{{ route('bukti.update', $bukti->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    {{-- SECTION 1: INFO UTAMA --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-cube text-warning fs-5"></i>
                        <span class="section-title">Informasi Dasar</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Kasus Terkait --}}
                        <div class="col-12">
                            <label class="form-label-glow">Kasus Terkait</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-briefcase"></i></span>
                                <select name="kasus_id" class="form-select form-select-glass" required>
                                    <option value="">-- Pilih Kasus --</option>
                                    @foreach($kasus as $k)
                                        <option value="{{ $k->id }}" {{ old('kasus_id', $bukti->kasus_id) == $k->id ? 'selected' : '' }}>
                                            [#{{ $k->nomor_kasus }}] {{ $k->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Nama Bukti & Kategori --}}
                        <div class="col-md-7">
                            <label class="form-label-glow">Nama Barang Bukti</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-tag"></i></span>
                                <input type="text" name="nama_bukti" class="form-control form-control-glass" 
                                       value="{{ old('nama_bukti', $bukti->nama_bukti) }}" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-glow">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-squares-four"></i></span>
                                <select name="kategori" class="form-select form-select-glass" required>
                                    @foreach(['Senjata', 'Digital', 'Dokumen', 'Biologis', 'Sidik Jari', 'CCTV', 'Lainnya'] as $cat)
                                        <option value="{{ $cat }}" {{ $bukti->kategori == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: FILE & DOKUMENTASI --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-file-cloud text-warning fs-5"></i>
                        <span class="section-title">Dokumentasi & Fisik</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-glow">File / Foto Bukti</label>

                            {{-- A. PREVIEW FILE LAMA (Database) --}}
                            @if($bukti->file_path)
                                <div id="currentFileBox" class="file-preview-glass">
                                    @if(Str::startsWith($bukti->file_type, 'image/'))
                                        <img src="{{ asset('storage/' . $bukti->file_path) }}" class="preview-thumb">
                                    @else
                                        <div class="preview-thumb bg-dark d-flex align-items-center justify-content-center">
                                            <i class="ph-bold ph-file-pdf text-danger fs-3"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="text-white small fw-bold">File Saat Ini</div>
                                        <div class="text-secondary" style="font-size: 0.75rem;">
                                            {{ number_format($bukti->file_size / 1024, 2) }} KB
                                        </div>
                                        <a href="{{ asset('storage/' . $bukti->file_path) }}" target="_blank" class="text-warning small text-decoration-none">
                                            <i class="ph-bold ph-eye"></i> Lihat Full Size
                                        </a>
                                    </div>
                                    <div class="badge bg-secondary bg-opacity-20 text-secondary border border-secondary border-opacity-25">Tersimpan</div>
                                </div>
                            @endif

                            {{-- B. PREVIEW FILE BARU (JS Triggered) --}}
                            <div id="newFileBox" class="file-preview-glass d-none" style="border-color: #f59e0b; background: rgba(245, 158, 11, 0.05);">
                                <img id="newImgPreview" class="preview-thumb d-none">
                                <div id="newIconPreview" class="preview-thumb bg-dark d-flex align-items-center justify-content-center d-none">
                                    <i class="ph-bold ph-file text-warning fs-3"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-warning small fw-bold">Akan Diupload</div>
                                    <div id="newFileName" class="text-secondary text-truncate" style="font-size: 0.75rem; max-width: 250px;"></div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" onclick="cancelUpload()">
                                        <i class="ph-bold ph-x"></i> Batalkan Upload
                                    </button>
                                </div>
                                <div class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-25">Baru</div>
                            </div>

                            {{-- Input File --}}
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-upload-simple"></i></span>
                                <input type="file" name="foto" id="fileInput" class="form-control form-control-glass" 
                                       accept="image/*,application/pdf" onchange="handleFileSelect(event)">
                            </div>
                        </div>

                        {{-- Lokasi & Waktu --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Lokasi Ditemukan</label>
                            <input type="text" name="lokasi_ditemukan" class="form-control form-control-glass standalone-input" 
                                   value="{{ old('lokasi_ditemukan', $bukti->lokasi_ditemukan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Waktu Ditemukan</label>
                            <input type="datetime-local" name="waktu_ditemukan" class="form-control form-control-glass standalone-input"
                                   value="{{ old('waktu_ditemukan', $bukti->waktu_ditemukan ? \Carbon\Carbon::parse($bukti->waktu_ditemukan)->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        
                        {{-- Petugas & Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label-glow">Petugas Penemu</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-detective"></i></span>
                                <input type="text" name="petugas_menemukan" class="form-control form-control-glass" 
                                       value="{{ old('petugas_menemukan', $bukti->petugas_menemukan) }}">
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label-glow">Deskripsi & Kondisi Fisik</label>
                            <textarea name="deskripsi" class="form-control form-control-glass standalone-input" rows="4">{{ old('deskripsi', $bukti->deskripsi) }}</textarea>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top border-secondary border-opacity-10">
                        <a href="{{ route('bukti.index') }}" class="btn btn-glass-cancel">
                            <i class="ph-bold ph-x"></i> Batal
                        </a>
                        <button type="button" class="btn btn-neon-update" onclick="confirmUpdate()">
                            <i class="ph-bold ph-floppy-disk me-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    // 1. Logic Preview Gambar
    function handleFileSelect(event) {
        const file = event.target.files[0];
        const currentBox = document.getElementById('currentFileBox');
        const newBox = document.getElementById('newFileBox');
        const newImg = document.getElementById('newImgPreview');
        const newIcon = document.getElementById('newIconPreview');
        const newName = document.getElementById('newFileName');

        if (file) {
            if(currentBox) currentBox.classList.add('d-none');
            newBox.classList.remove('d-none');
            newName.textContent = file.name + ' (' + (file.size/1024).toFixed(2) + ' KB)';

            if (file.type.startsWith('image/')) {
                newImg.src = URL.createObjectURL(file);
                newImg.classList.remove('d-none');
                newIcon.classList.add('d-none');
            } else {
                newImg.classList.add('d-none');
                newIcon.classList.remove('d-none');
            }
        }
    }

    function cancelUpload() {
        document.getElementById('fileInput').value = '';
        document.getElementById('newFileBox').classList.add('d-none');
        const currentBox = document.getElementById('currentFileBox');
        if(currentBox) currentBox.classList.remove('d-none');
    }

    // 2. Logic SweetAlert Submit
    function confirmUpdate() {
        const form = document.getElementById('editBuktiForm');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan data bukti sudah benar sebelum disimpan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            background: '#1e293b',
            color: '#fff',
            width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    timer: 1500,
                    didOpen: () => { Swal.showLoading() },
                    background: '#1e293b',
                    color: '#fff',
                    showConfirmButton: false
                });
                
                setTimeout(() => {
                    form.submit();
                }, 800); 
            }
        })
    }
</script>

@endsection