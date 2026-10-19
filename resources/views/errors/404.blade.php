@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan | CuplikCom')

@section('content')
<main class="w-full max-w-[1280px] mx-auto px-4 py-16 text-center">
    <div class="max-w-md mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-emerald-50 dark:bg-emerald-950/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-6xl font-black text-[#111111] dark:text-white mb-2">404</h1>
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-3">Halaman Tidak Ditemukan</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            Berita atau halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau tautan yang Anda masukkan kurang tepat.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white text-sm font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="{{ route('search') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-lg transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari Berita
            </a>
        </div>
    </div>
</main>
@endsection
