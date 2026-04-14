<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Halol — Mahsulot Autentifikatsiyasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

        /* ─── PRODUCT CARD ─── */
        .product-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e5ebe5;
            box-shadow: 0 8px 32px rgba(13, 107, 60, 0.08);
            margin-top: 20px;
            animation: slideIn 0.4s ease both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-image-wrap {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            overflow: hidden;
        }

        .product-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .img-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(13, 107, 60, 0.15);
            border-radius: 8px;
            padding: 5px 11px;
            font-size: 12px;
            font-weight: 700;
            color: #0d6b3c;
        }

        .logo-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border-radius: 50%;
        }

        .logo-badge img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .product-body {
            padding: 22px 24px 24px;
        }

        .product-name {
            font-size: 19px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.3px;
        }

        .product-rating-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .star {
            font-size: 15px;
            color: #ccc;
        }

        .star.active {
            color: #f39c12;
        }

        .rating-val {
            font-size: 13.5px;
            font-weight: 700;
            color: #374151;
        }

        .rating-count {
            font-size: 12.5px;
            color: #9ca3af;
        }

        .product-divider {
            height: 1px;
            background: #f3f4f6;
            margin: 16px 0;
        }

        .product-desc {
            font-size: 13.5px;
            color: #6b7280;
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 18px;
            padding: 14px 16px;
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border: 1px solid #bbf7d0;
            border-radius: 12px;
        }

        .price-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .price-val {
            font-size: 22px;
            font-weight: 800;
            color: #0d6b3c;
            font-family: 'DM Mono', monospace;
        }

        .price-currency {
            font-size: 13px;
            font-weight: 600;
            color: #059669;
            margin-left: 3px;
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

        /* ─── BRANDS ─── */
        .brands-section {
            padding: 72px 24px;
            overflow: hidden;
        }

        .brands-inner {
            max-width: 1080px;
            margin: 0 auto;
            text-align: center;
        }

        .brands-title {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 32px;
        }

        .brands-track-wrap {
            position: relative;
            overflow: hidden;
        }

        .brands-track-wrap::before,
        .brands-track-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 80px;
            z-index: 2;
        }

        .brands-track-wrap::before {
            left: 0;
            background: linear-gradient(to right, var(--off), transparent);
        }

        .brands-track-wrap::after {
            right: 0;
            background: linear-gradient(to left, var(--off), transparent);
        }

        .brands-track {
            display: flex;
            gap: 20px;
            animation: scrollBrands 22s linear infinite;
            width: max-content;
        }

        .brands-track:hover {
            animation-play-state: paused;
        }

        @keyframes scrollBrands {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .brand-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 99px;
            padding: 12px 22px;
            box-shadow: var(--card-shadow);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .brand-pill-icon {
            font-size: 20px;
        }

        .brand_logo {
            width: 15px;
            height: 15px;
            border-radius: 50%;
        }


        .brand-pill-name {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .brand-pill-badge {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--g2);
            background: #dcfce7;
            border-radius: 99px;
            padding: 2px 8px;
        }

        /* ─── FAQ ─── */
        .faq-section {
            padding: 80px 24px;
        }

        .faq-inner {
            max-width: 720px;
            margin: 0 auto;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .faq-item {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.2s;
        }

        .faq-item:hover {
            box-shadow: var(--card-shadow-hover);
        }

        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            cursor: pointer;
            user-select: none;
            gap: 16px;
        }

        .faq-q-text {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .faq-chevron {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--off);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 13px;
            color: var(--muted);
            transition: transform 0.3s ease, background 0.2s;
        }

        .faq-item.open .faq-chevron {
            transform: rotate(180deg);
            background: #dcfce7;
            color: var(--g2);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.3s ease;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
            padding: 0 24px;
        }

        .faq-item.open .faq-answer {
            max-height: 300px;
            padding: 0 24px 20px;
        }

        /* ─── CONTACT ─── */
        .contact-section {
            padding: 0 24px 80px;
        }

        .contact-inner {
            max-width: 1080px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .contact-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .contact-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 13px;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .contact-label {
            font-size: 12px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }

        .contact-value {
            font-size: 17px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.2px;
        }

        .contact-hint {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        .contact-link {
            text-decoration: none;
            color: inherit;
            display: contents;
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
            background: #0d1117;
            padding: 56px 24px 32px;
        }

        .footer-top {
            max-width: 1080px;
            margin: 0 auto 40px;
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            gap: 40px;
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            text-decoration: none;
        }

        .footer-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--g2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .footer-brand-name {
            font-size: 18px;
            font-weight: 800;
            color: var(--accent);
        }

        .footer-brand-desc {
            font-size: 13.5px;
            color: #6b7280;
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .footer-socials {
            display: flex;
            gap: 10px;
        }

        .footer-social {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #1a2332;
            border: 1px solid #2d3748;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }

        .footer-social:hover {
            background: var(--g2);
            border-color: var(--g3);
            transform: translateY(-2px);
        }

        .footer-col-title {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #4b5563;
            margin-bottom: 16px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-link {
            font-size: 13.5px;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: var(--accent);
        }

        .footer-bottom {
            max-width: 1080px;
            margin: 0 auto;
            padding-top: 28px;
            border-top: 1px solid #1a2332;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 13px;
            color: #4b5563;
        }

        .footer-copy a {
            color: #6b7280;
            text-decoration: none;
        }

        .footer-copy a:hover {
            color: var(--accent);
        }

        .footer-bottom-badges {
            display: flex;
            gap: 8px;
        }

        .footer-badge {
            font-size: 11.5px;
            font-weight: 600;
            color: #4b5563;
            background: #1a2332;
            border: 1px solid #2d3748;
            border-radius: 6px;
            padding: 4px 10px;
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

            .contact-grid {
                grid-template-columns: 1fr;
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
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

            .footer-top {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
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

        .lang-select {
            appearance: none;
            -webkit-appearance: none;
            background: #f3f4f6 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 10px center;
            border: 1px solid #e5e7eb;
            border-radius: 99px;
            padding: 7px 30px 7px 12px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--g2);
            cursor: pointer;
            outline: none;
            transition: border-color 0.2s, background-color 0.2s;
        }

        .lang-select:hover {
            border-color: var(--g2);
            background-color: #f0fdf4;
        }

        .lang-select:focus {
            border-color: var(--g2);
            box-shadow: 0 0 0 3px rgba(13, 107, 60, 0.08);
        }
    </style>
</head>

<body>

    {{-- ─── NAVBAR ─── --}}
    <nav>
        <div class="nav-pill">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <img src="halol/halol.jpg" alt="Halol">
                </div>
                <span class="logo-name">Halol</span>
            </a>
            <div class="nav-right">
                {{-- til tugmalari --}}
                <div class="lang-switcher">
                    <select class="lang-select" onchange="location='/lang/'+this.value">
                        <option value="uz" {{ app()->getLocale() === 'uz' ? 'selected' : '' }}>🇺🇿 UZ</option>
                        <option value="ru" {{ app()->getLocale() === 'ru' ? 'selected' : '' }}>🇷🇺 RU</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇬🇧 EN</option>
                    </select>
                </div>
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->brand)
                            <a href="{{ url('/dashboard') }}" class="nav-link">{{ __('app.panel') }}</a>
                        @else
                            <a href="{{ url('/brandRegister') }}" class="nav-link">{{ __('app.panel') }}</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="nav-link">{{ __('app.login') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-cta">{{ __('app.register') }}</a>
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
                {{ __('app.reliable') }}
            </div>
            <h1>{{ __('app.hero_title_1') }}<br><em>{{ __('app.hero_title_2') }}</em></h1>
            <p class="hero-sub">{{ __('app.hero_sub') }}</p>
        </div>
    </section>

    {{-- ─── VERIFY CARD ─── --}}
    <div class="verify-outer" id="verify">
        <div class="verify-card">
            <div class="verify-card-header">
                <div class="verify-icon">📦</div>
                <div>
                    <div class="verify-title">{{ __('app.verify_title') }}</div>
                    <div class="verify-subtitle">{{ __('app.verify_sub') }}</div>
                </div>
            </div>
            <div class="input-row">
                <input type="text" id="serialInput" class="serial-input" placeholder="Masalan: 12345678901234"
                    maxlength="20" autocomplete="off">
                <button class="verify-btn" onclick="checkSerial()" id="verifyBtn">
                    <span class="btn-txt">{{ __('app.verify_btn') }}</span>
                    <span class="btn-arrow">→</span>
                    <span class="spinner"></span>
                </button>
            </div>
            <div class="demo-row">
                <span class="demo-label">Demo:</span>
                <span class="demo-chip" onclick="fillDemo('12345678909929')">12345678909929 ✅</span>
                <span class="demo-chip" onclick="fillDemo('FAKE-0000-000000')">FAKE-0000 ❌</span>
            </div>
            <div class="result-box success" id="resultSuccess">
                {{-- <div class="result-icon-wrap">✅</div> --}}
                <div style="width:100%">
                    <div class="result-title">{{ __('app.success_title') }}</div>
                    <div class="result-desc">{{ __('app.success_desc') }}</div>
                    <div class="result-tags">
                        <span class="rtag">O'zbekiston</span>
                        <span class="rtag">Halol sertifikat</span>
                    </div>
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <img id="party_image" src="" alt="Mahsulot">
                            <div class="img-badge">{{ __('app.img_badge') }}</div>
                            <div class="logo-badge"><img id="logo_brand" src="" alt=""></div>
                        </div>
                        <div class="product-body">
                            <div class="product-name" id="party_title"></div>
                            <div class="product-rating-row">
                                <div class="stars" id="star_container">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div>
                                <span class="rating-val" id="party_rating"></span>
                                <span class="rating-count">· {{ __('app.certified') }}</span>
                            </div>
                            <div class="product-divider"></div>
                            <div class="product-desc" id="description"></div>
                            <div class="product-price-row">
                                <div class="price-label">{{ __('app.price_label') }}</div>
                                <div>
                                    <span class="price-val" id="price"></span>
                                    <span class="price-currency">{{ __('app.price_currency') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="result-box error" id="resultError">
                <div class="result-icon-wrap">❌</div>
                <div>
                    <div class="result-title">{{ __('app.error_title') }}</div>
                    <div class="result-desc">{{ __('app.error_desc') }} Murojaat: <strong>+998 93 873 18
                            09</strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── STATS ─── --}}
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-num">500K+</div>
                <div class="stat-lbl">{{ __('app.checked_products') }}</div>
            </div>
            <div class="stat-card" style="transition-delay:0.1s">
                <div class="stat-num">99.9%</div>
                <div class="stat-lbl">{{ __('app.accuracy') }}</div>
            </div>
            <div class="stat-card" style="transition-delay:0.2s">
                <div class="stat-num">1 sek</div>
                <div class="stat-lbl">{{ __('app.avg_time') }}</div>
            </div>
            <div class="stat-card" style="transition-delay:0.3s">
                <div class="stat-num">12</div>
                <div class="stat-lbl">{{ __('app.regions') }}</div>
            </div>
        </div>
    </div>

    {{-- ─── HOW IT WORKS ─── --}}
    <section class="section" id="how">
        <div class="section-eyebrow reveal">{{ __('app.how_title') }}</div>
        <h2 class="section-heading reveal reveal-delay-1">{{ __('app.how_steps_title') }}</h2>
        <p class="section-sub reveal reveal-delay-2">{{ __('app.how_sub') }}</p>
        <div class="steps-grid">
            <div class="step-card reveal">
                <div class="step-num">1</div>
                <h3>{{ __('app.step1_title') }}</h3>
                <p>{{ __('app.step1_desc') }}</p>
            </div>
            <div class="step-card reveal reveal-delay-1">
                <div class="step-num">2</div>
                <h3>{{ __('app.step2_title') }}</h3>
                <p>{{ __('app.step2_desc') }}</p>
            </div>
            <div class="step-card reveal reveal-delay-2">
                <div class="step-num">3</div>
                <h3>{{ __('app.step3_title') }}</h3>
                <p>{{ __('app.step3_desc') }}</p>
            </div>
        </div>
    </section>

    {{-- ─── FEATURES ─── --}}
    <section class="features-section">
        <div class="features-inner">
            <div class="section-eyebrow reveal">{{ __('app.features_eyebrow') }}</div>
            <h2 class="section-heading reveal reveal-delay-1">{{ __('app.features_heading') }}</h2>
            <p class="section-sub reveal reveal-delay-2">{{ __('app.features_sub') }}</p>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon">🔒</div>
                    <h3>{{ __('app.feat1_title') }}</h3>
                    <p>{{ __('app.feat1_desc') }}</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon">⚡</div>
                    <h3>{{ __('app.feat2_title') }}</h3>
                    <p>{{ __('app.feat2_desc') }}</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon">📋</div>
                    <h3>{{ __('app.feat3_title') }}</h3>
                    <p>{{ __('app.feat3_desc') }}</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon">🕌</div>
                    <h3>{{ __('app.feat4_title') }}</h3>
                    <p>{{ __('app.feat4_desc') }}</p>
                </div>
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon">🇺🇿</div>
                    <h3>{{ __('app.feat5_title') }}</h3>
                    <p>{{ __('app.feat5_desc') }}</p>
                </div>
                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon">📞</div>
                    <h3>{{ __('app.feat6_title') }}</h3>
                    <p>{{ __('app.feat6_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── BRANDS ─── --}}
    <section class="brands-section">
        <div class="brands-inner">
            <div class="brands-title reveal">{{ __('app.brands_title') }}</div>
            <div class="brands-track-wrap">
                <div class="brands-track">
                    @foreach ($brands as $brand)
                        <div class="brand-pill"><span class="brand-pill-icon"><img
                                    src="{{ asset('storage/' . $brand->logo) }}" class="brand_logo"
                                    alt=""></span><span
                                class="brand-pill-name">{{ $brand->name }}</span><span class="brand-pill-badge">✓
                                Halol</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ─── FAQ ─── --}}
    <section class="faq-section" id="faq">
        <div class="faq-inner">
            <div class="section-eyebrow reveal" style="text-align:center">Ko'p so'raladigan savollar</div>
            <h2 class="section-heading reveal reveal-delay-1" style="text-align:center; margin-bottom:8px">Savol va
                javoblar</h2>
            <p class="section-sub reveal reveal-delay-2" style="text-align:center; margin:0 auto 40px">Bizga tez-tez
                beriladigan savollar va ularning javoblari.</p>

            <div class="faq-list">
                <div class="faq-item reveal">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-q-text">Serial raqam qayerda yozilgan bo'ladi?</span>
                        <span class="faq-chevron">▾</span>
                    </div>
                    <div class="faq-answer">Serial raqam odatda mahsulot qopqog'ining yon tomonida, yorliqda yoki
                        qutining tagida yozilgan bo'ladi. U "S/N:", "Ser:", yoki "№" belgisi bilan boshlanadi.</div>
                </div>
                <div class="faq-item reveal reveal-delay-1">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-q-text">Tekshirish pullikmi?</span>
                        <span class="faq-chevron">▾</span>
                    </div>
                    <div class="faq-answer">Yo'q, mahsulotni tekshirish mutlaqo bepul. Siz har qanday vaqtda,
                        cheklovsiz tekshirishingiz mumkin.</div>
                </div>
                <div class="faq-item reveal reveal-delay-2">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-q-text">Mahsulot topilmasa nima qilish kerak?</span>
                        <span class="faq-chevron">▾</span>
                    </div>
                    <div class="faq-answer">Agar mahsulot bazada topilmasa, bu mahsulot Halol tizimida ro'yxatdan
                        o'tmagan yoki soxta bo'lishi mumkin. Bunday holda +998 93 873 18 09 raqamiga murojaat qiling
                        yoki sotuvchiga qaytaring.</div>
                </div>
                {{-- <div class="faq-item reveal">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-q-text">Halol sertifikat nima va u qanchalik ishonchli?</span>
                        <span class="faq-chevron">▾</span>
                    </div>
                    <div class="faq-answer">Halol sertifikat mahsulotning Islom talablariga muvofiq tayyorlanganligini
                        tasdiqlovchi rasmiy hujjat. Bizning tizimimizdagi barcha brendlar O'zbekiston Halol markazi
                        tomonidan tekshirilgan va tasdiqlangan.</div>
                </div> --}}
                <div class="faq-item reveal reveal-delay-1">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span class="faq-q-text">Brendim Halol tizimiga qo'shilishi uchun nima qilish kerak?</span>
                        <span class="faq-chevron">▾</span>
                    </div>
                    <div class="faq-answer">Ro'yxatdan o'tish tugmasini bosing va kerakli ma'lumotlarni to'ldiring.
                        Bizning jamoamiz 1-2 ish kuni ichida siz bilan bog'lanadi va keyingi qadamlar haqida yo'riqnoma
                        beradi.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CONTACT ─── --}}
    <section class="contact-section" id="contact">
        <div class="contact-inner">
            <div class="section-eyebrow reveal">{{ __('app.contact') }}</div>
            <h2 class="section-heading reveal reveal-delay-1">{{ __('app.contact_title') }}</h2>
            <p class="section-sub reveal reveal-delay-2">{{ __('app.contact_sub') }}</p>
            <div class="contact-grid">
                <a href="tel:+998712000000" class="contact-link">
                    <div class="contact-card reveal">
                        <div class="contact-icon">📞</div>
                        <div>
                            <div class="contact-label">{{ __('app.contact_phone') }}</div>
                            <div class="contact-value">+998 93 873 18 09</div>
                            <div class="contact-hint">{{ __('app.contact_phone_hint') }}</div>
                        </div>
                    </div>
                </a>
                <a href="mailto:info@halol.uz" class="contact-link">
                    <div class="contact-card reveal reveal-delay-1">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <div class="contact-label">{{ __('app.contact_email') }}</div>
                            <div class="contact-value">info@halol.uz</div>
                            <div class="contact-hint">{{ __('app.contact_email_hint') }}</div>
                        </div>
                    </div>
                </a>
                <a href="https://t.me/haloluz" target="_blank" class="contact-link">
                    <div class="contact-card reveal reveal-delay-2">
                        <div class="contact-icon">✈️</div>
                        <div>
                            <div class="contact-label">{{ __('app.contact_tg') }}</div>
                            <div class="contact-value">@haloluz</div>
                            <div class="contact-hint">{{ __('app.contact_tg_hint') }}</div>
                        </div>
                    </div>
                </a>
                <div class="contact-card reveal reveal-delay-3">
                    <div class="contact-icon">📍</div>
                    <div>
                        <div class="contact-label">{{ __('app.contact_addr') }}</div>
                        <div class="contact-value">Toshkent sh.</div>
                        <div class="contact-hint">Amir Temur ko'chasi, 108</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CTA ─── --}}
    <section class="cta-section">
        <div class="cta-inner reveal">
            <h2>{{ __('app.cta_heading') }}</h2>
            <p>{{ __('app.cta_sub') }}</p>
            <button class="cta-btn"
                onclick="document.getElementById('serialInput').focus(); window.scrollTo({top: 320, behavior: 'smooth'})">{{ __('app.cta_btn') }}<span>→</span>
            </button>
        </div>
    </section>

    {{-- ─── FOOTER ─── --}}
    <footer>
        <div class="footer-top">
            <div>
                <a href="/" class="footer-brand-logo">
                    <div class="footer-brand-icon">🌿</div>
                    <span class="footer-brand-name">Halol</span>
                </a>
                <p class="footer-brand-desc">{{ __('app.footer_desc') }}</p>
                <div class="footer-socials">
                    <a href="https://t.me/Halol_Brendlar" target="_blank" class="footer-social" title="Telegram">
                        <i class="bi bi-telegram"></i>
                    </a>

                    <a href="https://www.instagram.com/halol_brand?igsh=eHowd3V3N2J4aGls" target="_blank"
                        class="footer-social" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>

                    {{-- 
                        <a href="https://facebook.com/haloluz" target="_blank" class="footer-social" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="https://youtube.com/@haloluz" target="_blank" class="footer-social" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    --}}
                </div>
            </div>

            <div>
                <div class="footer-col-title">{{ __('app.navigation') }}</div>
                <div class="footer-links">
                    <a href="#verify" class="footer-link">{{ __('app.footer_link_verify') }}</a>
                    <a href="#how" class="footer-link">{{ __('app.footer_link_how') }}</a>
                    <a href="#faq" class="footer-link">{{ __('app.footer_link_faq') }}</a>
                    <a href="#contact" class="footer-link">{{ __('app.footer_link_contact') }}</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">{{ __('app.brands_for') }}</div>
                <div class="footer-links">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="footer-link">Ro'yxatdan o'tish</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="footer-link">Kirish</a>
                    @endif
                    <a href="#" class="footer-link">{{ __('app.footer_link_price') }}</a>
                    <a href="#" class="footer-link">{{ __('app.footer_link_api') }}</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">{{ __('app.help') }}</div>
                <div class="footer-links">
                    <a href="tel:+998712000000" class="footer-link">+998 93 873 18 09</a>
                    <a href="mailto:info@halol.uz" class="footer-link">info@halol.uz</a>
                    <a href="#" class="footer-link">{{ __('app.footer_link_privacy') }}</a>
                    <a href="#" class="footer-link">{{ __('app.footer_link_terms') }}</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <span class="footer-copy">&copy; {{ date('Y') }} Halol. {{ __('app.footer_rights') }} · <a
                    href="#">O'zbekiston</a></span>
            <div class="footer-bottom-badges">
                <span class="footer-badge">{{ __('app.footer_badge_halol') }}</span>
                <span class="footer-badge">{{ __('app.footer_badge_made') }}</span>
            </div>
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
            const logoBrand = document.getElementById('logo_brand');
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

            function updateStars(rating) {
                const ratingValue = rating;

                const stars = document.querySelectorAll('#star_container .star');

                stars.forEach((star, index) => {
                    if (index < ratingValue) {
                        star.classList.add('active');
                    } else {
                        star.classList.remove('active');
                    }
                });
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
                        updateStars(data.rating);
                        document.getElementById('resultSuccess').classList.add('visible');
                        partyTitle.textContent = data.party_name;
                        partyRating.textContent = data.rating;
                        partyImage.src = data.image;
                        logoBrand.src = data.brand_logo;
                        partyDesc.textContent = data.description;
                        partyPrice.textContent = Number(data.price).toLocaleString('uz-UZ');
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

        /* ─── FAQ TOGGLE ─── */
        function toggleFaq(el) {
            const item = el.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        }

        /* ─── SCROLL REVEAL ─── */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll('.reveal, .stat-card').forEach(el => observer.observe(el));
    </script>
</body>

</html>
