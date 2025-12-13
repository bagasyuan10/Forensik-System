@extends('layouts.layout')

@section('content')

{{-- STYLE KHUSUS EDIT (Amber/Warning Theme) --}}
<style>
    .custom-card {
        background: linear-gradient(145deg, #1e293b, #0f172a);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .page-title {
        background: linear-gradient(to right, #fff, #fbbf24);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .form-label-custom {
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-label-custom i { color: #fbbf24; font-size: 1.1rem; } /* Icon Amber */
    .text-danger { color: #ef4444 !important; }

    /* Glassy Inputs */
    .form-control-dark, .form-select-dark {
        background-color: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control-dark:focus, .form-select-dark:focus {
        background-color: rgba(15, 23, 42, 0.9);
        border-color: #fbbf24; /* Fokus Amber */
        box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1);
        color: #fff;
    }

    /* File Input Styling */
    .form-control-dark[type="file"] { padding: 10px; }
    .form-control-dark::file-selector-button {
        background-color: rgba(251, 191, 36, 0.1);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 6px;
        padding: 6px 12px;
        margin-right: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .form-control-dark::file-selector-button:hover { background-color: rgba(251, 191, 36, 0.2); }

    /* Buttons */
    .btn-glow-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border: none;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.3);
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-glow-warning:hover { 
        transform: translateY(-2px); 
        color: white; 
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.6); 
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
    .btn-ghost:hover { background: rgba(255, 255, 255, 0.05); color: #fff; border-color: #fff; }

    /* Section Title */
    .section-title {
        color: #cbd5e1; font-weight: 700; font-size: 1rem;
        padding-bottom: 10px; margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; gap: 10px;
    }

    /* Image Preview */
    .current-photo-container {
        position: relative; width: 100px; height: 100px; flex-shrink: 0;
    }
    .img-preview {
        width: 100%; height: 100%; object-fit: cover;
        border-radius: 12px; border: 2px solid rgba(251, 191, 36, 0.3);
    }
    .photo-badge {
        position: absolute; bottom: -5px; right: -5px;
        background: #f59e0b; color: #000; font-size: 10px; font-weight: bold;
        padding: 2px 6px; border-radius: 4px;
    }
</style>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Edit Data Pelaku</h2>
            <p class="text-secondary m-0">Perbarui informasi identitas, status hukum, dan peran tersangka.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-warning bg-dark px-3 py-2 rounded-pill border border-warning border-opacity-25">
                <i class="ph-duotone ph-pencil-simple-slash"></i>
                <small class="fw-bold">Mode Edit</small>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('pelaku.update', $pelaku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-5">
                        
                        {{-- KOLOM KIRI: Identitas & Status --}}
                        <div class="col-lg-6">
                            <div class="section-title">
                                <i class="ph-duotone ph-fingerprint text-warning"></i> Identitas & Status
                            </div>

                            <div class="row g-4">
                                {{-- 1. Kasus Terkait --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-briefcase"></i> Kasus Terkait <span class="text-danger">*</span>
                                    </label>
                                    <select name="kasus_id" class="form-select form-select-dark" required>
                                        <option value="">-- Pilih Kasus --</option>
                                        @foreach ($kasus as $k)
                                            <option value="{{ $k->id }}" {{ old('kasus_id', $pelaku->kasus_id) == $k->id ? 'selected' : '' }}>
                                                [#{{ $k->nomor_kasus }}] {{ Str::limit($k->judul, 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 2. Nama Lengkap --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-user"></i> Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama" class="form-control form-control-dark" 
                                           value="{{ old('nama', $pelaku->nama) }}" placeholder="Nama sesuai KTP/Identitas" required>
                                </div>

                                {{-- 3. Status Hukum --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-gavel"></i> Status Hukum <span class="text-danger">*</span>
                                    </label>
                                    <select name="status_hukum" class="form-select form-select-dark" required>
                                        <option value="Saksi" {{ old('status_hukum', $pelaku->status_hukum) == 'Saksi' ? 'selected' : '' }}>👀 Saksi</option>
                                        <option value="Tersangka" {{ old('status_hukum', $pelaku->status_hukum) == 'Tersangka' ? 'selected' : '' }}>⚖️ Tersangka</option>
                                        <option value="Terdakwa" {{ old('status_hukum', $pelaku->status_hukum) == 'Terdakwa' ? 'selected' : '' }}>👨‍⚖️ Terdakwa</option>
                                        <option value="Terpidana" {{ old('status_hukum', $pelaku->status_hukum) == 'Terpidana' ? 'selected' : '' }}>🔒 Terpidana</option>
                                        <option value="DPO" {{ old('status_hukum', $pelaku->status_hukum) == 'DPO' ? 'selected' : '' }}>🚨 DPO / Buron</option>
                                    </select>
                                </div>

                                {{-- 4. Foto Pelaku --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-camera"></i> Foto
                                    </label>
                                    <div class="d-flex gap-3 align-items-center">
                                        @if($pelaku->foto)
                                            <div class="current-photo-container">
                                                <img src="{{ asset('storage/' . $pelaku->foto) }}" class="img-preview" alt="Foto Lama">
                                                <span class="photo-badge">Saat Ini</span>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <input type="file" name="foto" class="form-control form-control-dark" accept="image/*">
                                            <small class="text-secondary d-block mt-1" style="font-size: 0.75rem;">
                                                Biarkan kosong jika tidak ingin mengubah foto.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- 5. Biodata --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-identification-card"></i> Biodata Lengkap
                                    </label>
                                    <textarea name="biodata" class="form-control form-control-dark" rows="4" placeholder="Alamat, Tgl Lahir, NIK, dll...">{{ old('biodata', $pelaku->biodata) }}</textarea>
                                </div>
                            </div>
                        </div>


                        {{-- KOLOM KANAN: Detail Investigasi --}}
                        <div class="col-lg-6">
                            <div class="section-title">
                                <i class="ph-duotone ph-detective text-warning"></i> Detail Investigasi
                            </div>

                            <div class="row g-4">
                                {{-- 6. Hubungan dengan Korban --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-users-three"></i> Hubungan dgn Korban
                                    </label>
                                    <input type="text" name="hubungan_korban" class="form-control form-control-dark" 
                                           value="{{ old('hubungan_korban', $pelaku->hubungan_korban) }}" placeholder="Contoh: Teman, Saudara, Orang Asing">
                                </div>

                                {{-- 7. Peran --}}
                                <div class="col-md-6">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-mask-happy"></i> Peran dalam Kasus
                                    </label>
                                    <input type="text" name="peran" class="form-control form-control-dark" 
                                           value="{{ old('peran', $pelaku->peran) }}" placeholder="Contoh: Eksekutor, Otak Kejahatan">
                                </div>

                                {{-- 8. Pengakuan --}}
                                <div class="col-12">
                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-quotes"></i> Pengakuan / Kronologi
                                    </label>
                                    <textarea name="pengakuan" class="form-control form-control-dark" rows="4" placeholder="Catatan pengakuan tersangka...">{{ old('pengakuan', $pelaku->pengakuan) }}</textarea>
                                </div>

                                {{-- 9. Barang Bukti Terkait --}}
                                <div class="col-12">
                                    {{-- Ambil data di luar loop agar rapi --}}
                                    @php
                                        $buktiDimiliki = $pelaku->barangBukti->pluck('id')->toArray();
                                    @endphp

                                    <label class="form-label-custom">
                                        <i class="ph-bold ph-package"></i> Barang Bukti Terkait
                                    </label>
                                    
                                    <div class="p-3 rounded-3 border border-secondary border-opacity-10 bg-dark bg-opacity-25">
                                        <select name="barang_bukti_id" class="form-select form-select-dark">
                                            <option value="">-- Pilih Barang Bukti (Opsional) --</option>
                                            
                                            @foreach ($barangBukti as $bb)
                                                <option value="{{ $bb->id }}" {{ in_array($bb->id, $buktiDimiliki) ? 'selected' : '' }}>
                                                    {{ $bb->nama_bukti }} ({{ $bb->kategori }})
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                        {{-- Info text --}}
                                        <div class="mt-2 d-flex align-items-start gap-2">
                                            <i class="ph-fill ph-info text-secondary mt-1"></i>
                                            <small class="text-secondary lh-sm">
                                                Hanya bisa memilih satu. Jika barang bukti tidak ada, tambahkan di menu Barang Bukti dulu.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3 border-top border-secondary border-opacity-10 pt-4">
                            <a href="{{ route('pelaku.index') }}" class="btn btn-ghost">
                                <i class="ph-bold ph-arrow-u-up-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-glow-warning d-flex align-items-center gap-2">
                                <i class="ph-bold ph-check-circle"></i> Simpan Perubahan
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection