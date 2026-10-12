@extends('layouts.app')

@section('title', $video->judul . ' — CuplikCom Video')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Main Video Player & Info (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Video Player Frame -->
        <div class="aspect-video w-full rounded-xl overflow-hidden bg-black shadow-2xl border border-zinc-800">
            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $video->youtube_id }}?autoplay=1" title="{{ $video->judul }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>

        <div class="space-y-3 pb-6 border-b border-gray-200 dark:border-zinc-800">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                {{ $video->judul }}
            </h1>
            <div class="flex flex-wrap items-center justify-between text-xs text-gray-500 dark:text-gray-400 gap-2">
                <span>Dipublikasikan: {{ $video->formatted_date }}</span>
                <span>{{ number_format($video->dibaca) }} kali ditonton</span>
            </div>
        </div>

        <!-- Related Videos -->
        @if($relatedVideos->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 dark:border-zinc-800 pb-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-base font-bold uppercase tracking-wider text-gray-900 dark:text-white">Video Terkait Lainnya</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedVideos as $relVid)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-2.5">
                            <a href="{{ route('video.show', $relVid->slug) }}" class="group block space-y-2">
                                <div class="relative aspect-video bg-zinc-800 rounded overflow-hidden">
                                    @if($relVid->youtube_id)
                                        <img src="https://img.youtube.com/vi/{{ $relVid->youtube_id }}/mqdefault.jpg" alt="{{ $relVid->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    @endif
                                </div>
                                <h4 class="font-bold text-xs leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-[#d60000] transition-colors">
                                    {{ $relVid->judul }}
                                </h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <!-- Sidebar (4 cols) -->
    <aside class="lg:col-span-4 space-y-8">
        
        <!-- Trending Topics -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2 mb-4">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Topik Hangat
                    </h3>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($trendingTags as $tt)
                    <a href="{{ route('tag.show', $tt->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#d60000] hover:text-[#d60000] text-xs px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium transition-colors">
                        #{{ $tt->nama }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Berita Terpopuler -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2 mb-4">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Berita Terpopuler
                    </h3>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                @foreach($popularArticles as $rank => $pop)
                    <div class="py-3 first:pt-0 last:pb-0">
                        <a href="{{ route('article.show', $pop->slug) }}" class="flex gap-3 group">
                            <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:{{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} transition-colors leading-none">
                                0{{ $rank + 1 }}
                            </span>
                            <div>
                                <div class="text-[11px] text-gray-400 mb-1">
                                    <span class="font-extrabold {{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} uppercase">{{ $pop->category->nama ?? 'Berita' }}</span>
                                    <span>·</span>
                                    <span>{{ number_format($pop->dibaca) }} dibaca</span>
                                </div>
                                <h4 class="text-xs font-bold leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-[#d60000] transition-colors">
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
