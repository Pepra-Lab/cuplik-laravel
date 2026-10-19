@extends('layouts.app')

@section('title', '403 - Akses Ditolak | CuplikCom')

@section('content')
<main class="w-full max-w-[1280px] mx-auto px-4 py-16 text-center">
    <div class="max-w-md mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-50 dark:bg-red-950/40 flex items-center justify-center text-red-600 dark:text-red-400">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-black text-[#111111] dark:text-white mb-2">403</h1>
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Akses Ditolak</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kekeliruan.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white text-sm font-semibold rounded-lg shadow-sm transition">
                Kembali ke Beranda
            </a>
            @guest
            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-lg transition">
                Masuk ke Akun
            </a>
            @endguest
        </div>
    </div>
</main>
@endsection
