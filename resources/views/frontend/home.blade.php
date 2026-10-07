@extends('layouts.app')

@section('title', 'CuplikCom — Beritanya Unik dan Menggelitik')

@section('content')
<div class="space-y-10">

    <!-- Top Advertisement Banner (if active) -->
    @if($iklanHeader)
        <div class="w-full flex justify-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 p-2 rounded-lg">
            <a href="{{ $iklanHeader->link ?: '#' }}" class="block max-w-[728px] w-full text-center">
                @if($iklanHeader->gambar)
                    <img src="{{ $iklanHeader->gambar }}" alt="{{ $iklanHeader->judul }}" class="w-full h-auto rounded">
                @else
                    <div class="h-24 bg-emerald-50 dark:bg-emerald-950/40 border border-dashed border-[#008a24] rounded flex flex-col items-center justify-center p-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#008a24]">Ruang Iklan Banner Header</span>
                        <span class="text-xs text-gray-500">{{ $iklanHeader->judul }} · 728×90 px</span>
                    </div>
                @endif
            </a>
        </div>
    @endif

    <!-- Hero Headline & Carousel Banner -->
    @if($banners->isNotEmpty())
        <section class="relative overflow-hidden rounded-xl bg-zinc-900 text-white shadow-lg">
            <div id="heroSlider" class="relative min-h-[320px] md:min-h-[420px] flex items-end p-6 md:p-10">
                @foreach($banners as $index => $banner)
                    <div class="banner-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-index="{{ $index }}">
                        <!-- Background Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent z-10"></div>
                        @if($banner->gambar)
                            <img src="{{ $banner->gambar }}" alt="{{ $banner->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#0e1711] flex items-center justify-center">
                                <span class="text-9xl font-black text-white/5 uppercase select-none">CUPLIK</span>
                            </div>
                        @endif

                        <!-- Slide Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 z-20 max-w-3xl">
                            <span class="badge-cat mb-2">Headline Utama</span>
                            <h2 class="text-2xl md:text-4xl font-extrabold leading-tight text-white mb-3 hover:text-green-300 transition-colors">
                                <a href="{{ $banner->tautan ?: '#' }}">{{ $banner->judul }}</a>
                            </h2>
                            <div class="flex items-center gap-3 text-xs text-gray-300">
                                <span>Redaksi Cuplik</span>
                                <span>·</span>
                                <span>Update Terkini</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Slider Controls -->
                <div class="absolute bottom-6 right-6 z-30 flex items-center gap-2">
                    <button id="prevSlide" class="w-9 h-9 rounded-full bg-black/60 hover:bg-[#008a24] text-white flex items-center justify-center transition-colors">
                        &#10094;
                    </button>
                    <button id="nextSlide" class="w-9 h-9 rounded-full bg-black/60 hover:bg-[#008a24] text-white flex items-center justify-center transition-colors">
                        &#10095;
                    </button>
                </div>
            </div>
        </section>
    @endif

    <!-- Main Grid: News Feeds + Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left 8 Cols: Main Feeds & Category Sections -->
        <div class="lg:col-span-8 space-y-10">

            <!-- Berita Terkini (Card 1 & Card 2 Section) -->
            <section>
                <div class="flex items-center justify-between border-b-2 border-[#008a24] pb-2 mb-6">
                    <h2 class="text-xl font-black uppercase tracking-tight flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-[#008a24]"></span>
                        Berita Terkini
                    </h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Update 24 Jam Nonstop</span>
                </div>

                <!-- Featured Grid (1 Big Card + 3 Horizontal Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Left: Card 1 (Vertical Large) -->
                    @if($headlineMain)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <a href="{{ route('article.show', $headlineMain->slug) }}" class="group block">
                                <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $headlineMain->tone }}] dark:bg-zinc-800 mb-3">
                                    @if($headlineMain->foto)
                                        <img src="{{ $headlineMain->foto }}" alt="{{ $headlineMain->judul }}" loading="lazy">
                                    @endif
                                    <div class="th-art">{{ substr($headlineMain->category->nama ?? 'C', 0, 1) }}</div>
                                </div>
                                <div class="flex items-center justify-between text-xs mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="badge-cat">{{ $headlineMain->category->nama ?? 'Umum' }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $headlineMain->formatted_date }}</span>
                                    </div>
                                    <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $headlineMain->time_ago }}</span>
                                </div>
                                <h3 class="font-bold text-lg leading-snug line-clamp-2 group-hover:text-[#008a24] transition-colors mb-2">
                                    {{ $headlineMain->judul }}
                                </h3>
                                @if($headlineMain->lead)
                                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                        {{ $headlineMain->lead }}
                                    </p>
                                @endif
                            </a>
                        </div>
                    @endif

                    <!-- Right: Card 2 (List of Horizontal Cards) -->
                    <div class="space-y-4 flex flex-col justify-between">
                        @foreach($headlineSub->take(3) as $subArt)
                            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-3 hover:shadow-sm transition-shadow">
                                <a href="{{ route('article.show', $subArt->slug) }}" class="grid grid-cols-[100px_1fr] sm:grid-cols-[120px_1fr] gap-3 items-center group">
                                    <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $subArt->tone }}] dark:bg-zinc-800">
                                        @if($subArt->foto)
                                            <img src="{{ $subArt->foto }}" alt="{{ $subArt->judul }}" loading="lazy">
                                        @endif
                                        <div class="th-art text-lg">{{ substr($subArt->category->nama ?? 'C', 0, 1) }}</div>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between text-[11px] mb-1">
                                            <span class="badge-cat">{{ $subArt->category->nama ?? 'Umum' }}</span>
                                            <span class="text-gray-400 dark:text-gray-500">{{ $subArt->time_ago }}</span>
                                        </div>
                                        <h4 class="font-bold text-sm leading-snug line-clamp-2 group-hover:text-[#008a24] transition-colors">
                                            {{ $subArt->judul }}
                                        </h4>
                                        <div class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $subArt->formatted_date }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Categorized News Sections -->
            @foreach($categories->take(4) as $catSection)
                @if($catSection->articles->isNotEmpty())
                    <section>
                        <div class="flex items-center justify-between border-b-2 border-gray-200 dark:border-zinc-800 pb-2 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-sm bg-[#008a24]"></span>
                                <h3 class="text-lg font-bold uppercase tracking-tight text-gray-900 dark:text-white">{{ $catSection->nama }}</h3>
                            </div>
                            <a href="{{ route('category.show', $catSection->slug) }}" class="text-xs text-[#008a24] hover:underline font-semibold flex items-center gap-1">
                                Lihat Semua &rarr;
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($catSection->articles as $art)
                                <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-lg p-3.5 hover:border-[#008a24] transition-colors">
                                    <a href="{{ route('article.show', $art->slug) }}" class="group block">
                                        <div class="img-zoom-wrap aspect-[16/10] bg-[{{ $art->tone }}] dark:bg-zinc-800 mb-2.5">
                                            @if($art->foto)
                                                <img src="{{ $art->foto }}" alt="{{ $art->judul }}" loading="lazy">
                                            @endif
                                            <div class="th-art text-xl">{{ substr($catSection->nama, 0, 1) }}</div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                                            <span>{{ $art->formatted_date }}</span>
                                            <span>{{ $art->time_ago }}</span>
                                        </div>
                                        <h4 class="font-bold text-sm leading-snug line-clamp-2 group-hover:text-[#008a24] transition-colors">
                                            {{ $art->judul }}
                                        </h4>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach

            <!-- Video Galeri Section -->
            @if($videos->isNotEmpty())
                <section class="bg-zinc-950 text-white rounded-xl p-6 border border-zinc-800">
                    <div class="flex items-center justify-between border-b border-zinc-800 pb-3 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-600 animate-pulse"></span>
                            <h3 class="text-lg font-black uppercase tracking-wider text-white">Video Pilihan Redaksi</h3>
                        </div>
                        <a href="{{ route('video.index') }}" class="text-xs text-red-400 hover:text-red-300 font-semibold">Semua Video &rarr;</a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($videos as $vid)
                            <a href="{{ route('video.show', $vid->slug) }}" class="group block space-y-2">
                                <div class="relative aspect-video bg-zinc-800 rounded-lg overflow-hidden border border-zinc-700">
                                    @if($vid->youtube_id)
                                        <img src="https://img.youtube.com/vi/{{ $vid->youtube_id }}/mqdefault.jpg" alt="{{ $vid->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @endif
                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                                        <div class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center text-xs pl-0.5 shadow-md group-hover:scale-110 transition-transform">
                                            ▶
                                        </div>
                                    </div>
                                    @if($vid->durasi)
                                        <span class="absolute bottom-1 right-1 bg-black/80 text-[10px] text-white px-1.5 py-0.5 rounded font-mono">{{ $vid->durasi }}</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-bold leading-snug line-clamp-2 text-gray-200 group-hover:text-red-400 transition-colors">
                                    {{ $vid->judul }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Curhat Rakyat / Keluh Kesah Section -->
            <section class="bg-emerald-50/50 dark:bg-zinc-900/60 border border-emerald-100 dark:border-zinc-800 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="badge-cat mb-1">Ruang Publik</span>
                        <h3 class="text-lg font-black tracking-tight text-gray-900 dark:text-white">Keluh Kesah Rakyat</h3>
                    </div>
                    <a href="{{ route('curhat.index') }}" class="text-xs text-[#008a24] font-bold hover:underline">Semua Aspirasi &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($curhats->take(4) as $curhat)
                        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg p-4 shadow-sm space-y-2">
                            <p class="text-xs text-gray-700 dark:text-gray-300 italic leading-relaxed">
                                "{{ $curhat->pesan }}"
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-gray-400 dark:text-gray-500 pt-2 border-t border-gray-100 dark:border-zinc-800">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $curhat->pengirim }} · {{ $curhat->lokasi }}</span>
                                <span>{{ $curhat->time_ago }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Quick Curhat Form -->
                <form action="{{ route('curhat.store') }}" method="POST" class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-lg p-4">
                    @csrf
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#008a24] mb-2">Punya Aspirasi atau Keluhan di Daerah Anda?</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                        <input type="text" name="pengirim" placeholder="Nama / Inisial (mis. Warga Karangsong)" class="bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-1.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        <input type="text" name="lokasi" placeholder="Lokasi (mis. Indramayu / Cirebon)" class="bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-1.5 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>
                    <textarea name="pesan" rows="2" required placeholder="Tuliskan keluhan infrastruktur, pelayanan publik, atau aspirasi Anda..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24] mb-3"></textarea>
                    <button type="submit" class="bg-[#008a24] hover:bg-[#006f1c] text-white px-4 py-1.5 rounded text-xs font-bold transition-colors">
                        Kirim Aspirasi Saya
                    </button>
                </form>
            </section>

        </div>

        <!-- Right 4 Cols: Sidebar Widgets -->
        <div class="lg:col-span-4 space-y-8">

            <!-- Trending Topics / Tags -->
            <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5">
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4 flex items-center gap-2">
                    <span>🔥</span> Topik Hangat
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($trendingTags as $tt)
                        <a href="{{ route('tag.show', $tt->slug) }}" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700/80 hover:border-[#008a24] text-xs px-3 py-1.5 rounded-full text-gray-700 dark:text-gray-300 font-medium transition-colors">
                            #{{ $tt->nama }}
                            <span class="text-[10px] text-gray-400">({{ $tt->articles_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Polling Widget -->
            @if($activePoll)
                <div class="bg-white dark:bg-zinc-900 border border-emerald-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3 border-b border-gray-100 dark:border-zinc-800 pb-2">
                        <span class="badge-cat">Polling Mingguan</span>
                        <span class="text-[10px] text-gray-400">{{ $activePoll->total_votes }} Suara Masuk</span>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 leading-snug">
                        {{ $activePoll->pertanyaan }}
                    </h4>

                    <form id="pollForm" action="{{ route('poll.vote') }}" method="POST" class="space-y-3">
                        @csrf
                        @foreach($activePoll->options as $opt)
                            @php
                                $percent = $activePoll->total_votes > 0 ? round(($opt->suara / $activePoll->total_votes) * 100) : 0;
                            @endphp
                            <label class="block relative border border-gray-200 dark:border-zinc-700 rounded-lg p-3 cursor-pointer hover:border-[#008a24] transition-colors">
                                <div class="flex items-center gap-2 relative z-10 text-xs font-semibold text-gray-800 dark:text-gray-200">
                                    <input type="radio" name="poll_option_id" value="{{ $opt->id }}" required class="text-[#008a24] focus:ring-[#008a24]">
                                    <span>{{ $opt->opsi }}</span>
                                    <span class="ml-auto text-[11px] text-gray-500 dark:text-gray-400">{{ $percent }}% ({{ $opt->suara }})</span>
                                </div>
                                <div class="absolute top-0 bottom-0 left-0 bg-emerald-100/60 dark:bg-emerald-950/40 rounded-lg pointer-events-none transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </label>
                        @endforeach
                        <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-2 rounded text-xs font-bold uppercase tracking-wider transition-colors mt-2">
                            Kirim Pilihan Saya
                        </button>
                    </form>
                </div>
            @endif

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

            <!-- Berita Terpopuler (Ranked 1 - 5) -->
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

            <!-- Iklan Baris Widget -->
            @if($iklanBaris->isNotEmpty())
                <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2 mb-3">
                        <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 dark:text-white">Iklan Baris Rakyat</h3>
                        <span class="text-[10px] text-gray-400">Jual Beli · Properti · Jasa</span>
                    </div>
                    <div class="space-y-3">
                        @foreach($iklanBaris->take(3) as $ib)
                            <div class="bg-gray-50 dark:bg-zinc-800/60 p-2.5 rounded border border-gray-100 dark:border-zinc-800 text-xs">
                                <div class="flex items-center justify-between text-[10px] font-bold text-[#008a24] mb-1">
                                    <span>[{{ $ib->kategori }}] {{ $ib->pemasang }}</span>
                                    <span class="text-gray-400 font-normal">{{ $ib->formatted_date }}</span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-snug">{{ $ib->isi }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Hero Banner Auto-slide (every 8 seconds)
    const slides = document.querySelectorAll('.banner-slide');
    let currentSlide = 0;
    const totalSlides = slides.length;

    const showSlide = (n) => {
        slides.forEach((s, idx) => {
            if (idx === n) {
                s.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                s.classList.add('opacity-100', 'z-10');
            } else {
                s.classList.remove('opacity-100', 'z-10');
                s.classList.add('opacity-0', 'z-0', 'pointer-events-none');
            }
        });
        currentSlide = n;
    };

    if (totalSlides > 1) {
        document.getElementById('nextSlide')?.addEventListener('click', () => {
            showSlide((currentSlide + 1) % totalSlides);
        });

        document.getElementById('prevSlide')?.addEventListener('click', () => {
            showSlide((currentSlide - 1 + totalSlides) % totalSlides);
        });

        setInterval(() => {
            showSlide((currentSlide + 1) % totalSlides);
        }, 8000);
    }
</script>
@endpush
