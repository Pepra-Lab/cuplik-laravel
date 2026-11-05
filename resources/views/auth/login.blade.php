@extends('layouts.app')

@section('title', 'Masuk ke Akun — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <img src="{{ asset('assets/logo.png') }}" alt="Cuplik.com - Unik dan Menggelitik" class="h-14 w-auto mx-auto dark:brightness-125">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Masuk</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Masuk untuk mengakses CMS Redaksi atau akun pembaca</p>
        </div>

        @if(session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 p-3 rounded-lg text-xs">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@cuplik.com" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-[#008a24] hover:underline font-medium">Lupa sandi?</a>
                </div>
                <div class="relative">
                    <input type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg pl-4 pr-10 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                    <button type="button" tabindex="-1" aria-label="Tampilkan atau sembunyikan kata sandi" onclick="var i=this.parentElement.querySelector('input');var s=i.type==='password';i.type=s?'text':'password';this.querySelector('.eye-on').classList.toggle('hidden',s);this.querySelector('.eye-off').classList.toggle('hidden',!s);" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="eye-on w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 010-.64C3.42 8.2 7.36 5 12 5s8.58 3.2 9.96 6.68a1 1 0 010 .64C20.58 15.8 16.64 19 12 19s-8.58-3.2-9.96-6.68z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-off hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58a2 2 0 002.84 2.84M9.88 5.09A9.8 9.8 0 0112 5c4.64 0 8.58 3.2 9.96 6.68a1 1 0 010 .64 10.5 10.5 0 01-3.2 4.2M6.6 6.6A10.5 10.5 0 002.04 11.68a1 1 0 000 .64C3.42 15.8 7.36 19 12 19c1.7 0 3.3-.4 4.7-1.1"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="text-[#008a24] focus:ring-[#008a24] rounded">
                <label for="remember" class="text-xs text-gray-600 dark:text-gray-400">Ingat saya di perangkat ini</label>
            </div>

            @if(config('services.recaptcha.site_key'))
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            @endif

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#d60000] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#d60000] hover:text-[#008a24] font-bold hover:underline">Daftar Sekarang</a>
        </div>

    </div>
</div>

@if(config('services.recaptcha.site_key'))
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endif
@endsection
