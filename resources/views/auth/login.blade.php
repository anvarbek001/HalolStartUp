<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-field">
            <label for="email" class="form-label">Email manzil</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" class="form-input {{ $errors->has('email') ? 'error-input' : '' }}"
                placeholder="sizning@email.uz">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-field">
            <label for="password" class="form-label">Parol</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="form-input {{ $errors->has('password') ? 'error-input' : '' }}" placeholder="••••••••">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me + Forgot -->
        <div class="form-row">
            <label class="remember-label">
                <input type="checkbox" name="remember" id="remember_me">
                Meni eslab qol
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Parolni unutdingizmi?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="submit-btn">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                <polyline points="10 17 15 12 10 7" />
                <line x1="15" y1="12" x2="3" y2="12" />
            </svg>
            Kirish
        </button>
    </form>
</x-guest-layout>
