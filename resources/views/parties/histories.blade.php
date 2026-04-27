@extends('layouts.index')

@section('content')
    @use('App\Enums\PartyStatus');

    <style>
        .page-wrap {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 0 60px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #0d6b3c;
            margin-bottom: 6px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .dark .page-title {
            color: #f9fafb;
        }

        .page-count {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        /* ── Stats strip ── */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .stat-pill {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.07);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .dark .stat-pill {
            background: #1f2937;
            border-color: rgba(255, 255, 255, 0.07);
        }

        .stat-pill-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-pill-icon.green {
            background: #dcfce7;
            color: #15803d;
        }

        .stat-pill-icon.red {
            background: #fee2e2;
            color: #dc2626;
        }

        .stat-pill-icon.blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-pill-val {
            font-size: 22px;
            font-weight: 800;
            color: #111827;
            line-height: 1;
        }

        .dark .stat-pill-val {
            color: #f9fafb;
        }

        .stat-pill-lbl {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ── Timeline ── */
        .timeline {
            position: relative;
            padding-left: 32px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #dcfce7, #bbf7d0 40%, #e5e7eb 100%);
            border-radius: 2px;
        }

        /* ── Timeline item ── */
        .tl-item {
            position: relative;
            margin-bottom: 16px;
            animation: tlFadeIn .4s ease both;
        }

        @keyframes tlFadeIn {
            from {
                opacity: 0;
                transform: translateX(-12px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .tl-dot {
            position: absolute;
            left: -27px;
            top: 18px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px currentColor;
            z-index: 2;
            transition: transform .2s;
        }

        .tl-item:hover .tl-dot {
            transform: scale(1.25);
        }

        .tl-dot.activated {
            color: #15803d;
            background: #22c55e;
        }

        .tl-dot.deactivated {
            color: #dc2626;
            background: #ef4444;
        }

        .dark .tl-dot {
            border-color: #1f2937;
        }

        /* ── Card ── */
        .tl-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.07);
            border-radius: 16px;
            padding: 18px 20px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px 20px;
            align-items: start;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
            transition: transform .2s, box-shadow .2s, border-color .2s;
            cursor: default;
        }

        .tl-card:hover {
            transform: translateX(4px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.09);
            border-color: rgba(0, 0, 0, 0.12);
        }

        .dark .tl-card {
            background: #1f2937;
            border-color: rgba(255, 255, 255, 0.07);
        }

        .dark .tl-card:hover {
            border-color: rgba(255, 255, 255, 0.14);
        }

        /* ── Card left ── */
        .tl-left {
            min-width: 0;
        }

        .tl-top-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .tl-user {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tl-avatar {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, #4c6ef5, #7c3aed);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .tl-username {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .dark .tl-username {
            color: #f3f4f6;
        }

        /* ── Status flow ── */
        .status-flow {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            letter-spacing: 0.1px;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-arrow {
            color: #9ca3af;
            font-size: 14px;
            flex-shrink: 0;
        }

        /* ── Party info ── */
        .tl-party-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
        }

        .party-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 4px 10px;
        }

        .dark .party-badge {
            background: #374151;
            border-color: #4b5563;
            color: #d1d5db;
        }

        /* ── Right side: date ── */
        .tl-right {
            text-align: right;
            flex-shrink: 0;
        }

        .tl-date {
            font-size: 12.5px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        .dark .tl-date {
            color: #9ca3af;
        }

        .tl-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
            font-family: 'DM Mono', monospace;
        }

        /* ── Action tag ── */
        .action-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            margin-top: 6px;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }

        .action-tag.activated {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .action-tag.deactivated {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Empty ── */
        .empty-state {
            text-align: center;
            padding: 80px 24px;
            color: #9ca3af;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            background: #f3f4f6;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .dark .empty-icon {
            background: #374151;
        }

        .empty-title {
            font-size: 16px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }

        .dark .empty-title {
            color: #d1d5db;
        }

        /* ── Cursor pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 32px;
        }

        .page-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            color: #374151;
            transition: all .2s;
        }

        .page-btn:hover {
            background: #0d6b3c;
            border-color: #0d6b3c;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(13, 107, 60, .25);
        }

        .dark .page-btn {
            background: #1f2937;
            border-color: #374151;
            color: #d1d5db;
        }

        /* ── Day divider ── */
        .day-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 16px;
            padding-left: 0;
        }

        .day-divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .dark .day-divider-line {
            background: #374151;
        }

        .day-divider-label {
            font-size: 11.5px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }

        @media (max-width: 600px) {
            .stats-strip {
                grid-template-columns: 1fr;
            }

            .tl-card {
                grid-template-columns: 1fr;
            }

            .tl-right {
                text-align: left;
            }
        }
    </style>

    <div class="page-wrap">

        {{-- ── Header ── --}}
        <div class="page-header">
            <div>
                <div class="page-eyebrow">Tarix</div>
                <h1 class="page-title">Partiya holat o'zgarishlari</h1>
                <p class="page-count">Jami {{ $histories->count() }} ta yozuv ko'rsatilmoqda</p>
            </div>
            <a href="{{ route('parties') }}"
                style="display:inline-flex;align-items:center;gap:6px;padding:10px 18px;background:#f3f4f6;border-radius:10px;font-size:13px;font-weight:700;color:#374151;text-decoration:none;border:1px solid #e5e7eb;transition:.2s;"
                onmouseover="this.style.background='#0d6b3c';this.style.color='#fff'"
                onmouseout="this.style.background='#f3f4f6';this.style.color='#374151'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Orqaga
            </a>
        </div>

        {{-- ── Stats ── --}}
        @php
            $totalCount = $histories->count();
            $activatedCount = $histories->where('after_changing_status', PartyStatus::ACTIVE->value)->count();
            $inactiveCount = $histories->where('after_changing_status', PartyStatus::INACTIVE->value)->count();
        @endphp

        <div class="stats-strip">
            <div class="stat-pill">
                <div class="stat-pill-icon blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                </div>
                <div>
                    <div class="stat-pill-val">{{ $totalCount }}</div>
                    <div class="stat-pill-lbl">Jami o'zgarish</div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="stat-pill-icon green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div>
                    <div class="stat-pill-val">{{ $activatedCount }}</div>
                    <div class="stat-pill-lbl">Faollashtirilgan</div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="stat-pill-icon red">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>
                <div>
                    <div class="stat-pill-val">{{ $inactiveCount }}</div>
                    <div class="stat-pill-lbl">Faolsizlantirilgan</div>
                </div>
            </div>
        </div>

        {{-- ── Timeline ── --}}
        @if ($histories->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9ca3af"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="empty-title">Hech qanday tarix yo'q</div>
                <p style="font-size:13px;">Partiya holati o'zgartirilganda bu yerda ko'rinadi</p>
            </div>
        @else
            <div class="timeline">
                @php
                    $prevDate = null;
                    $delay = 0;
                @endphp

                @foreach ($histories as $history)
                    @php
                        $date = \Carbon\Carbon::parse($history->date_changing);
                        $dateLabel = $date->isToday()
                            ? 'Bugun'
                            : ($date->isYesterday()
                                ? 'Kecha'
                                : $date->format('d.m.Y'));
                        $isActivated = $history->after_changing_status === PartyStatus::ACTIVE->value;
                        $dotClass = $isActivated ? 'activated' : 'deactivated';
                        $delay += 60;
                    @endphp

                    {{-- Day divider --}}
                    @if ($dateLabel !== $prevDate)
                        <div class="day-divider">
                            <div class="day-divider-line"></div>
                            <span class="day-divider-label">{{ $dateLabel }}</span>
                            <div class="day-divider-line"></div>
                        </div>
                        @php $prevDate = $dateLabel; @endphp
                    @endif

                    <div class="tl-item" style="animation-delay: {{ $delay }}ms">
                        <div class="tl-dot {{ $dotClass }}"></div>

                        <div class="tl-card">
                            {{-- Left --}}
                            <div class="tl-left">
                                <div class="tl-top-row">
                                    {{-- User avatar + name --}}
                                    <div class="tl-user">
                                        <div class="tl-avatar">
                                            {{ strtoupper(substr($history->User->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <span class="tl-username">{{ $history->User->name ?? 'Noma\'lum' }}</span>
                                    </div>

                                    {{-- Status transition --}}
                                    <div class="status-flow">
                                        @php
                                            $beforeClass =
                                                $history->before_changing_status === PartyStatus::ACTIVE->value
                                                    ? PartyStatus::ACTIVE->value
                                                    : PartyStatus::INACTIVE->value;
                                            $afterClass =
                                                $history->after_changing_status === PartyStatus::ACTIVE->value
                                                    ? PartyStatus::ACTIVE->value
                                                    : PartyStatus::INACTIVE->value;
                                            $beforeLabel =
                                                $history->before_changing_status === PartyStatus::ACTIVE->value
                                                    ? 'Faol'
                                                    : 'Faolsiz';
                                            $afterLabel =
                                                $history->after_changing_status === PartyStatus::ACTIVE->value
                                                    ? 'Faol'
                                                    : 'Faolsiz';
                                        @endphp
                                        <span class="status-badge {{ $beforeClass }}">
                                            <span class="status-dot"></span>
                                            {{ $beforeLabel }}
                                        </span>
                                        <span class="status-arrow">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M5 12h14M12 5l7 7-7 7" />
                                            </svg>
                                        </span>
                                        <span class="status-badge {{ $afterClass }}">
                                            <span class="status-dot"></span>
                                            {{ $afterLabel }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Party info --}}
                                <div class="tl-party-row">
                                    <span class="party-badge">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 0L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        {{ $history->Party->name ?? 'Partiya #' . $history->party_id }}
                                    </span>

                                    <span class="action-tag {{ $isActivated ? 'activated' : 'deactivated' }}">
                                        {{ $isActivated ? '↑ Faollashtirildi' : '↓ Faolsizlantirildi' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Right: date/time --}}
                            <div class="tl-right">
                                <div class="tl-date">{{ $date->format('d.m.Y') }}</div>
                                <div class="tl-time">{{ $date->format('H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ── Cursor Pagination ── --}}
            <div class="pagination-wrap">
                @if ($histories->previousPageUrl())
                    <a href="{{ $histories->previousPageUrl() }}" class="page-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Oldingi
                    </a>
                @endif

                @if ($histories->nextPageUrl())
                    <a href="{{ $histories->nextPageUrl() }}" class="page-btn">
                        Keyingi
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif

    </div>

@endsection
