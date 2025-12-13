@extends('layouts.layout')

@section('content')

{{-- LIBRARY TAMBAHAN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- BACKGROUND DECORATION --- */
    .bg-blob-form {
        position: absolute; filter: blur(90px); z-index: 0; opacity: 0.3;
        animation: floatBlob 12s infinite ease-in-out;
    }
    .blob-blue { top: -10%; left: 20%; width: 400px; height: 400px; background: #3b82f6; }
    .blob-cyan { bottom: -10%; right: 10%; width: 300px; height: 300px; background: #06b6d4; }

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
    
    /* Rounded corners adjustment for input groups */
    .input-group .form-control-glass {
        border-top-right-radius: 12px; border-bottom-right-radius: 12px;
    }
    /* Rounded corners for standalone inputs */
    .standalone-input { border-radius: 12px !important; }

    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.85);
        border-color: #22d3ee;
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.15);
        color: #fff; z-index: 2;
    }
    .form-control-glass::placeholder { color: #475569; }

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

    /* Auto Generate Button */
    .btn-generate {
        background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.3);
        color: #22d3ee; font-size: 0.8rem; padding: 4px 12px; border-radius: 8px;
        cursor: pointer; transition: 0.2s;
    }
    .btn-generate:hover { background: rgba(34, 211, 238, 0.2); color: #fff; }

    /* Custom Scrollbar for Textarea */
    textarea::-webkit-scrollbar { width: 8px; }
    textarea::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    textarea::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    {{-- Background Lights --}}
    <div class="bg-blob-form blob-blue"></div>
    <div class="bg-blob-form blob-cyan"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <h2 class="fw-bold text-white mb-1">Registrasi Kasus Baru</h2>
            <p class="text-secondary m-0">Input data investigasi awal ke dalam sistem.</p>
        </div>
        <a href="{{ route('kasus.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                <form id="createCaseForm" action="{{ route('kasus.store') }}" method="POST">
                    @csrf

                    {{-- SECTION 1: IDENTITAS KASUS --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-fingerprint text-info fs-5"></i>
                        <span class="section-title">Identitas Kasus</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Judul Kasus --}}
                        <div class="col-md-8">
                            <label class="form-label-glow">Judul Kasus <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-text-t"></i></span>
                                <input type="text" name="judul_kasus" class="form-control form-control-glass" 
                                       placeholder="Contoh: Pembobolan Database Server Pusat" 
                                       value="{{ old('judul_kasus') }}" required>
                            </div>
                        </div>

                        {{-- Nomor Kasus (Auto Generate) --}}
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label-glow mb-0">Nomor Kasus <span class="required-star">*</span></label>
                                <button type="button" class="btn-generate" onclick="generateCaseID()">
                                    <i class="ph-bold ph-magic-wand"></i> Auto ID
                                </button>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-hash"></i></span>
                                <input type="text" name="nomor_kasus" id="nomor_kasus" class="form-control form-control-glass" 
                                       placeholder="K-YYYY-XXX" value="{{ old('nomor_kasus') }}" required readonly>
                            </div>
                        </div>

                        {{-- Jenis Kasus --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Kategori <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-squares-four"></i></span>
                                <select name="jenis_kasus_id" class="form-select form-select-glass" required>
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    @foreach ($jenisKasus as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_kasus_id') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Status Kasus --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Status Awal</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-flag"></i></span>
                                <select name="status" class="form-select form-select-glass">
                                    <option value="dibuat">🔵 Baru Dibuat (Open)</option>
                                    <option value="penyidikan">🟡 Dalam Penyidikan (In Progress)</option>
                                    <option value="selesai">🟢 Selesai (Closed)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: WAKTU & LOKASI --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-map-pin-line text-info fs-5"></i>
                        <span class="section-title">Waktu & Lokasi</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-glow">Tanggal Kejadian <span class="required-star">*</span></label>
                            <input type="datetime-local" name="tanggal_kejadian" class="form-control form-control-glass standalone-input" 
                                   value="{{ old('tanggal_kejadian') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Lokasi Kejadian</label>
                            <input type="text" name="lokasi_kejadian" class="form-control form-control-glass standalone-input" 
                                   placeholder="Nama Gedung, Ruangan, atau Alamat IP" value="{{ old('lokasi_kejadian') }}">
                        </div>
                    </div>

                    {{-- SECTION 3: DETAIL --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-clipboard-text text-info fs-5"></i>
                        <span class="section-title">Detail Investigasi</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-glow">Kronologi Singkat</label>
                            <textarea name="kronologi" class="form-control form-control-glass standalone-input" rows="5" 
                                      placeholder="Deskripsikan bagaimana insiden ditemukan dan langkah awal yang dilakukan...">{{ old('kronologi') }}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label-glow">Penyidik Utama</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-detective"></i></span>
                                <input type="text" name="penyidik" class="form-control form-control-glass" 
                                       value="{{ old('penyidik', Auth::user()->name ?? '') }}" placeholder="Nama Investigator">
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top border-secondary border-opacity-10">
                        <button type="button" class="btn btn-glass-cancel" onclick="window.history.back()">Batal</button>
                        <button type="button" class="btn btn-neon-save" onclick="confirmSubmit()">
                            <i class="ph-bold ph-floppy-disk me-2"></i> Simpan Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    // 1. Auto Generate ID Logic
    function generateCaseID() {
        const date = new Date();
        const year = date.getFullYear();
        // Random 4 digit number
        const randomNum = Math.floor(1000 + Math.random() * 9000);
        const caseID = `CS-${year}-${randomNum}`;
        
        const input = document.getElementById('nomor_kasus');
        
        // Animasi flicker sedikit
        input.style.color = '#22d3ee';
        input.value = "Generating...";
        
        setTimeout(() => {
            input.value = caseID;
            input.style.color = '#fff';
        }, 500);
    }

    // 2. SweetAlert Confirmation
    function confirmSubmit() {
        const form = document.getElementById('createCaseForm');
        
        // Cek validasi HTML5 standar dulu (required fields)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Kasus Baru?',
            text: "Pastikan data yang Anda masukkan sudah benar.",
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

    // Auto run generate ID jika kosong saat load
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById('nomor_kasus');
        if(input.value === '') {
            generateCaseID();
        }
    });
</script>

@endsection