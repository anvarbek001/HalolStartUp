<!DOCTYPE html>
<html lang="uz" x-data="adminPanel()" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | Dashboard</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Syne', 'sans-serif'],
                        'body': ['DM Sans', 'sans-serif'],
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
                            900: '#364fc7',
                        },
                        accent: '#ff6b6b',
                        surface: {
                            light: '#f8faff',
                            dark: '#0f1117',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease forwards',
                        'slide-in': 'slideIn 0.4s ease forwards',
                        'pulse-slow': 'pulse 3s infinite',
                        'float': 'float 6s ease-in-out infinite',
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
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-6px)'
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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .dark .glass {
            background: rgba(15, 17, 23, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-item {
            position: relative;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
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
            transition: transform 0.25s ease;
        }

        .sidebar-item.active::before,
        .sidebar-item:hover::before {
            transform: translateY(-50%) scaleY(1);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            opacity: 0.08;
            background: currentColor;
        }

        .menu-transition {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar */
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

        .gradient-text {
            background: linear-gradient(135deg, #5c7cfa 0%, #ff6b6b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .notification-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .table-row-hover:hover {
            background: rgba(92, 124, 250, 0.05);
        }

        .dark .table-row-hover:hover {
            background: rgba(92, 124, 250, 0.08);
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent 25%, rgba(92, 124, 250, 0.1) 50%, transparent 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .progress-bar {
            transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .click_logo {
            padding: 4px 10px;
            cursor: pointer;
            color: #fff;
            line-height: 190%;
            font-size: 13px;
            font-family: Arial;
            font-weight: bold;
            text-align: center;
            border: 1px solid #037bc8;
            text-shadow: 0px -1px 0px #037bc8;
            border-radius: 4px;
            background: #27a8e0;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzI3YThlMCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMxYzhlZDciIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
            background: -webkit-gradient(linear, 0 0, 0 100%, from(#27a8e0), to(#1c8ed7));
            background: -webkit-linear-gradient(#27a8e0 0%, #1c8ed7 100%);
            background: -moz-linear-gradient(#27a8e0 0%, #1c8ed7 100%);
            background: -o-linear-gradient(#27a8e0 0%, #1c8ed7 100%);
            background: linear-gradient(#27a8e0 0%, #1c8ed7 100%);
            box-shadow: inset 0px 1px 0px #45c4fc;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#27a8e0', endColorstr='#1c8ed7', GradientType=0);
            -webkit-box-shadow: inset 0px 1px 0px #45c4fc;
            -moz-box-shadow: inset 0px 1px 0px #45c4fc;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
        }

        .click_logo i {
            background: url(https://m.click.uz/static/img/logo.png) no-repeat top left;
            width: 30px;
            height: 25px;
            display: block;
            float: left;
        }

        .search_box {
            display: flex;
            align-items: center;
            gap: 7px;
        }
    </style>
</head>

<body class="bg-surface-light dark:bg-surface-dark text-gray-800 dark:text-gray-100 min-h-screen">

    <div class="flex h-screen overflow-hidden">

        <!-- ==================== SIDEBAR ==================== -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="relative z-30 flex-shrink-0 flex flex-col menu-transition bg-white dark:bg-gray-900 shadow-xl overflow-hidden">
            <!-- Logo -->
            <div class="flex items-center h-16 px-4 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 min-w-max">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-accent flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="font-display font-800 text-lg gradient-text whitespace-nowrap">HalolAdmin</span>
                </div>
            </div>

            <!-- Nav -->
            <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden">
                <div class="px-2 space-y-1">

                    <template x-for="item in navItems" :key="item.id">
                        <a :href="item.route" @click="activePage = item.id"
                            :class="activePage === item.id ?
                                'active bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' :
                                'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-800 dark:hover:text-gray-100'"
                            class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium group">
                            <span class="flex-shrink-0 w-5 h-5" x-html="item.icon"></span>
                            <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"
                                x-text="item.label"></span>
                            <span x-show="sidebarOpen && item.badge" x-transition
                                class="ml-auto bg-accent text-white text-xs font-bold px-1.5 py-0.5 rounded-full"
                                x-text="item.badge"></span>
                        </a>
                    </template>

                </div>

                <!-- Section divider -->
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

            <!-- Profile mini -->
            <div class="border-t border-gray-100 dark:border-gray-800 p-3">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-400 to-accent flex-shrink-0 flex items-center justify-center text-white font-display font-700 text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div x-show="sidebarOpen" x-transition class="min-w-0">
                        <p class="text-sm font-display font-600 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto text-gray-400">
                        @csrf
                        <button x-show="sidebarOpen" x-transition
                            class="ml-auto text-gray-400 hover:text-accent transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ==================== MAIN AREA ==================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- TOPBAR -->
            <header
                class="glass h-16 flex items-center px-6 gap-4 flex-shrink-0 border-b border-white/50 dark:border-gray-800 z-20">

                <!-- Toggle sidebar -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Search -->
                <div class="search_box max-w-lg relative">
                    <div style="">Hisobingizda:
                        <strong>{{ number_format(auth()->user()->userBalance->balance ?? 0, 0, '.', ' ') }}</strong>
                        uzs |
                    </div>

                    <div x-data="{ open: false, amount: '', loading: false }">

                        <button @click="open = true" class="click_logo">Hisobni to'ldirish</button> |

                        <!-- Backdrop -->
                        <div x-show="open" @click="open = false"
                            style="position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:40;">
                        </div>

                        <!-- Modal -->
                        <div x-show="open" @keydown.escape.window="open = false"
                            style="position:fixed; inset:0; z-index:50; display:flex; align-items:center; justify-content:center; padding:16px;">

                            <div
                                style="background:#fff; border-radius:20px; box-shadow:0 25px 60px rgba(0,0,0,0.2); width:100%; max-width:440px; padding:28px; position:relative;">

                                <!-- Close -->
                                <button @click="open = false"
                                    style="position:absolute; top:16px; right:16px; background:none; border:none; cursor:pointer; color:#9ca3af; font-size:20px;">✕</button>

                                <!-- Header -->
                                <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                                    <div
                                        style="width:44px; height:44px; background:#22c55e; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                                        💳</div>
                                    <div>
                                        <div style="font-size:1.1rem; font-weight:700; color:#1f2937;">Hisobni
                                            to'ldirish</div>
                                        <div style="font-size:0.8rem; color:#9ca3af;">Click orqali to'lov</div>
                                    </div>
                                </div>

                                <!-- Input -->
                                <label
                                    style="display:block; font-size:0.85rem; font-weight:600; color:#6b7280; margin-bottom:8px;">Summa</label>
                                <div style="position:relative; margin-bottom:16px;">
                                    <input x-model="amount" type="number" min="1000" placeholder="50 000"
                                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:12px 52px 12px 16px; font-size:1.1rem; font-weight:600; color:#1f2937; outline:none; box-sizing:border-box;"
                                        @focus="$el.style.borderColor='#22c55e'"
                                        @blur="$el.style.borderColor='#e5e7eb'">
                                    <span
                                        style="position:absolute; right:16px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:0.85rem;">so'm</span>
                                </div>

                                <!-- Quick amounts -->
                                <div style="display:flex; gap:8px; margin-bottom:24px;">
                                    <template x-for="val in [10000, 50000, 100000, 200000]">
                                        <button @click="amount = val"
                                            :style="amount == val ?
                                                'background:#22c55e; color:#fff; border-color:#22c55e;' :
                                                'background:#f9fafb; color:#6b7280; border-color:#e5e7eb;'"
                                            style="flex:1; border:1.5px solid; border-radius:10px; padding:8px 4px; font-size:0.78rem; font-weight:700; cursor:pointer; transition:.2s;">
                                            <span x-text="(val/1000)+'K'"></span>
                                        </button>
                                    </template>
                                </div>

                                <!-- Submit -->
                                <form
                                    :action="`https://my.click.uz/services/pay?service_id={{ env('CLICK_SERVICE_ID') }}&merchant_id={{ env('CLICK_MERCHANT_ID') }}&amount=${amount}&transaction_param={{ auth()->id() }}&return_url={{ url('/payment/success') }}`"
                                    method="POST">
                                    <button type="submit" :disabled="!amount || amount < 1000"
                                        @click="loading = true"
                                        :style="(!amount || amount < 1000) ?
                                        'background:#f3f4f6; color:#d1d5db; cursor:not-allowed;' :
                                        'background:#22c55e; color:#fff; cursor:pointer; box-shadow:0 4px 20px rgba(34,197,94,.35);'"
                                        style="width:100%; padding:14px; border:none; border-radius:12px; font-size:0.95rem; font-weight:700; transition:.2s; display:flex; align-items:center; justify-content:center; gap:8px;">
                                        <span
                                            x-text="loading ? 'Yo\'naltirilmoqda...' : 'Click orqali to\'lash'"></span>
                                    </button>
                                </form>

                                <p style="text-align:center; font-size:0.75rem; color:#9ca3af; margin-top:16px;">
                                    🔒 To'lov Click xavfsiz muhitida amalga oshiriladi
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        Brend holadi: {{ auth()->user()->brandStatus() }}
                    </div>
                    {{-- <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Qidirish..."
                        class="w-full pl-10 pr-4 py-2 text-sm bg-gray-100/80 dark:bg-gray-800/80 border border-transparent focus:border-primary-300 dark:focus:border-primary-700 rounded-xl outline-none transition-all placeholder:text-gray-400"> --}}
                </div>

                <div class="flex items-center gap-2 ml-auto">
                    <!-- Dark mode -->
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

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="relative p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span
                                class="notification-badge absolute top-1.5 right-1.5 w-2 h-2 bg-accent rounded-full"></span>
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
                                    class="text-xs bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-full font-medium">3
                                    yangi</span>
                            </div>
                            <template x-for="notif in notifications" :key="notif.id">
                                <div
                                    class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors border-b border-gray-50 dark:border-gray-800/50 last:border-0">
                                    <div class="flex gap-3">
                                        <div :class="notif.color"
                                            class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 text-white text-xs font-display font-700"
                                            x-text="notif.avatar"></div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium leading-snug" x-text="notif.text"></p>
                                            <p class="text-xs text-gray-400 mt-0.5" x-text="notif.time"></p>
                                        </div>
                                        <div x-show="notif.unread"
                                            class="w-2 h-2 bg-primary-500 rounded-full flex-shrink-0 mt-1.5"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Avatar -->
                    <a href="{{ route('profile.edit') }}"
                        class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-400 to-accent text-white text-sm font-display font-700 flex items-center justify-center shadow-md">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</a>
                </div>
            </header>

            <!-- ==================== PAGE CONTENT ==================== -->
            <main class="flex-1 overflow-y-auto p-6 bg-surface-light dark:bg-surface-dark">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- ==================== ALPINE DATA ==================== -->
    <script>
        function adminPanel() {
            return {
                sidebarOpen: true,
                darkMode: false,
                activePage: 'dashboard',
                activePeriod: 'Oy',
                today: new Date().toLocaleDateString('uz-UZ', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }),

                navItems: [{
                        id: 'dashboard',
                        label: 'Dashboard',
                        route: '{{ route('dashboard') }}',
                        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`
                    },
                    {
                        id: 'party',
                        label: 'Partiyalar',
                        route: '{{ route('parties') }}',
                        // badge: '12',
                        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 0L4 7m8 4v10"/>
                            </svg>`
                    },
                    @if (auth()->user()->name === 'adminstrator')
                        {
                            id: 'admin',
                            label: 'Admin',
                            route: '{{ route('admin') }}',
                            icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 20a6 6 0 0112 0"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11l2 2 4-4"/>
                            </svg>`
                        },
                    @endif
                ],

                systemItems: [
                    // {
                    //     id: 'settings',
                    //     label: 'Sozlamalar',
                    //     icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
                    // },
                    {
                        id: 'help',
                        label: 'Yordam',
                        icon: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
                    },
                ],

                stats: [{
                        id: 1,
                        label: "Jami foydalanuvchilar",
                        value: "24,521",
                        change: 12.5,
                        progress: 75,
                        iconBg: "bg-primary-50 dark:bg-primary-900/20",
                        progressColor: "bg-gradient-to-r from-primary-400 to-primary-600",
                        icon: `<svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
                    },
                    {
                        id: 2,
                        label: "Bu oy daromad",
                        value: "₩8,340,000",
                        change: 8.2,
                        progress: 62,
                        iconBg: "bg-emerald-50 dark:bg-emerald-900/20",
                        progressColor: "bg-gradient-to-r from-emerald-400 to-emerald-600",
                        icon: `<svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
                    },
                    {
                        id: 3,
                        label: "Yangi buyurtmalar",
                        value: "1,893",
                        change: -3.1,
                        progress: 45,
                        iconBg: "bg-amber-50 dark:bg-amber-900/20",
                        progressColor: "bg-gradient-to-r from-amber-400 to-amber-600",
                        icon: `<svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>`
                    },
                    {
                        id: 4,
                        label: "Konversiya",
                        value: "5.27%",
                        change: 1.8,
                        progress: 53,
                        iconBg: "bg-purple-50 dark:bg-purple-900/20",
                        progressColor: "bg-gradient-to-r from-purple-400 to-purple-600",
                        icon: `<svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>`
                    },
                ],

                trafficSources: [{
                        label: "Organik qidiruv",
                        value: 42,
                        color: "bg-primary-500"
                    },
                    {
                        label: "To'g'ridan-to'g'ri",
                        value: 28,
                        color: "bg-emerald-500"
                    },
                    {
                        label: "Ijtimoiy tarmoqlar",
                        value: 18,
                        color: "bg-amber-500"
                    },
                    {
                        label: "Boshqalar",
                        value: 12,
                        color: "bg-purple-500"
                    },
                ],

                users: [{
                        id: 1,
                        name: "Alisher Karimov",
                        email: "alisher@example.com",
                        status: "Faol",
                        role: "Admin",
                        date: "12 Yan 2025",
                        avatarColor: "bg-gradient-to-br from-primary-400 to-primary-600"
                    },
                    {
                        id: 2,
                        name: "Malika Yusupova",
                        email: "malika@example.com",
                        status: "Faol",
                        role: "Moderator",
                        date: "08 Yan 2025",
                        avatarColor: "bg-gradient-to-br from-emerald-400 to-emerald-600"
                    },
                    {
                        id: 3,
                        name: "Bobur Toshmatov",
                        email: "bobur@example.com",
                        status: "Nofaol",
                        role: "Foydalanuvchi",
                        date: "01 Yan 2025",
                        avatarColor: "bg-gradient-to-br from-amber-400 to-amber-600"
                    },
                    {
                        id: 4,
                        name: "Nodira Xasanova",
                        email: "nodira@example.com",
                        status: "Faol",
                        role: "Foydalanuvchi",
                        date: "28 Dek 2024",
                        avatarColor: "bg-gradient-to-br from-purple-400 to-purple-600"
                    },
                    {
                        id: 5,
                        name: "Sanjar Raximov",
                        email: "sanjar@example.com",
                        status: "Faol",
                        role: "Redaktor",
                        date: "25 Dek 2024",
                        avatarColor: "bg-gradient-to-br from-rose-400 to-rose-600"
                    },
                ],

                activities: [{
                        id: 1,
                        text: "Yangi foydalanuvchi ro'yxatdan o'tdi",
                        time: "5 daqiqa oldin",
                        iconBg: "bg-primary-100 dark:bg-primary-900/30",
                        icon: `<svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>`
                    },
                    {
                        id: 2,
                        text: "#2841 buyurtma tasdiqlandi",
                        time: "23 daqiqa oldin",
                        iconBg: "bg-emerald-100 dark:bg-emerald-900/30",
                        icon: `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`
                    },
                    {
                        id: 3,
                        text: "Tizim yangilandi v2.4.1",
                        time: "1 soat oldin",
                        iconBg: "bg-amber-100 dark:bg-amber-900/30",
                        icon: `<svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>`
                    },
                    {
                        id: 4,
                        text: "Server backup muvaffaqiyatli yakunlandi",
                        time: "3 soat oldin",
                        iconBg: "bg-purple-100 dark:bg-purple-900/30",
                        icon: `<svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>`
                    },
                    {
                        id: 5,
                        text: "Yangi mahsulot qo'shildi",
                        time: "5 soat oldin",
                        iconBg: "bg-rose-100 dark:bg-rose-900/30",
                        icon: `<svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>`
                    },
                ],

                notifications: [{
                        id: 1,
                        avatar: "A",
                        text: "Alisher yangi buyurtma berdi",
                        time: "2 daqiqa oldin",
                        unread: true,
                        color: "bg-gradient-to-br from-primary-400 to-primary-600"
                    },
                    {
                        id: 2,
                        avatar: "M",
                        text: "Malika hisobotni yukladi",
                        time: "15 daqiqa oldin",
                        unread: true,
                        color: "bg-gradient-to-br from-emerald-400 to-emerald-600"
                    },
                    {
                        id: 3,
                        avatar: "S",
                        text: "Server CPU 90% ga yetdi",
                        time: "1 soat oldin",
                        unread: false,
                        color: "bg-gradient-to-br from-amber-400 to-amber-600"
                    },
                ],

                init() {
                    // Joriy URL ga qarab active itemni topish
                    const currentUrl = window.location.href;
                    const found = this.navItems.find(item => item.route === currentUrl);
                    if (found) {
                        this.activePage = found.id;
                    }

                    this.$nextTick(() => {
                        this.initMainChart();
                        this.initDoughnutChart();
                    });
                },

                initMainChart() {
                    const ctx = document.getElementById('mainChart').getContext('2d');
                    const isDark = this.darkMode;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 224);
                    gradient.addColorStop(0, 'rgba(92, 124, 250, 0.2)');
                    gradient.addColorStop(1, 'rgba(92, 124, 250, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyn', 'Iyl', 'Avg', 'Sen', 'Okt', 'Noy',
                                'Dek'
                            ],
                            datasets: [{
                                label: "Foydalanuvchilar",
                                data: [1200, 1900, 1500, 2400, 2100, 3100, 2800, 3600, 3200, 4100, 3800,
                                    4800
                                ],
                                borderColor: '#5c7cfa',
                                backgroundColor: gradient,
                                borderWidth: 2.5,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBackgroundColor: '#5c7cfa',
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                                fill: true,
                            }, {
                                label: "Buyurtmalar",
                                data: [600, 900, 700, 1200, 1100, 1600, 1400, 1900, 1700, 2100, 1900, 2500],
                                borderColor: '#ff6b6b',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: '#ff6b6b',
                                pointHoverBorderColor: '#fff',
                                pointHoverBorderWidth: 2,
                                borderDash: [5, 5],
                            }]
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
                                    backgroundColor: isDark ? '#1f2937' : 'white',
                                    titleColor: isDark ? '#f9fafb' : '#111827',
                                    bodyColor: isDark ? '#9ca3af' : '#6b7280',
                                    borderColor: isDark ? '#374151' : '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 12,
                                    cornerRadius: 12,
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
                                            size: 11,
                                            family: 'DM Sans'
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)',
                                        drawBorder: false
                                    },
                                    border: {
                                        display: false,
                                        dash: [4, 4]
                                    },
                                    ticks: {
                                        color: '#9ca3af',
                                        font: {
                                            size: 11,
                                            family: 'DM Sans'
                                        }
                                    }
                                }
                            }
                        }
                    });
                },

                initDoughnutChart() {
                    const ctx = document.getElementById('doughnutChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Organik', "To'g'ridan", 'Ijtimoiy', 'Boshqa'],
                            datasets: [{
                                data: [42, 28, 18, 12],
                                backgroundColor: ['#5c7cfa', '#34d399', '#fbbf24', '#a78bfa'],
                                borderWidth: 0,
                                hoverOffset: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0,0,0,0.8)',
                                    padding: 10,
                                    cornerRadius: 8,
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>

</body>

</html>
