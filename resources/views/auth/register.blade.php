<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ForensicSys</title>
    
    {{-- CSS Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Glow (Nuansa Ungu untuk Register) */
        .bg-glow {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, rgba(15,23,42,0) 70%);
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 0; pointer-events: none;
        }

        /* Glass Card */
        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .brand-title {
            background: linear-gradient(to right, #a78bfa, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        /* === INPUT STYLING === */
        .form-control-glass {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff !important;
            border-radius: 12px;
            padding: 12px 16px 12px 45px;
            transition: all 0.3s;
        }
        .form-control-glass::placeholder { color: #94a3b8 !important; opacity: 1; }
        
        .form-control-glass:focus {
            background: rgba(15, 23, 42, 0.9);
            border-color: #8b5cf6; /* Fokus Ungu */
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
            color: #fff;
        }

        .input-icon {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1.2rem; transition: color 0.3s; z-index: 10;
        }
        .input-group:focus-within .input-icon { color: #8b5cf6; }

        /* Button Register (Gradient Ungu) */
        .btn-primary-glow {
            background: linear-gradient(135deg, #7c3aed, #3b82f6);
            border: none; color: white; font-weight: 700; padding: 12px;
            border-radius: 12px; width: 100%;
            box-shadow: 0 0 15px rgba(124, 58, 237, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 30px rgba(124, 58, 237, 0.6);
            color: white;
        }

        /* Divider */
        .divider { display: flex; align-items: center; text-align: center; margin: 25px 0; color: #64748b; font-size: 0.85rem; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .divider::before { margin-right: 10px; } .divider::after { margin-left: 10px; }

        /* === SOCIAL BUTTONS (Sama dengan Login) === */
        .social-btn {
            width: 55px; height: 55px; border-radius: 16px;
            background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer; text-decoration: none; color: #cbd5e1;
            position: relative; overflow: hidden;
        }
        .social-btn svg { width: 24px; height: 24px; }
        .social-btn:hover { transform: translateY(-5px) scale(1.05); color: white; }

        /* Brand Hovers */
        .btn-google:hover { background: rgba(234, 67, 53, 0.1); border-color: #ea4335; box-shadow: 0 5px 20px -5px rgba(234, 67, 53, 0.4); }
        .btn-github:hover { background: rgba(255, 255, 255, 0.1); border-color: #ffffff; box-shadow: 0 5px 20px -5px rgba(255, 255, 255, 0.3); }
        .btn-microsoft:hover { background: rgba(0, 164, 239, 0.1); border-color: #00a4ef; box-shadow: 0 5px 20px -5px rgba(0, 164, 239, 0.4); }

        .link-auth { color: #a78bfa; text-decoration: none; font-weight: 600; transition: color 0.2s; }
        .link-auth:hover { color: #c4b5fd; text-decoration: underline; }

        /* SweetAlert Custom */
        div:where(.swal2-container).swal2-center > .swal2-popup {
            background: rgba(15, 23, 42, 0.95) !important; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; box-shadow: 0 0 40px rgba(139, 92, 246, 0.2);
        }
        .swal-title-gradient { background: linear-gradient(to right, #f472b6, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
        .swal2-confirm {
            background: linear-gradient(135deg, #7c3aed, #3b82f6) !important; box-shadow: 0 0 15px rgba(124, 58, 237, 0.4) !important; border-radius: 12px !important; font-weight: bold !important;
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

    <div class="login-card animate__animated animate__fadeInDown">
        <div class="text-center mb-4">
            <div class="brand-title">Create Account</div>
            <p class="text-secondary small">Bergabung dengan ForensicSys hari ini.</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3 position-relative input-group">
                <i class="ph-bold ph-user input-icon"></i>
                <input type="text" name="name" class="form-control form-control-glass" placeholder="Full Name" required>
            </div>

            <div class="mb-3 position-relative input-group">
                <i class="ph-bold ph-envelope input-icon"></i>
                <input type="email" name="email" class="form-control form-control-glass" placeholder="Email Address" required>
            </div>

            <div class="mb-3 position-relative input-group">
                <i class="ph-bold ph-lock-key input-icon"></i>
                <input type="password" name="password" class="form-control form-control-glass" placeholder="Create Password" required>
            </div>

            <div class="mb-3 position-relative input-group">
                <i class="ph-bold ph-lock-key-open input-icon"></i>
                <input type="password" name="password_confirmation" class="form-control form-control-glass" placeholder="Confirm Password" required>
            </div>

            <div class="mb-4 form-check">
                <input class="form-check-input bg-dark border-secondary" type="checkbox" id="terms" required>
                <label class="form-check-label text-secondary small" for="terms">
                    Saya setuju dengan <a href="#" class="link-auth">Syarat & Ketentuan</a>
                </label>
            </div>

            <button type="submit" class="btn-primary-glow">
                Sign Up <i class="ph-bold ph-user-plus ms-1"></i>
            </button>
        </form>

        <div class="divider">atau daftar dengan</div>

        <div class="d-flex justify-content-center gap-3">
             <a href="#" class="social-btn btn-google" title="Google">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
            </a>
            
            <a href="#" class="social-btn btn-github" title="GitHub">
                <i class="ph-bold ph-github-logo"></i>
            </a>
            
            <a href="#" class="social-btn btn-microsoft" title="Microsoft">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#f25022" d="M1 1H11V11H1z"/><path fill="#00a4ef" d="M13 1H23V11H13z"/><path fill="#7fba00" d="M1 13H11V23H1z"/><path fill="#ffb900" d="M13 13H23V23H13z"/></svg>
            </a>
        </div>

        <div class="text-center mt-4">
            <p class="text-secondary small mb-0">
                Sudah punya akun? <a href="{{ route('login') }}" class="link-auth">Login disini</a>
            </p>
        </div>
    </div>

    {{-- SCRIPT: POPUP VALIDASI ERROR --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($errors->any())
                Swal.fire({
                    showClass: { popup: 'animate__animated animate__zoomInDown' },
                    hideClass: { popup: 'animate__animated animate__zoomOut' },
                    
                    // Gambar Kucing Kaget / Shocked Cat
                    imageUrl: 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExcDdtYWR3YmJ6YmJ6YmJ6YmJ6YmJ6YmJ6YmJ6YmJ6YmJ6/C21GGDOpKT6Z5JX656/giphy.gif', 
                    imageWidth: 200, imageHeight: 200, imageAlt: 'Waduh Error',
                    
                    title: '<span class="swal-title-gradient">Waduh, Gagal Daftar!</span>',
                    html: `
                        <div style="color: #cbd5e1; text-align: left; font-size: 0.95rem;">
                            Ada yang kurang pas nih datanya:<br>
                            <ul style="margin-top: 10px; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    `,
                    background: '#0f172a',
                    confirmButtonText: 'Oke, Saya Perbaiki',
                    buttonsStyling: false,
                    customClass: { confirmButton: 'swal2-confirm btn btn-lg text-white w-100 mt-3' },
                    backdrop: `rgba(15, 23, 42, 0.8) left top no-repeat`
                });
            @endif
        });
    </script>

</body>
</html>