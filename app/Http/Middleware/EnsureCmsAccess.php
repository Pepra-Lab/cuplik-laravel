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
     * `cms:staff` khusus Admin/Super Admin/Redaktur (semua kecuali Member),
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
            'staff' => $user->isCmsStaff(),
            'member' => $user->isMember(),
            default => $user->canAccessCms(),
        };

        if (! $allowed) {
            $fallback = match (true) {
                $user->isMember() => 'admin.iklan-saya.index',
                $user->canAccessCms() => 'admin.articles.index',
                default => 'home',
            };

            return redirect()->route($fallback)
                ->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
