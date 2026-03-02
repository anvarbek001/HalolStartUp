@extends('layouts.index')
@section('content')

    <style>
        .party-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .party-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(92, 124, 250, 0.12);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 99px;
        }

        .status-fresh {
            background: rgba(52, 211, 153, 0.12);
            color: #059669;
        }

        .status-warning {
            background: rgba(251, 191, 36, 0.12);
            color: #d97706;
        }

        .status-expired {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
        }

        .star-rating {
            color: #fbbf24;
            letter-spacing: -1px;
        }

        .expand-btn {
            transition: transform 0.3s ease;
        }

        .expand-btn.open {
            transform: rotate(180deg);
        }

        .products-section {
            display: none;
        }

        .products-section.open {
            display: block;
            animation: slideDown 0.3s ease forwards;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .uniq-badge {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            background: rgba(92, 124, 250, 0.08);
            color: #4c6ef5;
            padding: 2px 8px;
            border-radius: 6px;
            border: 1px solid rgba(92, 124, 250, 0.15);
        }

        .image-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid rgba(92, 124, 250, 0.15);
        }

        .dark .image-placeholder {
            background: linear-gradient(135deg, rgba(92, 124, 250, 0.15), rgba(92, 124, 250, 0.08));
        }

        .image-thumb {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid rgba(92, 124, 250, 0.15);
        }

        .progress-mini {
            height: 4px;
            border-radius: 99px;
            background: rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .dark .progress-mini {
            background: rgba(255, 255, 255, 0.06);
        }

        .progress-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #5c7cfa, #818cf8);
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-row {
            transition: background 0.2s ease;
        }

        .product-row:hover {
            background: rgba(92, 124, 250, 0.04);
        }
    </style>

    <!-- Heading -->
    <div class="mb-8 animate-fade-in">

        <!-- Tugma -->
        <div x-data="{ open: false }">

            <!-- Modal -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="open = false">

                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-display font-700 text-gray-900 dark:text-white">Yangi Partiya</h3>
                        <button @click="open = false"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-4">
                        {{-- Form content shu yerga --}}
                        <p class="text-sm text-gray-500">Form content...</p>
                    </div>

                    <!-- Footer -->
                    <div
                        class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                        <button @click="open = false"
                            class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 transition-colors">
                            Bekor qilish
                        </button>
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 rounded-xl shadow-lg shadow-primary-500/25 transition-all">
                            Saqlash
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="font-display text-2xl font-700 text-gray-900 dark:text-white">Partiyalar</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Xush kelibsiz! Bugungi holat quyida.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button @click="open = true"
                        class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-600 dark:text-gray-300 hover:border-primary-400 transition-all">
                        + Partiya
                    </button>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Partiya qidirish..."
                        class="pl-9 pr-4 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 transition-all w-56">
                </div>
                <select id="statusFilter"
                    class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 transition-all text-gray-600 dark:text-gray-300">
                    <option value="all">Hammasi</option>
                    <option value="fresh">Yangi</option>
                    <option value="warning">Muddati yaqin</option>
                    <option value="expired">Muddati o'tgan</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 animate-fade-in">
        @foreach ([['label' => 'Partiyalar', 'value' => $parties->total(), 'gradient' => 'from-primary-400 to-primary-600', 'path' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'], ['label' => 'Mahsulotlar', 'value' => $parties->sum(fn($p) => $p->products->count()), 'gradient' => 'from-emerald-400 to-emerald-600', 'path' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'], ['label' => 'Jami Skanlar', 'value' => number_format($parties->sum(fn($p) => $p->products->sum('scan_count'))), 'gradient' => 'from-amber-400 to-amber-600', 'path' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01'], ['label' => "Muddati o'tgan", 'value' => $parties->filter(fn($p) => $p->expires_at && now()->gt($p->expires_at))->count(), 'gradient' => 'from-rose-400 to-rose-600', 'path' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as $s)
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

    <!-- Parties List -->
    <div class="space-y-4" id="partiesList">
        @forelse($parties as $index => $party)
            @php
                $now = now();
                $isExpired = $party->expires_at && $now->gt($party->expires_at);
                $isWarning = !$isExpired && $party->expires_at && $now->diffInDays($party->expires_at) <= 30;
                $statusCls = $isExpired ? 'status-expired' : ($isWarning ? 'status-warning' : 'status-fresh');
                $statusLbl = $isExpired ? "Muddati o'tgan" : ($isWarning ? 'Muddati yaqin' : 'Yangi');
                $productCnt = $party->products->count();
                $scanCnt = $party->products->sum('scan_count');
                $scanPct = $productCnt > 0 ? min(100, round(($scanCnt / ($productCnt * 10)) * 100)) : 0;
            @endphp

            <div class="party-card bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm animate-fade-in"
                style="animation-delay: {{ $index * 0.05 }}s" data-name="{{ strtolower($party->name) }}"
                data-status="{{ $isExpired ? 'expired' : ($isWarning ? 'warning' : 'fresh') }}">

                <div class="p-5">
                    <div class="flex items-start gap-4">
                        <!-- Image -->
                        @if ($party->image)
                            <img src="{{ Storage::url($party->image) }}" alt="{{ $party->name }}" class="image-thumb">
                        @else
                            <div class="image-placeholder">
                                <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 flex-wrap">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-display font-700 text-gray-900 dark:text-white text-base">
                                            {{ $party->name }}</h3>
                                        <span class="status-badge {{ $statusCls }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $statusLbl }}
                                        </span>
                                    </div>
                                    @if ($party->rating)
                                        <div class="flex items-center gap-1 mt-1">
                                            <span class="star-rating text-sm">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    {{ $i <= round($party->rating) ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <span class="text-xs text-gray-400">({{ $party->rating }})</span>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 line-clamp-1">
                                        {{ $party->description }}</p>
                                </div>

                                @if ($party->price)
                                    <div class="text-right flex-shrink-0">
                                        <p class="font-display font-700 text-lg text-gray-900 dark:text-white">
                                            {{ number_format($party->price) }} <span
                                                class="text-xs font-normal text-gray-400">so'm</span>
                                        </p>
                                        <p class="text-xs text-gray-400">birlik narxi</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 mt-3 flex-wrap">
                                <span class="uniq-badge">#{{ $party->uniq_id }}</span>

                                @if ($party->manufactured_at)
                                    <span class="flex items-center gap-1 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Ishlab chiqarilgan:
                                        {{ \Carbon\Carbon::parse($party->manufactured_at)->format('d.m.Y') }}
                                    </span>
                                @endif

                                @if ($party->expires_at)
                                    <span
                                        class="flex items-center gap-1 text-xs {{ $isExpired ? 'text-rose-500' : ($isWarning ? 'text-amber-500' : 'text-gray-400') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Muddat: {{ \Carbon\Carbon::parse($party->expires_at)->format('d.m.Y') }}
                                    </span>
                                @endif

                                <span class="flex items-center gap-1 text-xs text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
                                    </svg>
                                    {{ number_format($scanCnt) }} skan
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50 dark:border-gray-800">
                        <div class="flex items-center gap-4 flex-1 mr-4">
                            <span class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <strong class="text-gray-700 dark:text-gray-200">{{ $productCnt }}</strong> ta mahsulot
                            </span>
                            @if ($productCnt > 0)
                                <div class="flex-1 max-w-32">
                                    <div class="progress-mini">
                                        <div class="progress-fill" style="width: {{ $scanPct }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $scanPct }}% faollik</p>
                                </div>
                            @endif
                        </div>

                        @if ($productCnt > 0)
                            <button onclick="toggleProducts({{ $party->id }})"
                                class="flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/20 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors">
                                <span id="expandText-{{ $party->id }}">Mahsulotlarni ko'rish</span>
                                <svg id="expandIcon-{{ $party->id }}" class="w-4 h-4 expand-btn" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        @else
                            <span class="text-xs text-gray-400 italic">Mahsulot yo'q</span>
                        @endif
                    </div>
                </div>

                <!-- Products Table -->
                @if ($productCnt > 0)
                    <div id="products-{{ $party->id }}"
                        class="products-section border-t border-gray-50 dark:border-gray-800">
                        <div class="p-4">
                            <p
                                class="text-xs font-display font-600 uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">
                                Mahsulotlar ro'yxati
                            </p>
                            <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-800/50">
                                            <th
                                                class="text-left px-4 py-2.5 text-xs font-600 text-gray-400 uppercase tracking-wider">
                                                #</th>
                                            <th
                                                class="text-left px-4 py-2.5 text-xs font-600 text-gray-400 uppercase tracking-wider">
                                                QR Kod</th>
                                            <th
                                                class="text-left px-4 py-2.5 text-xs font-600 text-gray-400 uppercase tracking-wider">
                                                Barkod</th>
                                            <th
                                                class="text-left px-4 py-2.5 text-xs font-600 text-gray-400 uppercase tracking-wider">
                                                Skanlar</th>
                                            <th
                                                class="text-left px-4 py-2.5 text-xs font-600 text-gray-400 uppercase tracking-wider">
                                                Sana</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-50 dark:divide-gray-800">
                                        @foreach ($party->products as $pIdx => $product)
                                            <tr class="product-row">
                                                <td class="px-4 py-3 text-xs text-gray-400">{{ $pIdx + 1 }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="uniq-badge">{{ $product->qrcode_number }}</span>
                                                </td>
                                                <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-300">
                                                    {{ $product->barcode_number }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="text-sm font-600 {{ $product->scan_count > 5 ? 'text-primary-600 dark:text-primary-400' : 'text-gray-700 dark:text-gray-300' }}">
                                                            {{ $product->scan_count }}
                                                        </span>
                                                        @if ($product->scan_count > 0)
                                                            <div class="w-12 progress-mini">
                                                                <div class="progress-fill"
                                                                    style="width: {{ min(100, $product->scan_count * 10) }}%">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-xs text-gray-400">
                                                    {{ $product->created_at->format('d.m.Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-display font-700 text-gray-700 dark:text-gray-300 mb-1">Partiyalar topilmadi</h3>
                <p class="text-sm text-gray-400">Hali hech qanday partiya qo'shilmagan</p>
            </div>
        @endforelse
    </div>

    @if ($parties->hasPages())
        <div class="mt-6 flex justify-center">{{ $parties->links() }}</div>
    @endif

    <script>
        function toggleProducts(id) {
            const section = document.getElementById('products-' + id);
            const icon = document.getElementById('expandIcon-' + id);
            const text = document.getElementById('expandText-' + id);
            const isOpen = section.classList.contains('open');
            section.classList.toggle('open', !isOpen);
            icon.classList.toggle('open', !isOpen);
            text.textContent = isOpen ? "Mahsulotlarni ko'rish" : 'Yopish';
        }

        document.getElementById('searchInput').addEventListener('input', filter);
        document.getElementById('statusFilter').addEventListener('change', filter);

        function filter() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const s = document.getElementById('statusFilter').value;
            document.querySelectorAll('.party-card').forEach(c => {
                c.style.display = (c.dataset.name.includes(q) && (s === 'all' || c.dataset.status === s)) ? '' :
                    'none';
            });
        }
    </script>

@endsection
