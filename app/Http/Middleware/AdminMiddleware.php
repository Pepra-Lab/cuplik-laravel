<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login', ['next' => 'admin'])->with('error', 'Silakan masuk terlebih dahulu untuk mengakses Admin CMS.');
        }

        $user = auth()->user();
        if ($user->status === 'Diblokir' || $user->status === 'Nonaktif') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        if (!$user->isStaff()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki hak akses ke panel admin.');
        }

        return $next($request);
    }
}
