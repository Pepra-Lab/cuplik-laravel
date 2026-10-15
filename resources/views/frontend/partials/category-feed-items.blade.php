@foreach($categories as $cat)
    @php
        $catArticles = $cat->articles;
        $leadArticle = $catArticles->first();
        $subArticles = $catArticles->slice(1, 3);
    @endphp

    @if($catArticles->count() > 0)
        <!-- Category Box Container Group -->
        <section class="space-y-4 category-feed-section" data-category="{{ $cat->slug }}">
            
            <!-- Category Header: Title + Selengkapnya Link with Icon (Space Between) -->
            <div class="flex items-center justify-between border-b-2 border-gray-900 dark:border-zinc-700 pb-2">
                <div class="flex items-center gap-2.5">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-5 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-5 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h2 class="text-lg sm:text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                        {{ $cat->nama }}
                    </h2>
                </div>
                <a href="{{ route('category.show', $cat->slug) }}" class="text-xs font-bold text-[#008a24] hover:text-[#d60000] hover:underline flex items-center gap-1 transition-colors">
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
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-[#d60000] text-white uppercase shadow-xs">
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
                        <h3 class="font-black text-lg sm:text-xl leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#d60000] transition-colors">
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
                <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase bg-[#d60000] text-white inline-block">
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
                    <button type="submit" class="px-5 py-2 bg-[#008a24] hover:bg-[#d60000] text-white text-xs font-bold rounded-lg transition-colors shrink-0">
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
            @if(isset($iklanBetweenCategory) && $iklanBetweenCategory && $iklanBetweenCategory->gambar)
                <a href="{{ $iklanBetweenCategory->link ?: '#' }}" class="block max-w-2xl mx-auto">
                    <img src="{{ asset($iklanBetweenCategory->gambar) }}" alt="{{ $iklanBetweenCategory->judul }}" class="w-full h-auto rounded-lg mx-auto">
                </a>
            @else
                <div class="h-24 sm:h-28 bg-emerald-50 dark:bg-emerald-950/30 border border-dashed border-[#008a24] rounded-lg flex flex-col items-center justify-center p-4">
                    <span class="text-xs font-bold text-[#d60000] uppercase tracking-wider">Slot Iklan Display (728 × 90 px)</span>
                    <span class="text-[11px] text-gray-500 mt-1">Hubungi Redaksi CuplikCom untuk Pemasangan Iklan Sponsor</span>
                </div>
            @endif
        </div>
    @endif

@endforeach
