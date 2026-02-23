<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profil formasi -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

{{-- =====================================================
     BREND RO'YXATDAN O'TKAZISH BO'LIMI
     ===================================================== --}}
<section class="mt-10">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __("Brend Ma'lumotlari") }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Brendingizni ro'yxatdan o'tkazing. Ma'lumotlar tekshirilgandan so'ng tasdiqlanadi.") }}
        </p>
    </header>

    {{-- Xato xabari --}}
    @if (session('error'))
        <div class="mt-4 p-4 rounded-md bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Muvaffaqiyat xabari --}}
    @if (session('success'))
        <div class="mt-4 p-4 rounded-md bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Brend formasi --}}
    <form method="post" action="{{ route('brandRegister') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        {{-- Brend nomi va Viloyat (yon-yon) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Brend nomi --}}
            <div>
                <x-input-label for="brand_name" :value="__('Brend nomi')" />
                <x-text-input id="brand_name" name="name" type="text" class="mt-1 block w-full"
                    value="{{ $brand->name }}" placeholder="Masalan: Zara, Nike..." required autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- Viloyat --}}
            <div>
                <x-input-label for="viloyat_id" :value="__('Viloyat')" />
                <select id="viloyat_id" name="viloyat_id" required
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                           focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                           rounded-md shadow-sm text-sm">
                    <option value="" disabled {{ old('viloyat_id') ? '' : 'selected' }}>
                        {{ __('Viloyatni tanlang') }}
                    </option>
                    @isset($viloyatlar)
                        @foreach ($viloyatlar as $viloyat)
                            <option value="{{ $viloyat->id }}"
                                {{ $brand->viloyat_id == $viloyat->id ? 'selected' : '' }}>
                                {{ $viloyat->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('viloyat_id')" />
            </div>
        </div>

        {{-- Tavsif --}}
        <div>
            <x-input-label for="description" :value="__('Brend haqida')" />
            <textarea id="description" name="description" rows="4" required
                placeholder="Brendingiz haqida qisqacha ma'lumot bering..."
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                       focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                       rounded-md shadow-sm text-sm resize-none">{{ $brand->description }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        {{-- Fayl yuklash (yon-yon) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Litsenziya --}}
            <div>
                <x-input-label for="license" :value="__('Litsenziya')" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('JPG, PNG, JPEG yoki PDF. Maks: 4 MB') }}
                </p>

                {{-- Custom file upload --}}
                {{-- <label for="license"
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed
                           border-gray-300 dark:border-gray-700 rounded-md cursor-pointer
                           hover:border-indigo-400 dark:hover:border-indigo-500
                           hover:bg-gray-50 dark:hover:bg-gray-800/50
                           transition-colors duration-200 group">
                    <div class="flex flex-col items-center justify-center gap-1 text-center px-4"
                        id="license-placeholder">
                        <svg class="w-7 h-7 text-gray-400 group-hover:text-indigo-400 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-500">
                            {{ __('Litsenziyani yuklang') }}
                        </span>
                        <span class="text-xs text-gray-400" id="license-filename">
                            {{ __('Fayl tanlanmagan') }}
                        </span>
                    </div>
                    <input id="license" name="license" type="file" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                        onchange="updateFileName('license', 'license-filename')" />
                </label> --}}
                <x-input-error class="mt-2" :messages="$errors->get('license')" />
            </div>

            {{-- Logo --}}
            <div>
                <x-input-label for="logo" :value="__('Brend logosi')" />
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('JPG, PNG yoki JPEG. Maks: 4 MB') }}
                </p>

                <label for="logo"
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed
                           border-gray-300 dark:border-gray-700 rounded-md cursor-pointer
                           hover:border-indigo-400 dark:hover:border-indigo-500
                           hover:bg-gray-50 dark:hover:bg-gray-800/50
                           transition-colors duration-200 group relative overflow-hidden">

                    {{-- Logo preview --}}
                    <img id="logo-preview" src="{{ asset('storage/' . $brand->logo) }}" alt="Logo preview"
                        class="absolute inset-0 w-full h-full object-contain p-2" />

                    <div class="flex flex-col items-center justify-center gap-1 text-center px-4" id="logo-placeholder">
                        <svg class="w-7 h-7 text-gray-400 group-hover:text-indigo-400 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-500">
                            {{ __('Logoni yuklang') }}
                        </span>
                        <span class="text-xs text-gray-400" id="logo-filename">
                            {{ __('Fayl tanlanmagan') }}
                        </span>
                    </div>
                    <input id="logo" name="logo" type="file" accept=".jpg,.jpeg,.png" class="hidden"
                        onchange="previewLogo(this)" />
                </label>
                <x-input-error class="mt-2" :messages="$errors->get('logo')" />
            </div>
        </div>

        {{-- Submit tugmasi --}}
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button type="submit">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                {{ __('Brendni saqlash') }}
            </x-primary-button>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('* Barcha maydonlar to\'ldirilishi shart') }}
            </p>
        </div>
    </form>
</section>

@push('scripts')
    <script>
        /**
         * Fayl nomini yangilash
         */
        function updateFileName(inputId, labelId) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);
            if (input.files && input.files[0]) {
                const name = input.files[0].name;
                label.textContent = name.length > 28 ? name.substring(0, 25) + '...' : name;
                label.classList.add('text-indigo-500');
            }
        }

        /**
         * Logo preview ko'rsatish
         */
        function previewLogo(input) {
            const preview = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            const filenameEl = document.getElementById('logo-filename');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('opacity-0');
                };
                reader.readAsDataURL(input.files[0]);

                const name = input.files[0].name;
                filenameEl.textContent = name.length > 28 ? name.substring(0, 25) + '...' : name;
            }
        }
    </script>
@endpush
