@extends('layouts.app')

@section('title', 'Atur Ulang Kata Sandi — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">

        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Atur Ulang Kata Sandi</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Buat kata sandi baru untuk akun Anda.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" required class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Kata Sandi Baru</label>
                <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" autocomplete="new-password" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Ulangi Kata Sandi</label>
                <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Simpan Kata Sandi
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Kembali ke <a href="{{ route('login') }}" class="text-[#008a24] font-bold hover:underline">Halaman Masuk</a>
        </div>

    </div>
</div>
@endsection
