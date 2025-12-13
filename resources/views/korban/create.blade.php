@extends('layouts.layout')

@section('content')

{{-- LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND DECORATION (Sama persis) --- */
    .bg-blob-form {
        position: absolute; filter: blur(90px); z-index: 0; opacity: 0.3;
        animation: floatBlob 12s infinite ease-in-out;
    }
    .blob-blue { top: -10%; left: 20%; width: 400px; height: 400px; background: #3b82f6; }
    .blob-cyan { bottom: -10%; right: 10%; width: 300px; height: 300px; background: #06b6d4; }
    .blob-purple { bottom: 20%; left: 10%; width: 250px; height: 250px; background: #8b5cf6; }

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(20px, -20px); }
    }

    /* --- GLASS CARD --- */
    .form-card {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative; z-index: 1; overflow: hidden;
    }

    /* --- INPUT STYLES --- */
    .input-group-text-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-right: none;
        color: #94a3b8;
        border-top-left-radius: 12px; border-bottom-left-radius: 12px;
    }

    .form-control-glass, .form-select-glass {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    
    .input-group .form-control-glass {
        border-top-right-radius: 12px; border-bottom-right-radius: 12px;
    }
    .standalone-input { border-radius: 12px !important; }

    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.85);
        border-color: #22d3ee;
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.15);
        color: #fff; z-index: 2;
    }
    .form-control-glass::placeholder { color: #475569; }

    /* Fix untuk Input Type File agar rapi di dark mode */
    .form-control-glass[type="file"] {
        padding: 8px 10px;
    }
    .form-control-glass::file-selector-button {
        background-color: rgba(255, 255, 255, 0.1);
        color: #e2e8f0; border: none; border-radius: 6px;
        padding: 4px 10px; margin-right: 12px; cursor: pointer;
    }

    /* --- LABELS & TITLES --- */
    .section-divider {
        display: flex; align-items: center; gap: 15px; margin: 30px 0 20px;
    }
    .section-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent); }
    .section-title {
        color: #22d3ee; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;
    }

    .form-label-glow {
        color: #cbd5e1; font-weight: 500; font-size: 0.9rem; margin-bottom: 8px;
    }
    .required-star { color: #ef4444; margin-left: 3px; }

    /* --- BUTTONS --- */
    .btn-neon-save {
        background: linear-gradient(135deg, #06b6d4, #2563eb);
        border: none; color: white; padding: 12px 35px;
        border-radius: 50px; font-weight: 600; letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        transition: 0.3s;
    }
    .btn-neon-save:hover {
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(6, 182, 212, 0.6); color: white;
    }

    .btn-glass-cancel {
        background: transparent; border: 1px solid rgba(255,255,255,0.2);
        color: #94a3b8; padding: 12px 30px; border-radius: 50px; transition: 0.3s;
    }
    .btn-glass-cancel:hover {
        background: rgba(255,255,255,0.05); color: #fff; border-color: #fff;
    }

    /* Scrollbar */
    textarea::-webkit-scrollbar { width: 8px; }
    textarea::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    textarea::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    {{-- Background Lights --}}
    <div class="bg-blob-form blob-blue"></div>
    <div class="bg-blob-form blob-cyan"></div>
    <div class="bg-blob-form blob-purple"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <h2 class="fw-bold text-white mb-1">Registrasi Data Korban</h2>
            <p class="text-secondary m-0">Input identitas dan kondisi fisik korban terkait kasus.</p>
        </div>
        <a href="{{ route('korban.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                {{-- Form perlu enctype multipart karena ada upload FOTO --}}
                <form id="createKorbanForm" action="{{ route('korban.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- SECTION 1: KASUS & IDENTITAS --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-identification-card text-info fs-5"></i>
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
                                    <option value="" selected disabled>Pilih Nomor Kasus...</option>
                                    @foreach($kasus as $k)
                                        <option value="{{ $k->id }}" {{ old('kasus_id') == $k->id ? 'selected' : '' }}>
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
                                       placeholder="16 Digit NIK" value="{{ old('nik') }}">
                            </div>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Nama Lengkap <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-user"></i></span>
                                <input type="text" name="nama" class="form-control form-control-glass" 
                                       placeholder="Nama sesuai identitas" value="{{ old('nama') }}" required>
                            </div>
                        </div>

                        {{-- TTL --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Tempat Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-map-pin"></i></span>
                                <input type="text" name="tempat_lahir" class="form-control form-control-glass" value="{{ old('tempat_lahir') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-glass standalone-input" value="{{ old('tanggal_lahir') }}">
                        </div>

                        {{-- Jenis Kelamin & No Telp --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Jenis Kelamin</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-gender-intersex"></i></span>
                                <select name="jenis_kelamin" class="form-select form-select-glass">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-phone"></i></span>
                                <input type="number" name="no_telp" class="form-control form-control-glass" 
                                       placeholder="Contoh: 0812..." value="{{ old('no_telp') }}">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label class="form-label-glow">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control form-control-glass standalone-input" rows="2" 
                                      placeholder="Alamat lengkap korban...">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- SECTION 2: KONDISI & MEDIA --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-first-aid-kit text-info fs-5"></i>
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
                                    <option value="Luka Ringan">🟡 Luka Ringan</option>
                                    <option value="Luka Berat">🔴 Luka Berat</option>
                                    <option value="Meninggal Dunia">⚫ Meninggal Dunia</option>
                                    <option value="Sehat/Selamat">🟢 Sehat / Selamat</option>
                                    <option value="Trauma Psikis">🔵 Trauma Psikis</option>
                                </select>
                            </div>
                        </div>

                        {{-- Foto Korban --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Foto Korban (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-image"></i></span>
                                <input type="file" name="foto" class="form-control form-control-glass" accept="image/*">
                            </div>
                        </div>

                        {{-- Keterangan Luka --}}
                        <div class="col-12">
                            <label class="form-label-glow">Keterangan Luka / Fisik</label>
                            <textarea name="keterangan_luka" class="form-control form-control-glass standalone-input" rows="3" 
                                      placeholder="Deskripsikan luka memar, lecet, atau kondisi fisik saat ditemukan...">{{ old('keterangan_luka') }}</textarea>
                        </div>

                        {{-- Versi Kejadian --}}
                        <div class="col-12">
                            <label class="form-label-glow">Keterangan Singkat (Versi Korban)</label>
                            <textarea name="versi_kejadian" class="form-control form-control-glass standalone-input" rows="3" 
                                      placeholder="Apa yang disampaikan korban mengenai kejadian tersebut?">{{ old('versi_kejadian') }}</textarea>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-glass-cancel" onclick="window.history.back()">Batal</button>
                        <button type="button" class="btn btn-neon-save" onclick="confirmSubmit()">
                            <i class="ph-bold ph-floppy-disk me-2"></i> Simpan Data Korban
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    // SweetAlert Confirmation
    function confirmSubmit() {
        const form = document.getElementById('createKorbanForm');
        
        // Cek validasi HTML5 standar
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Data Korban?',
            text: "Pastikan data identitas dan kondisi sudah sesuai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#06b6d4', // Cyan
            cancelButtonColor: '#334155',  // Slate
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Periksa Lagi',
            background: '#1e293b',
            color: '#fff',
            width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state
                Swal.fire({
                    title: 'Menyimpan...',
                    timer: 2000,
                    didOpen: () => { Swal.showLoading() },
                    background: '#1e293b',
                    color: '#fff',
                    showConfirmButton: false
                });
                
                // Submit form
                setTimeout(() => {
                    form.submit();
                }, 800); 
            }
        })
    }
</script>

@endsection