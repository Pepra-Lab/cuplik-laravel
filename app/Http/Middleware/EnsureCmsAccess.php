<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCmsAccess
{
    /**
     * Pemakaian: `cms` untuk semua peran CMS, `cms:admin` khusus Admin dan Super Admin,
     * `cms:member` khusus Member.
     */
    public function handle(Request $request, Closure $next, ?string $level = null): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'))
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses CMS.');
        }

        if (! $user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        $allowed = match ($level) {
            'admin' => $user->isAdmin(),
            'member' => $user->isMember(),
            default => $user->canAccessCms(),
        };

        if (! $allowed) {
            $fallback = $user->canAccessCms() ? 'admin.articles.index' : 'home';

            return redirect()->route($fallback)
                ->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
