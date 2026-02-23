{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}


@extends('layouts.index')
@section('content')
    <!-- Page heading -->
    <div class="mb-8 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-display text-2xl font-700 text-gray-900 dark:text-white">Bosh sahifa</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Xush kelibsiz! Bugungi holat
                    quyida.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400 dark:text-gray-500">
                    <span x-text="today"></span>
                </span>
                {{-- <button
                    class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white text-sm font-medium rounded-xl shadow-lg shadow-primary-500/25 transition-all hover:shadow-primary-500/40 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Yangi qo'shish
                </button> --}}
            </div>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <template x-for="(stat, i) in stats" :key="stat.id">
            <div class="stat-card bg-white dark:bg-gray-900 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-gray-800"
                :style="`animation-delay: ${i * 100}ms`" style="animation: fadeIn 0.5s ease forwards; opacity: 0;">
                <div class="flex items-start justify-between mb-4">
                    <div :class="stat.iconBg" class="w-11 h-11 rounded-xl flex items-center justify-center">
                        <span class="w-5 h-5" x-html="stat.icon"></span>
                    </div>
                    <span
                        :class="stat.change > 0 ?
                            'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 dark:text-emerald-400' :
                            'text-red-500 bg-red-50 dark:bg-red-900/20 dark:text-red-400'"
                        class="text-xs font-display font-600 px-2 py-1 rounded-lg flex items-center gap-1">
                        <svg x-show="stat.change > 0" class="w-3 h-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        <svg x-show="stat.change < 0" class="w-3 h-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        <span x-text="Math.abs(stat.change) + '%'"></span>
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-1" x-text="stat.label">
                </p>
                <p class="font-display text-2xl font-700 text-gray-900 dark:text-white" x-text="stat.value"></p>
                <div class="mt-3 bg-gray-100 dark:bg-gray-800 rounded-full h-1.5 overflow-hidden">
                    <div :style="`width: ${stat.progress}%`" :class="stat.progressColor"
                        class="h-full rounded-full progress-bar"></div>
                </div>
            </div>
        </template>
    </div>

    <!-- CHARTS + QUICK ACTIONS -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-8">

        <!-- Main chart -->
        <div
            class="xl:col-span-2 bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-display font-700 text-gray-900 dark:text-white">Foydalanuvchilar
                        grafigi</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Oylik statistika</p>
                </div>
                <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 rounded-xl p-1">
                    <template x-for="period in ['Hafta', 'Oy', 'Yil']" :key="period">
                        <button @click="activePeriod = period"
                            :class="activePeriod === period ?
                                'bg-white dark:bg-gray-700 shadow text-primary-600 dark:text-primary-400' :
                                'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                            class="px-3 py-1.5 text-xs font-display font-600 rounded-lg transition-all" x-text="period">
                        </button>
                    </template>
                </div>
            </div>
            <div class="h-56">
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <!-- Traffic sources -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <h2 class="font-display font-700 text-gray-900 dark:text-white mb-1">Trafik manbalari</h2>
            <p class="text-sm text-gray-400 mb-6">Bu oy</p>
            <div class="h-40 flex items-center justify-center mb-6">
                <canvas id="doughnutChart"></canvas>
            </div>
            <div class="space-y-3">
                <template x-for="source in trafficSources" :key="source.label">
                    <div class="flex items-center gap-3">
                        <div :class="source.color" class="w-3 h-3 rounded-full flex-shrink-0"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400 flex-1" x-text="source.label"></span>
                        <span class="text-sm font-display font-600 text-gray-900 dark:text-white"
                            x-text="source.value + '%'"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- TABLE + RECENT ACTIVITY -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- Users table -->
        <div
            class="xl:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h2 class="font-display font-700 text-gray-900 dark:text-white">So'nggi foydalanuvchilar
                </h2>
                <a href="#"
                    class="text-sm text-primary-500 hover:text-primary-600 font-medium transition-colors">Barchasi
                    →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-50 dark:border-gray-800">
                            <th
                                class="px-6 py-3 text-left text-xs font-display font-600 uppercase tracking-wider text-gray-400">
                                Foydalanuvchi</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-display font-600 uppercase tracking-wider text-gray-400">
                                Holat</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-display font-600 uppercase tracking-wider text-gray-400">
                                Rol</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-display font-600 uppercase tracking-wider text-gray-400">
                                Sana</th>
                            <th
                                class="px-6 py-3 text-right text-xs font-display font-600 uppercase tracking-wider text-gray-400">
                                Amal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="user in users" :key="user.id">
                            <tr
                                class="table-row-hover border-b border-gray-50 dark:border-gray-800/50 last:border-0 transition-colors">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div :class="user.avatarColor"
                                            class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-sm font-display font-700"
                                            x-text="user.name[0]"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="user.name">
                                            </p>
                                            <p class="text-xs text-gray-400" x-text="user.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5">
                                    <span
                                        :class="user.status === 'Faol' ?
                                            'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' :
                                            'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400'"
                                        class="text-xs font-medium px-2.5 py-1 rounded-lg" x-text="user.status"></span>
                                </td>
                                <td class="px-6 py-3.5 text-sm text-gray-500 dark:text-gray-400" x-text="user.role"></td>
                                <td class="px-6 py-3.5 text-sm text-gray-400" x-text="user.date"></td>
                                <td class="px-6 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button
                                            class="p-1.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 text-gray-400 hover:text-primary-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button
                                            class="p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent activity -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
            <h2 class="font-display font-700 text-gray-900 dark:text-white mb-5">So'nggi faollik</h2>
            <div class="space-y-4 relative">
                <div
                    class="absolute left-4 top-2 bottom-2 w-px bg-gradient-to-b from-primary-200 via-primary-100 to-transparent dark:from-primary-800 dark:via-primary-900">
                </div>
                <template x-for="activity in activities" :key="activity.id">
                    <div class="flex gap-4 relative">
                        <div :class="activity.iconBg"
                            class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 z-10 border-2 border-white dark:border-gray-900">
                            <span class="w-3.5 h-3.5" x-html="activity.icon"></span>
                        </div>
                        <div class="min-w-0 pt-0.5">
                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-snug" x-text="activity.text"></p>
                            <p class="text-xs text-gray-400 mt-1" x-text="activity.time"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <!-- Toast container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3" style="pointer-events:none;">
        @if (session('success'))
            <div class="toast-item flex items-center gap-3 px-5 py-4 rounded-2xl border"
                style="background:rgba(16,185,129,0.12); border-color:rgba(16,185,129,0.25); pointer-events:all; min-width:300px;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background:rgba(16,185,129,0.2);">
                    <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-display text-sm font-600" style="color:#10b981;">Muvaffaqiyatli!</p>
                    <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('.toast-item').remove()" class="text-xs transition-colors"
                    style="color:rgba(255,255,255,0.25);">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-item flex items-center gap-3 px-5 py-4 rounded-2xl border"
                style="background:rgba(248,113,113,0.1); border-color:rgba(248,113,113,0.25); pointer-events:all; min-width:300px;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background:rgba(248,113,113,0.15);">
                    <svg class="w-4 h-4" style="color:#f87171;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-display text-sm font-600" style="color:#f87171;">Xatolik!</p>
                    <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">{{ session('error') }}</p>
                </div>
                <button onclick="this.closest('.toast-item').remove()" class="text-xs transition-colors"
                    style="color:rgba(255,255,255,0.25);">✕</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast-item flex items-center gap-3 px-5 py-4 rounded-2xl border"
                style="background:rgba(248,113,113,0.1); border-color:rgba(248,113,113,0.25); pointer-events:all; min-width:300px;">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background:rgba(248,113,113,0.15);">
                    <svg class="w-4 h-4" style="color:#f87171;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-display text-sm font-600" style="color:#f87171;">Xatoliklar mavjud</p>
                    <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">{{ $errors->first() }}</p>
                </div>
                <button onclick="this.closest('.toast-item').remove()" class="text-xs"
                    style="color:rgba(255,255,255,0.25);">✕</button>
            </div>
        @endif
    </div>

    <style>
        .toast-item {
            animation: toastIn .4s cubic-bezier(.34, 1.56, .64, 1) both;
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

    <script>
        // 4 soniyadan keyin avtomatik yo'qolish
        document.querySelectorAll('.toast-item').forEach((el, i) => {
            setTimeout(() => {
                el.style.transition = 'opacity .4s ease, transform .4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(40px)';
                setTimeout(() => el.remove(), 400);
            }, 4000 + i * 300);
        });
    </script>
@endsection
