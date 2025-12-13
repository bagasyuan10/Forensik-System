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
    .blob-orange { top: -10%; right: 20%; width: 400px; height: 400px; background: #f59e0b; } /* Amber */
    .blob-red { bottom: -10%; left: 10%; width: 300px; height: 300px; background: #ef4444; } /* Red */

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 20px); }
    }

    /* --- GLASS CARD --- */
    .form-card {
        background: rgba(30, 41, 59, 0.4);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(245, 158, 11, 0.15); /* Amber Border */
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        position: relative; z-index: 1; overflow: hidden;
    }

    /* --- INPUT STYLES (AMBER FOCUS) --- */
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
    
    .input-group .form-control-glass { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    .standalone-input { border-radius: 12px !important; }

    .form-control-glass:focus, .form-select-glass:focus {
        background: rgba(15, 23, 42, 0.85);
        border-color: #f59e0b; /* Amber Focus */
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.2);
        color: #fff; z-index: 2;
    }

    /* Readonly Input Styling */
    .form-control-glass[readonly] {
        background: rgba(15, 23, 42, 0.9);
        color: #64748b; cursor: not-allowed;
        border-style: dashed;
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

    /* Custom Badge for Edit Mode */
    .badge-edit-mode {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
        padding: 5px 12px; border-radius: 20px; font-size: 0.75rem;
    }
</style>

<div class="container-fluid py-4 position-relative" style="min-height: 85vh;">
    
    {{-- Background Lights (Warm) --}}
    <div class="bg-blob-form blob-orange"></div>
    <div class="bg-blob-form blob-red"></div>

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInDown">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h2 class="fw-bold text-white mb-0">Update Data Kasus</h2>
                <span class="badge-edit-mode"><i class="ph-fill ph-pencil-simple me-1"></i> Mode Edit</span>
            </div>
            <p class="text-secondary m-0">Perbarui informasi dan status perkembangan kasus.</p>
        </div>
        <a href="{{ route('kasus.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="ph-bold ph-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="form-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-1s">
                
                {{-- Gunakan route update dan method PUT --}}
                <form id="editCaseForm" action="{{ route('kasus.update', $kasus->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- SECTION 1: IDENTITAS (READ ONLY & EDITABLE) --}}
                    <div class="section-divider mt-0">
                        <i class="ph-duotone ph-fingerprint text-warning fs-5"></i>
                        <span class="section-title">Identitas Utama</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        {{-- Nomor Kasus (Biasanya tidak boleh diedit sembarangan) --}}
                        <div class="col-md-4">
                            <label class="form-label-glow">Nomor Kasus <small class="text-secondary">(Locked)</small></label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-lock-key"></i></span>
                                <input type="text" name="nomor_kasus" class="form-control form-control-glass" 
                                       value="{{ old('nomor_kasus', $kasus->nomor_kasus) }}" readonly 
                                       title="Nomor kasus tidak dapat diubah demi integritas data">
                            </div>
                        </div>

                        {{-- Judul Kasus --}}
                        <div class="col-md-8">
                            <label class="form-label-glow">Judul Kasus</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-text-t"></i></span>
                                <input type="text" name="judul_kasus" class="form-control form-control-glass" 
                                       value="{{ old('judul_kasus', $kasus->judul) }}" required>
                            </div>
                        </div>

                        {{-- Jenis Kasus --}}
                        <div class="col-md-6">
                            <label class="form-label-glow">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-squares-four"></i></span>
                                <select name="jenis_kasus_id" class="form-select form-select-glass" required>
                                    @foreach ($jenisKasus as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_kasus_id', $kasus->jenis_kasus) == $jenis ? 'selected' : '' }}>
                                            {{ $jenis }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Status Kasus (Highlight Penting di Edit) --}}
                        <div class="col-md-6">
                            <label class="form-label-glow text-warning">Status Terkini</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass" style="border-color: rgba(245, 158, 11, 0.3);">
                                    <i class="ph-fill ph-flag text-warning"></i>
                                </span>
                                <select name="status" class="form-select form-select-glass" style="border-color: rgba(245, 158, 11, 0.3);">
                                    <option value="dibuat" {{ old('status', $kasus->status) == 'dibuat' ? 'selected' : '' }}>🔵 Baru Dibuat (Open)</option>
                                    <option value="penyidikan" {{ old('status', $kasus->status) == 'penyidikan' ? 'selected' : '' }}>🟡 Sedang Disidik (In Progress)</option>
                                    <option value="selesai" {{ old('status', $kasus->status) == 'selesai' ? 'selected' : '' }}>🟢 Selesai (Closed)</option>
                                    <option value="diarsipkan" {{ old('status', $kasus->status) == 'diarsipkan' ? 'selected' : '' }}>⚪ Diarsipkan (Archived)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: DETAIL --}}
                    <div class="section-divider">
                        <i class="ph-duotone ph-clipboard-text text-warning fs-5"></i>
                        <span class="section-title">Detail & Perkembangan</span>
                        <div class="section-line"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-glow">Tanggal Kejadian</label>
                            {{-- Format tanggal untuk value input date biasanya Y-m-d --}}
                            <input type="date" name="tanggal_kejadian" class="form-control form-control-glass standalone-input" 
                                   value="{{ old('tanggal_kejadian', $kasus->tanggal_kejadian) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-glow">Lokasi Kejadian</label>
                            <input type="text" name="lokasi_kejadian" class="form-control form-control-glass standalone-input" 
                                   value="{{ old('lokasi_kejadian', $kasus->lokasi) }}">
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label-glow">Kronologi / Catatan Tambahan</label>
                            <textarea name="kronologi" class="form-control form-control-glass standalone-input" rows="6">{{ old('kronologi', $kasus->deskripsi) }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-glow">Penyidik Utama</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-glass"><i class="ph-bold ph-detective"></i></span>
                                <input type="text" name="penyidik" class="form-control form-control-glass" 
                                       value="{{ old('penyidik', $kasus->penyidik) }}">
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top border-secondary border-opacity-10">
                        {{-- Tombol Batal --}}
                        <button type="button" class="btn btn-glass-cancel" onclick="window.history.back()">
                            <i class="ph-bold ph-x"></i> Batal
                        </button>

                        {{-- Tombol Simpan --}}
                        <button type="button" class="btn btn-neon-update" onclick="confirmUpdate()">
                            <i class="ph-bold ph-check-circle me-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
    function confirmUpdate() {
        const form = document.getElementById('editCaseForm');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Data kasus lama akan diperbarui dengan data ini.",
            icon: 'warning', // Icon warning cocok untuk Edit
            showCancelButton: true,
            confirmButtonColor: '#f59e0b', // Amber
            cancelButtonColor: '#334155',  // Slate
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            background: '#1e293b',
            color: '#fff',
            width: '400px'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memperbarui...',
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