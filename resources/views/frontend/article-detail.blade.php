@extends('layouts.app')

@section('title', $article->judul . ' — CuplikCom')
@section('meta_description', $article->lead ?: Str::limit(strip_tags($article->isi), 160))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Main Article Body (8 cols) -->
    <article class="lg:col-span-8 space-y-6">
        
        <!-- Breadcrumb & Category -->
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-[#008a24]">Home</a>
            <span>/</span>
            <a href="{{ route('category.show', $article->category->slug) }}" class="hover:text-[#008a24] font-semibold text-[#008a24]">{{ $article->category->nama }}</a>
            <span>/</span>
            <span class="truncate max-w-[200px]">{{ $article->judul }}</span>
        </div>

        <!-- Title -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-tight text-gray-900 dark:text-white">
            {{ $article->judul }}
        </h1>

        <!-- Metadata Info -->
        <div class="flex flex-wrap items-center justify-between gap-4 py-3 border-y border-gray-200 dark:border-zinc-800 text-xs text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#008a24] text-white flex items-center justify-center font-bold">
                    {{ substr($article->penulis_nama ?: 'C', 0, 1) }}
                </div>
                <div>
                    <div class="font-bold text-gray-900 dark:text-white">Penulis: {{ $article->penulis_nama ?: 'Redaksi Cuplik' }}</div>
                    @if($article->editor_nama)
                        <div>Editor: {{ $article->editor_nama }}</div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4">
                <span>📅 {{ $article->formatted_date }} ({{ $article->time_ago }})</span>
                @if($article->lokasi)
                    <span>📍 {{ $article->lokasi }}</span>
                @endif
                <span>👁️ {{ number_format($article->dibaca) }} dibaca</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $article->tone }}] dark:bg-zinc-800 rounded-xl overflow-hidden">
            @if($article->foto)
                <img src="{{ $article->foto }}" alt="{{ $article->judul }}" class="w-full h-full object-cover">
            @else
                <div class="th-art text-6xl">{{ substr($article->category->nama, 0, 1) }}</div>
            @endif
        </div>

        <!-- Lead / Ringkasan -->
        @if($article->lead)
            <div class="bg-emerald-50 dark:bg-emerald-950/30 border-l-4 border-[#008a24] p-4 rounded text-sm text-gray-800 dark:text-gray-200 font-medium leading-relaxed italic">
                {{ $article->lead }}
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose dark:prose-invert max-w-none text-base leading-relaxed text-gray-800 dark:text-gray-200 space-y-4">
            {!! $article->isi !!}
        </div>

        <!-- In-Article Advertisement Slot -->
        @if($iklanArtikel)
            <div class="my-6 p-4 bg-gray-50 dark:bg-zinc-900 border border-dashed border-gray-300 dark:border-zinc-700 rounded-lg text-center">
                <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-2">Advertorial</span>
                <a href="{{ $iklanArtikel->link ?: '#' }}" class="block">
                    @if($iklanArtikel->gambar)
                        <img src="{{ $iklanArtikel->gambar }}" alt="{{ $iklanArtikel->judul }}" class="mx-auto max-h-48 rounded">
                    @else
                        <div class="py-6 text-xs text-gray-500 font-medium">{{ $iklanArtikel->judul }}</div>
                    @endif
                </a>
            </div>
        @endif

        <!-- Tags -->
        @if($article->tags->isNotEmpty())
            <div class="pt-4 border-t border-gray-200 dark:border-zinc-800">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-2">Topik Terkait:</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" class="bg-gray-100 dark:bg-zinc-800 hover:bg-[#008a24] hover:text-white px-3 py-1 rounded-full text-xs font-medium text-gray-700 dark:text-gray-300 transition-colors">
                            #{{ $tag->nama }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Social Share Buttons -->
        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-zinc-900 rounded-xl border border-gray-200 dark:border-zinc-800">
            <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Bagikan Berita:</span>
            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->judul . ' ' . url()->current()) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1.5 rounded font-bold flex items-center gap-1.5">
                    WhatsApp
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->judul) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="bg-black hover:bg-zinc-800 text-white text-xs px-3 py-1.5 rounded font-bold flex items-center gap-1.5">
                    X (Twitter)
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded font-bold flex items-center gap-1.5">
                    Facebook
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="bg-gray-200 dark:bg-zinc-700 hover:bg-gray-300 text-gray-800 dark:text-white text-xs px-3 py-1.5 rounded font-bold">
                    Salin Link
                </button>
            </div>
        </div>

        <!-- Related News (Card 1 style) -->
        @if($relatedArticles->isNotEmpty())
            <div class="pt-6">
                <h3 class="text-lg font-black uppercase tracking-tight text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4">
                    Berita Terkait di Kanal {{ $article->category->nama }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($relatedArticles as $rel)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-3 hover:border-[#008a24] transition-colors">
                            <a href="{{ route('article.show', $rel->slug) }}" class="group block">
                                <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $rel->tone }}] dark:bg-zinc-800 mb-2">
                                    @if($rel->foto)
                                        <img src="{{ $rel->foto }}" alt="{{ $rel->judul }}" loading="lazy">
                                    @endif
                                    <div class="th-art text-xl">{{ substr($rel->category->nama, 0, 1) }}</div>
                                </div>
                                <div class="flex items-center justify-between text-[11px] text-gray-400 mb-1">
                                    <span>{{ $rel->formatted_date }}</span>
                                    <span>{{ $rel->time_ago }}</span>
                                </div>
                                <h4 class="font-bold text-xs leading-snug line-clamp-2 group-hover:text-[#008a24] transition-colors">
                                    {{ $rel->judul }}
                                </h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Comments Section -->
        <section class="pt-6 border-t border-gray-200 dark:border-zinc-800 space-y-6">
            <h3 class="text-lg font-black tracking-tight text-gray-900 dark:text-white">
                Diskusi Pembaca ({{ $article->comments->count() }})
            </h3>

            <!-- Comment Form -->
            <form action="{{ route('article.comment.store', $article->slug) }}" method="POST" class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ auth()->user()?->name }}" required placeholder="Nama Anda" class="w-full bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-1.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Email (opsional)</label>
                        <input type="email" name="email" value="{{ auth()->user()?->email }}" placeholder="email@example.com" class="w-full bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-1.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Komentar & Pandangan *</label>
                    <textarea name="komentar" rows="3" required placeholder="Tulis tanggapan atau komentar yang santun dan objektif..." class="w-full bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]"></textarea>
                </div>
                <button type="submit" class="bg-[#008a24] hover:bg-[#006f1c] text-white px-4 py-2 rounded text-xs font-bold uppercase tracking-wider transition-colors">
                    Kirim Komentar
                </button>
            </form>

            <!-- Comments List -->
            <div class="space-y-3">
                @forelse($article->comments as $comment)
                    <div class="p-4 bg-white dark:bg-zinc-900/80 border border-gray-100 dark:border-zinc-800 rounded-lg space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-gray-900 dark:text-white">{{ $comment->nama }}</span>
                            <span class="text-gray-400">{{ $comment->time_ago }}</span>
                        </div>
                        <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $comment->komentar }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada komentar untuk artikel ini. Jadilah yang pertama memberikan tanggapan!</p>
                @endforelse
            </div>
        </section>

    </article>

    <!-- Sidebar (4 cols) -->
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

        <!-- Sidebar Banner Ad -->
        @if($iklanSidebar)
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-3 flex justify-center">
                <a href="{{ $iklanSidebar->link ?: '#' }}" class="block max-w-[300px] w-full text-center">
                    @if($iklanSidebar->gambar)
                        <img src="{{ $iklanSidebar->gambar }}" alt="{{ $iklanSidebar->judul }}" class="w-full h-auto rounded">
                    @else
                        <div class="h-64 bg-emerald-50 dark:bg-emerald-950/40 border border-dashed border-[#008a24] rounded flex flex-col items-center justify-center p-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#008a24]">Ruang Iklan Sidebar</span>
                            <span class="text-xs text-gray-500">{{ $iklanSidebar->judul }} · 300×250 px</span>
                        </div>
                    @endif
                </a>
            </div>
        @endif

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
                                <div class="text-[11px] text-gray-400 mb-1">{{ $pop->category->nama }} · {{ $pop->dibaca }} dibaca</div>
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
