@extends('layouts.app')

@section('title', 'Lupa Kata Sandi — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Lupa Kata Sandi</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan email terdaftar Anda untuk menerima tautan pemulihan kata sandi.</p>
        </div>

        @if(session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 p-3 rounded-lg text-xs">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@cuplik.com" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#d60000] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Kirim Tautan Reset
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Kembali ke <a href="{{ route('login') }}" class="text-[#d60000] hover:text-[#008a24] font-bold hover:underline">Halaman Masuk</a>
        </div>

    </div>
</div>
@endsection
