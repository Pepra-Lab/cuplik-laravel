@extends('layouts.app')

@section('title', $page->judul . ' — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
            @if($page->badge)
                <span class="badge-cat mb-2">{{ $page->badge }}</span>
            @endif
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                {{ $page->judul }}
            </h1>
            @if($page->subjudul)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $page->subjudul }}</p>
            @endif
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-4 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
            {!! $page->konten !!}
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-8">
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
