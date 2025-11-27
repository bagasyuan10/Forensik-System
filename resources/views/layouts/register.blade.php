<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ForensicSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        body {
            background: #0f172a;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh; /* Min height agar bisa scroll jika form panjang */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .bg-glow {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.15) 0%, rgba(15,23,42,0) 70%); /* Sedikit ungu */
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 0; pointer-events: none;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 460px; /* Sedikit lebih lebar */
            position: relative;
            z-index: 1;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .brand-title {
            background: linear-gradient(to right, #22d3ee, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            font-size: 1.8rem;
        }

        .form-control-glass {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 12px;
            padding: 12px 16px 12px 45px;
            transition: all 0.3s;
        }
        .form-control-glass:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #8b5cf6; /* Fokus warna ungu */
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
            color: #fff;
        }

        .input-icon {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1.2rem; transition: color 0.3s;
        }
        .input-group:focus-within .input-icon { color: #8b5cf6; }

        .btn-primary-glow {
            background: linear-gradient(135deg, #8b5cf6, #3b82f6); /* Gradient Ungu-Biru */
            border: none; color: white; font-weight: 700; padding: 12px;
            border-radius: 12px; width: 100%;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.5);
            color: white;
        }

        .divider {
            display: flex; align-items: center; text-align: center; margin: 25px 0;
            color: #64748b; font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .divider::before { margin-right: 10px; }
        .divider::after { margin-left: 10px; }

        .social-btn {
            width: 50px; height: 50px; border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex; align-items: center; justify-content: center;
            color: #cbd5e1; font-size: 1.5rem; transition: all 0.3s;
            cursor: pointer; text-decoration: none;
        }
        .social-btn:hover {
            background: rgba(255, 255, 255, 0.1); transform: translateY(-3px);
            color: white; border-color: rgba(255, 255, 255, 0.3);
        }
        .link-auth { color: #8b5cf6; text-decoration: none; font-weight: 600; }
        .link-auth:hover { color: #a78bfa; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-title">Create Account</div>
            <p class="text-secondary small">Bergabung dengan ForensicSys.</p>
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
            <a href="#" class="social-btn" title="Google">
                <i class="ph-bold ph-google-logo"></i>
            </a>
            <a href="#" class="social-btn" title="GitHub">
                <i class="ph-bold ph-github-logo"></i>
            </a>
            <a href="#" class="social-btn" title="Microsoft">
                <i class="ph-bold ph-microsoft-logo"></i>
            </a>
        </div>

        <div class="text-center mt-4">
            <p class="text-secondary small mb-0">
                Sudah punya akun? <a href="{{ route('login') }}" class="link-auth">Login disini</a>
            </p>
        </div>
    </div>

</body>
</html>