@extends('layouts.app')

@section('title', 'Daftar Akun Baru — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-xl bg-[#008a24] text-white flex items-center justify-center text-2xl font-black mx-auto shadow-md">
                C
            </div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Daftar Akun CuplikCom</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Daftar untuk mengirim atau mengelola berita di CuplikCom</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Daftar sebagai</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['Member' => 'Kirim berita, iklan, curhat, komentar, dan dapat email berita terbaru', 'Redaktur' => 'Mengelola berita dan video milik sendiri'] as $role => $desc)
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="{{ $role }}" class="peer sr-only" {{ old('role', 'Member') === $role ? 'checked' : '' }}>
                            <div class="h-full p-3 rounded-lg border border-gray-300 dark:border-zinc-700 text-xs peer-checked:border-[#008a24] peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-950/30">
                                <span class="block font-bold text-gray-900 dark:text-white">{{ $role }}</span>
                                <span class="block text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">{{ $desc }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Kata Sandi</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>

            <p class="text-[11px] text-gray-500 dark:text-gray-400">Akun baru akan aktif setelah diverifikasi admin.</p>

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Daftar Akun Baru
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#008a24] font-bold hover:underline">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection
