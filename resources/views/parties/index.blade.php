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

        /* Modal overlay — har qanday elementdan ustda */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .modal-container {
            position: fixed;
            inset: 0;
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            pointer-events: none;
        }

        .modal-box {
            background: white;
            border-radius: 20px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 672px;
            max-height: 90vh;
            overflow-y: auto;
            pointer-events: all;
            position: relative;
        }

        .dark .modal-box {
            background: #111827;
        }

        .modal-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: white;
            border-bottom: 1px solid #f3f4f6;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dark .modal-header {
            background: #111827;
            border-color: #1f2937;
        }

        .modal-footer {
            position: sticky;
            bottom: 0;
            background: white;
            border-top: 1px solid #f3f4f6;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        .dark .modal-footer {
            background: #111827;
            border-color: #1f2937;
        }

        .product_add_button {
            font-size: 12px;
            border: none;
            outline: none;
            color: white;
            padding: 5px;
            background: linear-gradient(to right, rgb(152, 210, 221), rgb(104, 147, 204));
            border-radius: 10px;
            box-shadow: 0 0 4px 1px rgb(73, 193, 240);
        }
    </style>

    {{-- ═══════════════════════════════════════════
         MODAL — x-data sahifa darajasida
    ═══════════════════════════════════════════ --}}
    <div x-data="{
        open: false,
        loading: false,
        imagePreview: null,
        rating: 0,
        onImage(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => this.imagePreview = ev.target.result;
            reader.readAsDataURL(file);
        },
    
        // TAHRIRLASH MODAL
        editOpen: false,
        editLoading: false,
        editImagePreview: null,
        editRating: 0,
        editParty: {},
        openEdit(party) {
            this.editParty = { ...party };
            this.editRating = party.rating || 0;
            this.editImagePreview = party.image_url || null;
            this.editOpen = true;
        },
        onEditImage(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => this.editImagePreview = ev.target.result;
            reader.readAsDataURL(file);
        }
    }">

        {{-- ── Backdrop ── --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
            class="modal-overlay" style="display: none;">
        </div>

        {{-- ── Modal ── --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2" @keydown.escape.window="open = false"
            class="modal-container" style="display: none;">

            <div class="modal-box">

                {{-- Header --}}
                <div class="modal-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-md flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display font-700 text-gray-900 dark:text-white text-base">Yangi Partiya</h3>
                            <p class="text-xs text-gray-400">Barcha maydonlarni to'ldiring</p>
                        </div>
                    </div>
                    <button @click="open = false"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('parties.store') }}" method="POST" enctype="multipart/form-data"
                    @submit="loading = true">
                    @csrf

                    <div class="px-6 py-5 space-y-5">

                        {{-- Rasm --}}
                        <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                                Partiya rasmi
                            </label>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                    <template x-if="imagePreview">
                                        <img :src="imagePreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!imagePreview">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </template>
                                </div>
                                <label class="flex-1 cursor-pointer">
                                    <div
                                        class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-center hover:border-primary-400 transition-colors">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="text-primary-500 font-600">Fayl tanlash</span> yoki bu yerga
                                            tashlang
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">PNG, JPG — max 2MB</p>
                                    </div>
                                    <input type="file" name="image" accept="image/*" class="hidden"
                                        @change="onImage($event)" required>
                                </label>
                            </div>
                        </div>

                        {{-- 2 ustun --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Nomi --}}
                            <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Partiya nomi <span class="text-rose-400">*</span>
                                </label>
                                <input type="text" name="name" required placeholder="Masalan: A-001 Seriya"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                            </div>

                            {{-- Brand --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Brand <span class="text-rose-400">*</span>
                                </label>
                                <input type="text" name="brand_id" value="{{ $brand->name }}" readonly
                                    placeholder="Masalan: A-001 Seriya"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                            </div> --}}

                            {{-- Narx --}}
                            <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Birlik narxi
                                </label>
                                <div class="relative">
                                    <input type="number" name="price" min="0" placeholder="0"
                                        class="w-full pl-3 pr-14 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                                    <span
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-600">so'm</span>
                                </div>
                            </div>

                            {{-- Buyurtma soni --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Buyurtma soni <span class="text-rose-400">*</span>
                                </label>
                                <input type="number" name="order" min="1" required placeholder="100"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                            </div> --}}

                            {{-- Ishlab chiqarilgan --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Ishlab chiqarilgan sana
                                </label>
                                <input type="date" name="manufactured_at"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 transition-all text-gray-800 dark:text-gray-200">
                            </div> --}}

                            {{-- Muddat --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Saqlash muddati
                                </label>
                                <input type="date" name="expires_at"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 transition-all text-gray-800 dark:text-gray-200">
                            </div> --}}
                        </div>

                        {{-- Reyting --}}
                        {{-- <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                                Reyting
                            </label>
                            <div class="flex items-center gap-1">
                                <template x-for="star in [1,2,3,4,5]">
                                    <button type="button" @click="rating = star"
                                        :class="star <= rating ? 'text-amber-400' : 'text-gray-200 dark:text-gray-700'"
                                        class="text-2xl transition-colors hover:text-amber-300 focus:outline-none">★</button>
                                </template>
                                <span x-text="rating > 0 ? rating + ' / 5' : 'Tanlanmagan'"
                                    class="ml-2 text-xs text-gray-400"></span>
                            </div>
                            <input type="hidden" name="rating" :value="rating || ''">
                        </div> --}}

                        {{-- Tavsif --}}
                        <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                Tavsif <span class="text-rose-400">*</span>
                            </label>
                            <textarea name="description" rows="3" required placeholder="Partiya haqida qisqacha ma'lumot..."
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-primary-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400 resize-none"></textarea>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                            Bekor qilish
                        </button>
                        <button type="submit" :disabled="loading"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-600 text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 rounded-xl shadow-lg shadow-primary-500/25 transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            <span x-text="loading ? 'Saqlanmoqda...' : 'Saqlash'"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>


        {{-- ── TAHRIRLASH MODAL Backdrop ── --}}
        <div x-show="editOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="editOpen = false"
            class="modal-overlay" style="display: none;"></div>

        {{-- ── TAHRIRLASH MODAL ── --}}
        <div x-show="editOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2" @keydown.escape.window="editOpen = false"
            class="modal-container" style="display: none;">

            <div class="modal-box">

                {{-- Header --}}
                <div class="modal-header">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-md flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display font-700 text-gray-900 dark:text-white text-base">Partiyani tahrirlash
                            </h3>
                            <p class="text-xs text-gray-400" x-text="'#' + (editParty.uniq_id || '')"></p>
                        </div>
                    </div>
                    <button @click="editOpen = false"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form :action="'/parties/' + editParty.id" method="POST" enctype="multipart/form-data"
                    @submit="editLoading = true">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-5 space-y-5">

                        {{-- Rasm --}}
                        <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                                Partiya rasmi
                            </label>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                    <template x-if="editImagePreview">
                                        <img :src="editImagePreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!editImagePreview">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </template>
                                </div>
                                <label class="flex-1 cursor-pointer">
                                    <div
                                        class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-center hover:border-amber-400 transition-colors">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="text-amber-500 font-600">Fayl tanlash</span> yoki bu yerga
                                            tashlang
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">PNG, JPG — max 2MB</p>
                                    </div>
                                    <input type="file" name="image" accept="image/*" class="hidden"
                                        @change="onEditImage($event)">
                                </label>
                            </div>
                        </div>

                        {{-- 2 ustun --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Nomi --}}
                            <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Partiya nomi <span class="text-rose-400">*</span>
                                </label>
                                <input type="text" name="name" required :value="editParty.name"
                                    placeholder="Masalan: A-001 Seriya"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-amber-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                            </div>

                            {{-- Narx --}}
                            <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Birlik narxi
                                </label>
                                <div class="relative">
                                    <input type="number" name="price" min="0" :value="editParty.price"
                                        placeholder="0"
                                        class="w-full pl-3 pr-14 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-amber-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400">
                                    <span
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-600">so'm</span>
                                </div>
                            </div>

                            {{-- Ishlab chiqarilgan --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Ishlab chiqarilgan sana
                                </label>
                                <input type="date" name="manufactured_at" :value="editParty.manufactured_at"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-amber-400 transition-all text-gray-800 dark:text-gray-200">
                            </div> --}}

                            {{-- Muddat --}}
                            {{-- <div>
                                <label
                                    class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                    Saqlash muddati
                                </label>
                                <input type="date" name="expires_at" :value="editParty.expires_at"
                                    class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-amber-400 transition-all text-gray-800 dark:text-gray-200">
                            </div> --}}
                        </div>

                        {{-- Reyting --}}
                        {{-- <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">
                                Reyting
                            </label>
                            <div class="flex items-center gap-1">
                                <template x-for="star in [1,2,3,4,5]">
                                    <button type="button" @click="editRating = star"
                                        :class="star <= editRating ? 'text-amber-400' : 'text-gray-200 dark:text-gray-700'"
                                        class="text-2xl transition-colors hover:text-amber-300 focus:outline-none">★</button>
                                </template>
                                <span x-text="editRating > 0 ? editRating + ' / 5' : 'Tanlanmagan'"
                                    class="ml-2 text-xs text-gray-400"></span>
                            </div>
                            <input type="hidden" name="rating" :value="editRating || ''">
                        </div> --}}

                        {{-- Tavsif --}}
                        <div>
                            <label
                                class="block text-xs font-600 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                Tavsif <span class="text-rose-400">*</span>
                            </label>
                            <textarea name="description" rows="3" required :value="editParty.description"
                                placeholder="Partiya haqida qisqacha ma'lumot..."
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl outline-none focus:border-amber-400 focus:bg-white dark:focus:bg-gray-900 transition-all text-gray-800 dark:text-gray-200 placeholder-gray-400 resize-none"
                                x-text="editParty.description"></textarea>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="button" @click="editOpen = false"
                            class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                            Bekor qilish
                        </button>
                        <button type="submit" :disabled="editLoading"
                            class="flex items-center gap-2 px-5 py-2.5 text-sm font-600 text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 rounded-xl shadow-lg shadow-amber-500/25 transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg x-show="editLoading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            <span x-text="editLoading ? 'Saqlanmoqda...' : 'Saqlash'"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════
             PAGE CONTENT
        ═══════════════════════════════════════════ --}}

        <!-- Heading -->
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="font-display text-2xl font-700 text-gray-900 dark:text-white">Partiyalar</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Xush kelibsiz! Bugungi holat quyida.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="download_shablon px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-600 dark:text-gray-300 hover:border-primary-400 transition-all">
                        Shablon⬇️
                    </button>
                    @if (auth()->user()->brand->status == 'active')
                        <button @click="open = true"
                            class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-600 dark:text-gray-300 hover:border-primary-400 transition-all">
                            + Partiya
                        </button>
                    @else
                        <button id="brand_dontactive"
                            class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-600 dark:text-gray-300 hover:border-primary-400 transition-all">
                            + Partiya
                        </button>
                    @endif
                    <script>
                        const downloadShablon = document.querySelector('.download_shablon');
                        downloadShablon.addEventListener('click', () => {
                            window.location.href = '/download/shablon?id={{ Auth::user()->id }}';
                        });
                    </script>
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
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $s['gradient'] }} flex items-center justify-center shadow-md flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $s['path'] }}" />
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
                    $dialogId = 'dialog-' . $party->id;
                @endphp

                <div class="party-card bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm animate-fade-in"
                    style="animation-delay: {{ $index * 0.05 }}s" data-name="{{ strtolower($party->name) }}"
                    data-status="{{ $isExpired ? 'expired' : ($isWarning ? 'warning' : 'fresh') }}">

                    <div class="p-5">
                        <div class="flex items-start gap-4">
                            @if ($party->image)
                                <img src="{{ Storage::url($party->image) }}" alt="{{ $party->name }}"
                                    class="image-thumb">
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

                                            @if (auth()->user()->brand->status == 'active' && $party->products->isEmpty())
                                                <button command="show-modal" commandfor={{ $dialogId }}
                                                    class="product_add_button rounded-md bg-white/10 px-2.5 py-1.5 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Mahsulot+</button>
                                            @endif
                                            <el-dialog>
                                                <dialog id={{ $dialogId }} aria-labelledby="dialog-title"
                                                    class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                                                    <el-dialog-backdrop
                                                        class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                                                    <div tabindex="0"
                                                        class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                                                        <el-dialog-panel
                                                            class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                                                            <form action="{{ route('products.import') }}"
                                                                enctype="multipart/form-data" method="POST">
                                                                @csrf
                                                                <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                    <div class="sm:flex sm:items-start">
                                                                        <div
                                                                            class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-500/10 sm:mx-0 sm:size-10">
                                                                            <svg viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="1.5"
                                                                                data-slot="icon" aria-hidden="true"
                                                                                class="size-6 text-red-400">
                                                                                <path
                                                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                        </div>
                                                                        <div
                                                                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                            <h3 id="dialog-title"
                                                                                class="text-base font-semibold text-white">
                                                                                Excel fayl tanlang</h3>
                                                                            <div class="mt-2">
                                                                                <input type="file" name="file"
                                                                                    accept=".xlsx,.xls" required>
                                                                                <input type="hidden" name="party_id"
                                                                                    value="{{ $party->id }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="bg-gray-700/25 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                                    <button type="submit" command="close"
                                                                        commandfor={{ $dialogId }}
                                                                        class="inline-flex w-full justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-400 sm:ml-3 sm:w-auto">Saqlash</button>
                                                                    <button type="button" command="close"
                                                                        commandfor={{ $dialogId }}
                                                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20 sm:mt-0 sm:w-auto">Orqaga</button>
                                                                </div>
                                                            </form>
                                                        </el-dialog-panel>
                                                    </div>
                                                </dialog>
                                            </el-dialog>

                                            @if (auth()->user()->brand->status == 'active')
                                                <button class="product_add_button" type="button"
                                                    @click="openEdit({
                                                    id: {{ $party->id }},
                                                    uniq_id: '{{ $party->uniq_id }}',
                                                    name: '{{ addslashes($party->name) }}',
                                                    price: '{{ $party->price }}',
                                                    rating: {{ $party->rating ?? 0 }},
                                                    description: '{{ addslashes($party->description) }}',
                                                    manufactured_at: '{{ $party->manufactured_at ? \Carbon\Carbon::parse($party->manufactured_at)->format('Y-m-d') : '' }}',
                                                    expires_at: '{{ $party->expires_at ? \Carbon\Carbon::parse($party->expires_at)->format('Y-m-d') : '' }}',
                                                    image_url: '{{ $party->image ? Storage::url($party->image) : '' }}'
                                                })">
                                                    <svg width="18" height="18" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor">
                                                        <path d="M12 20h9" />
                                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('party.delete', $party->id) }}" method="POST"
                                                    onsubmit="return confirm('Tasdiqlaysizmi')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="product_add_button">
                                                        <svg width="18" height="18" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M3 6h18" />
                                                            <path d="M8 6V4h8v2" />
                                                            <path d="M19 6l-1 14H6L5 6" />
                                                            <path d="M10 11v6" />
                                                            <path d="M14 11v6" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @if (!$party->product)
                                                    <form
                                                        action="{{ route('party.activated', ['party_id' => $party->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="product_add_button">
                                                            {!! $party->partyStatusBtn() !!}
                                                        </button>
                                                    </form>
                                                @endif
                                                <span>
                                                    {!! $party->partyStatus() !!}
                                                </span>
                                            @endif
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
                                                {{ number_format($party->price) }}
                                                <span class="text-xs font-normal text-gray-400">so'm</span>
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
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01" />
                                        </svg>
                                        {{ number_format($scanCnt) }} skan
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div
                            class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50 dark:border-gray-800">
                            <div class="flex items-center gap-4 flex-1 mr-4">
                                <span class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <strong class="text-gray-700 dark:text-gray-200">{{ $productCnt }}</strong> ta
                                    mahsulot
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
                                        <tbody
                                            class="bg-white dark:bg-gray-900 divide-y divide-gray-50 dark:divide-gray-800">
                                            @foreach ($party->products as $pIdx => $product)
                                                <tr class="product-row">
                                                    <td class="px-4 py-3 text-xs text-gray-400">{{ $pIdx + 1 }}</td>
                                                    <td class="px-4 py-3">
                                                        <span class="uniq-badge">{{ $product->qrcode_number }}</span>
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-300">
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

    </div>{{-- /x-data --}}

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
                    <p class="text-xs mt-0.5" style="color:rgba(24, 23, 23, 0.5);">{{ session('success') }}</p>
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
                    <p class="text-xs mt-0.5" style="color:rgba(24, 23, 23, 0.5);">{{ session('error') }}</p>
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
                    <p class="text-xs mt-0.5" style="color:rgba(24, 23, 23, 0.5);">{{ $errors->first() }}</p>
                </div>
                <button onclick="this.closest('.toast-item').remove()" class="text-xs"
                    style="color:rgba(24, 23, 23, 0.5);">✕</button>
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

    <script>
        document.getElementById('brand_dontactive').addEventListener('click', () => {
            alert('Brandingiz admin tomonidan tekshiruvda,tez orada jarayon aktivlashadi.')
        })
    </script>
@endsection
