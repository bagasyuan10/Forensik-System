@extends('layouts.layout')

@section('content')

{{-- LIBRARY --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND DECORATION --- */
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
        background: rgba(30, 41, 59, 0.6); /* Lebih gelap sedikit agar kontras */
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(245, 158, 11, 0.15);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative; z-index: 1; overflow: hidden;
    }

    /* --- INPUT STYLES (HIGH CONTRAST) --- */
    .input-group-text-glass {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-right: none; 
        color: #fbbf24; /* Icon warna kuning terang */
        border-top-left-radius: 12px; border-bottom-left-radius: 12px;
    }

    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.8) !important; /* Background input gelap */
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important; /* Teks PUTIH MUTLAK */
        padding: 12px 16px;
        font-weight: 500;
    }

    /* Fix Placeholder Color */
    .form-control-glass::placeholder {
        color: #94a3b8 !important; /* Abu-abu terang untuk placeholder */
        opacity: 1;
    }

    /* Fix Select Options (Dropdown Menu) */
    .form-select-glass option {
        background-color: #0f172a; /* Background hitam saat dropdown dibuka */
        color: #ffffff;
        padding: 10px;
    }

    .input-group .form-control-glass, .input-group .form-select-glass { 
        border-top-right-radius: 12px; border-bottom-right-radius: 12px; 
    }
    .standalone-input { border-radius: 12px !important; }

    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 1) !important;
        border-color: #f59e0b !important;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
        color: #fff !important; 
        outline: none;
    }

    /* --- UPLOAD ZONE --- */
    .upload-zone-glass {
        position: relative;
        background: rgba(15, 23, 42, 0.6);
        border: 2px dashed rgba(245, 158, 11, 0.4);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
    }
    .upload-zone-glass:hover {
        background: rgba(15, 23, 42, 0.8);
        border-color: #f59e0b;
    }
    .upload-zone-glass input[type="file"] {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer; z-index: 10;
    }

    /* --- TEXT LABELS --- */
    .section-title {
        color: #f59e0b; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;
    }
    .form-label-glow { 
        color: #e2e8f0; /* Label putih terang */
        font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; 
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }

    /* --- BUTTONS --- */
    .btn-neon-save {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none; color: white; padding: 12px 35px;
        border-radius: 50px; font-weight: 700;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
    }
    .btn-neon-save:hover { transform: translateY(-2px); color: white; }
    
    .btn-glass-cancel {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.3);
        color: #fff; padding: 12px 30px; border-radius: 50px;
    }
    .btn-glass-cancel:hover { background: rgba(255,255,255,0.1); color: #fff; }

    .preview-img { max-height: 200px; border-radius: 10px; border: 2px solid rgba(255,255,255,0.2); }
    
    .badge-create-mode {
        background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4);
        color: #34d399; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;
    }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    <div class="bg-blob-form blob-orange"></div>
    <div class="bg-blob-form blob-red"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Registrasi Barang Bukti</h2>
                <span class="badge-create-mode"><i class="ph-bold ph-plus-circle me-1"></i> Data Baru</span>
            </div>
            <p class="text-light opacity-75 m-0">Input data bukti fisik atau digital ke dalam sistem.</p>
        </div>
        <a href="{{ route('bukti.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3" style="border-color: rgba(255,255,255,0.3);">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                <form id="createBuktiForm" action="{{ route('bukti.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 

                    {{-- SECTION 1 --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-cube text-warning fs-5"></i>
                        <span class="section-title">Informasi Dasar</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Kasus --}}
                        <div class="col-12">
                            <label class="form-label-glow">Kasus Terkait</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-briefcase"></i></span>
                                <select name="kasus_id" class="form-select form-select-glass" required>
                                    <option value="" class="text-secondary">-- Pilih Kasus --</option>
                                    @foreach($kasus as $k)
                                        <option value="{{ $k->id }}">
                                            [#{{ $k->nomor_kasus }}] {{ $k->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Nama & Kategori --}}
                        <div class="col-md-7">
                            <label class="form-label-glow">Nama Barang Bukti</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-tag"></i></span>
                                <input type="text" name="nama_bukti" class="form-control form-control-glass" 
                                       placeholder="Contoh: Pistol Glock 19, Flashdisk..." required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label-glow">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-squares-four"></i></span>
                                <select name="kategori" class="form-select form-select-glass" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Senjata">Senjata</option>
                                    <option value="Digital">Digital / Elektronik</option>
                                    <option value="Dokumen">Dokumen</option>
                                    <option value="Biologis">Biologis</option>
                                    <option value="Sidik Jari">Sidik Jari</option>
                                    <option value="CCTV">Rekaman CCTV</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2 --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-file-cloud text-warning fs-5"></i>
                        <span class="section-title">File & Dokumentasi</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-glow">Foto / File Bukti</label>
                            
                            <div class="upload-zone-glass" id="uploadZone">
                                <input type="file" name="foto" id="fileInput" accept="image/*,application/pdf" onchange="previewFile(event)">
                                
                                <div id="uploadPlaceholder">
                                    <i class="ph-duotone ph-cloud-arrow-up text-warning mb-3" style="font-size: 48px;"></i>
                                    <h6 class="text-white fw-bold">Klik atau Tarik file ke sini</h6>
                                    <p class="text-light opacity-75 small mb-0">Format: JPG, PNG, PDF (Maks. 5MB)</p>
                                </div>

                                <div id="previewContainer" class="d-none">
                                    <img id="previewImage" class="preview-img" src="">
                                    <div id="fileIconContainer" class="d-none mt-3">
                                        <i class="ph-duotone ph-file-pdf text-danger" style="font-size:48px;"></i>
                                    </div>
                                    <p id="fileName" class="text-warning mt-2 small fw-bold"></p>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill mt-2 position-relative" style="z-index: 20;" onclick="resetFile(event)">
                                        <i class="ph-bold ph-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Lokasi & Waktu --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Lokasi Ditemukan</label>
                            <input type="text" name="lokasi_ditemukan" class="form-control form-control-glass standalone-input" 
                                   placeholder="Detail lokasi penemuan...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Waktu Ditemukan</label>
                            <input type="datetime-local" name="waktu_ditemukan" class="form-control form-control-glass standalone-input">
                        </div>
                        
                        {{-- Petugas --}}
                        <div class="col-12">
                            <label class="form-label-glow">Petugas Penemu</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-detective"></i></span>
                                <input type="text" name="petugas_menemukan" class="form-control form-control-glass" 
                                       placeholder="Nama petugas yang mengamankan bukti">
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label-glow">Deskripsi & Kondisi</label>
                            <textarea name="deskripsi" class="form-control form-control-glass standalone-input" rows="4" 
                                      placeholder="Jelaskan kondisi fisik bukti, nomor seri, atau ciri khusus lainnya..."></textarea>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top border-secondary border-opacity-25">
                        <a href="{{ route('bukti.index') }}" class="btn btn-glass-cancel">
                            <i class="ph-bold ph-x"></i> Batal
                        </a>
                        <button type="button" class="btn btn-neon-save" onclick="confirmSubmit()">
                            <i class="ph-bold ph-check-circle me-2"></i> Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Logic JS tetap sama, hanya styling yang diperkuat
    const fileInput = document.getElementById('fileInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const fileIconContainer = document.getElementById('fileIconContainer');
    const fileName = document.getElementById('fileName');

    function previewFile(event) {
        const file = event.target.files[0];
        if (file) {
            uploadPlaceholder.classList.add('d-none');
            previewContainer.classList.remove('d-none');
            fileName.textContent = file.name;

            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewImage.classList.remove('d-none');
                fileIconContainer.classList.add('d-none');
            } else {
                previewImage.classList.add('d-none');
                fileIconContainer.classList.remove('d-none');
            }
        }
    }

    function resetFile(event) {
        event.preventDefault(); event.stopPropagation();
        fileInput.value = '';
        uploadPlaceholder.classList.remove('d-none');
        previewContainer.classList.add('d-none');
        previewImage.src = '';
    }

    function confirmSubmit() {
        const form = document.getElementById('createBuktiForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }

        Swal.fire({
            title: 'Simpan Bukti Baru?',
            text: "Pastikan data yang diinput sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#334155',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            background: '#1e293b', color: '#fff', width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...', timer: 1500, didOpen: () => { Swal.showLoading() },
                    background: '#1e293b', color: '#fff', showConfirmButton: false
                });
                setTimeout(() => { form.submit(); }, 800); 
            }
        })
    }
</script>

@endsection