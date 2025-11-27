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
    .text-danger { color: #ef4444 !important; }

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
    
    /* Date Input Fix */
    input[type="date"], input[type="datetime-local"] {
        color-scheme: dark;
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

    /* Section Divider */
    .section-title {
        color: #e2e8f0;
        font-weight: 700;
        font-size: 1rem;
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Validation Feedback */
    .invalid-feedback { font-size: 0.85em; color: #f87171; }
    .is-invalid { border-color: #ef4444 !important; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1) !important; }
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Registrasi Kasus Baru</h2>
            <p class="text-secondary m-0">Buat laporan investigasi awal untuk insiden baru.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-secondary bg-dark px-3 py-2 rounded-pill border border-secondary border-opacity-10">
                <i class="ph-duotone ph-folder-plus"></i>
                <small>New Entry</small>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('kasus.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        
                        {{-- SECTION 1: Informasi Dasar --}}
                        <div class="col-12">
                            <div class="section-title mt-0">
                                <i class="ph-duotone ph-info text-info"></i> Informasi Dasar
                            </div>
                        </div>

                        {{-- 1. Judul Kasus --}}
                        <div class="col-md-8">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-text-t"></i> Judul Kasus <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="judul_kasus" class="form-control form-control-dark @error('judul_kasus') is-invalid @enderror" 
                                   value="{{ old('judul_kasus') }}" placeholder="Contoh: Pencurian Data Server Utama..." required>
                            @error('judul_kasus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 2. Nomor Kasus --}}
                        <div class="col-md-4">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-hash"></i> Nomor Kasus <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nomor_kasus" class="form-control form-control-dark @error('nomor_kasus') is-invalid @enderror" 
                                   value="{{ old('nomor_kasus') }}" placeholder="Auto / Manual: K-2024-001" required>
                            @error('nomor_kasus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 3. Jenis Kasus --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-squares-four"></i> Jenis Kasus <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_kasus_id" class="form-select form-select-dark @error('jenis_kasus_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($jenisKasus as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_kasus_id') == $jenis ? 'selected' : '' }}>
                                        {{ $jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_kasus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 4. Status Kasus --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-flag"></i> Status Awal <span class="text-danger">*</span>
                            </label>
                            <select name="status" class="form-select form-select-dark" required>
                                <option value="dibuat" {{ old('status') == 'dibuat' ? 'selected' : '' }}>🟢 Baru Dibuat (Open)</option>
                                <option value="penyidikan" {{ old('status') == 'penyidikan' ? 'selected' : '' }}>🟡 Sedang Disidik (In Progress)</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>🔵 Selesai (Closed)</option>
                                <option value="diarsipkan" {{ old('status') == 'diarsipkan' ? 'selected' : '' }}>⚪ Diarsipkan (Archived)</option>
                            </select>
                        </div>


                        {{-- SECTION 2: Detail Kejadian --}}
                        <div class="col-12 mt-4">
                            <div class="section-title">
                                <i class="ph-duotone ph-calendar-plus text-warning"></i> Detail Kejadian
                            </div>
                        </div>

                        {{-- 5. Tanggal Kejadian --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-calendar"></i> Tanggal Kejadian <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal_kejadian" class="form-control form-control-dark @error('tanggal_kejadian') is-invalid @enderror" 
                                   value="{{ old('tanggal_kejadian') }}" required>
                            @error('tanggal_kejadian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 6. Lokasi Kejadian --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-map-pin"></i> Lokasi Kejadian
                            </label>
                            <input type="text" name="lokasi_kejadian" class="form-control form-control-dark" 
                                   value="{{ old('lokasi_kejadian') }}" placeholder="Nama Gedung, Jalan, atau Koordinat">
                        </div>

                        {{-- 7. Kronologi --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-article"></i> Kronologi / Runtutan Peristiwa
                            </label>
                            <textarea name="kronologi" class="form-control form-control-dark @error('kronologi') is-invalid @enderror" rows="6" 
                                      placeholder="Jelaskan secara rinci bagaimana kejadian bermula dan ditemukan...">{{ old('kronologi') }}</textarea>
                            @error('kronologi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 8. Penyidik --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-detective"></i> Penyidik / Investigator Utama
                            </label>
                            <input type="text" name="penyidik" class="form-control form-control-dark" 
                                   value="{{ old('penyidik') }}" placeholder="Nama Investigator yang menangani">
                        </div>


                        {{-- Buttons --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3 border-top border-secondary border-opacity-10 pt-4">
                            <a href="{{ route('kasus.index') }}" class="btn btn-ghost">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-glow d-flex align-items-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Simpan Kasus
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection