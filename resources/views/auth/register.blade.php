@extends('layouts.app')

@section('title', 'Daftar Akun Baru — CuplikCom')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <img src="{{ asset('assets/logo.png') }}" alt="Cuplik.com - Unik dan Menggelitik" class="h-14 w-auto mx-auto dark:brightness-125">
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Daftar Akun</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400">Dapatkan akses penuh ke diskusi pembaca dan kirim aspirasi daerah</p>
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
                    @foreach(['Member' => 'Pasang iklan (ditinjau admin dulu), kirim curhat, dan beri komentar', 'Redaktur' => 'Mengelola berita dan video milik sendiri'] as $role => $desc)
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

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Nama Inisial</label>
                    <input type="text" name="nm_inisial" value="{{ old('nm_inisial') }}" maxlength="10" placeholder="Opsional" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">No. Telp/HP</label>
                    <input type="text" name="telp" value="{{ old('telp') }}" maxlength="20" placeholder="08xxxxxxxxxx" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" maxlength="50" placeholder="Opsional" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Alamat</label>
                <textarea name="alamat" rows="2" maxlength="300" placeholder="Opsional" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" minlength="8" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg pl-4 pr-10 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                    <button type="button" tabindex="-1" aria-label="Tampilkan atau sembunyikan kata sandi" onclick="var i=this.parentElement.querySelector('input');var s=i.type==='password';i.type=s?'text':'password';this.querySelector('.eye-on').classList.toggle('hidden',s);this.querySelector('.eye-off').classList.toggle('hidden',!s);" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="eye-on w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 010-.64C3.42 8.2 7.36 5 12 5s8.58 3.2 9.96 6.68a1 1 0 010 .64C20.58 15.8 16.64 19 12 19s-8.58-3.2-9.96-6.68z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-off hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58a2 2 0 002.84 2.84M9.88 5.09A9.8 9.8 0 0112 5c4.64 0 8.58 3.2 9.96 6.68a1 1 0 010 .64 10.5 10.5 0 01-3.2 4.2M6.6 6.6A10.5 10.5 0 002.04 11.68a1 1 0 000 .64C3.42 15.8 7.36 19 12 19c1.7 0 3.3-.4 4.7-1.1"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg pl-4 pr-10 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                    <button type="button" tabindex="-1" aria-label="Tampilkan atau sembunyikan kata sandi" onclick="var i=this.parentElement.querySelector('input');var s=i.type==='password';i.type=s?'text':'password';this.querySelector('.eye-on').classList.toggle('hidden',s);this.querySelector('.eye-off').classList.toggle('hidden',!s);" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="eye-on w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.04 12.32a1 1 0 010-.64C3.42 8.2 7.36 5 12 5s8.58 3.2 9.96 6.68a1 1 0 010 .64C20.58 15.8 16.64 19 12 19s-8.58-3.2-9.96-6.68z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-off hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58a2 2 0 002.84 2.84M9.88 5.09A9.8 9.8 0 0112 5c4.64 0 8.58 3.2 9.96 6.68a1 1 0 010 .64 10.5 10.5 0 01-3.2 4.2M6.6 6.6A10.5 10.5 0 002.04 11.68a1 1 0 000 .64C3.42 15.8 7.36 19 12 19c1.7 0 3.3-.4 4.7-1.1"/></svg>
                    </button>
                </div>
            </div>

            @if(config('services.recaptcha.site_key'))
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
            @endif

            <button type="submit" class="w-full bg-[#008a24] hover:bg-[#d60000] text-white py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow">
                Daftar Akun Baru
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#d60000] hover:text-[#008a24] font-bold hover:underline">Masuk di sini</a>
        </div>

    </div>
</div>

@if(config('services.recaptcha.site_key'))
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
@endif
@endsection
