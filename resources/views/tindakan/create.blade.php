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
    .input-group .form-control-glass, 
    .input-group .form-select-glass {
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

    /* Fix Calendar Icon Color in Dark Mode */
    input[type="datetime-local"] { color-scheme: dark; }

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
            <h2 class="fw-bold text-white mb-1">Tambah Tindakan Baru</h2>
            <p class="text-secondary m-0">Catat aktivitas investigasi atau tindakan hukum baru.</p>
        </div>
        <a href="{{ route('tindakan.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                <form id="createActionForm" action="{{ route('tindakan.store') }}" method="POST">
                    @csrf

                    {{-- SECTION 1: IDENTITAS TINDAKAN --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-files text-info fs-5"></i>
                        <span class="section-title">Identitas Tindakan</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Pilih Kasus --}}
                        <div class="col-12">
                            <label class="form-label-glow">Kasus Terkait <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-briefcase"></i></span>
                                <select name="kasus_id" class="form-select form-select-glass" required>
                                    <option value="" selected disabled>-- Pilih nomor atau judul kasus --</option>
                                    @foreach($kasus as $k)
                                        <option value="{{ $k->id }}" {{ old('kasus_id') == $k->id ? 'selected' : '' }}>
                                            [#{{ $k->nomor_kasus ?? 'NA' }}] {{ $k->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Judul Tindakan --}}
                        <div class="col-12">
                            <label class="form-label-glow">Judul Tindakan <span class="required-star">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-text-t"></i></span>
                                <input type="text" name="judul_tindakan" class="form-control form-control-glass" 
                                       placeholder="Contoh: Penyitaan Barang Bukti di TKP" 
                                       value="{{ old('judul_tindakan') }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: WAKTU & PELAKSANA --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-clock-user text-info fs-5"></i>
                        <span class="section-title">Waktu & Pelaksana</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Waktu Tindakan --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Waktu Pelaksanaan</label>
                            <input type="datetime-local" name="waktu_tindakan" class="form-control form-control-glass standalone-input"
                                   value="{{ old('waktu_tindakan') }}">
                        </div>

                        {{-- Petugas --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Petugas / Penyidik</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-user-circle"></i></span>
                                <input type="text" name="petugas" class="form-control form-control-glass" 
                                       placeholder="Nama petugas yang bertanggung jawab"
                                       value="{{ old('petugas') }}">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: DETAIL --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-article text-info fs-5"></i>
                        <span class="section-title">Detail Laporan</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label-glow">Deskripsi Detail</label>
                            <textarea name="deskripsi" class="form-control form-control-glass standalone-input" rows="5" 
                                      placeholder="Jelaskan detail tindakan yang dilakukan, hasil yang didapat, atau catatan penting lainnya...">{{ old('deskripsi') }}</textarea>
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
    // SweetAlert Confirmation
    function confirmSubmit() {
        const form = document.getElementById('createActionForm');
        
        // Cek validasi HTML5 standar dulu (required fields)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Tindakan?',
            text: "Pastikan data yang dimasukkan sudah sesuai dengan prosedur.",
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