@extends('layouts.app')

@section('title', 'Tag #' . $tag->nama . ' — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Tag Header -->
    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
        <span class="badge-cat mb-2">Topik Tag</span>
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
            #{{ $tag->nama }}
        </h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Arsip berita dan topik pembahasan yang berkaitan dengan #{{ $tag->nama }}.
        </p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Articles List (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            @if($articles->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($articles as $art)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-4 hover:shadow-md transition-all flex flex-col justify-between">
                            <a href="{{ route('article.show', $art->slug) }}" class="group block">
                                <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $art->tone }}] dark:bg-zinc-800 mb-3">
                                    @if($art->foto)
                                        <img src="{{ $art->foto }}" alt="{{ $art->judul }}" loading="lazy">
                                    @endif
                                    <div class="th-art text-2xl">{{ substr($art->category->nama ?? 'C', 0, 1) }}</div>
                                </div>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                    <span class="badge-cat">{{ $art->category->nama ?? 'Umum' }}</span>
                                    <span>{{ $art->time_ago }}</span>
                                </div>
                                <h3 class="font-bold text-base leading-snug line-clamp-2 group-hover:text-[#008a24] transition-colors mb-2">
                                    {{ $art->judul }}
                                </h3>
                                @if($art->lead)
                                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                        {{ $art->lead }}
                                    </p>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-gray-50 dark:bg-zinc-900 rounded-xl p-12 text-center text-gray-500">
                    <p class="text-sm">Belum ada artikel dengan tag ini.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar (4 cols) -->
        <aside class="lg:col-span-4 space-y-8">
            
            <!-- Trending Topics -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4 flex items-center gap-2">
                    <span>🔥</span> Topik Populer
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($trendingTags as $tt)
                        <a href="{{ route('tag.show', $tt->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#008a24] text-xs px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium transition-colors">
                            #{{ $tt->nama }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Berita Terpopuler -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4 flex items-center gap-2">
                    <span>📈</span> Berita Terpopuler
                </h3>
                <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                    @foreach($popularArticles as $rank => $pop)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <a href="{{ route('article.show', $pop->slug) }}" class="flex gap-3 group">
                                <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:text-[#008a24] transition-colors leading-none">
                                    0{{ $rank + 1 }}
                                </span>
                                <div>
                                    <div class="text-[11px] text-gray-400 mb-1">{{ $pop->category->nama ?? 'Berita' }} · {{ $pop->dibaca }} dibaca</div>
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
</div>
@endsection
