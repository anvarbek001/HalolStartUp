<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halol — Mahsulot Autentifikatsiyasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #0D6B3C;
            --green-dark: #094d2b;
            --green-light: #e8f5ee;
            --muted: #6b6b6b;
            --border: #e0e0e0;
            --white: #ffffff;
            --bg: #f8f9fa;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--bg);
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: var(--green);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .logo-icon img {
            width: 100%;
            border-radius: 8px;
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--green);
        }

        .logo-sub {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all .2s;
        }

        .btn-ghost {
            color: var(--muted);
        }

        .btn-ghost:hover {
            background: var(--bg);
        }

        .btn-primary {
            background: var(--green);
            color: white;
        }

        .btn-primary:hover {
            background: var(--green-dark);
        }

        .hero {
            background: linear-gradient(135deg, #094d2b 0%, #0D6B3C 60%, #17a35a 100%);
            color: white;
            padding: 80px 24px 96px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 99px;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: clamp(32px, 5vw, 54px);
            font-weight: 700;
            line-height: 1.15;
            max-width: 700px;
            margin: 0 auto 16px;
            letter-spacing: -0.5px;
        }

        .hero h1 span {
            color: #86efac;
        }

        .hero p {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.8);
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .verify-wrap {
            display: flex;
            justify-content: center;
            padding: 0 24px;
            margin-top: -52px;
            position: relative;
            z-index: 10;
        }

        .verify-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
            padding: 40px;
            width: 100%;
            max-width: 560px;
        }

        .verify-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .verify-card>p {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .serial-input {
            flex: 1;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 13px 16px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: border-color .2s;
            background: var(--bg);
        }

        .serial-input:focus {
            border-color: var(--green);
            background: white;
        }

        .verify-btn {
            background: var(--green);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px 24px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }

        .verify-btn:hover {
            background: var(--green-dark);
        }

        .result-box {
            margin-top: 20px;
            border-radius: 10px;
            padding: 16px 18px;
            display: none;
            align-items: flex-start;
            gap: 12px;
        }

        .result-box.visible {
            display: flex;
        }

        .result-box.success {
            background: var(--green-light);
            border: 1px solid #b2dfca;
        }

        .result-box.error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
        }

        .result-icon {
            font-size: 22px;
            flex-shrink: 0;
        }

        .result-title {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .result-box.success .result-title {
            color: var(--green);
        }

        .result-box.error .result-title {
            color: #dc2626;
        }

        .result-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.5;
        }

        .result-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .meta-tag {
            font-size: 12px;
            background: white;
            border: 1px solid #d1fae5;
            border-radius: 6px;
            padding: 3px 10px;
            color: var(--green);
            font-weight: 500;
        }

        .hints {
            margin-top: 16px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .hint-label {
            font-size: 12px;
            color: var(--muted);
        }

        .hint-chip {
            font-size: 12px;
            color: var(--muted);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 4px 10px;
            cursor: pointer;
            transition: all .15s;
            font-family: monospace;
        }

        .hint-chip:hover {
            border-color: var(--green);
            color: var(--green);
        }

        .section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 72px 24px;
        }

        .section-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 700;
            letter-spacing: -0.3px;
            margin-bottom: 12px;
        }

        .section-desc {
            font-size: 16px;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.6;
            margin-bottom: 48px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }

        .step-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px 24px;
            transition: box-shadow .2s;
        }

        .step-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--green);
            color: white;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .step-card h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .step-card p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.55;
        }

        .trust-section {
            background: var(--white);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .trust-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 32px;
            text-align: center;
        }

        .trust-item .num {
            font-size: 36px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: -1px;
        }

        .trust-item .lbl {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 26px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            transition: box-shadow .2s;
        }

        .feature-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--green-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .feature-card h3 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .feature-card p {
            font-size: 13.5px;
            color: var(--muted);
            line-height: 1.55;
        }

        .cta-section {
            background: linear-gradient(135deg, #094d2b, #0D6B3C);
            color: white;
            text-align: center;
            padding: 80px 24px;
        }

        .cta-section h2 {
            font-size: clamp(26px, 3vw, 40px);
            font-weight: 700;
            margin-bottom: 12px;
        }

        .cta-section p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            max-width: 420px;
            margin: 0 auto 32px;
            line-height: 1.6;
        }

        .cta-btn {
            display: inline-block;
            background: white;
            color: #094d2b;
            font-weight: 700;
            font-size: 15px;
            font-family: inherit;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            transition: transform .15s;
        }

        .cta-btn:hover {
            transform: translateY(-2px);
        }

        footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 28px 24px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        footer strong {
            color: var(--green);
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .verify-btn.loading .spinner {
            display: inline-block;
        }

        .verify-btn.loading .btn-txt {
            display: none;
        }

        @media (max-width: 600px) {
            .input-group {
                flex-direction: column;
            }

            .verify-card {
                padding: 28px 20px;
            }

            .hero {
                padding: 60px 20px 80px;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav>
        <div class="nav-inner">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <img src="build/assets/logos/halol_icon.jpg" alt="">
                </div>
                <div>
                    <div class="logo-text">Halol</div>
                    <div class="logo-sub">Autentifikatsiya tizimi</div>
                </div>
            </a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->brand)
                            <a href="{{ url('/dashboard') }}" class="btn-ghost">Mening panelim</a>
                        @else
                            <a href="{{ url('/brandRegister') }}" class="btn-ghost">Mening panelim</a>
                        @endif
                        @if (auth()->user()->status == 1)
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost">Kirish</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Ro'yxatdan o'tish</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-badge">✅ &nbsp;Ishonchli mahsulot tekshiruvi</div>
        <h1>Haqiqiy mahsulotni<br><span>soxtasidan ajrating</span></h1>
        <p>Halol brendi mahsulotlarining autentikligini bir soniyada tekshiring. Serial raqamni kiriting — natijani
            darhol bilib oling.</p>
    </section>

    {{-- VERIFY CARD --}}
    <div class="verify-wrap" id="verify">
        <div class="verify-card">
            <h2>📦 Mahsulotni tekshirish</h2>
            <p>Mahsulot qopqog'i yoki yorliqda yozilgan serial raqamni kiriting.</p>
            <div class="input-group">
                <input type="text" id="serialInput" class="serial-input" placeholder="HLB-2024-XXXXXX" maxlength="20"
                    autocomplete="off">
                <button class="verify-btn" onclick="checkSerial()" id="verifyBtn">
                    <span class="btn-txt">Tekshirish</span>
                    <span class="spinner"></span>
                </button>
            </div>
            <div class="hints">
                <span class="hint-label">Demo:</span>
                <span class="hint-chip" onclick="fillDemo('HLB-2024-A1B2C3')">HLB-2024-A1B2C3 ✅</span>
                <span class="hint-chip" onclick="fillDemo('FAKE-0000-000000')">FAKE-0000 ❌</span>
            </div>
            <div class="result-box success" id="resultSuccess">
                <span class="result-icon">✅</span>
                <div>
                    <div class="result-title">Mahsulot haqiqiy!</div>
                    <div class="result-desc">Ushbu mahsulot Halol brendining rasmiy mahsuloti hisoblanadi.</div>
                    <div class="result-meta">
                        <span class="meta-tag">🏭 O'zbekiston</span>
                        <span class="meta-tag">📅 Muddati: 2026</span>
                        <span class="meta-tag">🕌 Halol sertifikat</span>
                    </div>
                </div>
            </div>
            <div class="result-box error" id="resultError">
                <span class="result-icon">❌</span>
                <div>
                    <div class="result-title">Mahsulot topilmadi</div>
                    <div class="result-desc">Bu serial raqam bazada mavjud emas. Mahsulot soxta bo'lishi mumkin.
                        Murojaat: <strong>+998 71 200 00 00</strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- HOW IT WORKS --}}
    <section class="section" id="how">
        <div class="section-label">Qanday ishlaydi</div>
        <h2 class="section-title">3 ta oddiy qadam</h2>
        <p class="section-desc">Mahsulotni tekshirish hech qachon bu qadar oson bo'lmagan.</p>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">1</div>
                <h3>Serial raqamni toping</h3>
                <p>Mahsulot qopqog'i, yorliq yoki qutisidagi "S/N:" raqamni toping.</p>
            </div>
            <div class="step-card">
                <div class="step-num">2</div>
                <h3>Raqamni kiriting</h3>
                <p>Yuqoridagi qidiruv maydoniga serial raqamni kiriting va tekshiring.</p>
            </div>
            <div class="step-card">
                <div class="step-num">3</div>
                <h3>Natijani bilib oling</h3>
                <p>Tizim bir soniyada mahsulotning haqiqiy yoki soxta ekanini ko'rsatadi.</p>
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <div class="trust-section">
        <div class="trust-inner">
            <div class="trust-item">
                <div class="num">500K+</div>
                <div class="lbl">Tekshirilgan mahsulot</div>
            </div>
            <div class="trust-item">
                <div class="num">99.9%</div>
                <div class="lbl">Aniqlik darajasi</div>
            </div>
            <div class="trust-item">
                <div class="num">1 sek</div>
                <div class="lbl">O'rtacha tekshiruv vaqti</div>
            </div>
            <div class="trust-item">
                <div class="num">14+</div>
                <div class="lbl">Viloyatda mavjud</div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <section class="section">
        <div class="section-label">Nima uchun Halol</div>
        <h2 class="section-title">Sog'liq va ishonch — birinchi o'rinda</h2>
        <p class="section-desc">Soxta mahsulotlardan himoyalanish uchun eng ishonchli yechim.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <div>
                    <h3>Xavfsiz tekshiruv</h3>
                    <p>Har bir serial raqam kriptografik himoya ostida. Soxtalashtirish imkonsiz.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <div>
                    <h3>Bir soniyada natija</h3>
                    <p>Kuchli server infratuzilmasi yordamida tezkor tekshiruv.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <div>
                    <h3>To'liq ma'lumot</h3>
                    <p>Ishlab chiqarilgan sana, joy, muddati va boshqa muhim ma'lumotlar.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🕌</div>
                <div>
                    <h3>Halol sertifikat</h3>
                    <p>Barcha mahsulotlar rasmiy halol sertifikat olgan manbalardan.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🇺🇿</div>
                <div>
                    <h3>O'zbekistonda ishlab chiqarilgan</h3>
                    <p>Mahalliy ishlab chiqaruvchilar bilan sifat nazorati ostida.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📞</div>
                <div>
                    <h3>24/7 qo'llab-quvvatlash</h3>
                    <p>Muammo yuzaga kelsa, mutaxassislar doimo tayyor.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <h2>Mahsulotingizni hoziroq tekshiring</h2>
        <p>Sog'lig'ingiz uchun faqat haqiqiy Halol mahsulotlarini tanlang.</p>
        <button class="cta-btn"
            onclick="document.getElementById('serialInput').focus();window.scrollTo({top:300,behavior:'smooth'})">
            Tekshirishni boshlash →
        </button>
    </section>

    {{-- FOOTER --}}
    <footer>
        <p>&copy; {{ date('Y') }} <strong>Halol</strong> — Barcha huquqlar himoyalangan · O'zbekiston · +998 71 200
            00 00</p>
    </footer>

    <script>
        const validSerials = ['HLB-2024-A1B2C3', 'HLB-2025-Z4W9P2', 'HLB-2024-001234', 'HLB-2025-ABCDEF'];

        function fillDemo(val) {
            document.getElementById('serialInput').value = val;
            document.getElementById('resultSuccess').classList.remove('visible');
            document.getElementById('resultError').classList.remove('visible');
        }

        function checkSerial() {
            const input = document.getElementById('serialInput');
            const btn = document.getElementById('verifyBtn');
            const val = input.value.trim().toUpperCase();

            document.getElementById('resultSuccess').classList.remove('visible');
            document.getElementById('resultError').classList.remove('visible');

            if (!val) {
                input.style.borderColor = '#f87171';
                input.focus();
                setTimeout(() => input.style.borderColor = '', 1500);
                return;
            }

            btn.classList.add('loading');
            btn.disabled = true;

            // 🔁 Bu yerda real API chaqiruvini qo'shing: fetch('/api/verify', {...})
            setTimeout(() => {
                const isValid = validSerials.includes(val) || /^HLB-20\d{2}-[A-Z0-9]{6}$/.test(val);
                btn.classList.remove('loading');
                btn.disabled = false;
                document.getElementById(isValid ? 'resultSuccess' : 'resultError').classList.add('visible');
            }, 800);
        }

        document.getElementById('serialInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') checkSerial();
        });
    </script>
</body>

</html>
