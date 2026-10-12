@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . ($q ?: 'Semua Berita') . ' — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Search Banner Box Container -->
    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
        <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight mb-4">
            Hasil Pencarian
        </h1>
        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <input type="text" name="q" value="{{ $q }}" placeholder="Ketik kata kunci berita, isu, tokoh..." class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24] input-search-hover">
            </div>
            <div class="sm:col-span-3">
                <select name="kategori" class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-3 py-2.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:border-[#008a24]">
                    <option value="">Semua Kanal</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full bg-[#008a24] hover:bg-[#d60000] text-white py-2.5 rounded-lg text-xs font-bold transition-colors flex items-center justify-center">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Search Results Grid: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 space-y-4">
            <div class="text-xs text-gray-500 dark:text-gray-400 pb-2 border-b border-gray-200 dark:border-zinc-800">
                Menampilkan <strong>{{ $articles->total() }}</strong> berita untuk pencarian <em>"{{ $q }}"</em>
            </div>

            @if($articles->isNotEmpty())
                <div class="space-y-4">
                    @foreach($articles as $art)
                        <!-- Card Image 2 (Horizontal Card) -->
                        <article class="p-4 bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-xl hover:border-[#008a24] transition-colors">
                            <div class="group flex flex-col sm:flex-row gap-4 items-start">
                                
                                <!-- Image with hover zoom -->
                                <div class="img-zoom-wrap w-full sm:w-44 aspect-[16/10] shrink-0 bg-gray-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
                                    <a href="{{ route('article.show', $art->slug) }}" class="block w-full h-full">
                                        @if($art->foto)
                                            <img src="{{ $art->foto }}" alt="{{ $art->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-xl">
                                                {{ substr($art->category->nama ?? 'C', 0, 1) }}
                                            </div>
                                        @endif
                                    </a>
                                </div>

                                <div class="flex-1 min-w-0 flex flex-col justify-between space-y-1.5 w-full">
                                    <!-- Top Metadata: Category and Date above title -->
                                    <div class="flex items-center gap-2 text-[10px]">
                                        <span class="px-2 py-0.5 rounded font-extrabold {{ $loop->iteration % 2 === 1 ? 'bg-[#d60000]' : 'bg-[#008a24]' }} text-white uppercase shadow-xs">
                                            {{ $art->category->nama ?? 'Berita' }}
                                        </span>
                                        <span class="text-gray-400">
                                            {{ $art->formatted_date }}
                                        </span>
                                    </div>

                                    <!-- Title (Truncated to 2 lines) -->
                                    <h3 class="font-bold text-sm sm:text-base leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#d60000] transition-colors">
                                        <a href="{{ route('article.show', $art->slug) }}">
                                            {{ $art->judul }}
                                        </a>
                                    </h3>

                                    @if($art->lead)
                                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                            {{ $art->lead }}
                                        </p>
                                    @endif

                                    <!-- Time Ago below title -->
                                    <div class="text-[10px] text-gray-400 pt-1">
                                        {{ $art->time_ago }}
                                    </div>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-gray-50 dark:bg-zinc-900 rounded-xl p-12 text-center text-gray-500 text-xs">
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Tidak ada berita yang cocok</p>
                    <p class="mt-1">Coba gunakan kata kunci lain atau pilih kanal yang berbeda.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-8">
            
            <!-- Trending Topics -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
                <div class="flex items-center gap-2 border-b border-gray-200 dark:border-zinc-800 pb-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Topik Hangat
                    </h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($trendingTags as $tt)
                        <a href="{{ route('tag.show', $tt->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 hover:border-[#d60000] hover:text-[#d60000] text-xs px-3 py-1.5 rounded-full text-gray-800 dark:text-gray-200 font-semibold transition-colors">
                            #{{ $tt->nama }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Berita Terpopuler -->
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
                <div class="flex items-center gap-2 border-b border-gray-100 dark:border-zinc-800 pb-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Berita Terpopuler
                    </h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                    @foreach($popularArticles as $rank => $pop)
                        <div class="py-3 first:pt-0 last:pb-0">
                            <a href="{{ route('article.show', $pop->slug) }}" class="flex gap-3 group items-start">
                                <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 {{ $rank % 2 === 0 ? 'group-hover:text-[#d60000]' : 'group-hover:text-[#008a24]' }} transition-colors leading-none shrink-0 w-7">
                                    0{{ $rank + 1 }}
                                </span>
                                <div class="min-w-0">
                                    <div class="text-[10px] text-gray-400 mb-0.5"><span class="font-bold {{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }}">{{ $pop->category->nama ?? 'Berita' }}</span> · {{ number_format($pop->dibaca) }} dibaca</div>
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
</div>
@endsection
