<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Pengaduan Masyarakat</title>
    
    {{-- FONTS & ICONS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    {{-- CSS LIBRARIES --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    {{-- SWEETALERT (POP UP) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* === GLOBAL THEME (AURORA) === */
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
            background: radial-gradient(circle at 0% 0%, #1e1b4b, #0f172a 40%),
                        radial-gradient(circle at 100% 100%, #06b6d4 0%, #0f172a 50%);
            background-size: 150% 150%;
            animation: aurora 10s ease infinite alternate;
            color: #e2e8f0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes aurora {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        /* Overlay Jaring Halus */
        .shapes-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px; pointer-events: none; z-index: -1;
        }

        /* Navbar Transparan */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        /* Card Form Kaca */
        .glass-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
        }
        .glass-card:hover { transform: translateY(-5px); border-color: rgba(255,255,255,0.2); }

        /* Input Glowing */
        .form-control-glass {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff; border-radius: 12px; padding: 14px 18px;
            transition: all 0.3s;
        }
        .form-control-glass::placeholder { color: rgba(148, 163, 184, 0.6); }
        .form-control-glass:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #22d3ee;
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.15);
            color: #fff;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); opacity: 0.6; cursor: pointer;
        }

        /* Tombol Neon */
        .btn-submit-neon {
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border: none; padding: 16px; font-weight: 700; letter-spacing: 0.5px;
            border-radius: 12px; color: white; width: 100%;
            box-shadow: 0 10px 20px -5px rgba(6, 182, 212, 0.4);
            transition: all 0.3s;
        }
        .btn-submit-neon:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 30px -5px rgba(6, 182, 212, 0.6);
            color: #fff;
        }

        /* Typography */
        .hero-title {
            font-weight: 800; letter-spacing: -1px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        
        /* Animasi Ikon Floating */
        .floating-icon {
            font-size: 180px; color: #22d3ee;
            filter: drop-shadow(0 0 40px rgba(34, 211, 238, 0.3));
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        /* Custom SweetAlert Style */
        div:where(.swal2-container).swal2-center > .swal2-popup {
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
        }
        div:where(.swal2-title) { color: #fff !important; font-family: 'Outfit', sans-serif; }
        div:where(.swal2-html-container) { color: #cbd5e1 !important; }
    </style>
</head>
<body>

    <div class="shapes-overlay"></div>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-dark navbar-glass sticky-top py-3">
        <div class="container d-flex justify-content-between">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <div class="bg-info bg-opacity-25 p-2 rounded-3 text-info">
                    <i class="ph-bold ph-shield-check"></i>
                </div>
                <span>Sistem Pengaduan</span>
            </a>
            
            {{-- LOGIKA TOMBOL NAVBAR --}}
            <div class="d-flex gap-2">
                @auth
                    {{-- Cek apakah emailnya Admin Khusus --}}
                    @if(Auth::user()->email === 'aqewtzy@gmail.com')
                        <a href="{{ route('dashboard') }}" class="btn btn-info rounded-pill px-4 btn-sm fw-bold">
                            <i class="ph-bold ph-squares-four me-1"></i> Dashboard
                        </a>
                    @else
                        {{-- Jika User Biasa --}}
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-white small fw-medium">Halo, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger rounded-pill px-4 btn-sm">Logout</button>
                            </form>
                        </div>
                    @endif
                @else
                    {{-- Jika Belum Login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 btn-sm">
                        Login Petugas
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <div class="container py-5">
        <div class="row align-items-center justify-content-center min-vh-75">
            
            {{-- Bagian Kiri: Teks & Animasi --}}
            <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-start animate__animated animate__fadeInLeft">
                <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-25 px-3 py-2 rounded-pill mb-3">
                    <i class="ph-fill ph-lock-key me-1"></i> Aman & Rahasia
                </span>
                <h1 class="display-4 hero-title mb-3">Layanan Aspirasi &<br>Pengaduan Online.</h1>
                <p class="text-secondary lead mb-4">
                    Sampaikan laporan Anda langsung kepada instansi pemerintah yang berwenang. Privasi Anda prioritas kami.
                </p>

                {{-- Ikon Floating Animasi --}}
                <div class="d-flex justify-content-center justify-content-lg-start py-4">
                    <i class="ph-duotone ph-megaphone-simple floating-icon"></i>
                </div>
            </div>

            {{-- Bagian Kanan: Form Pengaduan --}}
            <div class="col-lg-6 offset-lg-1 animate__animated animate__fadeInRight animate__delay-1s">
                <div class="glass-card p-4 p-md-5">
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="text-white fw-bold m-0">Tulis Laporan</h4>
                        <i class="ph-duotone ph-pencil-simple-line text-info fs-3"></i>
                    </div>

                    <form action="{{ route('laporan.store.public') }}" method="POST" id="formLaporan" onsubmit="return confirmSubmit(event)">
                        @csrf
                        <input type="hidden" name="is_public" value="1">

                        <div class="mb-3">
                            <label class="text-secondary mb-2 small fw-bold">Judul Laporan</label>
                            <input type="text" name="judul_laporan" class="form-control form-control-glass" placeholder="Ada masalah apa?" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-secondary mb-2 small fw-bold">Nama Pelapor</label>
                                <input type="text" name="penyusun" class="form-control form-control-glass" placeholder="Boleh samaran">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-secondary mb-2 small fw-bold">Tanggal</label>
                                <input type="date" name="tanggal_laporan" class="form-control form-control-glass" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-secondary mb-2 small fw-bold">Isi Laporan</label>
                            <textarea name="isi_laporan" class="form-control form-control-glass" rows="4" placeholder="Ceritakan kronologinya..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit-neon d-flex align-items-center justify-content-center gap-2">
                            <i class="ph-bold ph-paper-plane-right"></i> Kirim Sekarang
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <footer class="text-center text-secondary py-4 mt-5">
        <small class="opacity-50">&copy; {{ date('Y') }} Sistem Pengaduan Masyarakat.</small>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil Terkirim!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    background: '#1e293b',
                    color: '#fff',
                    confirmButtonColor: '#3b82f6',
                    confirmButtonText: 'Oke, Sipp!'
                    // Saya hapus bagian backdrop url confetti supaya aman dulu
                });
            @else
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, 
                    background: '#1e293b', color: '#fff', timerProgressBar: true
                });
                Toast.fire({ icon: 'info', title: 'Selamat Datang di Layanan Pengaduan' });
            @endif
        });

        function confirmSubmit(e) {
            e.preventDefault();
            const form = document.getElementById('formLaporan');
            if(!form.checkValidity()) {
                form.reportValidity();
                return false;
            }

            Swal.fire({
                title: 'Mengirim...',
                text: 'Mohon tunggu sebentar',
                icon: 'info', // Ganti icon jadi info biar aman
                timer: 2000,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#fff',
                didOpen: () => { Swal.showLoading(); }
            }).then(() => {
                form.submit();
            });
        }
    </script>

</body>
</html>