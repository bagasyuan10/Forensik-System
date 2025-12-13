@extends('layouts.layout')

@section('content')

{{-- LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND DECORATION (Warm Tones for Edit Mode) --- */
    .bg-blob-form {
        position: absolute; filter: blur(90px); z-index: 0; opacity: 0.3;
        animation: floatBlob 12s infinite ease-in-out;
    }
    /* Warna diubah ke Oranye/Merah/Kuning untuk nuansa "Edit/Warning" */
    .blob-one { top: -10%; left: 20%; width: 400px; height: 400px; background: #f59e0b; } /* Amber */
    .blob-two { bottom: -10%; right: 10%; width: 300px; height: 300px; background: #ef4444; } /* Red */
    .blob-three { bottom: 20%; left: 10%; width: 250px; height: 250px; background: #d97706; } /* Dark Amber */

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(20px, -20px); }
    }

    /* --- GLASS CARD --- */
    .form-card {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(245, 158, 11, 0.2); /* Border Amber tipis */
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative; z-index: 1; overflow: hidden;
    }

    /* --- INPUT STYLES (Amber Focus) --- */
    .input-group-text-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-right: none; color: #94a3b8;
        border-top-left-radius: 12px; border-bottom-left-radius: 12px;
    }

    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff; padding: 12px 16px; transition: all 0.3s ease;
    }
    
    .input-group .form-control-glass { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    .standalone-input { border-radius: 12px !important; }

    /* Focus State warna Amber */
    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.85);
        border-color: #f59e0b;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.15);
        color: #fff; z-index: 2;
    }

    /* --- LABELS --- */
    .section-divider { display: flex; align-items: center; gap: 15px; margin: 30px 0 20px; }
    .section-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent); }
    .section-title { color: #f59e0b; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
    .form-label-glow { color: #cbd5e1; font-weight: 500; font-size: 0.9rem; margin-bottom: 8px; }
    .required-star { color: #ef4444; margin-left: 3px; }

    /* --- BUTTONS --- */
    .btn-neon-edit {
        background: linear-gradient(135deg, #f59e0b, #ea580c); /* Amber to Orange */
        border: none; color: white; padding: 12px 35px;
        border-radius: 50px; font-weight: 600; letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4); transition: 0.3s;
    }
    .btn-neon-edit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6); color: white; }

    .btn-glass-cancel {
        background: transparent; border: 1px solid rgba(255,255,255,0.2);
        color: #94a3b8; padding: 12px 30px; border-radius: 50px; transition: 0.3s;
    }
    .btn-glass-cancel:hover { background: rgba(255,255,255,0.05); color: #fff; border-color: #fff; }

    /* --- FILE PREVIEW BOX (New) --- */
    .file-preview-wrapper {
        background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px; padding: 10px; margin-bottom: 10px;
        display: flex; align-items: center; gap: 15px;
    }
    .preview-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); }
    .badge-status { font-size: 0.7rem; padding: 4px 8px; border-radius: 6px; }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    {{-- Background Lights (Warm) --}}
    <div class="bg-blob-form blob-one"></div>
    <div class="bg-blob-form blob-two"></div>
    <div class="bg-blob-form blob-three"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <h2 class="fw-bold text-white mb-1">Edit Data Korban</h2>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning text-dark border border-white border-opacity-25">
                    <i class="ph-bold ph-pencil-simple"></i> Mode Edit
                </span>
                <p class="text-secondary m-0">Perbarui identitas dan kondisi fisik korban.</p>
            </div>
        </div>
        <a href="{{ route('korban.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                {{-- Form Update --}}
                <form id="editKorbanForm" action="{{ route('korban.update', $korban->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- SECTION 1: KASUS & IDENTITAS --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-identification-card text-warning fs-5"></i>
                        <span class="section-title">Data Identitas</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Kasus Terkait --}}
                        <div class="col-12">
                            <label class="form-label-glow">Kasus Terkait <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-folder-open"></i></span>
                                <select name="kasus_id" class="form-select form-select-glass" required>
                                    <option value="" disabled>Pilih Nomor Kasus...</option>
                                    @foreach($kasus as $k)
                                        <option value="{{ $k->id }}" {{ old('kasus_id', $korban->kasus_id) == $k->id ? 'selected' : '' }}>
                                            [#{{ $k->nomor_kasus }}] {{ $k->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">NIK (KTP)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-cardholder"></i></span>
                                <input type="number" name="nik" class="form-control form-control-glass" 
                                       placeholder="16 Digit NIK" value="{{ old('nik', $korban->nik) }}">
                            </div>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Nama Lengkap <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-user"></i></span>
                                <input type="text" name="nama" class="form-control form-control-glass" 
                                       placeholder="Nama sesuai identitas" value="{{ old('nama', $korban->nama) }}" required>
                            </div>
                        </div>

                        {{-- TTL (Tempat & Tanggal Lahir dipisah seperti Create) --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Tempat Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-map-pin"></i></span>
                                <input type="text" name="tempat_lahir" class="form-control form-control-glass" 
                                       value="{{ old('tempat_lahir', $korban->tempat_lahir) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-glass standalone-input" 
                                   value="{{ old('tanggal_lahir', $korban->tanggal_lahir) }}">
                        </div>

                        {{-- Jenis Kelamin & No Telp --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-gender-intersex"></i></span>
                                <select name="jenis_kelamin" class="form-select form-select-glass">
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $korban->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $korban->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-phone"></i></span>
                                <input type="number" name="no_telp" class="form-control form-control-glass" 
                                       placeholder="Contoh: 0812..." value="{{ old('no_telp', $korban->no_telp) }}">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label class="form-label-glow">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control form-control-glass standalone-input" rows="2" 
                                      placeholder="Alamat lengkap korban...">{{ old('alamat', $korban->alamat) }}</textarea>
                        </div>
                    </div>

                    {{-- SECTION 2: KONDISI & MEDIA --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-first-aid-kit text-warning fs-5"></i>
                        <span class="section-title">Kondisi & Bukti</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Status Kondisi --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Status Kondisi <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-heartbeat"></i></span>
                                <select name="status_korban" class="form-select form-select-glass" required>
                                    @php $status = old('status_korban', $korban->status_korban); @endphp
                                    <option value="Luka Ringan" {{ $status == 'Luka Ringan' ? 'selected' : '' }}>🟡 Luka Ringan</option>
                                    <option value="Luka Berat" {{ $status == 'Luka Berat' ? 'selected' : '' }}>🔴 Luka Berat</option>
                                    <option value="Meninggal Dunia" {{ $status == 'Meninggal Dunia' ? 'selected' : '' }}>⚫ Meninggal Dunia</option>
                                    <option value="Sehat/Selamat" {{ $status == 'Sehat/Selamat' ? 'selected' : '' }}>🟢 Sehat / Selamat</option>
                                    <option value="Trauma Psikis" {{ $status == 'Trauma Psikis' ? 'selected' : '' }}>🔵 Trauma Psikis</option>
                                </select>
                            </div>
                        </div>

                        {{-- Foto Korban dengan Preview Logic --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Update Foto (Opsional)</label>
                            
                            {{-- Preview Foto Lama (Jika ada) --}}
                            @if($korban->foto)
                                <div id="oldPhotoBox" class="file-preview-wrapper">
                                    <img src="{{ asset('storage/' . $korban->foto) }}" class="preview-thumb">
                                    <div class="lh-1">
                                        <div class="text-white small fw-bold mb-1">Foto Saat Ini</div>
                                        <span class="badge-status bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25">Tersimpan</span>
                                    </div>
                                </div>
                            @endif

                            {{-- Preview Foto Baru (Hidden by default) --}}
                            <div id="newPhotoBox" class="file-preview-wrapper d-none" style="border-color: #f59e0b; background: rgba(245, 158, 11, 0.1);">
                                <img id="newImgPreview" class="preview-thumb">
                                <div class="flex-grow-1 lh-1">
                                    <div class="text-warning small fw-bold mb-1">Foto Baru Dipilih</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge-status bg-warning bg-opacity-25 text-warning border border-warning border-opacity-25">New</span>
                                        <button type="button" class="btn btn-sm btn-link text-white p-0 text-decoration-none" onclick="cancelUpload()">
                                            <small>Batal</small>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-image"></i></span>
                                <input type="file" name="foto" id="fileInput" class="form-control form-control-glass" 
                                       accept="image/*" onchange="handleFileSelect(event)">
                            </div>
                        </div>

                        {{-- Keterangan Luka --}}
                        <div class="col-12">
                            <label class="form-label-glow">Keterangan Luka / Fisik</label>
                            <textarea name="keterangan_luka" class="form-control form-control-glass standalone-input" rows="3" 
                                      placeholder="Deskripsikan luka memar, lecet, atau kondisi fisik...">{{ old('keterangan_luka', $korban->keterangan_luka) }}</textarea>
                        </div>

                        {{-- Versi Kejadian --}}
                        <div class="col-12">
                            <label class="form-label-glow">Keterangan Singkat (Versi Korban)</label>
                            <textarea name="versi_kejadian" class="form-control form-control-glass standalone-input" rows="3" 
                                      placeholder="Apa yang disampaikan korban mengenai kejadian tersebut?">{{ old('versi_kejadian', $korban->versi_kejadian) }}</textarea>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top border-secondary border-opacity-10">
                        <a href="{{ route('korban.index') }}" class="btn btn-glass-cancel">Batal</a>
                        <button type="button" class="btn btn-neon-edit" onclick="confirmUpdate()">
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
    // 1. Logic Preview Foto
    function handleFileSelect(event) {
        const file = event.target.files[0];
        const oldBox = document.getElementById('oldPhotoBox');
        const newBox = document.getElementById('newPhotoBox');
        const newImg = document.getElementById('newImgPreview');

        if (file) {
            if(oldBox) oldBox.classList.add('d-none'); // Sembunyikan foto lama
            newBox.classList.remove('d-none'); // Tampilkan box foto baru
            newImg.src = URL.createObjectURL(file); // Set gambar
        }
    }

    function cancelUpload() {
        const fileInput = document.getElementById('fileInput');
        const oldBox = document.getElementById('oldPhotoBox');
        const newBox = document.getElementById('newPhotoBox');

        fileInput.value = ''; // Reset input file
        newBox.classList.add('d-none'); // Sembunyikan box baru
        if(oldBox) oldBox.classList.remove('d-none'); // Munculkan foto lama lagi
    }

    // 2. SweetAlert Confirmation (Warna Amber)
    function confirmUpdate() {
        const form = document.getElementById('editKorbanForm');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Data korban akan diperbarui dengan informasi ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b', // Amber
            cancelButtonColor: '#334155',  // Slate
            confirmButtonText: 'Ya, Update Data!',
            cancelButtonText: 'Cek Lagi',
            background: '#1e293b',
            color: '#fff',
            width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memperbarui...',
                    timer: 2000,
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