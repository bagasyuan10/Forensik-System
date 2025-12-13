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
            <h2 class="fw-bold text-white mb-1">Formulir Pengaduan</h2>
            <p class="text-secondary m-0">Catat laporan masyarakat untuk ditindaklanjuti.</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Error Handling (Menyatu dengan desain) --}}
    @if ($errors->any())
        <div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-white animate__animated animate__headShake mb-4">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="ph-fill ph-warning-circle text-danger fs-5"></i>
                <strong class="text-danger-emphasis">Terjadi Kesalahan Input</strong>
            </div>
            <ul class="mb-0 small text-danger-emphasis opacity-75">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                <form id="createLaporanForm" action="{{ route('laporan.store') }}" method="POST">
                    @csrf

                    {{-- SECTION 1: INFO UTAMA --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-megaphone text-info fs-5"></i>
                        <span class="section-title">Informasi Dasar</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Judul Aduan --}}
                        <div class="col-12">
                            <label class="form-label-glow">Perihal / Judul Aduan <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-article"></i></span>
                                <input type="text" name="judul_laporan" id="judul_laporan"
                                       class="form-control form-control-glass" 
                                       placeholder="Contoh: Laporan Kehilangan Motor di Pasar Besar" 
                                       value="{{ old('judul_laporan') }}" required>
                            </div>
                        </div>

                        {{-- Pelapor --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Nama Pelapor (Warga)</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-user-circle"></i></span>
                                <input type="text" name="penyusun" id="penyusun"
                                       class="form-control form-control-glass" 
                                       placeholder="Nama lengkap warga" 
                                       value="{{ old('penyusun') }}">
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Tanggal Pengaduan</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-calendar-blank"></i></span>
                                <input type="date" name="tanggal_laporan" id="tanggal_laporan"
                                       class="form-control form-control-glass" 
                                       value="{{ old('tanggal_laporan', now()->format('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: DETAIL --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-clipboard-text text-info fs-5"></i>
                        <span class="section-title">Kronologi & Detail</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-glow">Detail Kronologi Aduan <span class="required-star">*</span></label>
                            <textarea name="isi_laporan" id="isi_laporan"
                                      class="form-control form-control-glass standalone-input" 
                                      rows="8" 
                                      placeholder="Jelaskan secara rinci apa yang terjadi, lokasi kejadian, dan informasi penting lainnya yang disampaikan pelapor..." 
                                      required>{{ old('isi_laporan') }}</textarea>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top border-secondary border-opacity-10">
                        <a href="{{ route('laporan.index') }}" class="btn btn-glass-cancel">Batal</a>
                        <button type="button" class="btn btn-neon-save" onclick="confirmSubmit()">
                            <i class="ph-bold ph-paper-plane-right me-2"></i> Kirim Aduan
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
        const form = document.getElementById('createLaporanForm');
        
        // Cek validasi HTML5 standar (required fields)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Kirim Pengaduan?',
            text: "Pastikan data aduan sudah sesuai.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#06b6d4', // Cyan
            cancelButtonColor: '#334155',  // Slate
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Periksa Lagi',
            background: '#1e293b',
            color: '#fff',
            width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading state
                Swal.fire({
                    title: 'Mengirim...',
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