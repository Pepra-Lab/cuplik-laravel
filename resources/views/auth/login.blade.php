@extends('layouts.app')

@section('title', 'Masuk ke Akun — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-xl bg-[#008a24] text-white flex items-center justify-center text-2xl font-black mx-auto shadow-md">
                C
            </div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Masuk ke CuplikCom</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Masuk untuk mengakses CMS Redaksi atau akun pembaca</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post', request()->query()) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', 'admin@cuplik.com') }}" required placeholder="email@cuplik.com" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300">Kata Sandi</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-[#008a24] hover:underline font-medium">Lupa sandi?</a>
                </div>
                <input type="password" name="password" value="password" required placeholder="••••••••" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="text-[#008a24] focus:ring-[#008a24] rounded">
                <label for="remember" class="text-xs text-gray-600 dark:text-gray-400">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Masuk Sekarang
            </button>
        </form>

        <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 rounded-lg text-xs text-gray-600 dark:text-gray-400 space-y-1">
            <span class="font-bold text-[#008a24]">Akun Demo Redaksi:</span>
            <p>Admin / CMS: <code>admin@cuplik.com</code> | Sandi: <code>password</code></p>
        </div>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#008a24] font-bold hover:underline">Daftar Sekarang</a>
        </div>

    </div>
</div>
@endsection
