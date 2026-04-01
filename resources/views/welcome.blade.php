<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Halol — Mahsulot Autentifikatsiyasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=dm-mono:400,500"
        rel="stylesheet" />
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

        /* ─── HERO ─── */
        .hero {
            background: linear-gradient(160deg, var(--g1) 0%, var(--g2) 55%, #1d7a4a 100%);
            padding: 160px 24px 120px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .hero-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.12) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
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
            margin-bottom: 28px;
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

        .hero h1 {
            font-size: clamp(34px, 5.5vw, 58px);
            font-weight: 800;
            line-height: 1.1;
            color: white;
            letter-spacing: -1.5px;
            max-width: 680px;
            margin: 0 auto 18px;
            animation: fadeUp 0.7s 0.1s ease both;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--accent);
        }

        .hero-sub {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.65;
            max-width: 460px;
            margin: 0 auto;
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

        /* ─── VERIFY CARD ─── */
        .verify-outer {
            display: flex;
            justify-content: center;
            padding: 0 24px;
            margin-top: -64px;
            position: relative;
            z-index: 10;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .verify-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 16px 56px rgba(0, 0, 0, 0.14), 0 4px 16px rgba(0, 0, 0, 0.06);
            padding: 40px 44px;
            width: 100%;
            max-width: 580px;
        }

        .verify-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .verify-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--g2), var(--g3));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .verify-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .verify-subtitle {
            font-size: 13.5px;
            color: var(--muted);
            margin-top: 2px;
        }

        .input-row {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .serial-input {
            flex: 1;
            border: 1.5px solid #e5e7eb;
            border-radius: 11px;
            padding: 14px 18px;
            font-size: 15px;
            font-family: 'DM Mono', monospace;
            font-weight: 500;
            letter-spacing: 0.5px;
            outline: none;
            background: #f9fafb;
            color: #111827;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .serial-input::placeholder {
            color: #c1c7d0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            letter-spacing: 0;
        }

        .serial-input:focus {
            border-color: var(--g2);
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 107, 60, 0.08);
        }

        .verify-btn {
            background: linear-gradient(160deg, var(--g2), var(--g1));
            color: white;
            border: none;
            border-radius: 11px;
            padding: 14px 26px;
            font-size: 14.5px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 16px rgba(13, 107, 60, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .verify-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(13, 107, 60, 0.38);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .verify-btn:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
        }

        .btn-arrow {
            transition: transform 0.2s;
        }

        .verify-btn:hover .btn-arrow {
            transform: translateX(3px);
        }

        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .verify-btn.loading .spinner {
            display: block;
        }

        .verify-btn.loading .btn-txt {
            display: none;
        }

        .verify-btn.loading .btn-arrow {
            display: none;
        }

        .demo-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 14px;
        }

        .demo-label {
            font-size: 12px;
            color: #c1c7d0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .demo-chip {
            font-size: 12px;
            color: var(--muted);
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            padding: 5px 12px;
            cursor: pointer;
            font-family: 'DM Mono', monospace;
            transition: all 0.15s;
        }

        .demo-chip:hover {
            border-color: var(--g2);
            color: var(--g2);
            background: #f0fdf4;
        }

        /* ─── RESULT ─── */
        .result-box {
            margin-top: 18px;
            border-radius: 12px;
            padding: 16px 18px;
            display: none;
            align-items: flex-start;
            gap: 14px;
            animation: resultIn 0.3s ease;
        }

        @keyframes resultIn {
            from {
                opacity: 0;
                transform: translateY(6px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .result-box.visible {
            display: flex;
        }

        .result-box.success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .result-box.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .result-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .result-box.success .result-icon-wrap {
            background: #dcfce7;
        }

        .result-box.error .result-icon-wrap {
            background: #fee2e2;
        }

        .result-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .result-box.success .result-title {
            color: #15803d;
        }

        .result-box.error .result-title {
            color: #dc2626;
        }

        .result-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.55;
        }

        .result-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }

        .rtag {
            font-size: 11.5px;
            font-weight: 600;
            background: white;
            border: 1px solid #d1fae5;
            color: #166534;
            border-radius: 6px;
            padding: 3px 10px;
        }

        /* ─── STATS ─── */
        .stats-section {
            max-width: 1080px;
            margin: 72px auto 0;
            padding: 0 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px 24px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            opacity: 0;
            transform: translateY(20px);
        }

        .stat-card.visible {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.5s ease, transform 0.5s ease, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-num {
            font-size: 38px;
            font-weight: 800;
            color: var(--g2);
            letter-spacing: -1.5px;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-lbl {
            font-size: 13px;
            color: var(--muted);
            font-weight: 500;
        }

        /* ─── HOW ─── */
        .section {
            max-width: 1080px;
            margin: 0 auto;
            padding: 80px 24px;
        }

        .section-eyebrow {
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--g2);
            margin-bottom: 10px;
        }

        .section-heading {
            font-size: clamp(26px, 3vw, 38px);
            font-weight: 800;
            letter-spacing: -0.8px;
            line-height: 1.15;
            margin-bottom: 12px;
        }

        .section-sub {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.65;
            max-width: 480px;
            margin-bottom: 48px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .step-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px 28px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .step-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--g2), var(--g3));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .step-card:hover::after {
            transform: scaleX(1);
        }

        .step-num {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--g2), var(--g3));
            color: white;
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 4px 12px rgba(13, 107, 60, 0.3);
        }

        .step-card h3 {
            font-size: 16.5px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.2px;
        }

        .step-card p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ─── FEATURES ─── */
        .features-section {
            background: linear-gradient(160deg, var(--g1) 0%, var(--g2) 100%);
            padding: 80px 24px;
        }

        .features-inner {
            max-width: 1080px;
            margin: 0 auto;
        }

        .features-section .section-eyebrow {
            color: var(--accent);
        }

        .features-section .section-heading {
            color: white;
        }

        .features-section .section-sub {
            color: rgba(255, 255, 255, 0.65);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: var(--radius);
            padding: 28px;
            transition: background 0.2s, transform 0.2s;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.11);
            transform: translateY(-3px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .feature-card h3 {
            font-size: 15.5px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        /* ─── CTA ─── */
        .cta-section {
            padding: 80px 24px;
            text-align: center;
        }

        .cta-inner {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 56px 48px;
            box-shadow: var(--card-shadow);
        }

        .cta-inner h2 {
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 800;
            letter-spacing: -0.6px;
            margin-bottom: 12px;
        }

        .cta-inner p {
            font-size: 15.5px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(160deg, var(--g2), var(--g1));
            color: white;
            font-weight: 700;
            font-size: 15px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 15px 32px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(13, 107, 60, 0.32);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(13, 107, 60, 0.4);
        }

        .cta-btn span {
            transition: transform 0.2s;
        }

        .cta-btn:hover span {
            transform: translateX(3px);
        }

        /* ─── FOOTER ─── */
        footer {
            background: #111827;
            padding: 28px 24px;
            text-align: center;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .footer-logo {
            font-size: 16px;
            font-weight: 800;
            color: var(--accent);
        }

        .footer-sep {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #374151;
        }

        .footer-text {
            font-size: 13px;
            color: #6b7280;
        }

        .footer-text a {
            color: #9ca3af;
            text-decoration: none;
        }

        .footer-text a:hover {
            color: var(--accent);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 860px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            nav {
                width: calc(100% - 32px);
            }

            .nav-pill {
                padding: 8px 10px 8px 16px;
            }

            .verify-card {
                padding: 28px 22px;
            }

            .input-row {
                flex-direction: column;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .cta-inner {
                padding: 36px 24px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero {
                padding: 140px 20px 100px;
            }
        }

        /* ─── SCROLL REVEAL ─── */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }
    </style>
</head>

<body>

    {{-- ─── NAVBAR ─── --}}
    <nav>
        <div class="nav-pill">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <img src="halol/halol.jpg" alt="Halol">
                </div>
                <span class="logo-name">Halol</span>
            </a>
            <div class="nav-right">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->brand)
                            <a href="{{ url('/dashboard') }}" class="nav-link">Mening panelim</a>
                        @else
                            <a href="{{ url('/brandRegister') }}" class="nav-link">Mening panelim</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Kirish</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-cta">Ro'yxatdan o'tish</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- ─── HERO ─── --}}
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-glow"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                Ishonchli mahsulot tekshiruvi
            </div>
            <h1>Haqiqiy mahsulotni<br><em>soxtasidan ajrating</em></h1>
            <p class="hero-sub">Serial raqamni kiriting va mahsulotning Halol brendiga tegishliligini bir soniyada bilib
                oling.</p>
        </div>
    </section>

    {{-- ─── VERIFY CARD ─── --}}
    <div class="verify-outer" id="verify">
        <div class="verify-card">
            <div class="verify-card-header">
                <div class="verify-icon">📦</div>
                <div>
                    <div class="verify-title">Mahsulotni tekshirish</div>
                    <div class="verify-subtitle">Qopqoq yoki yorliqdagi serial raqamni kiriting</div>
                </div>
            </div>
            <div class="input-row">
                <input type="text" id="serialInput" class="serial-input" placeholder="Masalan: 12345678901234"
                    maxlength="20" autocomplete="off">
                <button class="verify-btn" onclick="checkSerial()" id="verifyBtn">
                    <span class="btn-txt">Tekshirish</span>
                    <span class="btn-arrow">→</span>
                    <span class="spinner"></span>
                </button>
            </div>
            <div class="demo-row">
                <span class="demo-label">Demo:</span>
                <span class="demo-chip" onclick="fillDemo('12345678904374')">12345678904374 ✅</span>
                <span class="demo-chip" onclick="fillDemo('FAKE-0000-000000')">FAKE-0000 ❌</span>
            </div>
            <div class="result-box success" id="resultSuccess">
                <div class="result-icon-wrap">✅</div>
                <div>
                    <div class="result-title">Mahsulot haqiqiy!</div>
                    <div class="result-desc">Ushbu mahsulot Halol brendining rasmiy mahsuloti hisoblanadi va sifat
                        nazoratidan o'tgan.</div>
                    <div class="result-tags">
                        <span class="rtag">🏭 O'zbekiston</span>
                        <span class="rtag">🕌 Halol sertifikat</span>
                    </div>
                    <div style="margin-top: 4px;">
                        <div>
                            <img id="party_image" src="" alt="">
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div>Mahsulot nomi:</div>
                            <div id="party_title"></div>|
                            <div>Reyting:</div>
                            <div id="party_rating"></div>
                        </div>
                        <div>
                            <p id="description"></p>
                        </div>
                        <div id="price">

                        </div>
                    </div>
                </div>
            </div>
            <div class="result-box error" id="resultError">
                <div class="result-icon-wrap">❌</div>
                <div>
                    <div class="result-title">Mahsulot topilmadi</div>
                    <div class="result-desc">Bu serial raqam bazada mavjud emas. Murojaat: <strong>+998 71 200 00
                            00</strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── STATS ─── --}}
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-num">500K+</div>
                <div class="stat-lbl">Tekshirilgan mahsulot</div>
            </div>
            <div class="stat-card" style="transition-delay:0.1s">
                <div class="stat-num">99.9%</div>
                <div class="stat-lbl">Aniqlik darajasi</div>
            </div>
            <div class="stat-card" style="transition-delay:0.2s">
                <div class="stat-num">1 sek</div>
                <div class="stat-lbl">O'rtacha tekshiruv vaqti</div>
            </div>
            <div class="stat-card" style="transition-delay:0.3s">
                <div class="stat-num">14+</div>
                <div class="stat-lbl">Viloyatda mavjud</div>
            </div>
        </div>
    </div>

    {{-- ─── HOW IT WORKS ─── --}}
    <section class="section" id="how">
        <div class="section-eyebrow reveal">Qanday ishlaydi</div>
        <h2 class="section-heading reveal reveal-delay-1">3 ta oddiy qadam</h2>
        <p class="section-sub reveal reveal-delay-2">Mahsulotni tekshirish hech qachon bu qadar oson bo'lmagan.</p>
        <div class="steps-grid">
            <div class="step-card reveal">
                <div class="step-num">1</div>
                <h3>Serial raqamni toping</h3>
                <p>Mahsulot qopqog'i, yorliq yoki qutisidagi "S/N:" raqamni toping.</p>
            </div>
            <div class="step-card reveal reveal-delay-1">
                <div class="step-num">2</div>
                <h3>Raqamni kiriting</h3>
                <p>Yuqoridagi qidiruv maydoniga serial raqamni kiriting va tekshiring.</p>
            </div>
            <div class="step-card reveal reveal-delay-2">
                <div class="step-num">3</div>
                <h3>Natijani bilib oling</h3>
                <p>Tizim bir soniyada mahsulotning haqiqiy yoki soxta ekanini ko'rsatadi.</p>
            </div>
        </div>
    </section>

    {{-- ─── FEATURES ─── --}}
    <section class="features-section">
        <div class="features-inner">
            <div class="section-eyebrow reveal">Nima uchun Halol</div>
            <h2 class="section-heading reveal reveal-delay-1">Sog'liq va ishonch — birinchi o'rinda</h2>
            <p class="section-sub reveal reveal-delay-2">Soxta mahsulotlardan himoyalanish uchun eng ishonchli yechim.
            </p>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon">🔒</div>
                    <h3>Xavfsiz tekshiruv</h3>
                    <p>Har bir serial raqam kriptografik himoya ostida. Soxtalashtirish imkonsiz.</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon">⚡</div>
                    <h3>Bir soniyada natija</h3>
                    <p>Kuchli server infratuzilmasi yordamida tezkor va ishonchli tekshiruv.</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon">📋</div>
                    <h3>To'liq ma'lumot</h3>
                    <p>Ishlab chiqarilgan sana, joy, muddati va boshqa muhim ma'lumotlar.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">🕌</div>
                    <h3>Halol sertifikat</h3>
                    <p>Barcha mahsulotlar rasmiy halol sertifikat olgan manbalardan keltiriladi.</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon">🇺🇿</div>
                    <h3>Mahalliy ishlab chiqaruv</h3>
                    <p>O'zbekiston ishlab chiqaruvchilari bilan sifat nazorati ostida ishlaydi.</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon">📞</div>
                    <h3>24/7 qo'llab-quvvatlash</h3>
                    <p>Muammo yuzaga kelsa, mutaxassislar sizga yordam berishga doim tayyor.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CTA ─── --}}
    <section class="cta-section">
        <div class="cta-inner reveal">
            <h2>Mahsulotingizni hoziroq tekshiring</h2>
            <p>Sog'lig'ingiz uchun faqat haqiqiy Halol mahsulotlarini tanlang. Tekshirish bepul va bir soniyada.</p>
            <button class="cta-btn"
                onclick="document.getElementById('serialInput').focus(); window.scrollTo({top: 320, behavior: 'smooth'})">
                Tekshirishni boshlash <span>→</span>
            </button>
        </div>
    </section>

    {{-- ─── FOOTER ─── --}}
    <footer>
        <div class="footer-inner">
            <span class="footer-logo">Halol</span>
            <span class="footer-sep"></span>
            <span class="footer-text">&copy; {{ date('Y') }} Barcha huquqlar himoyalangan</span>
            <span class="footer-sep"></span>
            <span class="footer-text">O'zbekiston</span>
            <span class="footer-sep"></span>
            <span class="footer-text"><a href="tel:+998712000000">+998 71 200 00 00</a></span>
        </div>
    </footer>

    <script>
        /* ─── SERIAL CHECK ─── */
        function fillDemo(val) {
            document.getElementById('serialInput').value = val;
            document.getElementById('resultSuccess').classList.remove('visible');
            document.getElementById('resultError').classList.remove('visible');
        }

        function checkSerial() {
            const input = document.getElementById('serialInput');
            const btn = document.getElementById('verifyBtn');
            const partyTitle = document.getElementById('party_title');
            const partyRating = document.getElementById('party_rating');
            const partyImage = document.getElementById('party_image');
            const partyDesc = document.getElementById('description');
            const partyPrice = document.getElementById('price');
            const val = input.value.trim().toUpperCase();

            document.getElementById('resultSuccess').classList.remove('visible');
            document.getElementById('resultError').classList.remove('visible');

            if (!val) {
                input.style.borderColor = '#fca5a5';
                input.focus();
                setTimeout(() => input.style.borderColor = '', 1800);
                return;
            }

            btn.classList.add('loading');
            btn.disabled = true;

            fetch('/products/check', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        qrcode: val
                    })
                })
                .then(res => res.json())
                .then(data => {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                    if (data.success) {
                        document.getElementById('resultSuccess').classList.add('visible');
                        partyTitle.textContent = data.party_name
                        partyRating.textContent = data.rating
                        partyImage.src = data.image;
                        partyDesc.textContent = data.description
                        partyPrice.textContent = data.price
                    } else {
                        document.getElementById('resultError').classList.add('visible');
                    }
                })
                .catch(() => {
                    btn.classList.remove('loading');
                    btn.disabled = false;
                    document.getElementById('resultError').classList.add('visible');
                });
        }

        document.getElementById('serialInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') checkSerial();
        });

        /* ─── SCROLL REVEAL ─── */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll('.reveal, .stat-card').forEach(el => observer.observe(el));
    </script>
</body>

</html>
