@extends('layouts.layout')

@section('content')

{{-- STYLE KHUSUS CREATE (Cyan/Blue Theme) --}}
<style>
    /* Card Container */
    .custom-card {
        background: linear-gradient(145deg, #1e293b, #0f172a);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Page Title */
    .page-title {
        background: linear-gradient(to right, #fff, #22d3ee);
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
    .form-label-custom i { color: #22d3ee; font-size: 1.1rem; } /* Icon Cyan */
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
        border-color: #22d3ee; /* Fokus Cyan */
        box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
        color: #fff;
    }

    .form-control-dark::placeholder { color: #475569; }
    
    /* File Input Styling */
    .form-control-dark[type="file"] { padding: 10px; }
    .form-control-dark::file-selector-button {
        background-color: rgba(34, 211, 238, 0.1);
        color: #22d3ee;
        border: 1px solid rgba(34, 211, 238, 0.3);
        border-radius: 6px;
        padding: 6px 12px;
        margin-right: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .form-control-dark::file-selector-button:hover { background-color: rgba(34, 211, 238, 0.2); }

    /* Buttons */
    .btn-glow {
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border: none;
        box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-glow:hover { 
        transform: translateY(-2px); 
        color: white; 
        box-shadow: 0 0 20px rgba(6, 182, 212, 0.6); 
    }

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
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Registrasi Data Pelaku</h2>
            <p class="text-secondary m-0">Input data tersangka atau pelaku tindak kriminal baru.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-info bg-dark px-3 py-2 rounded-pill border border-info border-opacity-25">
                <i class="ph-duotone ph-plus-circle"></i>
                <small class="fw-bold">Mode Input</small>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('pelaku.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row g-5">
                        
                        {{-- KOLOM KIRI: Identitas Utama --}}
                        <div class="col-lg-6">
                            <div class="section-title">
                                <i class="ph-duotone ph-fingerprint text-info"></i> Identitas & Status
                            </div>

                            <div class="row g-4">
                                {{-- 1. Kasus --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-folder-lock"></i> Kasus Terkait <span class="text-danger">*</span>
                                    </label>
                                    <select name="kasus_id" class="form-select form-select-dark @error('kasus_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kasus --</option>
                                        @foreach ($kasus as $k)
                                            <option value="{{ $k->id }}" {{ old('kasus_id') == $k->id ? 'selected' : '' }}>
                                                [#{{ $k->nomor_kasus }}] {{ Str::limit($k->judul ?? $k->judul_kasus, 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kasus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- 2. Nama --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-user-focus"></i> Nama Lengkap / Alias <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama') }}" placeholder="Nama sesuai identitas atau alias" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- 3. Status Hukum --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-gavel"></i> Status Hukum <span class="text-danger">*</span>
                                    </label>
                                    <select name="status_hukum" class="form-select form-select-dark @error('status_hukum') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Saksi" {{ old('status_hukum') == 'Saksi' ? 'selected' : '' }}>👀 Saksi</option>
                                        <option value="Tersangka" {{ old('status_hukum') == 'Tersangka' ? 'selected' : '' }}>⚖️ Tersangka</option>
                                        <option value="Terdakwa" {{ old('status_hukum') == 'Terdakwa' ? 'selected' : '' }}>👨‍⚖️ Terdakwa</option>
                                        <option value="Terpidana" {{ old('status_hukum') == 'Terpidana' ? 'selected' : '' }}>🔒 Terpidana</option>
                                        <option value="DPO" {{ old('status_hukum') == 'DPO' ? 'selected' : '' }}>🚨 DPO / Buron</option>
                                    </select>
                                    @error('status_hukum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- 4. Foto --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-camera"></i> Foto Pelaku
                                    </label>
                                    <input type="file" name="foto" class="form-control form-control-dark @error('foto') is-invalid @enderror" accept="image/*">
                                    @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- 5. Biodata --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-identification-card"></i> Biodata Lengkap
                                    </label>
                                    <textarea name="biodata" class="form-control form-control-dark @error('biodata') is-invalid @enderror" rows="5" 
                                              placeholder="Usia, Alamat, Pekerjaan, Ciri-ciri fisik, Riwayat kriminal sebelumnya...">{{ old('biodata') }}</textarea>
                                    @error('biodata') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>


                        {{-- KOLOM KANAN: Detail Investigasi --}}
                        <div class="col-lg-6">
                            <div class="section-title">
                                <i class="ph-duotone ph-detective text-info"></i> Detail Investigasi
                            </div>

                            <div class="row g-4">
                                {{-- 6. Hubungan --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-users-three"></i> Hubungan dgn Korban
                                    </label>
                                    <input type="text" name="hubungan_korban" class="form-control form-control-dark" 
                                           value="{{ old('hubungan_korban') }}" placeholder="Contoh: Teman, Tetangga, Orang Asing">
                                </div>

                                {{-- 7. Peran --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-mask-happy"></i> Peran dalam Kasus
                                    </label>
                                    <input type="text" name="peran" class="form-control form-control-dark" 
                                           value="{{ old('peran') }}" placeholder="Contoh: Eksekutor, Otak pelaku, Pembantu">
                                </div>

                                {{-- 8. Pengakuan --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-quotes"></i> Pengakuan / Kronologi
                                    </label>
                                    <textarea name="pengakuan" class="form-control form-control-dark" rows="5" 
                                              placeholder="Catat keterangan atau pengakuan pelaku di sini (Versi Pelaku)...">{{ old('pengakuan') }}</textarea>
                                </div>

                                {{-- 9. Barang Bukti --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-package"></i> Barang Bukti Terkait (Opsional)
                                    </label>
                                    <select name="barang_bukti_id" class="form-select form-select-dark">
                                        <option value="">-- Tidak Ada / Belum Ditentukan --</option>
                                        @if(isset($barangBukti))
                                            @foreach ($barangBukti as $bb)
                                                <option value="{{ $bb->id }}" {{ old('barang_bukti_id') == $bb->id ? 'selected' : '' }}>
                                                    {{ $bb->nama_bukti }} ({{ $bb->kategori }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="text-secondary mt-1 d-block">Barang bukti yang dipilih akan otomatis terhubung dengan pelaku ini.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3 border-top border-secondary border-opacity-10 pt-4">
                            <a href="{{ route('pelaku.index') }}" class="btn btn-ghost">
                                <i class="ph-bold ph-arrow-u-up-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-glow d-flex align-items-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Simpan Data Pelaku
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection