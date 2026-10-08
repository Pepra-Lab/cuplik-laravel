@extends('layouts.app')

@section('title', 'Kanal ' . $category->nama . ' — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Category Header Box Container -->
    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="px-2.5 py-1 rounded text-[10px] font-extrabold bg-[#008a24] text-white uppercase inline-block mb-1.5">
                    Kanal Berita
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                    {{ $category->nama }}
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Kumpulan berita mendalam, liputan investigasi, dan kabar terkini seputar {{ strtolower($category->nama) }}.
                </p>
            </div>

            <!-- Sub Tags Filter Pills -->
            @if($category->tags->isNotEmpty())
                <div class="flex flex-wrap items-center gap-1.5">
                    <a href="{{ route('category.show', $category->slug) }}" class="text-xs px-3 py-1.5 rounded-lg font-bold transition-colors {{ !$selectedTagSlug ? 'bg-[#008a24] text-white' : 'bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-gray-700 dark:text-gray-300 hover:border-[#008a24]' }}">
                        Semua
                    </a>
                    @foreach($category->tags as $tag)
                        <a href="{{ route('category.show', ['slug' => $category->slug, 'tag' => $tag->slug]) }}" class="text-xs px-3 py-1.5 rounded-lg font-bold transition-colors {{ $selectedTagSlug === $tag->slug ? 'bg-[#008a24] text-white' : 'bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 text-gray-700 dark:text-gray-300 hover:border-[#008a24]' }}">
                            #{{ $tag->nama }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Main Grid: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Articles Grid using Card Image 1 (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            @if($articles->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($articles as $art)
                        <!-- Card Image 1 (Vertical Card) -->
                        <article class="group flex flex-col space-y-2.5">
                            
                            <!-- Thumbnail with hover zoom and slight border radius -->
                            <div class="img-zoom-wrap aspect-[16/10] bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                <a href="{{ route('article.show', $art->slug) }}" class="block w-full h-full">
                                    @if($art->foto)
                                        <img src="{{ $art->foto }}" alt="{{ $art->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-2xl">
                                            {{ substr($category->nama, 0, 1) }}
                                        </div>
                                    @endif
                                </a>
                            </div>

                            <!-- Top Metadata: Category & Date (Left), Time Ago (Right) above Title -->
                            <div class="flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#008a24] text-white uppercase">
                                        {{ $category->nama }}
                                    </span>
                                    <span class="text-gray-500 dark:text-gray-400 text-[11px] font-medium">
                                        {{ $art->formatted_date }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-[11px]">
                                        {{ $art->time_ago }}
                                    </span>
                                </div>
                            </div>

                            <!-- Title (Truncated to 2 lines with ...) -->
                            <h3 class="font-bold text-sm sm:text-base leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
                                <a href="{{ route('article.show', $art->slug) }}">
                                    {{ $art->judul }}
                                </a>
                            </h3>

                            @if($art->lead)
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ $art->lead }}
                                </p>
                            @endif

                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-gray-50 dark:bg-zinc-900 rounded-xl p-12 text-center text-gray-500 text-xs border border-gray-200 dark:border-zinc-800">
                    <p>Belum ada artikel dalam kategori ini.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-8">
            
            <!-- Trending Topics -->
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
                <div class="flex items-center gap-2 border-b border-gray-100 dark:border-zinc-800 pb-2">
                    <div class="w-1.5 h-4 bg-[#008a24]"></div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Topik Hangat
                    </h3>
                </div>
                <div class="space-y-2">
                    @foreach($trendingTags as $rank => $tt)
                        <a href="{{ route('tag.show', $tt->slug) }}" class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-zinc-800/80 border border-gray-200/80 dark:border-zinc-700/80 hover:border-[#008a24] transition-colors group">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xs font-black text-[#008a24]">0{{ $rank + 1 }}</span>
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#008a24] transition-colors">#{{ $tt->nama }}</span>
                            </div>
                            <span class="text-[10px] text-gray-400">{{ $tt->articles_count }} berita</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Space Iklan -->
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
                        <span class="text-[10px] text-gray-400 mt-1">Advertorial &amp; Promosi</span>
                    </div>
                @endif
            </div>

            <!-- Berita Terpopuler -->
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-4 bg-[#008a24]"></div>
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                            Paling Populer
                        </h3>
                    </div>
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

        </aside>

    </div>

</div>
@endsection
