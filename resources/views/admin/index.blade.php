@extends('layouts.index')
@section('content')

    <style>
        .user-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(92, 124, 250, 0.1);
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #5c7cfa, #818cf8, #a78bfa);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .status-select {
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 28px 4px 10px;
            border-radius: 99px;
            border: 1.5px solid transparent;
            outline: none;
            transition: all 0.2s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='3'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .status-select:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.12);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.25);
        }

        .status-inactive {
            background: rgba(107, 114, 128, 0.10);
            color: #6b7280;
            border-color: rgba(107, 114, 128, 0.20);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706;
            border-color: rgba(245, 158, 11, 0.25);
        }

        .status-blocked {
            background: rgba(239, 68, 68, 0.10);
            color: #dc2626;
            border-color: rgba(239, 68, 68, 0.20);
        }

        .avatar-ring {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #5c7cfa, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(92, 124, 250, 0.3);
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(92, 124, 250, 0.15);
        }

        .brand-logo-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dark .brand-logo-placeholder {
            background: linear-gradient(135deg, rgba(92, 124, 250, 0.2), rgba(92, 124, 250, 0.1));
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 99px;
            background: rgba(92, 124, 250, 0.08);
            color: #5c7cfa;
        }

        .dark .stat-chip {
            background: rgba(92, 124, 250, 0.15);
        }

        .expand-panel {
            display: none;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dark .expand-panel {
            border-top-color: rgba(255, 255, 255, 0.06);
        }

        .expand-panel.is-open {
            display: block;
        }

        .chevron {
            transition: transform 0.3s ease;
        }

        .chevron.rotated {
            transform: rotate(180deg);
        }

        .search-input {
            transition: all 0.2s ease;
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(92, 124, 250, 0.15);
        }

        .toast-pop {
            animation: toastIn .4s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        .btn_download {
            background: #059669;
            border-radius: 10px;
            font-size: 10px;
            padding: 5px 15px;
            color: white;
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
    </style>

    {{-- ══════════ HEADING ══════════ --}}
    <div class="mb-8 animate-fade-in">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="font-display text-2xl font-700 text-gray-900 dark:text-white">Foydalanuvchilar</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Jami <strong class="text-gray-700 dark:text-gray-200">{{ $users->count() }}</strong> ta foydalanuvchi
                </p>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Qidirish..."
                    class="search-input pl-9 pr-4 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 transition-all w-56 text-gray-700 dark:text-gray-200">
            </div>
        </div>
    </div>

    {{-- ══════════ STATS ══════════ --}}
    @php
        $totalBrands = $users->filter(fn($u) => $u->brand)->count();
        $activeBrands = $users->filter(fn($u) => $u->brand?->status === 'active')->count();
        $pendingBrands = $users->filter(fn($u) => $u->brand?->status === 'pending')->count();
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 animate-fade-in">
        @foreach ([['label' => 'Jami foydalanuvchi', 'value' => $users->count(), 'gradient' => 'from-primary-400 to-primary-600', 'path' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Brandlar', 'value' => $totalBrands, 'gradient' => 'from-violet-400 to-violet-600', 'path' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'], ['label' => 'Faol brandlar', 'value' => $activeBrands, 'gradient' => 'from-emerald-400 to-emerald-600', 'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Kutilmoqda', 'value' => $pendingBrands, 'gradient' => 'from-amber-400 to-amber-600', 'path' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']] as $s)
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['gradient'] }} flex items-center justify-center shadow-md flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['path'] }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $s['label'] }}</p>
                        <p class="font-display text-xl font-700 text-gray-900 dark:text-white">{{ $s['value'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ══════════ USERS LIST ══════════ --}}
    <div class="space-y-4" id="usersList">
        @forelse($users as $index => $user)
            <div class="user-card bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm animate-fade-in"
                style="animation-delay: {{ $index * 0.04 }}s"
                data-search="{{ strtolower($user->name) }} {{ strtolower($user->email) }} {{ strtolower($user->brand?->name ?? '') }}">

                <div class="p-5">
                    <div class="flex items-start gap-4">

                        {{-- Avatar --}}
                        <div class="avatar-ring flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 flex-wrap">

                                {{-- User info --}}
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-display font-700 text-gray-900 dark:text-white text-base">
                                            {{ $user->name }}
                                        </h3>
                                        @if ($user->brand)
                                            <span class="stat-chip">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                                                </svg>
                                                {{ $user->brand->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Brand yo'q</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                    <div class="flex items-center gap-3 mt-2 flex-wrap">
                                        <span class="flex items-center gap-1 text-xs text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $user->created_at->format('d.m.Y') }}
                                        </span>
                                        @if ($user->brand)
                                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                                {{ $user->brand->parties->count() }} partiya
                                            </span>
                                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                {{ $user->brand->parties->sum(fn($p) => $p->products->count()) }} mahsulot
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    @if ($user->brand)
                                        {{-- Status select --}}
                                        <div class="relative flex items-center gap-2">
                                            <select class="status-select status-{{ $user->brand->status }}"
                                                data-brand-id="{{ $user->brand->id }}" onchange="changeStatus(this)">
                                                <option value="active" @selected($user->brand->status === 'active')>✅ Faol</option>
                                                <option value="inactive" @selected($user->brand->status === 'inactive')>⚪ Nofaol</option>
                                                <option value="pending" @selected($user->brand->status === 'pending')>⏳ Kutilmoqda</option>
                                                <option value="blocked" @selected($user->brand->status === 'blocked')>🚫 Bloklangan</option>
                                            </select>
                                            <svg class="spinner w-4 h-4 animate-spin text-gray-400 flex-shrink-0 hidden"
                                                fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4" />
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                            </svg>
                                        </div>

                                        {{-- Expand button --}}
                                        <button onclick="toggleExpand(this)" data-target="expand-{{ $user->id }}"
                                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-600 text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors">
                                            <span class="btn-label">Batafsil</span>
                                            <svg class="chevron w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Expand panel ── --}}
                @if ($user->brand)
                    <div id="expand-{{ $user->id }}" class="expand-panel">
                        <div class="p-5 space-y-5">

                            {{-- Brand card --}}
                            <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                                @if ($user->brand->logo)
                                    <img src="{{ Storage::url($user->brand->logo) }}" class="brand-logo" alt="">
                                @else
                                    <div class="brand-logo-placeholder">
                                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-600 text-sm text-gray-800 dark:text-gray-100">{{ $user->brand->name }}
                                    </p>
                                    @if ($user->brand->description)
                                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">
                                            {{ $user->brand->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right flex-shrink-0">
                                    @if ($user->brand->license)
                                        <p class="text-xs text-gray-400">Litsenziya</p>
                                        <a href="{{ route('download.license', $user->brand->id) }}"
                                            class="btn_download">yuklash</a>
                                    @endif
                                    @if ($user->brand->rating)
                                        <div class="flex items-center justify-end gap-1 mt-1">
                                            <span class="text-amber-400 text-sm">★</span>
                                            <span
                                                class="text-xs font-600 text-gray-600 dark:text-gray-300">{{ $user->brand->rating }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Partiyalar --}}
                            @if ($user->brand->parties->count() > 0)
                                <div>
                                    <p
                                        class="text-xs font-600 uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                                        Partiyalar ({{ $user->brand->parties->count() }})
                                    </p>
                                    <div class="space-y-2">
                                        @foreach ($user->brand->parties->take(5) as $party)
                                            <div
                                                class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    @if ($party->image)
                                                        <img src="{{ Storage::url($party->image) }}"
                                                            class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                                                    @else
                                                        <div
                                                            class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-4 h-4 text-primary-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-xs font-600 text-gray-700 dark:text-gray-200 truncate">
                                                            {{ $party->name }}</p>
                                                        <p class="text-xs text-gray-400">#{{ $party->uniq_id }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3 flex-shrink-0">
                                                    <span class="text-xs text-gray-400">
                                                        <strong
                                                            class="text-gray-600 dark:text-gray-300">{{ $party->products->count() }}</strong>
                                                        mahsulot
                                                    </span>
                                                    @if ($party->price)
                                                        <span class="text-xs font-600 text-gray-600 dark:text-gray-300">
                                                            {{ number_format($party->price) }} so'm
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($user->brand->parties->count() > 5)
                                            <p class="text-xs text-center text-gray-400 py-1">
                                                + {{ $user->brand->parties->count() - 5 }} ta partiya
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic text-center py-2">Hali partiya qo'shilmagan</p>
                            @endif

                        </div>
                    </div>
                @endif

            </div>
        @empty
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-16 text-center">
                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-display font-700 text-gray-700 dark:text-gray-300 mb-1">Foydalanuvchilar topilmadi</h3>
                <p class="text-sm text-gray-400">Hali hech qanday foydalanuvchi yo'q</p>
            </div>
        @endforelse
    </div>

    {{-- ══════════ TOAST ══════════ --}}
    <div id="toast-container" class="fixed top-6 right-6 z-[99999] flex flex-col gap-3" style="pointer-events:none;">
    </div>

    <script>
        // ── Search ──────────────────────────────────────────────
        document.getElementById('searchInput').addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('#usersList [data-search]').forEach(card => {
                card.style.display = card.dataset.search.includes(q) ? '' : 'none';
            });
        });

        // ── Expand / collapse ───────────────────────────────────
        function toggleExpand(btn) {
            const panel = document.getElementById(btn.dataset.target);
            const open = panel.classList.toggle('is-open');
            btn.querySelector('.btn-label').textContent = open ? 'Yopish' : 'Batafsil';
            btn.querySelector('.chevron').classList.toggle('rotated', open);
        }

        // ── Status change ───────────────────────────────────────
        async function changeStatus(select) {
            const brandId = select.dataset.brandId;
            const newStatus = select.value;
            const spinner = select.parentElement.querySelector('.spinner');

            select.disabled = true;
            spinner.classList.remove('hidden');

            try {
                const res = await fetch('/admin/brand/' + brandId + '/status', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: newStatus
                    }),
                });
                const data = await res.json();
                if (data.success) {
                    select.className = 'status-select status-' + newStatus;
                    showToast('Status yangilandi!', 'success');
                } else {
                    showToast('Xatolik yuz berdi', 'error');
                }
            } catch {
                showToast('Tarmoq xatoligi', 'error');
            }

            select.disabled = false;
            spinner.classList.add('hidden');
        }

        // ── Toast ────────────────────────────────────────────────
        function showToast(message, type = 'success') {
            const cfg = {
                success: {
                    bg: 'rgba(16,185,129,0.12)',
                    border: 'rgba(16,185,129,0.25)',
                    color: '#10b981',
                    icon: 'M5 13l4 4L19 7'
                },
                error: {
                    bg: 'rgba(248,113,113,0.10)',
                    border: 'rgba(248,113,113,0.25)',
                    color: '#f87171',
                    icon: 'M6 18L18 6M6 6l12 12'
                },
            };
            const c = cfg[type] || cfg.success;
            const el = document.createElement('div');
            el.className = 'toast-pop flex items-center gap-3 px-5 py-4 rounded-2xl border';
            el.style.cssText = `background:${c.bg};border-color:${c.border};pointer-events:all;min-width:280px;`;
            el.innerHTML =
                `
            <div style="width:32px;height:32px;border-radius:10px;background:${c.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="color:${c.color};width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${c.icon}"/>
                </svg>
            </div>
            <p style="font-size:13px;font-weight:600;color:${c.color};flex:1;">${message}</p>
            <button onclick="this.closest('div').remove()" style="color:rgba(128,128,128,0.5);font-size:12px;">✕</button>`;
            document.getElementById('toast-container').appendChild(el);
            setTimeout(() => {
                el.style.transition = 'opacity .3s ease, transform .3s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(40px)';
                setTimeout(() => el.remove(), 300);
            }, 3500);
        }

        @if (session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        @if (session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    </script>

@endsection
