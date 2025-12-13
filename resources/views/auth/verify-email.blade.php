<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - ForensicSys</title>
    
    {{-- CSS Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            color: #e2e8f0;
        }

        /* Background Glow (Hijau/Teal untuk Verifikasi) */
        .bg-glow {
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.15) 0%, rgba(15,23,42,0) 70%);
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 0; pointer-events: none;
        }

        /* Glass Card */
        .card-glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%; max-width: 500px;
            text-align: center;
            position: relative; z-index: 1;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Typography */
        .brand-gradient {
            background: linear-gradient(to right, #2dd4bf, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* Floating Icon Animation */
        .floating-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: inline-block;
            background: linear-gradient(135deg, #2dd4bf, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 0 15px rgba(45, 212, 191, 0.3));
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* Button Glow */
        .btn-glow {
            background: linear-gradient(135deg, #0d9488, #2563eb);
            border: none; color: white; font-weight: 700; padding: 12px 30px;
            border-radius: 12px; width: 100%;
            box-shadow: 0 0 20px rgba(13, 148, 136, 0.3);
            transition: all 0.3s;
        }
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(13, 148, 136, 0.5);
            color: white;
        }

        .btn-logout {
            color: #94a3b8; font-size: 0.9rem; font-weight: 500;
            transition: color 0.2s;
        }
        .btn-logout:hover { color: #f87171; text-decoration: none; }

        /* SweetAlert Custom */
        div:where(.swal2-container).swal2-center > .swal2-popup {
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(255,255,255,0.1); border-radius: 24px;
            box-shadow: 0 0 40px rgba(45, 212, 191, 0.2);
        }
        .swal-title-custom { color: #fff; font-weight: 800; }
        .swal2-confirm {
            background: linear-gradient(135deg, #0d9488, #2563eb) !important;
            box-shadow: 0 0 15px rgba(13, 148, 136, 0.4) !important;
            border-radius: 12px !important;
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

    <div class="card-glass animate__animated animate__zoomIn">
        <i class="ph-duotone ph-paper-plane-tilt floating-icon"></i>
        
        <h2 class="mb-3 brand-gradient">Cek Email Kamu!</h2>
        
        <p class="text-secondary mb-4" style="line-height: 1.6;">
            Terima kasih telah bergabung! 🚀<br>
            Kami telah mengirimkan link verifikasi ke alamat email kamu. <br>
            <span class="text-white small opacity-75">(Jangan lupa cek folder Spam juga ya!)</span>
        </p>

        <div class="d-flex flex-column gap-3">
            {{-- Form Resend --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-glow">
                    <i class="ph-bold ph-envelope-simple-open me-2"></i> Kirim Ulang Link
                </button>
            </form>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link btn-logout text-decoration-none">
                    <i class="ph-bold ph-sign-out me-1"></i> Bukan akun kamu? Logout
                </button>
            </form>
        </div>
    </div>

    {{-- SCRIPT: POPUP LUCU KETIKA SUKSES KIRIM ULANG --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek session status dari Laravel Fortify/Breeze
            @if (session('status') == 'verification-link-sent')
                Swal.fire({
                    // Animasi Masuk
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' },

                    // GIF Lucu (Surat Meluncur Cepat / Rocket)
                    imageUrl: 'https://media.giphy.com/media/13HgwGsXf0aiGY/giphy.gif', 
                    imageWidth: 250, imageHeight: 180, imageAlt: 'Sent!',
                    
                    title: '<span class="swal-title-custom">Wushhh! 🚀</span>',
                    html: '<span style="color: #cbd5e1;">Email verifikasi baru sudah meluncur ke inbox kamu. Cek sekarang ya!</span>',
                    
                    confirmButtonText: 'Siap Kapten!',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'swal2-confirm btn btn-lg text-white w-100 mt-3' },
                    backdrop: `rgba(15, 23, 42, 0.8) left top no-repeat`
                });
            @endif
        });
    </script>

</body>
</html>