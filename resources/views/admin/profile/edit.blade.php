@extends('layouts.admin')

@section('title', 'Profil Saya')

@php
    $inputClass = 'w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]';
    $labelClass = 'block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1';
@endphp

@section('content')
<div class="space-y-5">

    <div>
        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white">Profil Saya</h2>
        <p class="text-xs text-gray-400">Kelola nama, email, dan kata sandi akun Anda sendiri.</p>
    </div>

    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm max-w-xl">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Data Akun</h3>
                <p class="text-xs text-gray-400">Peran: {{ $user->role }}</p>
            </div>
            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 dark:bg-blue-950 text-blue-600">{{ $user->role }}</span>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="{{ $labelClass }}">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="{{ $inputClass }}">
                @error('name') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="{{ $labelClass }}">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $inputClass }}">
                @error('email') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2 border-t border-gray-100 dark:border-zinc-800">
                <p class="text-[11px] text-gray-400 mb-3">Kosongkan bagian kata sandi di bawah ini jika tidak ingin menggantinya.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">Kata Sandi Baru</label>
                        <input type="password" name="password" autocomplete="new-password" class="{{ $inputClass }}">
                        @error('password') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password" class="{{ $inputClass }}">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="{{ $labelClass }}">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" autocomplete="current-password" class="{{ $inputClass }}" placeholder="Wajib diisi hanya jika mengganti kata sandi">
                    @error('current_password') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end pt-2">
                <button type="submit" class="px-5 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
