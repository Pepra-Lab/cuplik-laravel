@extends('layouts.app')

@section('title', '500 - Terjadi Kesalahan Server | CuplikCom')

@section('content')
<main class="w-full max-w-[1280px] mx-auto px-4 py-16 text-center">
    <div class="max-w-md mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center text-amber-600 dark:text-amber-400">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-black text-[#111111] dark:text-white mb-2">500</h1>
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Kendala Sistem Internal</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            Sistem kami sedang mengalami kendala sementara saat memproses permintaan Anda. Tim teknis kami telah mencatat masalah ini.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white text-sm font-semibold rounded-lg shadow-sm transition">
                Kembali ke Beranda
            </a>
            <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-lg transition">
                Muat Ulang Halaman
            </button>
        </div>
    </div>
</main>
@endsection
