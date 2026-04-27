<!DOCTYPE html>
<html lang="uz" x-data="adminPanel()" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | Dashboard</title>
    @use('App\Enums\BrendStatus')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif']
                    },
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            100: '#dbe4ff',
                            200: '#bac8ff',
                            300: '#91a7ff',
                            400: '#748ffc',
                            500: '#5c7cfa',
                            600: '#4c6ef5',
                            700: '#4263eb',
                            800: '#3b5bdb',
                            900: '#364fc7'
                        },
                        accent: '#ff6b6b',
                        surface: {
                            light: '#f8faff',
                            dark: '#0f1117'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn .5s ease forwards',
                        'slide-in': 'slideIn .4s ease forwards'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        slideIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(-20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Syne', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, .7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, .4);
        }

        .dark .glass {
            background: rgba(15, 17, 23, .7);
            border-color: rgba(255, 255, 255, .08);
        }

        .sidebar-item {
            position: relative;
            transition: all .25s cubic-bezier(.4, 0, .2, 1);
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #5c7cfa, #ff6b6b);
            border-radius: 0 4px 4px 0;
            transition: transform .25s ease;
        }

        .sidebar-item.active::before,
        .sidebar-item:hover::before {
            transform: translateY(-50%) scaleY(1);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -40%;
            right: -20%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            opacity: .08;
            background: currentColor;
        }

        .menu-transition {
            transition: all .35s cubic-bezier(.4, 0, .2, 1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #5c7cfa 0%, #ff6b6b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .progress-bar {
            transition: width 1.2s cubic-bezier(.4, 0, .2, 1);
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #4c6ef5;
            border-radius: 99px;
        }

        .click_logo {
            padding: 4px 10px;
            cursor: pointer;
            color: #fff;
            font-size: 13px;
            font-family: Arial;
            font-weight: bold;
            border: 1px solid #037bc8;
            border-radius: 4px;
            background: linear-gradient(#27a8e0 0%, #1c8ed7 100%);
            box-shadow: inset 0 1px 0 #45c4fc;
        }

        #pay-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(4px);
            z-index: 9998;
        }

        #pay-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        #pay-modal.open {
            display: flex;
        }

        #pay-backdrop.open {
            display: block;
        }
    </style>
</head>

