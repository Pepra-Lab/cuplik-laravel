@extends('layouts.app')

@section('title', 'Polling Pembaca — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
            <span class="badge-cat mb-2">Suara Publik</span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Polling Pendapat Pembaca
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Sampaikan suara dan aspirasi Anda secara anonim untuk isu-isu publik strategis.
            </p>
        </div>

        <!-- Active Poll Card -->
        @if($activePoll)
            <div class="bg-white dark:bg-zinc-900 border-2 border-[#008a24] rounded-xl p-6 shadow-md">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3 mb-4">
                    <span class="bg-[#008a24] text-white px-2.5 py-1 rounded text-xs font-bold uppercase tracking-wider">
                        Sedang Berlangsung
                    </span>
                    <span class="text-xs font-semibold text-gray-500">{{ $activePoll->total_votes }} total suara</span>
                </div>

                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-6 leading-snug">
                    {{ $activePoll->pertanyaan }}
                </h2>

                <form action="{{ route('poll.vote') }}" method="POST" class="space-y-4">
                    @csrf
                    @foreach($activePoll->options as $opt)
                        @php
                            $pct = $activePoll->total_votes > 0 ? round(($opt->suara / $activePoll->total_votes) * 100) : 0;
                        @endphp
                        <label class="block relative border border-gray-200 dark:border-zinc-700 rounded-xl p-4 cursor-pointer hover:border-[#008a24] transition-all">
                            <div class="flex items-center justify-between relative z-10 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="poll_option_id" value="{{ $opt->id }}" required class="text-[#008a24] focus:ring-[#008a24]">
                                    <span>{{ $opt->opsi }}</span>
                                </div>
                                <span class="font-bold text-[#008a24]">{{ $pct }}% <span class="text-xs font-normal text-gray-400">({{ $opt->suara }} suara)</span></span>
                            </div>
                            <div class="absolute inset-y-0 left-0 bg-emerald-100/70 dark:bg-emerald-950/50 rounded-xl pointer-events-none transition-all duration-700" style="width: {{ $pct }}%"></div>
                        </label>
                    @endforeach

                    <button type="submit" class="w-full bg-[#008a24] hover:bg-[#006f1c] text-white py-3 rounded-lg text-sm font-bold uppercase tracking-wider transition-colors mt-4">
                        Kirim Pilihan Saya
                    </button>
                </form>
            </div>
        @endif

        <!-- Past Polls List -->
        @if($pastPolls->isNotEmpty())
            <div class="space-y-4">
                <h3 class="text-base font-bold uppercase tracking-wider text-gray-900 dark:text-white">Arsip Polling Sebelumnya</h3>
                <div class="space-y-4">
                    @foreach($pastPolls as $past)
                        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-3">
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span class="badge-cat-invert">Selesai</span>
                                <span>{{ $past->total_votes }} total suara</span>
                            </div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $past->pertanyaan }}</h4>
                            <div class="space-y-2 pt-2">
                                @foreach($past->options as $pOpt)
                                    @php
                                        $pPct = $past->total_votes > 0 ? round(($pOpt->suara / $past->total_votes) * 100) : 0;
                                    @endphp
                                    <div class="text-xs">
                                        <div class="flex justify-between font-medium mb-1">
                                            <span>{{ $pOpt->opsi }}</span>
                                            <span>{{ $pPct }}% ({{ $pOpt->suara }})</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
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
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5">
            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white border-b-2 border-[#008a24] pb-2 mb-4 flex items-center gap-2">
                Berita Terpopuler
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
@endsection
