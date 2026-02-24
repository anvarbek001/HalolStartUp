<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
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
</x-guest-layout>