<body class="bg-surface-light dark:bg-surface-dark text-gray-800 dark:text-gray-100 min-h-screen">

    {{-- ══ Route va config ma'lumotlari — JS uchun alohida, PHP bilan aralashmaydi ══ --}}
    <script>
        window.APP = {
            routes: {
                dashboard: "{{ route('dashboard') }}",
                parties: "{{ route('parties') }}",
                histories: "{{ route('histories') }}",
                help: "{{ route('help') }}",
                @if (auth()->check() && auth()->user()->name === 'adminstrator')
                    admin: "{{ route('admin') }}",
                @else
                    admin: null,
                @endif
            },
            click: {
                serviceId: "{{ env('CLICK_SERVICE_ID') }}",
                merchantId: "{{ env('CLICK_MERCHANT_ID') }}",
                userId: "{{ auth()->id() }}",
                returnUrl: "{{ url('/payment/success') }}",
            },
            isAdmin: {{ auth()->check() && auth()->user()->name === 'adminstrator' ? 'true' : 'false' }},
        };
    </script>

    <div class="flex h-screen overflow-hidden">

        {{-- ══════════ SIDEBAR ══════════ --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="relative z-30 flex-shrink-0 flex flex-col menu-transition bg-white dark:bg-gray-900 shadow-xl overflow-hidden">

            {{-- Logo --}}
            <div class="flex items-center h-16 px-4 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 min-w-max">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-accent flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition
                        class="font-display font-800 text-lg gradient-text whitespace-nowrap">HalolAdmin</span>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
                <div class="px-2 space-y-1">
                    <template x-for="item in navItems" :key="item.id">
                        <a :href="item.route" @click="activePage = item.id"
                            :class="activePage === item.id ?
                                'active bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' :
                                'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-800 dark:hover:text-gray-100'"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                            <span class="flex-shrink-0 w-5 h-5" x-html="item.icon"></span>
                            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"
                                x-text="item.label"></span>
                            <span x-show="sidebarOpen && item.badge" x-transition
                                class="ml-auto bg-accent text-white text-xs font-bold px-1.5 py-0.5 rounded-full"
                                x-text="item.badge"></span>
                        </a>
                    </template>
                </div>

                <div x-show="sidebarOpen" class="mx-4 my-4 border-t border-gray-100 dark:border-gray-800"></div>
                <div x-show="sidebarOpen" class="px-4 mb-2">
                    <p class="text-xs font-display font-600 uppercase tracking-widest text-gray-400 dark:text-gray-600">
                        Tizim</p>
                </div>

                <div class="px-2 space-y-1">
                    <template x-for="item in systemItems" :key="item.id">
                        <a href="#" @click="activePage = item.id"
                            :class="activePage === item.id ?
                                'active bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' :
                                'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-800 dark:hover:text-gray-100'"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
                            <span class="flex-shrink-0 w-5 h-5" x-html="item.icon"></span>
                            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"
                                x-text="item.label"></span>
                        </a>
                    </template>
                </div>
            </nav>

            {{-- Profile --}}
            <div class="border-t border-gray-100 dark:border-gray-800 p-3">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-400 to-accent flex-shrink-0 flex items-center justify-center text-white font-display font-700 text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition class="min-w-0">
                        <p class="text-sm font-display font-600 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                        @csrf
                        <button x-show="sidebarOpen" x-transition
                            class="text-gray-400 hover:text-accent transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ══════════ MAIN ══════════ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- TOPBAR --}}
            <header
                class="glass h-16 flex items-center px-6 gap-4 flex-shrink-0 border-b border-white/50 dark:border-gray-800 z-20">

                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-3 text-sm">
                    <span class="text-gray-500 dark:text-gray-400">
                        Hisob: <strong class="text-gray-800 dark:text-gray-100">
                            {{ number_format(auth()->user()->userBalance->balance ?? 0, 0, '.', ' ') }} uzs
                        </strong>
                    </span>
                    <span class="text-gray-300 dark:text-gray-700">|</span>
                    <button onclick="payModal.open()" class="click_logo">Hisobni to'ldirish</button>
                    <span class="text-gray-300 dark:text-gray-700">|</span>
                    <span class="text-gray-500 dark:text-gray-400">
                        Brend: <strong>{{ auth()->user()->brandStatus() }}</strong>
                    </span>
                </div>

                <div class="flex items-center gap-2 ml-auto">

                    <button @click="darkMode = !darkMode"
                        class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span
                                class="absolute top-1.5 right-1.5 w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-80 glass rounded-2xl shadow-2xl border border-white/50 dark:border-gray-700 overflow-hidden z-50">
                            <div
                                class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                <h3 class="font-display font-600 text-sm">Bildirishnomalar</h3>
                                <span
                                    class="text-xs bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full">3
                                    yangi</span>
                            </div>
                            <template x-for="n in notifications" :key="n.id">
                                <div
                                    class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors border-b border-gray-50 dark:border-gray-800/50 last:border-0">
                                    <div class="flex gap-3">
                                        <div :class="n.color"
                                            class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xs font-700"
                                            x-text="n.avatar"></div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium leading-snug" x-text="n.text"></p>
                                            <p class="text-xs text-gray-400 mt-0.5" x-text="n.time"></p>
                                        </div>
                                        <div x-show="n.unread"
                                            class="w-2 h-2 bg-primary-500 rounded-full flex-shrink-0 mt-1.5"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-400 to-accent text-white text-sm font-display font-700 flex items-center justify-center shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-surface-light dark:bg-surface-dark">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ══════════ PAYMENT MODAL ══════════ --}}
    <div id="pay-backdrop" onclick="payModal.close()"></div>
    <div id="pay-modal">
        <div
            style="background:#fff;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.2);width:100%;max-width:440px;padding:28px;position:relative;">

            <button onclick="payModal.close()"
                style="position:absolute;top:16px;right:16px;background:none;border:none;cursor:pointer;color:#9ca3af;font-size:20px;">✕</button>

            <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
                <div
                    style="width:44px;height:44px;background:#22c55e;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">
                    💳</div>
                <div>
                    <div style="font-size:1.1rem;font-weight:700;color:#1f2937;">Hisobni to'ldirish</div>
                    <div style="font-size:.8rem;color:#9ca3af;">Click orqali to'lov</div>
                </div>
            </div>

            <label
                style="display:block;font-size:.85rem;font-weight:600;color:#6b7280;margin-bottom:8px;">Summa</label>
            <div style="position:relative;margin-bottom:16px;">
                <input id="pay-amount" type="number" min="1000" placeholder="50 000"
                    oninput="payModal.syncBtn()" onfocus="this.style.borderColor='#22c55e'"
                    onblur="this.style.borderColor='#e5e7eb'"
                    style="width:100%;border:1.5px solid #e5e7eb;border-radius:12px;padding:12px 52px 12px 16px;font-size:1.1rem;font-weight:600;color:#1f2937;outline:none;box-sizing:border-box;">
                <span
                    style="position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.85rem;">so'm</span>
            </div>

            <div style="display:flex;gap:8px;margin-bottom:24px;">
                @foreach ([10000, 50000, 100000, 200000] as $v)
                    <button id="q{{ $v }}" onclick="payModal.pick({{ $v }})"
                        style="flex:1;border:1.5px solid #e5e7eb;border-radius:10px;padding:8px 4px;font-size:.78rem;font-weight:700;cursor:pointer;background:#f9fafb;color:#6b7280;transition:.2s;">
                        {{ $v / 1000 }}K
                    </button>
                @endforeach
            </div>

            <form id="pay-form" method="GET" target="_blank">
                <button id="pay-btn" type="submit" disabled
                    style="width:100%;padding:14px;border:none;border-radius:12px;font-size:.95rem;font-weight:700;transition:.2s;background:#f3f4f6;color:#d1d5db;cursor:not-allowed;">
                    Click orqali to'lash
                </button>
            </form>

            <p style="text-align:center;font-size:.75rem;color:#9ca3af;margin-top:16px;">🔒 To'lov Click xavfsiz
                muhitida amalga oshiriladi</p>
        </div>
    </div>

    {{-- ══════════ ALPINE DATA ══════════ --}}
    <script>
        function adminPanel() {
            const R = window.APP.routes;

            // Nav itemlarni PHP aralashmasdan quramiz
            const baseNav = [{
                    id: 'dashboard',
                    label: 'Dashboard',
                    route: R.dashboard,
                    icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`
                },
                {
                    id: 'party',
                    label: 'Partiyalar',
                    route: R.parties,
                    icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 0L4 7m8 4v10M4 7v10l8 4"/></svg>`
                },
                {
                    id: 'histories',
                    label: 'Tarix',
                    route: R.histories,
                    icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m9-3a9 9 0 11-3-6.7M12 3v3m0 12v3"/>
                        </svg>`
                }
            ];

            // Admin itemni faqat JS da tekshiramiz — PHP Blade da ham himoyalangan
            if (window.APP.isAdmin && R.admin) {
                baseNav.push({
                    id: 'admin',
                    label: 'Admin',
                    route: R.admin,
                    icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 20a6 6 0 0112 0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11l2 2 4-4"/></svg>`
                });
            }

            return {
                sidebarOpen: true,
                darkMode: false,
                activePage: 'dashboard',
                navItems: baseNav,

                systemItems: [{
                    id: 'help',
                    route: R.help,
                    label: 'Yordam',
                    icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
                }, ],

                notifications: [{
                        id: 1,
                        avatar: 'A',
                        text: "Alisher yangi buyurtma berdi",
                        time: "2 daqiqa oldin",
                        unread: true,
                        color: "bg-gradient-to-br from-primary-400 to-primary-600"
                    },
                    {
                        id: 2,
                        avatar: 'M',
                        text: "Malika hisobotni yukladi",
                        time: "15 daqiqa oldin",
                        unread: true,
                        color: "bg-gradient-to-br from-emerald-400 to-emerald-600"
                    },
                    {
                        id: 3,
                        avatar: 'S',
                        text: "Server CPU 90% ga yetdi",
                        time: "1 soat oldin",
                        unread: false,
                        color: "bg-gradient-to-br from-amber-400 to-amber-600"
                    },
                ],

                init() {
                    const found = this.navItems.find(i => i.route === window.location.href);
                    if (found) this.activePage = found.id;
                    this.$nextTick(() => {
                        this.initMainChart();
                        this.initDoughnutChart();
                    });
                },

                initMainChart() {
                    const ctx = document.getElementById('mainChart')?.getContext('2d');
                    if (!ctx) return;
                    const grad = ctx.createLinearGradient(0, 0, 0, 224);
                    grad.addColorStop(0, 'rgba(92,124,250,.2)');
                    grad.addColorStop(1, 'rgba(92,124,250,0)');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyn', 'Iyl', 'Avg', 'Sen', 'Okt', 'Noy',
                                'Dek'
                            ],
                            datasets: [{
                                    label: 'Foydalanuvchilar',
                                    data: [1200, 1900, 1500, 2400, 2100, 3100, 2800, 3600, 3200, 4100, 3800,
                                        4800
                                    ],
                                    borderColor: '#5c7cfa',
                                    backgroundColor: grad,
                                    borderWidth: 2.5,
                                    tension: .4,
                                    pointRadius: 0,
                                    pointHoverRadius: 6,
                                    fill: true
                                },
                                {
                                    label: 'Buyurtmalar',
                                    data: [600, 900, 700, 1200, 1100, 1600, 1400, 1900, 1700, 2100, 1900, 2500],
                                    borderColor: '#ff6b6b',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2,
                                    tension: .4,
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                    borderDash: [5, 5]
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    backgroundColor: 'white',
                                    titleColor: '#111827',
                                    bodyColor: '#6b7280',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 12,
                                    cornerRadius: 12
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    border: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#9ca3af',
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: 'rgba(0,0,0,.05)'
                                    },
                                    border: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#9ca3af',
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initDoughnutChart() {
                    const ctx = document.getElementById('doughnutChart')?.getContext('2d');
                    if (!ctx) return;
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Organik', "To'g'ridan", 'Ijtimoiy', 'Boshqa'],
                            datasets: [{
                                data: [42, 28, 18, 12],
                                backgroundColor: ['#5c7cfa', '#34d399', '#fbbf24', '#a78bfa'],
                                borderWidth: 0,
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }
        }

        // ══════ PAYMENT MODAL ══════
        const payModal = {
            QUICK: [10000, 50000, 100000, 200000],
            // Route va configlar window.APP dan olinadi — PHP aralashmaydi
            get SERVICE_ID() {
                return window.APP.click.serviceId;
            },
            get MERCHANT_ID() {
                return window.APP.click.merchantId;
            },
            get USER_ID() {
                return window.APP.click.userId;
            },
            get RETURN_URL() {
                return window.APP.click.returnUrl;
            },

            open() {
                document.getElementById('pay-amount').value = '';
                document.getElementById('pay-backdrop').classList.add('open');
                document.getElementById('pay-modal').classList.add('open');
                this.syncBtn();
                document.addEventListener('keydown', this._esc);
            },

            close() {
                document.getElementById('pay-backdrop').classList.remove('open');
                document.getElementById('pay-modal').classList.remove('open');
                document.removeEventListener('keydown', this._esc);
            },

            _esc(e) {
                if (e.key === 'Escape') payModal.close();
            },

            pick(val) {
                document.getElementById('pay-amount').value = val;
                this.syncBtn();
            },

            syncBtn() {
                const amount = Number(document.getElementById('pay-amount').value);
                const btn = document.getElementById('pay-btn');
                const form = document.getElementById('pay-form');

                this.QUICK.forEach(v => {
                    const b = document.getElementById('q' + v);
                    const on = v === amount;
                    b.style.background = on ? '#22c55e' : '#f9fafb';
                    b.style.color = on ? '#fff' : '#6b7280';
                    b.style.borderColor = on ? '#22c55e' : '#e5e7eb';
                });

                if (amount >= 1000) {
                    btn.disabled = false;
                    btn.style.cssText =
                        'width:100%;padding:14px;border:none;border-radius:12px;font-size:.95rem;font-weight:700;transition:.2s;background:#22c55e;color:#fff;cursor:pointer;box-shadow:0 4px 20px rgba(34,197,94,.35);';
                    form.action =
                        `https://my.click.uz/services/pay?service_id=${this.SERVICE_ID}&merchant_id=${this.MERCHANT_ID}&amount=${amount}&transaction_param=${this.USER_ID}&return_url=${this.RETURN_URL}`;
                } else {
                    btn.disabled = true;
                    btn.style.cssText =
                        'width:100%;padding:14px;border:none;border-radius:12px;font-size:.95rem;font-weight:700;transition:.2s;background:#f3f4f6;color:#d1d5db;cursor:not-allowed;';
                }
            }
        };
    </script>

</body>

</html>
