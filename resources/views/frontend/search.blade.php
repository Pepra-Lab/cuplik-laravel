@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . ($q ?: 'Semua Berita') . ' — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Search Banner Box -->
    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
        <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight mb-4">
            Hasil Pencarian
        </h1>
        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <input type="text" name="q" value="{{ $q }}" placeholder="Ketik kata kunci pencarian..." class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div class="sm:col-span-3">
                <select name="kategori" class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg px-3 py-2.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="">Semua Kanal</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-1">
                <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2.5 rounded-lg text-sm font-bold flex items-center justify-center">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Search Results Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 space-y-4">
            <div class="text-xs text-gray-500 dark:text-gray-400 pb-2 border-b border-gray-200 dark:border-zinc-800">
                Menampilkan <strong>{{ $articles->total() }}</strong> berita untuk pencarian <em>"{{ $q }}"</em>
            </div>

            @if($articles->isNotEmpty())
                <div class="space-y-4">
                    @foreach($articles as $art)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-4 hover:border-[#008a24] transition-colors">
                            <a href="{{ route('article.show', $art->slug) }}" class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-4 items-center group">
                                <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $art->tone }}] dark:bg-zinc-800 rounded">
                                    @if($art->foto)
                                        <img src="{{ $art->foto }}" alt="{{ $art->judul }}" loading="lazy">
                                    @endif
                                    <div class="th-art text-2xl">{{ substr($art->category->nama ?? 'C', 0, 1) }}</div>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-1">
                                        <span class="badge-cat">{{ $art->category->nama ?? 'Umum' }}</span>
                                        <span>{{ $art->formatted_date }}</span>
                                        <span>·</span>
                                        <span>{{ $art->time_ago }}</span>
                                    </div>
                                    <h3 class="font-bold text-base leading-snug text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors mb-1.5">
                                        {{ $art->judul }}
                                    </h3>
                                    @if($art->lead)
                                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                            {{ $art->lead }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-gray-50 dark:bg-zinc-900 rounded-xl p-12 text-center text-gray-500">
                    <p class="text-base font-bold text-gray-700 dark:text-gray-300">Tidak ada berita yang cocok</p>
                    <p class="text-xs mt-1">Coba gunakan kata kunci lain atau pilih kanal yang berbeda.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-8">
            <!-- Trending Topics -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4 flex items-center gap-2">
                    <span>🔥</span> Topik Hangat
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
