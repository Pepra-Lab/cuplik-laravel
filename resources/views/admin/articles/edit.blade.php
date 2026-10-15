@extends('layouts.admin')

@section('title', 'Edit Berita: ' . Str::limit($article->judul, 40))

@section('content')
<div class="max-w-5xl">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-gray-500 hover:text-[#008a24] flex items-center gap-1">
            &larr; Kembali ke Daftar Berita
        </a>
        <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline flex items-center gap-1">
            Lihat di Web Portal &rarr;
        </a>
    </div>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content (2 Cols) -->
            <div class="lg:col-span-2 space-y-5">
                
                <!-- Judul -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $article->judul) }}" required class="w-full px-3 py-2.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-sm font-semibold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Slug URL</label>
                        <input type="text" disabled value="{{ $article->slug }}" class="w-full px-3 py-2 bg-gray-100 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg text-xs text-gray-500 font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Lead / Teras Berita</label>
                        <textarea name="lead" rows="2" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">{{ old('lead', $article->lead) }}</textarea>
                        @error('lead') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Lokasi Liputan</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $article->lokasi) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Path / URL Foto</label>
                            <input type="text" name="foto" value="{{ old('foto', $article->foto) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi Berita Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="isi" id="editorIsi" rows="14" required class="w-full p-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-sans focus:outline-none focus:ring-2 focus:ring-[#008a24] leading-relaxed">{{ old('isi', $article->isi) }}</textarea>
                        @error('isi') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tags Selection -->
                <div data-tag-adder-wrapper class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Tagging & Topik Terkait</label>

                        @if(auth()->user()->isCmsStaff())
                            <button type="button" data-tag-adder-toggle class="flex items-center gap-1 text-[11px] font-bold text-[#008a24] hover:text-[#006f1c]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Tag
                            </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto p-2 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-gray-200 dark:border-zinc-700">
                        @php
                            $selectedTags = old('tags', $article->tags->pluck('id')->toArray());
                        @endphp
                        @foreach($tags as $tg)
                            <label class="flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 hover:text-[#008a24] cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tg->id }}" {{ in_array($tg->id, $selectedTags) ? 'checked' : '' }} class="rounded border-gray-300 text-[#008a24] focus:ring-[#008a24]">
                                <span class="truncate">{{ $tg->nama }}</span>
                            </label>
                        @endforeach
                    </div>

                    @if(auth()->user()->isCmsStaff())
                        <div data-tag-adder-panel class="mt-3 {{ $errors->has('new_tags') ? '' : 'hidden' }}">
                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-300 mb-1">Tag Baru</label>
                            <input type="text" name="new_tags" value="{{ old('new_tags') }}" placeholder="Contoh: Pilkada 2026, Banjir Indramayu" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                            <p class="text-[10px] text-gray-400 mt-1">Pisahkan dengan koma untuk beberapa tag. Cek dulu daftar di atas — jika tag serupa sudah ada, pakai itu saja agar tidak dobel. Tag baru akan langsung bisa dipakai, tapi baru tampil sebagai submenu publik setelah dikurasi Admin di menu Tag & Submenu.</p>
                            @error('new_tags') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

            </div>

            <!-- Meta Sidebar (1 Col) -->
            <div class="space-y-5">
                
                <!-- Status & Publish Box -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 dark:border-zinc-800 pb-2">Status Publikasi</h3>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Publikasi</label>
                        <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                            <option value="Terbit" {{ old('status', $article->status) === 'Terbit' ? 'selected' : '' }}>Terbitkan Langsung</option>
                            <option value="Review" {{ old('status', $article->status) === 'Review' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="Draft" {{ old('status', $article->status) === 'Draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kategori Kanal <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Terbit</label>
                        <input type="datetime-local" name="tanggal" value="{{ old('tanggal', $article->tanggal ? $article->tanggal->format('Y-m-d\TH:i') : date('Y-m-d\TH:i')) }}" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Warna Tone / Highlight</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="tone" value="{{ old('tone', $article->tone ?: '#eaf3ec') }}" class="w-8 h-8 rounded border border-gray-300 dark:border-zinc-700 cursor-pointer bg-transparent">
                            <span class="text-xs text-gray-400">Warna kartu banner/highlight</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100 dark:border-zinc-800">
                        <div class="text-[11px] text-gray-400">
                            Total Dibaca: <strong class="text-emerald-600 dark:text-emerald-400">{{ number_format($article->dibaca) }} kali</strong>
                        </div>
                    </div>
                </div>

                <!-- SEO Box -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 dark:border-zinc-800 pb-2">SEO Berita</h3>
                    <p class="text-[11px] text-gray-400 -mt-2">Opsional. Kosongkan untuk memakai judul/lead berita secara otomatis.</p>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" maxlength="70" value="{{ old('meta_title', $article->meta_title) }}" placeholder="Judul untuk hasil pencarian Google..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        @error('meta_title') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="3" maxlength="160" placeholder="Ringkasan singkat untuk hasil pencarian & pratinjau media sosial (maks 160 karakter)..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">{{ old('meta_description', $article->meta_description) }}</textarea>
                        @error('meta_description') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Gambar OG / Share (opsional)</label>
                        <input type="text" name="meta_image" value="{{ old('meta_image', $article->meta_image) }}" placeholder="Kosongkan untuk pakai foto utama berita" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        @error('meta_image') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Authorship Box -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 border-b border-gray-100 dark:border-zinc-800 pb-2">Kepengarangan & Redaksi</h3>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Penulis / Reporter</label>
                        <input list="staffList" name="penulis_nama" value="{{ old('penulis_nama', $article->penulis_nama) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Editor Bertugas</label>
                        <input list="staffList" name="editor_nama" value="{{ old('editor_nama', $article->editor_nama) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>

                    <datalist id="staffList">
                        @foreach($staff as $st)
                            <option value="{{ $st->name }}">{{ $st->role }}</option>
                        @endforeach
                    </datalist>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center">
                            Perbarui Berita
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
