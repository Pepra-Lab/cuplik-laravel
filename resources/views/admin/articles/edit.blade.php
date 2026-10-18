@extends('layouts.admin')

@section('title', 'Edit Berita: ' . Str::limit($article->judul, 40))

@section('content')
<div class="max-w-5xl">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-gray-500 hover:text-[#008a24] flex items-center gap-1 transition-colors">
            &larr; Kembali ke Daftar Berita
        </a>
        <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
            Lihat di Web Portal &rarr;
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs">
            <div class="font-bold mb-1">Terdapat kesalahan pada input form:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="articleForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content (2 Cols) -->
            <div class="lg:col-span-2 space-y-5">
                
                <!-- Card Konten Berita -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    
                    <!-- Judul Berita -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <span class="text-[11px] text-gray-400" id="judulCount">{{ mb_strlen($article->judul) }} karakter</span>
                        </div>
                        <input type="text" name="judul" id="judulInput" value="{{ old('judul', $article->judul) }}" required class="w-full px-3 py-2.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-sm font-semibold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Slug URL (Pengganti Field Lead, Dapat Diedit Redaktur) -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                                Slug URL Berita <span class="text-xs font-normal text-gray-400">(Dapat diedit redaktur, otomatis ringkas 5-6 kata inti)</span>
                            </label>
                            <button type="button" id="btnRegenerateSlug" class="text-[11px] font-semibold text-[#008a24] hover:underline flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Generate Ulang dari Judul
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" name="slug" id="slugInput" value="{{ old('slug', $article->slug) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        </div>
                        <div class="mt-1 flex flex-wrap items-center gap-1 text-[11px] text-gray-400 break-all [overflow-wrap:anywhere]">
                            <span class="shrink-0">Tautan Portal:</span>
                            <span class="text-gray-500 dark:text-gray-400 font-mono">{{ url('/artikel') }}/</span><strong id="slugPreview" class="text-[#008a24] font-mono">{{ old('slug', $article->slug) }}</strong>
                        </div>
                        @error('slug') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Lokasi Liputan -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Lokasi Liputan</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $article->lokasi) }}" placeholder="Contoh: JAKARTA, INDRAMAYU" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        @error('lokasi') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Isi Berita Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                            Isi Berita Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="isi" id="editorIsi" rows="14" class="w-full p-3 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-sans focus:outline-none focus:ring-2 focus:ring-[#008a24] leading-relaxed">{{ old('isi', $article->isi) }}</textarea>
                        @error('isi') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        <p id="isiWarning" class="hidden text-[11px] text-red-500 mt-1">Isi berita wajib diisi.</p>
                    </div>

                    <!-- Lead Otomatis Info Box -->
                    <div class="p-3 bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900/40 rounded-lg space-y-1">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="font-bold text-[#008a24] flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Lead / Ringkasan Berita (Otomatis dari Paragraf Pertama)
                            </span>
                            <span id="leadCount" class="text-gray-400">0 / 500 karakter</span>
                        </div>
                        <p class="text-[11px] text-gray-600 dark:text-gray-300 italic break-words [overflow-wrap:anywhere]" id="leadPreviewText">
                            {{ $article->lead ?: 'Menghasilkan ringkasan otomatis...' }}
                        </p>
                    </div>

                </div>

                <!-- Card Upload Gambar 1 & Gambar 2 -->
                <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <div class="border-b border-gray-100 dark:border-zinc-800 pb-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900 dark:text-white">Foto & Gambar Berita</h3>
                        <p class="text-[11px] text-gray-400">Upload file JPG, PNG, atau WEBP (Maksimal 2 MB per file). Bisa isi salah satu atau keduanya.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Upload Gambar 1 -->
                        <div class="p-4 bg-gray-50/70 dark:bg-zinc-800/40 border border-gray-200 dark:border-zinc-700/80 rounded-xl space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                                    <span class="w-5 h-5 rounded-full bg-[#008a24] text-white flex items-center justify-center text-[10px] font-black">1</span>
                                    Gambar 1
                                </span>
                                @if($article->foto)
                                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">Tersimpan</span>
                                @else
                                    <span class="text-[10px] text-gray-400">Kosong</span>
                                @endif
                            </div>

                            <!-- Gambar Saat Ini (Jika ada) -->
                            @if($article->foto)
                                <div id="currentBox1" class="relative aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                                    <img src="{{ $article->foto_url }}" alt="Gambar 1 Saat Ini" class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] px-2 py-1 truncate">
                                        Gambar saat ini aktif
                                    </div>
                                </div>
                                <label class="flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-0.5">
                                    <input type="checkbox" name="hapus_gambar_1" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Hapus Gambar 1 dari Berita</span>
                                </label>
                            @endif

                            <!-- Preview Box Gambar 1 (File Baru) -->
                            <div id="previewBox1" class="relative hidden aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-emerald-500 shadow-sm">
                                <img id="previewImg1" src="" alt="Preview Gambar 1 Baru" class="w-full h-full object-cover">
                                <button type="button" id="btnRemoveImg1" class="absolute top-2 right-2 bg-black/70 hover:bg-red-600 text-white rounded-full p-1 text-xs transition-colors" title="Batalkan Gambar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <div id="previewInfo1" class="absolute bottom-0 inset-x-0 bg-emerald-700/80 text-white text-[10px] px-2 py-1 truncate"></div>
                            </div>

                            <!-- File Input Gambar 1 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">
                                    {{ $article->foto ? 'Ganti File Gambar 1' : 'Upload File Gambar 1' }}
                                </label>
                                <input type="file" name="gambar_1" id="fileInput1" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 dark:file:bg-zinc-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 cursor-pointer">
                                @error('gambar_1') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Posisi Penempatan Gambar 1 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">Posisi Penempatan</label>
                                <select name="foto_posisi" class="w-full px-2.5 py-1.5 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-semibold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                                    <option value="header" {{ old('foto_posisi', $article->foto_posisi ?: 'header') === 'header' ? 'selected' : '' }}>Header / Di Atas Berita (Utama)</option>
                                    <option value="p1" {{ old('foto_posisi', $article->foto_posisi) === 'p1' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 1</option>
                                    <option value="p2" {{ old('foto_posisi', $article->foto_posisi) === 'p2' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 2</option>
                                    <option value="p3" {{ old('foto_posisi', $article->foto_posisi) === 'p3' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 3</option>
                                    <option value="p4" {{ old('foto_posisi', $article->foto_posisi) === 'p4' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 4</option>
                                    <option value="p5" {{ old('foto_posisi', $article->foto_posisi) === 'p5' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 5</option>
                                    <option value="bottom" {{ old('foto_posisi', $article->foto_posisi) === 'bottom' ? 'selected' : '' }}>Di Akhir / Bawah Berita</option>
                                </select>
                            </div>

                            <!-- Caption Gambar 1 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">Keterangan / Caption Gambar 1</label>
                                <input type="text" name="caption_foto" value="{{ old('caption_foto', $article->caption_foto) }}" placeholder="Contoh: Suasana pelantikan (Foto: Dok. Redaksi)" class="w-full px-2.5 py-1.5 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                            </div>
                        </div>

                        <!-- Upload Gambar 2 -->
                        <div class="p-4 bg-gray-50/70 dark:bg-zinc-800/40 border border-gray-200 dark:border-zinc-700/80 rounded-xl space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">2</span>
                                    Gambar 2
                                </span>
                                @if($article->foto_2)
                                    <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400">Tersimpan</span>
                                @else
                                    <span class="text-[10px] text-gray-400">Kosong</span>
                                @endif
                            </div>

                            <!-- Gambar 2 Saat Ini (Jika ada) -->
                            @if($article->foto_2)
                                <div id="currentBox2" class="relative aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-gray-200 dark:border-zinc-700">
                                    <img src="{{ $article->foto_2_url }}" alt="Gambar 2 Saat Ini" class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] px-2 py-1 truncate">
                                        Gambar 2 saat ini aktif
                                    </div>
                                </div>
                                <label class="flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-0.5">
                                    <input type="checkbox" name="hapus_gambar_2" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Hapus Gambar 2 dari Berita</span>
                                </label>
                            @endif

                            <!-- Preview Box Gambar 2 (File Baru) -->
                            <div id="previewBox2" class="relative hidden aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden border border-blue-500 shadow-sm">
                                <img id="previewImg2" src="" alt="Preview Gambar 2 Baru" class="w-full h-full object-cover">
                                <button type="button" id="btnRemoveImg2" class="absolute top-2 right-2 bg-black/70 hover:bg-red-600 text-white rounded-full p-1 text-xs transition-colors" title="Batalkan Gambar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <div id="previewInfo2" class="absolute bottom-0 inset-x-0 bg-blue-700/80 text-white text-[10px] px-2 py-1 truncate"></div>
                            </div>

                            <!-- File Input Gambar 2 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">
                                    {{ $article->foto_2 ? 'Ganti File Gambar 2' : 'Upload File Gambar 2' }}
                                </label>
                                <input type="file" name="gambar_2" id="fileInput2" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-100 dark:file:bg-zinc-700 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 cursor-pointer">
                                @error('gambar_2') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Posisi Penempatan Gambar 2 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">Posisi Penempatan</label>
                                <select name="foto_2_posisi" class="w-full px-2.5 py-1.5 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-semibold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                                    <option value="p2" {{ old('foto_2_posisi', $article->foto_2_posisi ?: 'p2') === 'p2' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 2</option>
                                    <option value="header" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'header' ? 'selected' : '' }}>Header / Di Atas Berita</option>
                                    <option value="p1" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'p1' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 1</option>
                                    <option value="p3" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'p3' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 3</option>
                                    <option value="p4" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'p4' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 4</option>
                                    <option value="p5" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'p5' ? 'selected' : '' }}>Di Dalam Berita — Setelah Paragraf 5</option>
                                    <option value="bottom" {{ old('foto_2_posisi', $article->foto_2_posisi) === 'bottom' ? 'selected' : '' }}>Di Akhir / Bawah Berita</option>
                                </select>
                            </div>

                            <!-- Caption Gambar 2 -->
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 dark:text-gray-300 mb-1">Keterangan / Caption Gambar 2</label>
                                <input type="text" name="caption_foto_2" value="{{ old('caption_foto_2', $article->caption_foto_2) }}" placeholder="Contoh: Grafik kenaikan harga" class="w-full px-2.5 py-1.5 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                            </div>
                        </div>

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

                    <div id="tagCheckboxGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto p-2 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border {{ $errors->has('tags') ? 'border-red-400 dark:border-red-700' : 'border-gray-200 dark:border-zinc-700' }}">
                        @php
                            $selectedTags = old('tags', $article->tags->pluck('id')->toArray());
                        @endphp
                        @foreach($tags as $tg)
                            <label class="flex items-center gap-2 text-xs text-gray-700 dark:text-gray-300 hover:text-[#008a24] cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tg->id }}" {{ in_array($tg->id, $selectedTags) ? 'checked' : '' }} class="tag-checkbox rounded border-gray-300 text-[#008a24] focus:ring-[#008a24]">
                                <span class="truncate">{{ $tg->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                    <p id="tagWarning" class="hidden text-[11px] text-red-500 mt-1">Pilih minimal satu tag di atas, atau isi kolom "Tag Baru".</p>

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
                        <button type="submit" class="w-full py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Perbarui & Simpan Berita
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. SLUG OTOMATIS & EDIT MANUAL
    // ==========================================
    const judulInput = document.getElementById('judulInput');
    const slugInput = document.getElementById('slugInput');
    const slugPreview = document.getElementById('slugPreview');
    const btnRegenerate = document.getElementById('btnRegenerateSlug');
    const judulCount = document.getElementById('judulCount');

    const INDONESIAN_STOPWORDS = new Set([
        'yang', 'di', 'ke', 'dari', 'dan', 'ini', 'itu', 'untuk', 'dengan', 'pada',
        'adalah', 'sebagai', 'dalam', 'oleh', 'atau', 'jika', 'maka', 'akan', 'sudah',
        'telah', 'sedang', 'ada', 'tidak', 'tak', 'bukan', 'bisa', 'dapat', 'lebih',
        'sangat', 'juga', 'serta', 'karena', 'agar', 'supaya', 'hingga', 'sampai',
        'saat', 'ketika', 'tentang', 'menurut', 'atas', 'bawah', 'antar', 'antara',
        'baru', 'mulai', 'resmi', 'jadi', 'menjadi', 'hari', 'besok', 'kemarin',
        'para', 'suatu', 'satu', 'dua', 'tiga', 'tersebut', 'lagi', 'masih', 'pun',
        'si', 'sang', 'ia', 'dia', 'mereka', 'kita', 'kami', 'kamu', 'anda', 'kalian',
        'lalu', 'kemudian', 'namun', 'tetapi', 'melainkan', 'hanya', 'saja', 'punya',
        'bila', 'apabila', 'seperti', 'bagai', 'bagaikan', 'yakni', 'yaitu', 'terhadap',
        'secara', 'bagi', 'terus', 'kembali', 'usai', 'pasca', 'bakal', 'kala', 'sejak'
    ]);

    function createConciseSlug(text) {
        if (!text) return '';
        let clean = text.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s]/g, ' ');

        let words = clean.split(/\s+/).filter(w => w.length > 0);
        let filtered = words.filter(w => !INDONESIAN_STOPWORDS.has(w) && w.length > 1);

        if (filtered.length === 0) {
            filtered = words;
        }

        let concise = filtered.slice(0, 5).join('-');
        return concise.replace(/-+/g, '-').replace(/^-|-$/g, '');
    }

    judulInput.addEventListener('input', function () {
        judulCount.textContent = this.value.trim().length + ' karakter';
    });

    slugInput.addEventListener('input', function () {
        let clean = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-');
        slugPreview.textContent = clean || 'slug-berita';
    });

    btnRegenerate.addEventListener('click', function () {
        const slug = createConciseSlug(judulInput.value.trim());
        slugInput.value = slug;
        slugPreview.textContent = slug || 'slug-berita';
    });

    // ==========================================
    // 2. LEAD OTOMATIS DARI PARAGRAF PERTAMA
    // ==========================================
    const editorIsi = document.getElementById('editorIsi');
    const leadCount = document.getElementById('leadCount');
    const leadPreviewText = document.getElementById('leadPreviewText');

    function extractFirstParagraphLead(text) {
        if (!text || !text.trim()) {
            return '';
        }

        let match = text.match(/<p[^>]*>(.*?)<\/p>/i);
        let paragraph = '';
        if (match && match[1]) {
            paragraph = match[1].replace(/<[^>]+>/g, '').trim();
        }

        if (!paragraph) {
            let parts = text.split(/(?:<br\s*\/?>|\r\n\r\n|\n\n|\r\r)/i);
            for (let part of parts) {
                let cl = part.replace(/<[^>]+>/g, '').trim();
                if (cl) {
                    paragraph = cl;
                    break;
                }
            }
        }

        if (!paragraph) {
            paragraph = text.replace(/<[^>]+>/g, '').trim();
        }

        paragraph = paragraph.replace(/\s+/g, ' ').trim();

        if (paragraph.length <= 500) {
            return paragraph;
        }

        let truncated = paragraph.substring(0, 500);
        let lastSpace = truncated.lastIndexOf(' ');
        if (lastSpace > 0) {
            truncated = truncated.substring(0, lastSpace);
        }
        return truncated.replace(/[,.-;:!?]+$/, '') + '...';
    }

    function updateLeadPreview() {
        const lead = extractFirstParagraphLead(editorIsi.value);
        if (lead) {
            leadCount.textContent = lead.length + ' / 500 karakter';
            leadPreviewText.textContent = '"' + lead + '"';
        } else {
            leadCount.textContent = '0 / 500 karakter';
            leadPreviewText.textContent = 'Belum ada konten paragraf pertama.';
        }
    }

    editorIsi.addEventListener('input', updateLeadPreview);
    updateLeadPreview();

    // ==========================================
    // 2b. RICH TEXT EDITOR (CKEditor) UNTUK ISI BERITA
    // ==========================================
    let isiEditorInstance = null;
    ClassicEditor
        .create(editorIsi, {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', 'insertTable', '|',
                'undo', 'redo',
            ],
        })
        .then(function (editor) {
            isiEditorInstance = editor;
            editor.model.document.on('change:data', function () {
                editorIsi.value = editor.getData();
                updateLeadPreview();
                if (editor.getData().trim() !== '') {
                    isiWarning.classList.add('hidden');
                }
            });
        })
        .catch(function (error) {
            console.error('Gagal memuat CKEditor, memakai textarea biasa sebagai cadangan:', error);
        });

    // ==========================================
    // 3. PREVIEW & VALIDASI UPLOAD GAMBAR 1 & 2
    // ==========================================
    function setupImageUpload(fileInputId, previewBoxId, previewImgId, previewInfoId, removeBtnId) {
        const fileInput = document.getElementById(fileInputId);
        const previewBox = document.getElementById(previewBoxId);
        const previewImg = document.getElementById(previewImgId);
        const previewInfo = document.getElementById(previewInfoId);
        const removeBtn = document.getElementById(removeBtnId);

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file ' + file.name + ' melebihi batas 2 MB (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB). Silakan pilih gambar yang lebih kecil.');
                this.value = '';
                previewBox.classList.add('hidden');
                return;
            }

            const allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowed.includes(file.type)) {
                alert('Tipe file tidak didukung. Harap upload format JPG, PNG, atau WEBP.');
                this.value = '';
                previewBox.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                const sizeKb = (file.size / 1024).toFixed(1);
                previewInfo.textContent = 'File baru: ' + file.name + ' (' + sizeKb + ' KB)';
                previewBox.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });

        removeBtn.addEventListener('click', function () {
            fileInput.value = '';
            previewImg.src = '';
            previewBox.classList.add('hidden');
        });
    }

    setupImageUpload('fileInput1', 'previewBox1', 'previewImg1', 'previewInfo1', 'btnRemoveImg1');
    setupImageUpload('fileInput2', 'previewBox2', 'previewImg2', 'previewInfo2', 'btnRemoveImg2');

    // ==========================================
    // 4. VALIDASI TAG & ISI WAJIB DIISI SEBELUM SUBMIT
    // ==========================================
    const articleForm = document.getElementById('articleForm');
    const tagCheckboxGrid = document.getElementById('tagCheckboxGrid');
    const tagWarning = document.getElementById('tagWarning');
    const newTagsInput = document.querySelector('input[name="new_tags"]');
    const isiWarning = document.getElementById('isiWarning');

    function hasAtLeastOneTag() {
        const anyChecked = !!tagCheckboxGrid.querySelector('.tag-checkbox:checked');
        const hasNewTag = newTagsInput && newTagsInput.value.trim() !== '';
        return anyChecked || hasNewTag;
    }

    function clearTagWarning() {
        tagWarning.classList.add('hidden');
        tagCheckboxGrid.classList.remove('border-red-400', 'dark:border-red-700');
        tagCheckboxGrid.classList.add('border-gray-200', 'dark:border-zinc-700');
    }

    tagCheckboxGrid.addEventListener('change', () => {
        if (hasAtLeastOneTag()) clearTagWarning();
    });
    if (newTagsInput) {
        newTagsInput.addEventListener('input', () => {
            if (hasAtLeastOneTag()) clearTagWarning();
        });
    }

    function isiIsEmpty() {
        return editorIsi.value.replace(/<[^>]+>/g, '').trim() === '';
    }

    articleForm.addEventListener('submit', function (e) {
        let blocked = false;
        let scrollTarget = null;

        if (isiIsEmpty()) {
            isiWarning.classList.remove('hidden');
            scrollTarget = editorIsi;
            blocked = true;
        }

        if (!hasAtLeastOneTag()) {
            tagWarning.classList.remove('hidden');
            tagCheckboxGrid.classList.remove('border-gray-200', 'dark:border-zinc-700');
            tagCheckboxGrid.classList.add('border-red-400', 'dark:border-red-700');
            scrollTarget = scrollTarget || tagCheckboxGrid;
            blocked = true;
        }

        if (blocked) {
            e.preventDefault();
            scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
    });
});
</script>
@endpush
