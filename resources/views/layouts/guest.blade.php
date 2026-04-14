<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Halol') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --g1: #0a4f2e;
            --g2: #0d6b3c;
            --g3: #15a058;
            --accent: #4ade80;
            --white: #ffffff;
            --off: #f5f7f5;
            --muted: #6b7280;
            --border: rgba(0, 0, 0, 0.07);
            --card-shadow: 0 2px 16px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
            --card-shadow-hover: 0 8px 32px rgba(0, 0, 0, 0.10), 0 2px 8px rgba(0, 0, 0, 0.06);
            --radius: 14px;
            --radius-sm: 8px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--off);
            color: #111827;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── NAV ─── */
        nav {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 200;
            width: calc(100% - 48px);
            max-width: 1080px;
        }

        .nav-pill {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 99px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
            padding: 10px 14px 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--g2);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--g1);
            letter-spacing: -0.3px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link {
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--muted);
            padding: 8px 14px;
            border-radius: 99px;
            transition: background 0.2s, color 0.2s;
        }

        .nav-link:hover {
            background: var(--off);
            color: #111827;
        }

        .nav-cta {
            text-decoration: none;
            background: var(--g2);
            color: white;
            font-size: 13.5px;
            font-weight: 700;
            padding: 9px 18px;
            border-radius: 99px;
            transition: background 0.2s, transform 0.15s;
        }

        .nav-cta:hover {
            background: var(--g1);
            transform: translateY(-1px);
        }

        /* ─── HERO / PAGE WRAPPER ─── */
        .auth-hero {
            background: linear-gradient(160deg, var(--g1) 0%, var(--g2) 55%, #1d7a4a 100%);
            padding: 140px 24px 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .auth-hero-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.12) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .auth-hero-content {
            position: relative;
            z-index: 2;
        }

        .auth-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.92);
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.3px;
            padding: 7px 16px;
            border-radius: 99px;
            margin-bottom: 20px;
            animation: fadeUp 0.6s ease both;
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
            animation: pulse 2s ease infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(0.85);
            }
        }

        .auth-hero h1 {
            font-size: clamp(26px, 4vw, 42px);
            font-weight: 800;
            line-height: 1.15;
            color: white;
            letter-spacing: -1px;
            margin: 0 auto 10px;
            animation: fadeUp 0.7s 0.1s ease both;
        }

        .auth-hero h1 em {
            font-style: normal;
            color: var(--accent);
        }

        .auth-hero-sub {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.65);
            animation: fadeUp 0.7s 0.2s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─── AUTH CARD ─── */
        .auth-card-outer {
            display: flex;
            justify-content: center;
            padding: 0 24px 80px;
            margin-top: -56px;
            position: relative;
            z-index: 10;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .auth-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 16px 56px rgba(0, 0, 0, 0.14), 0 4px 16px rgba(0, 0, 0, 0.06);
            padding: 40px 44px;
            width: 100%;
            max-width: 480px;
        }

        .auth-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
            padding-bottom: 22px;
            border-bottom: 1px solid #f3f4f6;
        }

        .auth-card-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--g2), var(--g3));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .auth-card-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .auth-card-title {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: #111827;
        }

        .auth-card-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ─── FORM ELEMENTS ─── */
        .form-field {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 7px;
            letter-spacing: 0.1px;
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 11px;
            padding: 13px 16px;
            font-size: 14.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            outline: none;
            background: #f9fafb;
            color: #111827;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .form-input::placeholder {
            color: #c1c7d0;
            font-weight: 400;
        }

        .form-input:focus {
            border-color: var(--g2);
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 107, 60, 0.08);
        }

        .form-input.error-input {
            border-color: #fca5a5;
            background: #fff;
        }

        .form-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            font-weight: 500;
        }

        /* ─── CHECKBOX / LINKS ROW ─── */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13.5px;
            color: #374151;
            font-weight: 500;
        }

        .remember-label input[type=checkbox] {
            accent-color: var(--g2);
            width: 15px;
            height: 15px;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--g2);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.15s;
        }

        .forgot-link:hover {
            color: var(--g1);
            text-decoration: underline;
        }

        /* ─── SUBMIT BTN ─── */
        .submit-btn {
            width: 100%;
            background: linear-gradient(160deg, var(--g2), var(--g1));
            color: white;
            border: none;
            border-radius: 11px;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(13, 107, 60, 0.3);
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            letter-spacing: 0.1px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 107, 60, 0.38);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn svg {
            transition: transform 0.2s;
        }

        .submit-btn:hover svg {
            transform: translateX(3px);
        }

        /* ─── HALOL BADGE ─── */
        .halol-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px;
            background: #f0fdf4;
            border-radius: 10px;
            border: 1px solid #bbf7d0;
            margin-top: 20px;
        }

        .halol-badge-dot {
            width: 7px;
            height: 7px;
            background: var(--g3);
            border-radius: 50%;
            box-shadow: 0 0 6px rgba(21, 160, 88, 0.5);
        }

        .halol-badge-text {
            font-size: 12.5px;
            color: var(--g1);
            font-weight: 700;
        }

        /* ─── TOAST ─── */
        #toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .toast-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 14px;
            min-width: 300px;
            max-width: 380px;
            pointer-events: all;
            animation: toastIn 0.4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(40px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .toast-item.toast-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .toast-item.toast-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .toast-icon-wrap {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-success .toast-icon-wrap {
            background: #dcfce7;
        }

        .toast-error .toast-icon-wrap {
            background: #fee2e2;
        }

        .toast-body {
            flex: 1;
        }

        .toast-title {
            font-size: 13.5px;
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }

        .toast-success .toast-title {
            color: #15803d;
        }

        .toast-error .toast-title {
            color: #dc2626;
        }

        .toast-msg {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.5;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 14px;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            line-height: 1;
            align-self: flex-start;
            transition: color 0.15s;
        }

        .toast-close:hover {
            color: #374151;
        }

        @media (max-width: 600px) {
            .auth-card {
                padding: 28px 20px;
            }

            .auth-hero {
                padding: 120px 20px 80px;
            }

            nav {
                width: calc(100% - 32px);
            }

            .nav-pill {
                padding: 8px 10px 8px 16px;
            }

            #toast-container {
                top: 16px;
                right: 16px;
                left: 16px;
            }

            .toast-item {
                min-width: unset;
                max-width: unset;
            }
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <nav>
        <div class="nav-pill">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('halol/halol.jpg') }}" alt="Halol">
                </div>
                <span class="logo-name">Halol</span>
            </a>
            <div class="nav-right">
                <a href="/" class="nav-link">Bosh sahifa</a>
                <a href="#" class="nav-link">Tekshirish</a>
                <a href="#" class="nav-cta">Ro'yxatdan o'tish</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="auth-hero">
        <div class="auth-hero-grid"></div>
        <div class="auth-hero-glow"></div>
        <div class="auth-hero-content">
            <div class="auth-hero-badge">
                <span class="badge-dot"></span>
                Halol Sertifikatlangan Platforma
            </div>
            <h1>Xush kelibsiz, <em>Halol</em>ga!</h1>
            <p class="auth-hero-sub">Hisobingizga kiring va xizmatlardan foydalaning</p>
        </div>
    </div>

    <!-- Card -->
    <div class="auth-card-outer">
        <div class="auth-card">
            <div class="auth-card-header">
                <div class="auth-card-icon">
                    <img src="{{ asset('halol/halol.jpg') }}" alt="Halol">
                </div>
                <div>
                    <div class="auth-card-title">Tizimga kirish</div>
                    <div class="auth-card-subtitle">Email va parolingizni kiriting</div>
                </div>
            </div>

            {{ $slot }}

            <div class="halol-badge">
                <div class="halol-badge-dot"></div>
                <span class="halol-badge-text">Halol sertifikatlangan xavfsiz platforma</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 0 0 1.946-.806 3.42 3.42 0 0 1 4.438 0 3.42 3.42 0 0 0 1.946.806 3.42 3.42 0 0 1 3.138 3.138 3.42 3.42 0 0 0 .806 1.946 3.42 3.42 0 0 1 0 4.438 3.42 3.42 0 0 0-.806 1.946 3.42 3.42 0 0 1-3.138 3.138 3.42 3.42 0 0 0-1.946.806 3.42 3.42 0 0 1-4.438 0 3.42 3.42 0 0 0-1.946-.806 3.42 3.42 0 0 1-3.138-3.138 3.42 3.42 0 0 0-.806-1.946 3.42 3.42 0 0 1 0-4.438 3.42 3.42 0 0 0 .806-1.946 3.42 3.42 0 0 1 3.138-3.138z"
                        stroke="#0d6b3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container">
        @if (session('success'))
            <div class="toast-item toast-success">
                <div class="toast-icon-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#15803d"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </div>
                <div class="toast-body">
                    <span class="toast-title">Muvaffaqiyatli!</span>
                    <p class="toast-msg">{{ session('success') }}</p>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-item').remove()">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-item toast-error">
                <div class="toast-icon-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
                <div class="toast-body">
                    <span class="toast-title">Xatolik!</span>
                    <p class="toast-msg">{{ session('error') }}</p>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-item').remove()">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast-item toast-error">
                <div class="toast-icon-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <div class="toast-body">
                    <span class="toast-title">Xatoliklar mavjud</span>
                    <p class="toast-msg">{{ $errors->first() }}</p>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-item').remove()">✕</button>
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.toast-item').forEach((el, i) => {
            setTimeout(() => {
                el.style.transition = 'opacity .4s ease, transform .4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(40px)';
                setTimeout(() => el.remove(), 400);
            }, 4000 + i * 300);
        });
    </script>
</body>

</html>
