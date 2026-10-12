@extends('layouts.app')

@section('title', 'Polling Pendapat Pembaca — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8 space-y-2">
            <span class="px-2.5 py-1 rounded text-[10px] font-extrabold bg-[#d60000] text-white uppercase inline-block shadow-xs">
                Suara Publik
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Polling Opini Publik Pantura
            </h1>
            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">
                Ikuti jejak pendapat mengenai isu-isu krusial daerah, kebijakan publik, dan aspirasi masyarakat secara anonim dan transparan.
            </p>
        </div>

        <!-- Active Poll Card -->
        @if($activePoll)
            <div class="bg-white dark:bg-zinc-900 border-2 border-[#008a24] rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3 mb-4">
                    <span class="bg-[#d60000] text-white px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider shadow-xs">
                        Sedang Berlangsung
                    </span>
                    <span class="text-xs font-bold text-gray-500">{{ number_format($activePoll->total_votes) }} total suara</span>
                </div>

                <h2 class="text-base sm:text-lg font-black text-gray-900 dark:text-white mb-6 leading-snug">
                    {{ $activePoll->pertanyaan }}
                </h2>

                <form action="{{ route('poll.vote') }}" method="POST" class="space-y-3.5">
                    @csrf
                    @foreach($activePoll->options as $opt)
                        @php
                            $pct = $activePoll->total_votes > 0 ? round(($opt->suara / $activePoll->total_votes) * 100) : 0;
                        @endphp
                        <label class="block relative border border-gray-200 dark:border-zinc-700 rounded-xl p-4 cursor-pointer hover:border-[#008a24] transition-all">
                            <div class="flex items-center justify-between relative z-10 text-xs sm:text-sm font-bold text-gray-900 dark:text-gray-100">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="poll_option_id" value="{{ $opt->id }}" required class="text-[#008a24] focus:ring-[#008a24]">
                                    <span>{{ $opt->opsi }}</span>
                                </div>
                                <span class="font-extrabold text-[#008a24]">{{ $pct }}% <span class="text-[11px] font-normal text-gray-400">({{ $opt->suara }})</span></span>
                            </div>
                            <div class="absolute inset-y-0 left-0 bg-emerald-100/70 dark:bg-emerald-950/50 rounded-xl pointer-events-none transition-all duration-700" style="width: {{ $pct }}%"></div>
                        </label>
                    @endforeach

                    <button type="submit" class="w-full bg-[#008a24] hover:bg-[#d60000] text-white py-3 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors mt-4 shadow-sm">
                        Kirim Pilihan Saya
                    </button>
                </form>
            </div>
        @endif

        <!-- Past Polls List -->
        @if($pastPolls->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b-2 border-gray-900 dark:border-zinc-700 pb-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-base font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Arsip Polling Sebelumnya
                    </h3>
                </div>
                <div class="space-y-4">
                    @foreach($pastPolls as $past)
                        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3 shadow-sm">
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span class="px-2 py-0.5 rounded bg-gray-200 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 text-[10px] font-bold uppercase">Selesai</span>
                                <span class="font-medium">{{ number_format($past->total_votes) }} total suara</span>
                            </div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $past->pertanyaan }}</h4>
                            <div class="space-y-2 pt-2">
                                @foreach($past->options as $pOpt)
                                    @php
                                        $pPct = $past->total_votes > 0 ? round(($pOpt->suara / $past->total_votes) * 100) : 0;
                                    @endphp
                                    <div class="text-xs">
                                        <div class="flex justify-between font-semibold mb-1">
                                            <span>{{ $pOpt->opsi }}</span>
                                            <span>{{ $pPct }}% ({{ $pOpt->suara }})</span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                            <div class="bg-gray-500 h-full rounded-full" style="width: {{ $pPct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $pastPolls->links() }}
            </div>
        @endif

    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-8">
        
        <!-- Tagar Trending -->
        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Tagar Trending
                    </h3>
                </div>
            </div>
            <div class="space-y-2">
                @foreach($trendingTags as $rank => $tt)
                    <a href="{{ route('tag.show', $tt->slug) }}" class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-zinc-800/80 border border-gray-200/80 dark:border-zinc-700/80 hover:border-[#d60000] dark:hover:border-[#d60000] transition-colors group">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xs font-black {{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }}">0{{ $rank + 1 }}</span>
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#d60000] transition-colors">#{{ $tt->nama }}</span>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $tt->articles_count }} berita</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Berita Terpopuler -->
        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Paling Banyak Dibaca
                    </h3>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @foreach($popularArticles as $rank => $pop)
                    <article class="py-3 first:pt-0 last:pb-0 flex items-start gap-3.5 group">
                        <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:{{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} transition-colors leading-none shrink-0 w-7">
                            0{{ $rank + 1 }}
                        </span>
                        <div class="space-y-1 min-w-0">
                            <div class="flex items-center gap-1.5 text-[10px] text-gray-400">
                                <span class="font-extrabold {{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} uppercase">{{ $pop->category->nama ?? 'Berita' }}</span>
                                <span>·</span>
                                <span>{{ number_format($pop->dibaca) }} dibaca</span>
                            </div>
                            <h4 class="font-bold text-xs leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#d60000] transition-colors">
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
@endsection
