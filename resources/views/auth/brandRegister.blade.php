<!DOCTYPE html>
<html lang="uz" x-data="brandRegister()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brend ro'yxatdan o'tkazish</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Cabinet+Grotesk:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Clash Display"', 'sans-serif'],
                        body: ['"Cabinet Grotesk"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Cabinet Grotesk', sans-serif;
        }

        .font-display,
        h1,
        h2,
        h3,
        label {
            font-family: 'Clash Display', sans-serif;
        }

        body {
            background: #0a0a0f;
            min-height: 100vh;
        }

        /* Animated background */
        .bg-glow {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bg-glow::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            animation: drift1 12s ease-in-out infinite;
        }

        .bg-glow::after {
            content: '';
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.12) 0%, transparent 70%);
            animation: drift2 15s ease-in-out infinite;
        }

        @keyframes drift1 {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(60px, 40px);
            }
        }

        @keyframes drift2 {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-40px, -60px);
            }
        }

        /* Grid pattern */
        .grid-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
        }

        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: #f1f5f9;
            font-size: 14px;
            transition: all 0.2s ease;
            outline: none;
            font-family: 'Cabinet Grotesk', sans-serif;
        }

        .form-input:focus {
            border-color: rgba(99, 102, 241, 0.6);
            background: rgba(99, 102, 241, 0.06);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .form-input option {
            background: #1e1e2e;
            color: #f1f5f9;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 8px;
            font-family: 'Clash Display', sans-serif;
        }

        .form-error {
            font-size: 12px;
            color: #f87171;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Logo upload */
        .upload-zone {
            border: 2px dashed rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: rgba(99, 102, 241, 0.5);
            background: rgba(99, 102, 241, 0.06);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            font-family: 'Clash Display', sans-serif;
            font-size: 15px;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            letter-spacing: 0.02em;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Step indicator */
        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            width: 24px;
            border-radius: 4px;
            background: #6366f1;
        }

        .step-dot.done {
            background: #10b981;
        }

        /* Progress line */
        .progress-line {
            height: 2px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #6366f1, #ec4899);
            border-radius: 99px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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

        .fade-up {
            animation: fadeUp 0.4s ease forwards;
        }

        /* Textarea */
        textarea.form-input {
            resize: none;
            min-height: 100px;
        }

        /* Number input */
        input[type=number]::-webkit-inner-spin-button {
            opacity: 0;
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>
    <div class="grid-pattern"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-2xl">

            <!-- Header -->
            <div class="text-center mb-10 fade-up">
                <div
                    class="inline-flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 rounded-full px-4 py-1.5 mb-6">
                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></span>
                    <span class="text-indigo-300 text-xs font-display font-600 tracking-widest uppercase">Yangi
                        brend</span>
                </div>
                <h1 class="font-display text-4xl font-700 text-white mb-3">
                    Brendni ro'yxatdan<br>
                    <span
                        style="background: linear-gradient(135deg, #6366f1, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">o'tkazing</span>
                </h1>
                <p class="text-white/40 text-sm">Barcha maydonlarni to'ldiring</p>
            </div>

            <!-- Progress -->
            <div class="mb-8 fade-up" style="animation-delay:0.1s">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-white/40 text-xs font-display uppercase tracking-wider">Jarayon</span>
                    <span class="text-indigo-400 text-xs font-display font-600"
                        x-text="Math.round(progress) + '%'"></span>
                </div>
                <div class="progress-line">
                    <div class="progress-fill" :style="`width: ${progress}%`"></div>
                </div>
                <div class="flex gap-2 mt-3">
                    <template x-for="(step, i) in steps" :key="i">
                        <div :class="{
                            'active': currentStep === i,
                            'done': currentStep > i
                        }"
                            class="step-dot"></div>
                    </template>
                </div>
            </div>

            <!-- Form card -->
            <div class="card rounded-2xl p-8 fade-up" style="animation-delay:0.15s">
                <form method="POST" action="{{ route('brand.store') }}" enctype="multipart/form-data"
                    @submit.prevent="submitForm">
                    @csrf

                    <!-- ═══ STEP 1: Asosiy ma'lumotlar ═══ -->
                    <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        <h2 class="font-display text-lg font-600 text-white mb-6 flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center text-indigo-400 text-xs">1</span>
                            Asosiy ma'lumotlar
                        </h2>

                        <div class="space-y-5">

                            <!-- Brend nomi -->
                            <div>
                                <label class="form-label">Brend nomi *</label>
                                <input type="text" name="name" x-model="form.name" @input="validateField('name')"
                                    placeholder="Masalan: Nike, Adidas..." class="form-input"
                                    :class="errors.name ? 'border-red-500/50' : ''">
                                <p x-show="errors.name" class="form-error">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                    </svg>
                                    <span x-text="errors.name"></span>
                                </p>
                            </div>

                            <!-- Viloyat -->
                            <div>
                                <label class="form-label">Viloyat *</label>
                                <select name="viloyat_id" x-model="form.viloyat_id"
                                    @change="validateField('viloyat_id')" class="form-input"
                                    :class="errors.viloyat_id ? 'border-red-500/50' : ''">
                                    <option value="">— Viloyatni tanlang —</option>
                                    @foreach ($viloyatlar as $viloyat)
                                        <option value="{{ $viloyat->id }}"
                                            {{ old('viloyat_id') == $viloyat->id ? 'selected' : '' }}>
                                            {{ $viloyat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p x-show="errors.viloyat_id" class="form-error">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                    </svg>
                                    <span x-text="errors.viloyat_id"></span>
                                </p>
                            </div>

                            <!-- Litsenziya -->
                            <div>
                                <label class="form-label">Litsenziya *</label>
                                <div class="relative">
                                    <input type="file" name="license" x-model="form.license"
                                        @input="validateField('license')" placeholder="LIC-2024-XXXXXXX"
                                        class="form-input pl-10" :class="errors.license ? 'border-red-500/50' : ''">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/30">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    </div>
                                </div>
                                <p x-show="errors.license" class="form-error">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                    </svg>
                                    <span x-text="errors.license"></span>
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" @click="nextStep()" class="btn-submit"
                                style="width:auto; padding: 12px 32px;">
                                Keyingisi
                                <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- ═══ STEP 2: Logo va tavsif ═══ -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        <h2 class="font-display text-lg font-600 text-white mb-6 flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center text-indigo-400 text-xs">2</span>
                            Logo va tavsif
                        </h2>

                        <div class="space-y-5">

                            <!-- Logo upload -->
                            <div>
                                <label class="form-label">Brend logosi *</label>
                                <div class="upload-zone" :class="{ 'dragover': isDragging }"
                                    @dragover.prevent="isDragging = true" @dragleave="isDragging = false"
                                    @drop.prevent="handleDrop($event)">
                                    <input type="file" name="logo" accept="image/*"
                                        @change="handleFile($event)" id="logo-input">

                                    <!-- Preview -->
                                    <div x-show="logoPreview" class="mb-4">
                                        <img :src="logoPreview"
                                            class="w-20 h-20 object-contain rounded-xl mx-auto border border-white/10">
                                    </div>

                                    <div x-show="!logoPreview">
                                        <div
                                            class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-white/50 text-sm">Rasmni bu yerga tashlang yoki <span
                                                class="text-indigo-400">tanlang</span></p>
                                        <p class="text-white/25 text-xs mt-1">PNG, JPG, SVG — max 2MB</p>
                                    </div>

                                    <div x-show="logoPreview" class="mt-2">
                                        <p class="text-green-400 text-xs font-display" x-text="logoName"></p>
                                        <button type="button" @click.stop="clearLogo()"
                                            class="text-white/30 hover:text-red-400 text-xs mt-1 transition-colors">✕
                                            O'chirish</button>
                                    </div>
                                </div>
                                <p x-show="errors.logo" class="form-error mt-2">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                    </svg>
                                    <span x-text="errors.logo"></span>
                                </p>
                            </div>

                            <!-- Tavsif -->
                            <div>
                                <label class="form-label">Tavsif *</label>
                                <textarea name="description" x-model="form.description" @input="validateField('description')"
                                    placeholder="Brend haqida qisqacha ma'lumot..." class="form-input"
                                    :class="errors.description ? 'border-red-500/50' : ''" rows="4"></textarea>
                                <div class="flex items-center justify-between mt-1.5">
                                    <p x-show="errors.description" class="form-error">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                                        </svg>
                                        <span x-text="errors.description"></span>
                                    </p>
                                    <span class="text-white/25 text-xs ml-auto"
                                        x-text="form.description.length + ' / 500'"></span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="prevStep()"
                                class="px-6 py-3 rounded-xl border border-white/10 text-white/50 hover:text-white hover:border-white/20 text-sm font-display font-600 transition-all">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Ortga
                            </button>
                            <button type="button" @click="nextStep()" class="btn-submit"
                                style="width:auto; padding: 12px 32px;">
                                Keyingisi
                                <svg class="w-4 h-4 inline ml-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- ═══ STEP 3: Tasdiqlash ═══ -->
                    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0">
                        <h2 class="font-display text-lg font-600 text-white mb-6 flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-indigo-500/20 border border-indigo-500/30 rounded-lg flex items-center justify-center text-indigo-400 text-xs">3</span>
                            Ma'lumotlarni tekshiring
                        </h2>

                        <!-- Summary -->
                        <div class="bg-white/[0.03] border border-white/[0.06] rounded-xl p-5 mb-6 space-y-4">

                            <!-- Logo + name -->
                            <div class="flex items-center gap-4 pb-4 border-b border-white/[0.06]">
                                <div x-show="logoPreview"
                                    class="w-14 h-14 rounded-xl overflow-hidden border border-white/10 flex-shrink-0">
                                    <img :src="logoPreview" class="w-full h-full object-contain">
                                </div>
                                <div x-show="!logoPreview"
                                    class="w-14 h-14 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white/20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-display font-600 text-white" x-text="form.name || '—'"></p>
                                    <p class="text-white/40 text-sm mt-0.5" x-text="form.license || '—'"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-white/30 text-xs font-display uppercase tracking-wider mb-1">Viloyat
                                    </p>
                                    <p class="text-white/80" x-text="getViloyatName()"></p>
                                </div>
                                <div>
                                    <p class="text-white/30 text-xs font-display uppercase tracking-wider mb-1">Tartib
                                    </p>
                                    <p class="text-white/80" x-text="form.order || '0'"></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-white/30 text-xs font-display uppercase tracking-wider mb-1">Tavsif
                                    </p>
                                    <p class="text-white/80 line-clamp-2" x-text="form.description || '—'"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for actual submit -->
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="rating" value="0">

                        <!-- Laravel validation errors -->
                        @if ($errors->any())
                            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-5">
                                <p class="text-red-400 text-sm font-display font-600 mb-2">Xatoliklar mavjud:</p>
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-red-300/80 text-sm flex items-center gap-2">
                                            <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6 flex justify-between">
                            <button type="button" @click="prevStep()"
                                class="px-6 py-3 rounded-xl border border-white/10 text-white/50 hover:text-white hover:border-white/20 text-sm font-display font-600 transition-all">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Ortga
                            </button>
                            <button type="submit" class="btn-submit" style="width:auto; padding: 12px 32px;"
                                :disabled="isSubmitting">
                                <span x-show="!isSubmitting">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Saqlash
                                </span>
                                <span x-show="isSubmitting" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Saqlanmoqda...
                                </span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Login link -->
            <p class="text-center text-white/25 text-sm mt-6">
                Allaqachon ro'yxatdanmisiz?
                <a href="{{ route('login') }}"
                    class="text-indigo-400 hover:text-indigo-300 transition-colors font-display font-600">Kirish</a>
            </p>

        </div>
    </div>

    <script>
        function brandRegister() {
            return {
                currentStep: 0,
                steps: [0, 1, 2],
                isSubmitting: false,
                isDragging: false,
                logoPreview: null,
                logoName: '',

                form: {
                    name: '',
                    viloyat_id: '',
                    license: '',
                    order: '',
                    description: '',
                },

                errors: {
                    name: '',
                    viloyat_id: '',
                    license: '',
                    description: '',
                    logo: '',
                },

                // Viloyat select options (for summary display)
                viloyatlar: Array.from(document.querySelectorAll('select[name="viloyat_id"] option'))
                    .filter(o => o.value)
                    .map(o => ({
                        id: o.value,
                        name: o.text
                    })),

                get progress() {
                    return ((this.currentStep) / this.steps.length) * 100;
                },

                getViloyatName() {
                    const v = this.viloyatlar.find(v => v.id == this.form.viloyat_id);
                    return v ? v.name : '—';
                },

                validateField(field) {
                    this.errors[field] = '';
                    if (field === 'name' && !this.form.name.trim()) {
                        this.errors.name = 'Brend nomi kiritilishi shart';
                    }
                    if (field === 'viloyat_id' && !this.form.viloyat_id) {
                        this.errors.viloyat_id = 'Viloyatni tanlang';
                    }
                    if (field === 'license' && !this.form.license.trim()) {
                        this.errors.license = 'Litsenziya raqami kiritilishi shart';
                    }
                    if (field === 'description') {
                        if (!this.form.description.trim()) {
                            this.errors.description = 'Tavsif kiritilishi shart';
                        } else if (this.form.description.length > 500) {
                            this.errors.description = 'Tavsif 500 belgidan oshmasligi kerak';
                        }
                    }
                },

                validateStep(step) {
                    let valid = true;
                    if (step === 0) {
                        ['name', 'viloyat_id', 'license'].forEach(f => {
                            this.validateField(f);
                            if (this.errors[f]) valid = false;
                        });
                    }
                    if (step === 1) {
                        this.validateField('description');
                        if (this.errors.description) valid = false;
                        if (!this.logoPreview) {
                            this.errors.logo = 'Logo yuklanishi shart';
                            valid = false;
                        }
                    }
                    return valid;
                },

                nextStep() {
                    if (!this.validateStep(this.currentStep)) return;
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                    }
                },

                prevStep() {
                    if (this.currentStep > 0) this.currentStep--;
                },

                handleFile(event) {
                    const file = event.target.files[0];
                    if (file) this.processFile(file);
                },

                handleDrop(event) {
                    this.isDragging = false;
                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        // Transfer to input
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        document.getElementById('logo-input').files = dt.files;
                        this.processFile(file);
                    }
                },

                processFile(file) {
                    if (file.size > 2 * 1024 * 1024) {
                        this.errors.logo = 'Fayl hajmi 2MB dan oshmasligi kerak';
                        return;
                    }
                    this.errors.logo = '';
                    this.logoName = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.logoPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                clearLogo() {
                    this.logoPreview = null;
                    this.logoName = '';
                    document.getElementById('logo-input').value = '';
                },

                submitForm(e) {
                    if (!this.validateStep(0) || !this.validateStep(1)) return;
                    this.isSubmitting = true;
                    e.target.submit();
                }
            }
        }
    </script>

</body>

</html>
