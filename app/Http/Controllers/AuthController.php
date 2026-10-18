<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const INACTIVE_MESSAGES = [
        User::STATUS_PENDING => 'Akun Anda belum diverifikasi admin. Mohon tunggu persetujuan.',
        User::STATUS_REJECTED => 'Pendaftaran akun Anda ditolak oleh admin.',
        'Nonaktif' => 'Akun Anda sedang dinonaktifkan.',
        'Diblokir' => 'Akun Anda diblokir.',
    ];

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->cmsHomeRoute());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => [new Recaptcha],
        ]);

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi tidak cocok dengan data kami.'])
                ->onlyInput('email');
        }

        $user = Auth::user();

        if (! $user->isActive()) {
            Auth::logout();

            return back()
                ->withErrors(['email' => self::INACTIVE_MESSAGES[$user->status] ?? 'Akun Anda tidak aktif.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($user->cmsHomeRoute()));
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->cmsHomeRoute());
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(User::CONTRIBUTOR_ROLES)],
            'g-recaptcha-response' => [new Recaptcha],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'status' => User::STATUS_PENDING,
        ]);

        return redirect()->route('login')
            ->with('status', 'Pendaftaran berhasil. Akun Anda bisa dipakai setelah diverifikasi admin.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }
}
