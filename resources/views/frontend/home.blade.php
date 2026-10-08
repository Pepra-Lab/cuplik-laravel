@extends('layouts.app')

@section('title', 'CuplikCom — Beritanya Unik dan Menggelitik')

@section('content')
<div class="space-y-10">

    <!-- ========================================================================= -->
    <!-- 1. HERO CONTAINER / HEADER: BANNER                                        -->
    <!-- ========================================================================= -->
    <section class="w-full space-y-2.5">
        
        <!-- Full-width Banner Box Container -->
        <div id="heroBannerContainer" class="relative w-full aspect-[21/9] sm:aspect-[24/9] md:aspect-[28/9] min-h-[240px] sm:min-h-[320px] md:min-h-[390px] rounded-xl overflow-hidden bg-zinc-950 group shadow-md">
            
            @php
                $slides = $banners->count() > 0 ? $banners : $popularArticles;
            @endphp

            @foreach($slides as $index => $slide)
                @php
                    $slideTitle = $slide->judul ?? 'Berita Terkini CuplikCom';
                    $slideLink = $slide->tautan ?? ($slide->slug ? route('article.show', $slide->slug) : '#');
                    $slideImage = $slide->gambar ?? ($slide->foto ?? null);
                    $slideCat = $slide->category->nama ?? 'Headline';
                @endphp

                <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-slide="{{ $index }}">
                    <a href="{{ $slideLink }}" class="block w-full h-full relative">
                        
                        <!-- Background Image with Hover Zoom -->
                        @if($slideImage)
                            <img src="{{ $slideImage }}" alt="{{ $slideTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                        @else
                            <div class="w-full h-full bg-zinc-900 flex items-center justify-center text-zinc-700 text-6xl font-black">
                                CUPLIK
                            </div>
                        @endif

                        <!-- Low-opacity Solid Black Overlay (NO GRADIENT) -->
                        <div class="absolute inset-0 bg-black/55"></div>

                        <!-- Banner Text Overlay (DM Sans Font) -->
                        <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-8 md:p-10 z-20 text-white space-y-2.5 max-w-4xl">
                            <span class="px-2.5 py-1 rounded text-[10px] sm:text-xs font-black uppercase tracking-wider bg-[#008a24] text-white inline-block shadow">
                                {{ $slideCat }}
                            </span>
                            <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-black leading-tight tracking-tight text-white drop-shadow-md line-clamp-2">
                                {{ $slideTitle }}
                            </h2>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>

        <!-- Banner Indicator Nodes/Dots (Bottom Right, outside box container) -->
        <div class="flex items-center justify-end gap-2 pr-1 pt-1">
            @foreach($slides as $index => $slide)
                <button type="button" onclick="goToSlide({{ $index }})" class="banner-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#008a24] scale-125' : 'bg-gray-300 dark:bg-zinc-700 hover:bg-gray-400' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

    </section>

    <!-- ========================================================================= -->
    <!-- 2. BOX CONTAINER: BERITA PILIHAN (GREEN BACKGROUND, 3 COLS CARD IMAGE 1)  -->
    <!-- ========================================================================= -->
    <section class="w-full bg-[#008a24] rounded-xl p-6 sm:p-8 text-white space-y-6 shadow-sm">
        
        <div class="flex items-center justify-between border-b border-white/20 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-white animate-pulse"></span>
                <h2 class="text-xl sm:text-2xl font-black tracking-tight text-white uppercase">
                    Berita Pilihan
                </h2>
            </div>
            <span class="text-xs text-white/90 font-semibold tracking-wide">Kurasi Redaksi Hari Ini</span>
        </div>

        <!-- 3 Columns Grid from Left to Right using Card Image 1 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($curatedNews->take(3) as $art)
                <!-- Card Image 1 in Green Box (White Text & White Badge with Green Font) -->
                <article class="group flex flex-col space-y-3">
                    
                    <!-- Image container with slight border radius and hover zoom -->
                    <div class="img-zoom-wrap aspect-[16/10] bg-black/20 rounded-lg overflow-hidden">
                        <a href="{{ route('article.show', $art->slug) }}" class="block w-full h-full">
                            @if($art->foto)
                                <img src="{{ $art->foto }}" alt="{{ $art->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white/40 font-black text-3xl">
                                    {{ substr($art->category->nama ?? 'C', 0, 1) }}
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Top Metadata above title (Category & Date on left, Time ago on right) -->
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <!-- White background badge with green font -->
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-white text-[#008a24] uppercase">
                                {{ $art->category->nama ?? 'Pilihan' }}
                            </span>
                            <span class="text-white/90 text-[11px] font-medium">
                                {{ $art->formatted_date }}
                            </span>
                        </div>
                        <div>
                            <span class="text-white/80 text-[11px]">
                                {{ $art->time_ago }}
                            </span>
                        </div>
                    </div>

                    <!-- Title (Truncated to 2 lines with ...) -->
                    <h3 class="font-bold text-base sm:text-lg leading-snug line-clamp-2 text-white group-hover:text-white/85 transition-colors">
                        <a href="{{ route('article.show', $art->slug) }}">
                            {{ $art->judul }}
                        </a>
                    </h3>

                </article>
            @endforeach
        </div>

    </section>

    <!-- ========================================================================= -->
    <!-- 3. MAIN CONTENT: 2 GRID COLUMNS (LEFT: CATEGORY FEEDS, RIGHT: SIDEBAR)    -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- ===================================================================== -->
        <!-- LEFT COLUMN (GRID 1: BERITA RINGKASAN PER KATEGORI)                   -->
        <!-- ===================================================================== -->
        <div class="lg:col-span-8 space-y-12">

            @foreach($categories as $cat)
                @php
                    $catArticles = $cat->articles;
                    $leadArticle = $catArticles->first();
                    $subArticles = $catArticles->slice(1, 3);
                @endphp

                @if($catArticles->count() > 0)
                    <!-- Category Box Container Group -->
                    <section class="space-y-4">
                        
                        <!-- Category Header: Title + Selengkapnya Link with Icon (Space Between) -->
                        <div class="flex items-center justify-between border-b-2 border-gray-900 dark:border-zinc-700 pb-2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-1.5 h-5 bg-[#008a24]"></div>
                                <h2 class="text-lg sm:text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                    {{ $cat->nama }}
                                </h2>
                            </div>
                            <a href="{{ route('category.show', $cat->slug) }}" class="text-xs font-bold text-[#008a24] hover:underline flex items-center gap-1">
                                <span>Selengkapnya</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- 2 Rows of Content -->
                        <div class="space-y-5">
                            
                            <!-- Row 1: Big Headline Latest Article using Card Image 1 (Vertical) -->
                            @if($leadArticle)
                                <article class="group flex flex-col space-y-2.5">
                                    
                                    <!-- Image Container with hover zoom -->
                                    <div class="img-zoom-wrap aspect-[16/9] sm:aspect-[21/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                        <a href="{{ route('article.show', $leadArticle->slug) }}" class="block w-full h-full">
                                            @if($leadArticle->foto)
                                                <img src="{{ $leadArticle->foto }}" alt="{{ $leadArticle->judul }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-zinc-700 font-black text-4xl">
                                                    {{ substr($cat->nama, 0, 1) }}
                                                </div>
                                            @endif
                                        </a>
                                    </div>

                                    <!-- Top Metadata: Category & Date (Left), Time Ago (Right) above Title -->
                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#008a24] text-white uppercase">
                                                {{ $cat->nama }}
                                            </span>
                                            <span class="text-gray-600 dark:text-gray-400 text-[11px] font-medium">
                                                {{ $leadArticle->formatted_date }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-400 text-[11px]">
                                                {{ $leadArticle->time_ago }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Headline Title (Truncated to 2 lines) -->
                                    <h3 class="font-black text-lg sm:text-xl leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
                                        <a href="{{ route('article.show', $leadArticle->slug) }}">
                                            {{ $leadArticle->judul }}
                                        </a>
                                    </h3>

                                    @if($leadArticle->lead)
                                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                            {{ $leadArticle->lead }}
                                        </p>
                                    @endif

                                </article>
                            @endif

                            <!-- Row 2: 3 Items Arranged using Card Image 2 (Horizontal) -->
                            @if($subArticles->count() > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-gray-100 dark:border-zinc-800">
                                    @foreach($subArticles as $subArt)
                                        <article class="group flex flex-row sm:flex-col gap-3 items-start">
                                            
                                            <!-- Thumbnail Container with Hover Zoom -->
                                            <div class="img-zoom-wrap w-28 sm:w-full aspect-[16/10] shrink-0 bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                                <a href="{{ route('article.show', $subArt->slug) }}" class="block w-full h-full">
                                                    @if($subArt->foto)
                                                        <img src="{{ $subArt->foto }}" alt="{{ $subArt->judul }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-zinc-700 font-bold text-sm">
                                                            {{ substr($cat->nama, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>

                                            <div class="flex-1 min-w-0 flex flex-col justify-between space-y-1">
                                                <!-- Top Metadata: Category and Date above title -->
                                                <div class="flex items-center gap-1.5 text-[10px]">
                                                    <span class="px-1.5 py-0.5 rounded font-extrabold bg-[#008a24] text-white uppercase">
                                                        {{ $cat->nama }}
                                                    </span>
                                                    <span class="text-gray-400">
                                                        {{ $subArt->formatted_date }}
                                                    </span>
                                                </div>

                                                <!-- Title (Truncated to 2 lines) -->
                                                <h4 class="font-bold text-xs sm:text-sm leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
                                                    <a href="{{ route('article.show', $subArt->slug) }}">
                                                        {{ $subArt->judul }}
                                                    </a>
                                                </h4>

                                                <!-- Time Ago below title -->
                                                <div class="text-[10px] text-gray-400">
                                                    {{ $subArt->time_ago }}
                                                </div>
                                            </div>

                                        </article>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                    </section>
                @endif

                <!-- Interleaved 1: Between Hukum and Ekonomi -> Box Container Newsletter -->
                @if(strtolower($cat->nama) === 'hukum')
                    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm my-8">
                        <div class="w-full md:w-1/3 max-w-[220px] aspect-[4/3] rounded-lg overflow-hidden shrink-0 bg-zinc-100 dark:bg-zinc-800 shadow">
                            <img src="{{ asset('assets/newsletter.png') }}" alt="Newsletter CuplikCom" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 space-y-3 text-left">
                            <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase bg-[#008a24] text-white inline-block">
                                Ruang Langganan Eksklusif
                            </span>
                            <h3 class="text-lg sm:text-xl font-black text-gray-900 dark:text-white leading-tight">
                                Dapatkan Rangkuman Berita Harian &amp; Analisis Kritis
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                                Jangan lewatkan isu-isu krusial Pantura, politik, dan suara warga langsung di email Anda setiap pagi tanpa spam.
                            </p>
                            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-2 max-w-md pt-1">
                                @csrf
                                <input type="email" name="email" required placeholder="Masukkan alamat email Anda..." class="flex-1 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
                                <button type="submit" class="px-5 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg transition-colors shrink-0">
                                    Langganan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Interleaved 2: Between Ekonomi and Ragam -> Box Container Space Iklan -->
                @if(strtolower($cat->nama) === 'ekonomi')
                    <div class="my-8 rounded-xl overflow-hidden border border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-900 p-4 text-center">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-2">
                            Ruang Iklan Banner
                        </span>
                        @if($iklanBetweenCategory && $iklanBetweenCategory->gambar)
                            <a href="{{ $iklanBetweenCategory->link ?: '#' }}" class="block max-w-2xl mx-auto">
                                <img src="{{ asset($iklanBetweenCategory->gambar) }}" alt="{{ $iklanBetweenCategory->judul }}" class="w-full h-auto rounded-lg mx-auto">
                            </a>
                        @else
                            <div class="h-24 sm:h-28 bg-emerald-50 dark:bg-emerald-950/30 border border-dashed border-[#008a24] rounded-lg flex flex-col items-center justify-center p-4">
                                <span class="text-xs font-bold text-[#008a24] uppercase tracking-wider">Slot Iklan Display (728 × 90 px)</span>
                                <span class="text-[11px] text-gray-500 mt-1">Hubungi Redaksi CuplikCom untuk Pemasangan Iklan Sponsor</span>
                            </div>
                        @endif
                    </div>
                @endif

            @endforeach

        </div>

        <!-- ===================================================================== -->
        <!-- RIGHT COLUMN (GRID 2: SIDEBAR WIDGETS)                                -->
        <!-- ===================================================================== -->
        <aside class="lg:col-span-4 space-y-8">
            
            <!-- 1. Tagar yang sedang trending (Trending Hashtags) in Box Container -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4">
                <div class="border-b border-gray-200 dark:border-zinc-800 pb-2.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-4 bg-[#008a24]"></div>
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                            Tagar Trending
                        </h3>
                    </div>
                    <span class="text-[10px] font-bold text-[#008a24]">#TopikHangat</span>
                </div>
                
                <div class="space-y-2">
                    @forelse($trendingTags as $rank => $tt)
                        <a href="{{ route('tag.show', $tt->slug) }}" class="flex items-center justify-between p-2 rounded-lg bg-white dark:bg-zinc-800/80 border border-gray-200/80 dark:border-zinc-700/80 hover:border-[#008a24] transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xs font-black text-[#008a24]">
                                    0{{ $rank + 1 }}
                                </span>
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#008a24] transition-colors">
                                    #{{ $tt->nama }}
                                </span>
                            </div>
                            <span class="text-[10px] text-gray-400 font-medium">
                                {{ $tt->articles_count }} berita
                            </span>
                        </a>
                    @empty
                        <span class="text-xs text-gray-400">Belum ada tagar trending.</span>
                    @endforelse
                </div>
            </div>

            <!-- 2. Keluh Kesah Rakyat (Curhat) with Anonymous Avatar & Message -->
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2.5">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-4 bg-[#008a24]"></div>
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                            Keluh Kesah Rakyat
                        </h3>
                    </div>
                    <a href="{{ route('curhat.index') }}" class="text-xs font-bold text-[#008a24] hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($curhats->take(4) as $c)
                        <div class="p-3.5 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-gray-100 dark:border-zinc-800 space-y-2">
                            <!-- Avatar Anonymous and Sender Info -->
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#008a24] text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                                    {{ substr($c->pengirim, 0, 1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate">
                                        {{ $c->pengirim }}
                                    </h4>
                                    <span class="text-[10px] text-gray-400 block truncate font-medium">
                                        {{ $c->lokasi ?: 'Warga' }} · {{ $c->created_at ? $c->created_at->diffForHumans() : '-' }}
                                    </span>
                                </div>
                            </div>
                            <!-- Message Content -->
                            <p class="text-xs text-gray-700 dark:text-gray-300 italic leading-relaxed line-clamp-3">
                                "{{ $c->pesan }}"
                            </p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-2">Belum ada aspirasi masuk.</p>
                    @endforelse
                </div>

                <!-- Fast Post Link -->
                <a href="{{ route('curhat.index') }}" class="block w-full py-2.5 bg-[#008a24] hover:bg-[#006f1c] text-white text-center text-xs font-bold rounded-lg transition-colors">
                    Kirim Aspirasi Saya
                </a>
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
                    <div class="h-44 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex flex-col items-center justify-center p-4 border border-dashed border-gray-300 dark:border-zinc-700">
                        <span class="text-xs font-bold text-gray-500 uppercase">Banner 300 × 250 px</span>
                        <span class="text-[10px] text-gray-400 mt-1">Advertorial &amp; Promosi Usaha</span>
                    </div>
                @endif
            </div>

            <!-- 4. Berita Terpopuler (Numbered List 01 to 05) -->
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
                <div class="border-b border-gray-100 dark:border-zinc-800 pb-2.5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-4 bg-[#008a24]"></div>
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                            Berita Terpopuler
                        </h3>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400">Paling Banyak Dibaca</span>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @foreach($popularArticles as $rank => $pop)
                        <article class="py-3 first:pt-0 last:pb-0 flex items-start gap-3.5 group">
                            <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:text-[#008a24] transition-colors leading-none shrink-0 w-7">
                                0{{ $rank + 1 }}
                            </span>
                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-1.5 text-[10px] text-gray-400">
                                    <span class="font-extrabold text-[#008a24] uppercase">{{ $pop->category->nama ?? 'Berita' }}</span>
                                    <span>·</span>
                                    <span>{{ number_format($pop->dibaca) }} dibaca</span>
                                </div>
                                <h4 class="font-bold text-xs leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
                                    <a href="{{ route('article.show', $pop->slug) }}">
                                        {{ $pop->judul }}
                                    </a>
                                </h4>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- 5. Tag Cloud Widget -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-zinc-800 pb-2">
                    <div class="w-1.5 h-4 bg-[#008a24]"></div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Katalog Topik &amp; Tag
                    </h3>
                </div>
                <div class="flex flex-wrap gap-1.5 pt-1">
                    @foreach($trendingTags as $tagItem)
                        <a href="{{ route('tag.show', $tagItem->slug) }}" class="px-2.5 py-1 rounded bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#008a24] text-[11px] font-semibold text-gray-700 dark:text-gray-300 transition-colors">
                            #{{ $tagItem->nama }}
                        </a>
                    @endforeach
                </div>
            </div>

        </aside>

    </div>

</div>

<!-- Banner Carousel Script: 10 Seconds Auto-Slide with Dot Switching -->
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.banner-dot');
    const totalSlides = slides.length;
    let bannerInterval = null;

    function showSlide(index) {
        if (totalSlides === 0) return;
        
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                slide.classList.add('opacity-100', 'z-10');
            } else {
                slide.classList.remove('opacity-100', 'z-10');
                slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
            }
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-gray-300', 'dark:bg-zinc-700');
                dot.classList.add('bg-[#008a24]', 'scale-125');
            } else {
                dot.classList.remove('bg-[#008a24]', 'scale-125');
                dot.classList.add('bg-gray-300', 'dark:bg-zinc-700');
            }
        });

        currentSlide = index;
    }

    function nextSlide() {
        if (totalSlides === 0) return;
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }

    function goToSlide(index) {
        showSlide(index);
        resetInterval();
    }

    function resetInterval() {
        clearInterval(bannerInterval);
        bannerInterval = setInterval(nextSlide, 10000); // 10 Seconds auto slide
    }

    // Initialize 10s auto rotation
    if (totalSlides > 1) {
        bannerInterval = setInterval(nextSlide, 10000);
    }
</script>
@endsection
