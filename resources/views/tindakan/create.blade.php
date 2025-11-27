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

    /* Inputs (Glassy) */
    .form-control-dark, .form-select-dark {
        background-color: rgba(15, 23, 42, 0.6); /* Slate-900 transparent */
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
    
    /* Fix Calendar Icon Color in Dark Mode */
    input[type="datetime-local"] {
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
</style>

<div class="container-fluid py-4">

    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Tambah Tindakan Baru</h2>
            <p class="text-secondary m-0">Catat aktivitas investigasi atau tindakan hukum baru.</p>
        </div>
        <div class="d-none d-md-block">
            <div class="d-flex align-items-center gap-2 text-secondary bg-dark px-3 py-2 rounded-pill border border-secondary border-opacity-10">
                <i class="ph-duotone ph-clock"></i>
                <small>{{ now()->format('d M Y') }}</small>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="custom-card p-4 p-md-5">
                
                <form action="{{ route('tindakan.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        
                        {{-- 1. Pilih Kasus --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-briefcase"></i> Kasus Terkait
                            </label>
                            <select name="kasus_id" class="form-select form-select-dark" required>
                                <option value="" selected disabled>-- Pilih nomor atau judul kasus --</option>
                                @foreach($kasus as $k)
                                    <option value="{{ $k->id }}">
                                        [#{{ $k->nomor_kasus ?? 'NA' }}] {{ $k->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 2. Judul Tindakan --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-text-t"></i> Judul Tindakan
                            </label>
                            <input type="text" name="judul_tindakan" class="form-control form-control-dark" 
                                   placeholder="Contoh: Penyitaan Barang Bukti di TKP" required>
                        </div>

                        {{-- 3. Waktu Tindakan --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-calendar-check"></i> Waktu Pelaksanaan
                            </label>
                            <input type="datetime-local" name="waktu_tindakan" class="form-control form-control-dark">
                        </div>

                        {{-- 4. Petugas --}}
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-user-circle"></i> Petugas / Penyidik
                            </label>
                            <input type="text" name="petugas" class="form-control form-control-dark" 
                                   placeholder="Nama petugas yang bertanggung jawab">
                        </div>

                        {{-- 5. Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label-custom">
                                <i class="ph-bold ph-article"></i> Deskripsi Detail
                            </label>
                            <textarea name="deskripsi" class="form-control form-control-dark" rows="5" 
                                      placeholder="Jelaskan detail tindakan yang dilakukan, hasil yang didapat, atau catatan penting lainnya..."></textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 mt-4 d-flex justify-content-end gap-3">
                            <a href="{{ route('tindakan.index') }}" class="btn btn-ghost">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-glow d-flex align-items-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Simpan Data
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection