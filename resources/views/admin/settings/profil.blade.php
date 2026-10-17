@extends('layouts.admin')

@section('title', 'Profil Situs')

@section('content')
    <div class="space-y-5">

        @include('admin.settings._tabs')

        <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm max-w-3xl">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800">
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Profil Situs</h2>
                <p class="text-xs text-gray-400">Identitas portal, kontak, dan tautan sosial media yang tampil di frontend.
                </p>
            </div>

            <form action="{{ route('admin.settings.profil.update') }}" method="POST" class="p-5 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Situs <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="site_name" required value="{{ old('site_name', $setting->site_name) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('site_name') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $setting->tagline) }}"
                            placeholder="Contoh: Portal Berita Terdepan"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="2"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">{{ old('deskripsi', $setting->deskripsi) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                        <input type="file" name="logo" value="{{ old('logo', $setting->logo) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Icon Website</label>
                        <input type="file" name="favicon" value="{{ old('favicon', $setting->favicon) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Email Redaksi</label>
                        <input type="email" name="email" value="{{ old('email', $setting->email) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                        @error('email') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $setting->alamat) }}"
                            class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white mb-2">Sosial Media</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Facebook</label>
                            <input type="text" name="facebook" value="{{ old('facebook', $setting->facebook) }}"
                                placeholder="https://facebook.com/..."
                                class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Twitter / X</label>
                            <input type="text" name="twitter" value="{{ old('twitter', $setting->twitter) }}"
                                placeholder="https://x.com/..."
                                class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $setting->instagram) }}"
                                placeholder="https://instagram.com/..."
                                class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">YouTube</label>
                            <input type="text" name="youtube" value="{{ old('youtube', $setting->youtube) }}"
                                placeholder="https://youtube.com/..."
                                class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white mb-2">Notifikasi Email Member</h3>
                    <label class="flex items-center justify-between gap-3 px-3 py-2.5 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">
                        <span class="text-xs text-gray-700 dark:text-gray-300">
                            <span class="font-bold block">Kirim Email ke Member saat Berita Terbit</span>
                            <span class="text-[11px] text-gray-400">Semua member dengan status aktif akan menerima email otomatis setiap ada berita baru berstatus "Terbit".</span>
                        </span>
                        <input type="checkbox" name="notifikasi_artikel_aktif" value="1" {{ old('notifikasi_artikel_aktif', $setting->notifikasi_artikel_aktif) ? 'checked' : '' }} class="w-4 h-4 accent-[#008a24] shrink-0">
                    </label>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Teks Footer</label>
                    <textarea name="footer_text" rows="2"
                        placeholder="&copy; 2026 Cuplik.com. Seluruh hak cipta dilindungi."
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">{{ old('footer_text', $setting->footer_text) }}</textarea>
                </div>

                <div class="flex justify-end pt-2 border-t border-gray-100 dark:border-zinc-800">
                    <button type="submit"
                        class="px-5 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                        Simpan Profil Situs
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection