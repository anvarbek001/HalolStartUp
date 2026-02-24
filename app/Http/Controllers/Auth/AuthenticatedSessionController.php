<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use function PHPUnit\Framework\isEmpty;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // dd($request->all());
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', "Iltimos avval ro'yxatdan o'ting");
        }


        $request->authenticate();

        $request->session()->regenerate();
        if (isEmpty($user->brand) || $user->brand->name == null) {
            return redirect()->route('brandRegister')->with('error', "Brendni ro'yxatdan o'tkazing");
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
