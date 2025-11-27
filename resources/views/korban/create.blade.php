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
    
    /* File Input Styling */
    .form-control-dark[type="file"] {
        padding: 10px;
    }
    .form-control-dark::file-selector-button {
        background-color: rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        margin-right: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .form-control-dark::file-selector-button:hover {
        background-color: rgba(255, 255, 255, 0.2);
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

    /* Validation Feedback */
    .invalid-feedback { font-size: 0.85em; color: #f87171; }
    .is-invalid { border-color: #ef4444 !important; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1) !important; }
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Registrasi Data Korban</h2>
            <p class="text-secondary m-0">Input data identitas dan kondisi korban kasus.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-secondary bg-dark px-3 py-2 rounded-pill border border-secondary border-opacity-10">
                <i class="ph-duotone ph-user-plus"></i>
                <small>Form Input</small>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('korban.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row g-4">
                        
                        {{-- 1. Kasus (Full Width) --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-folder-open"></i> Kasus Terkait <span class="text-danger">*</span>
                            </label>
                            <select name="kasus_id" class="form-select form-select-dark @error('kasus_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kasus --</option>
                                @foreach($kasus as $k)
                                    <option value="{{ $k->id }}" {{ old('kasus_id') == $k->id ? 'selected' : '' }}>
                                        [#{{ $k->nomor_kasus }}] {{ $k->judul }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kasus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- SEPARATOR: Identitas Diri --}}
                        <div class="col-12 mt-4 mb-2">
                            <h6 class="text-white border-bottom border-secondary border-opacity-25 pb-2">
                                <i class="ph-duotone ph-identification-card me-2"></i>Identitas Diri
                            </h6>
                        </div>

                        {{-- 2. Nama Lengkap --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-user"></i> Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- 3. Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-gender-intersex"></i> Jenis Kelamin
                            </label>
                            <select name="jenis_kelamin" class="form-select form-select-dark">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                                <option value="Tidak diketahui" {{ old('jenis_kelamin')=='Tidak diketahui'?'selected':'' }}>Tidak diketahui</option>
                            </select>
                        </div>

                        {{-- 4. Usia --}}
                        <div class="col-md-4">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-cake"></i> Usia (Tahun)
                            </label>
                            <input type="number" name="usia" class="form-control form-control-dark" 
                                   value="{{ old('usia') }}" placeholder="Contoh: 35">
                        </div>

                        {{-- 5. Kontak --}}
                        <div class="col-md-8">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-phone"></i> Kontak (Telp/Email)
                            </label>
                            <input type="text" name="kontak" class="form-control form-control-dark" 
                                   value="{{ old('kontak') }}" placeholder="Nomor HP atau Email keluarga">
                        </div>

                        {{-- 6. Alamat --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-map-pin"></i> Alamat Domisili
                            </label>
                            <textarea name="alamat" class="form-control form-control-dark" rows="2" 
                                      placeholder="Alamat lengkap korban">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- 7. Foto --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-image"></i> Foto Korban (Opsional)
                            </label>
                            <input type="file" name="foto" class="form-control form-control-dark @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- SEPARATOR: Kondisi & Keterangan --}}
                        <div class="col-12 mt-4 mb-2">
                            <h6 class="text-white border-bottom border-secondary border-opacity-25 pb-2">
                                <i class="ph-duotone ph-first-aid-kit me-2"></i>Kondisi & Keterangan
                            </h6>
                        </div>

                        {{-- 8. Luka / Kondisi --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-heartbeat"></i> Kondisi Fisik / Luka
                            </label>
                            <textarea name="luka" class="form-control form-control-dark" rows="4" 
                                      placeholder="Deskripsikan luka, memar, atau kondisi fisik saat ditemukan...">{{ old('luka') }}</textarea>
                        </div>

                        {{-- 9. Keterangan Tambahan --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-info"></i> Keterangan Tambahan
                            </label>
                            <textarea name="keterangan" class="form-control form-control-dark" rows="4" 
                                      placeholder="Catatan medis riwayat penyakit, atau informasi relevan lainnya...">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- 10. Versi Kejadian --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-chat-text"></i> Versi Kejadian (Dari Korban/Saksi)
                            </label>
                            <textarea name="versi_kejadian" class="form-control form-control-dark" rows="4" 
                                      placeholder="Kronologi singkat kejadian berdasarkan keterangan korban...">{{ old('versi_kejadian') }}</textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3">
                            <a href="{{ route('korban.index') }}" class="btn btn-ghost">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-glow d-flex align-items-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Simpan Data Korban
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection