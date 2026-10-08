@extends('layouts.app')

@section('title', $article->judul . ' — CuplikCom')
@section('meta_description', $article->lead ?: Str::limit(strip_tags($article->isi), 160))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- ========================================================================= -->
    <!-- COLUMN 1: MAIN ARTICLE CONTENT                                            -->
    <!-- ========================================================================= -->
    <article class="lg:col-span-8 space-y-6">
        
        <!-- Breadcrumb Category Link -->
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-[#008a24]">Home</a>
            <span>/</span>
            <a href="{{ route('category.show', $article->category->slug) }}" class="font-bold text-[#008a24] hover:underline">
                {{ $article->category->nama }}
            </a>
        </div>

        <!-- 1. Judul Berita -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight text-gray-900 dark:text-white">
            {{ $article->judul }}
        </h1>

        <!-- 2. Nama Author beserta Tanggal Publish format Indonesia (Space Between) -->
        <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-y border-gray-200 dark:border-zinc-800 text-xs">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-[#008a24] text-white font-black text-xs flex items-center justify-center shrink-0">
                    {{ substr($article->penulis_nama ?: 'R', 0, 1) }}
                </div>
                <div>
                    <span class="font-bold text-gray-900 dark:text-white block">
                        {{ $article->penulis_nama ?: 'Redaksi Cuplik' }}
                    </span>
                    @if($article->editor_nama)
                        <span class="text-[11px] text-gray-500 dark:text-gray-400">Editor: {{ $article->editor_nama }}</span>
                    @endif
                </div>
            </div>

            <div class="text-right text-gray-500 dark:text-gray-400">
                <span class="font-medium block text-gray-800 dark:text-gray-200">{{ $article->formatted_date }}</span>
                <span class="text-[11px]">{{ $article->time_ago }} · {{ number_format($article->dibaca) }} kali dibaca</span>
            </div>
        </div>

        <!-- 3. Gambar Utama (Featured Image) with Hover Zoom & Border Radius -->
        <div class="img-zoom-wrap aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-xl overflow-hidden shadow-sm">
            @if($article->foto)
                <img src="{{ $article->foto }}" alt="{{ $article->judul }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-zinc-700 font-black text-6xl">
                    {{ substr($article->category->nama ?? 'C', 0, 1) }}
                </div>
            @endif
        </div>

        @if($article->caption_foto)
            <p class="text-[11px] text-gray-500 italic text-center -mt-3">
                {{ $article->caption_foto }}
            </p>
        @endif

        <!-- Lead / Ringkasan -->
        @if($article->lead)
            <div class="p-4 bg-gray-50 dark:bg-zinc-900 border-l-4 border-[#008a24] rounded-r-lg text-sm text-gray-800 dark:text-gray-200 font-medium leading-relaxed italic">
                {{ $article->lead }}
            </div>
        @endif

        <!-- 4. Detail Teks Berita -->
        <div class="text-base leading-relaxed text-gray-800 dark:text-gray-200 space-y-4">
            {!! $article->isi !!}
        </div>

        <!-- In-Article Advertisement Slot (if any) -->
        @if($iklanArtikel)
            <div class="my-6 p-4 bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg text-center">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-2">Advertorial</span>
                <a href="{{ $iklanArtikel->link ?: '#' }}" class="block">
                    @if($iklanArtikel->gambar)
                        <img src="{{ asset($iklanArtikel->gambar) }}" alt="{{ $iklanArtikel->judul }}" class="mx-auto max-h-48 rounded">
                    @else
                        <div class="py-4 text-xs text-[#008a24] font-bold">{{ $iklanArtikel->judul }}</div>
                    @endif
                </a>
            </div>
        @endif

        <!-- 5. Icon Box Share dengan Warna Company Brand (WhatsApp, Instagram, Twitter, TikTok, Copy URL) -->
        <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800 space-y-3">
            <span class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider block">
                Bagikan Berita Ini:
            </span>
            <div class="flex flex-wrap items-center gap-2">
                
                <!-- WhatsApp (#25D366) -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->judul . ' ' . url()->current()) }}" target="_blank" class="px-3 py-2 bg-[#25D366] hover:opacity-90 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-opacity" title="Bagikan ke WhatsApp">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.181-.076.355.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>

                <!-- Instagram (#E1306C) -->
                <a href="https://instagram.com" target="_blank" class="px-3 py-2 bg-[#E1306C] hover:opacity-90 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-opacity" title="Buka Instagram">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>Instagram</span>
                </a>

                <!-- Twitter / X (#000000) -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="px-3 py-2 bg-black hover:opacity-90 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-opacity" title="Bagikan ke X / Twitter">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                    <span>X (Twitter)</span>
                </a>

                <!-- TikTok (#000000) -->
                <a href="https://tiktok.com" target="_blank" class="px-3 py-2 bg-black hover:opacity-90 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-opacity" title="Buka TikTok">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                    <span>TikTok</span>
                </a>

                <!-- Copy URL (#008a24) -->
                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" class="px-3 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors" title="Salin Tautan Berita">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                    </svg>
                    <span>Salin Link</span>
                </button>

            </div>
        </div>

        <!-- 6. Suggestion Berita (3 Items dari kiri ke kanan menggunakan Card Image 1) -->
        <section class="pt-8 border-t border-gray-200 dark:border-zinc-800 space-y-4">
            <div class="flex items-center justify-between border-b-2 border-[#008a24] pb-2">
                <h3 class="text-base sm:text-lg font-black uppercase tracking-tight text-gray-900 dark:text-white">
                    Berita Terkait Lainnya
                </h3>
                <a href="{{ route('category.show', $article->category->slug) }}" class="text-xs font-bold text-[#008a24] hover:underline">
                    Kanal {{ $article->category->nama }} &rarr;
                </a>
            </div>

            <!-- 3 Columns Grid using Card Image 1 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($relatedArticles->take(3) as $rel)
                    <article class="group flex flex-col space-y-2.5">
                        
                        <!-- Thumbnail with Slight Border Radius and Hover Zoom -->
                        <div class="img-zoom-wrap aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                            <a href="{{ route('article.show', $rel->slug) }}" class="block w-full h-full">
                                @if($rel->foto)
                                    <img src="{{ $rel->foto }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-xl">
                                        {{ substr($rel->category->nama ?? 'C', 0, 1) }}
                                    </div>
                                @endif
                            </a>
                        </div>

                        <!-- Top Metadata: Category & Date on Left, Time Ago on Right above Title -->
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#008a24] text-white">
                                    {{ $rel->category->nama ?? 'Berita' }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400 text-[11px]">
                                    {{ $rel->formatted_date }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-[11px]">
                                    {{ $rel->time_ago }}
                                </span>
                            </div>
                        </div>

                        <!-- Title (Truncated to 2 lines with ...) -->
                        <h4 class="font-bold text-xs sm:text-sm leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
                            <a href="{{ route('article.show', $rel->slug) }}">
                                {{ $rel->judul }}
                            </a>
                        </h4>

                    </article>
                @endforeach
            </div>
        </section>

        <!-- Diskusi Pembaca & Form Komentar -->
        <section class="pt-8 border-t border-gray-200 dark:border-zinc-800 space-y-6">
            <h3 class="text-base sm:text-lg font-black text-gray-900 dark:text-white">
                Diskusi Pembaca ({{ $article->comments->count() }})
            </h3>

            <!-- Comment Form -->
            <form action="{{ route('article.comment.store', $article->slug) }}" method="POST" class="bg-gray-50 dark:bg-zinc-900 p-5 rounded-xl border border-gray-200 dark:border-zinc-800 space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="text" name="nama" required placeholder="Nama lengkap Anda..." class="bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                    <input type="email" name="email" placeholder="Email (opsional / tidak dipublikasi)..." class="bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                </div>
                <textarea name="komentar" rows="3" required placeholder="Tulis tanggapan atau opini Anda terhadap berita ini..." class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg p-3 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover"></textarea>
                <button type="submit" class="px-5 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg transition-colors">
                    Kirim Komentar
                </button>
            </form>

            <!-- Comments List -->
            <div class="space-y-3">
                @forelse($article->comments as $com)
                    <div class="p-4 bg-white dark:bg-zinc-900 rounded-xl border border-gray-100 dark:border-zinc-800 space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-gray-900 dark:text-white">{{ $com->nama }}</span>
                            <span class="text-gray-400 text-[11px]">{{ $com->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $com->komentar }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-3">Belum ada tanggapan untuk berita ini. Jadilah yang pertama berkomentar!</p>
                @endforelse
            </div>
        </section>

    </article>

    <!-- ========================================================================= -->
    <!-- COLUMN 2: SIDEBAR (TAG, TRENDING, SPACE IKLAN)                            -->
    <!-- ========================================================================= -->
    <aside class="lg:col-span-4 space-y-8">
        
        <!-- 1. Tagar / Topik Terkait -->
        @if($article->tags->isNotEmpty())
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b border-gray-200 dark:border-zinc-800 pb-2">
                    Tag Berita
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#008a24] text-xs px-3 py-1.5 rounded-full text-gray-800 dark:text-gray-200 font-semibold transition-colors">
                            #{{ $tag->nama }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 2. Tagar Trending Umum -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b border-gray-200 dark:border-zinc-800 pb-2">
                Tagar Trending
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($trendingTags as $tt)
                    <a href="{{ route('tag.show', $tt->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#008a24] text-xs px-3 py-1.5 rounded-full text-gray-800 dark:text-gray-200 font-semibold transition-colors">
                        #{{ $tt->nama }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 3. Space Iklan (Sidebar Banner) -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-4 text-center">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-2">
                Space Iklan Sponsor
            </span>
            @if($iklanSidebar && $iklanSidebar->gambar)
                <a href="{{ $iklanSidebar->link ?: '#' }}" class="block max-w-[300px] mx-auto">
                    <img src="{{ asset($iklanSidebar->gambar) }}" alt="{{ $iklanSidebar->judul }}" class="w-full h-auto rounded-lg mx-auto">
                </a>
            @else
                <div class="h-60 bg-emerald-50 dark:bg-emerald-950/30 border border-dashed border-[#008a24] rounded-lg flex flex-col items-center justify-center p-4">
                    <span class="text-xs font-bold text-[#008a24] uppercase tracking-wider">Slot Iklan Sidebar</span>
                    <span class="text-[11px] text-gray-500 mt-1">300 × 250 px / 300 × 600 px</span>
                </div>
            @endif
        </div>

        <!-- 4. Berita Terpopuler -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4">
            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2">
                Berita Terpopuler
            </h3>
            <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                @foreach($popularArticles as $rank => $pop)
                    <div class="py-3 first:pt-0 last:pb-0">
                        <a href="{{ route('article.show', $pop->slug) }}" class="flex gap-3 group items-start">
                            <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:text-[#008a24] transition-colors leading-none shrink-0 w-7">
                                0{{ $rank + 1 }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-[10px] text-gray-400 mb-0.5">{{ $pop->category->nama ?? 'Berita' }} · {{ number_format($pop->dibaca) }} dibaca</div>
                                <h4 class="text-xs font-bold leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-[#008a24] transition-colors">
                                    {{ $pop->judul }}
                                </h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </aside>

</div>
@endsection
