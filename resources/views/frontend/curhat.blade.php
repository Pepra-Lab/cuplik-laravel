@extends('layouts.app')

@section('title', 'Keluh Kesah & Suara Rakyat — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8 space-y-2">
            <span class="px-2.5 py-1 rounded text-[10px] font-extrabold bg-[#008a24] text-white uppercase inline-block">
                Ruang Suara Publik
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Keluh Kesah Rakyat Pantura
            </h1>
            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">
                Kanal aspirasi warga Indramayu, Cirebon, Majalengka, Kuningan, Subang, dan sekitarnya untuk menyampaikan kendala jalan rusak, irigasi sawah, layanan puskesmas, bansos, dan fasilitas publik secara bebas dan bertanggung jawab.
            </p>
        </div>

        <!-- Submission Form Box -->
        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-4">
            <div class="flex items-center gap-2 border-b border-gray-100 dark:border-zinc-800 pb-3">
                <div class="w-1.5 h-4 bg-[#008a24]"></div>
                <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                    Sampaikan Keluhan &amp; Masukan Anda
                </h3>
            </div>

            @auth
                <form action="{{ route('curhat.store') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block mb-1">Nama / Inisial (Boleh Anonim)</label>
                            <input type="text" name="pengirim" placeholder="mis. Guru Honorer / Petani Anjatan..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-xs text-gray-900 dark:text-white input-search-hover">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block mb-1">Desa / Kecamatan / Kota *</label>
                            <input type="text" name="lokasi" required placeholder="mis. Bongas, Indramayu" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-xs text-gray-900 dark:text-white input-search-hover">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 dark:text-gray-300 block mb-1">Isi Pesan Keluhan &amp; Fakta Lapangan *</label>
                        <textarea name="pesan" rows="4" required placeholder="Ceritakan permasalahan fasilitas publik, jalan rusak, pupuk subsidi, pelayanan birokrasi yang Anda alami..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg p-3 text-xs text-gray-900 dark:text-white input-search-hover leading-relaxed"></textarea>
                    </div>
                    <button type="submit" class="bg-[#008a24] hover:bg-[#006f1c] text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                        Kirimkan Aspirasi Saya
                    </button>
                </form>
            @else
                <div class="text-xs text-gray-600 dark:text-gray-400 flex flex-wrap items-center justify-between gap-3">
                    <span>Masuk atau daftar sebagai Member untuk mengirim curhat.</span>
                    <span class="flex gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg font-bold">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 border border-[#008a24] text-[#008a24] rounded-lg font-bold">Daftar</a>
                    </span>
                </div>
            @endauth
        </div>

        <!-- Curhats Feed -->
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b-2 border-[#008a24] pb-2">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-4 bg-[#008a24]"></div>
                    <h3 class="text-base font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Aspirasi Warga Terpublikasi
                    </h3>
                </div>
                <span class="text-xs font-semibold text-gray-400">Dimoderasi Redaksi</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($curhats as $curhat)
                    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm space-y-3 flex flex-col justify-between">
                        <!-- Message -->
                        <p class="text-xs text-gray-800 dark:text-gray-200 italic leading-relaxed">
                            "{{ $curhat->pesan }}"
                        </p>
                        <!-- Author Metadata with Avatar -->
                        <div class="flex items-center justify-between text-[11px] pt-3 border-t border-gray-100 dark:border-zinc-800">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#008a24] text-white font-bold text-[10px] flex items-center justify-center">
                                    {{ substr($curhat->pengirim, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-900 dark:text-gray-100">
                                    {{ $curhat->pengirim }} <span class="text-[#008a24] font-normal">({{ $curhat->lokasi }})</span>
                                </span>
                            </div>
                            <span class="text-gray-400 font-medium">{{ $curhat->time_ago }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6">
                {{ $curhats->links() }}
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-8">
        
        <!-- Tagar Trending -->
        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 space-y-4 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-4 bg-[#008a24]"></div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Tagar Trending
                    </h3>
                </div>
            </div>
            <div class="space-y-2">
                @foreach($trendingTags as $rank => $tt)
                    <a href="{{ route('tag.show', $tt->slug) }}" class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-zinc-800/80 border border-gray-200/80 dark:border-zinc-700/80 hover:border-[#008a24] transition-colors group">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xs font-black text-[#008a24]">0{{ $rank + 1 }}</span>
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#008a24] transition-colors">#{{ $tt->nama }}</span>
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
                    <div class="w-1.5 h-4 bg-[#008a24]"></div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Berita Terpopuler
                    </h3>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @foreach($popularArticles as $rank => $pop)
                    <article class="py-3 first:pt-0 last:pb-0 flex items-start gap-3.5 group">
                        <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:text-[#008a24] transition-colors leading-none shrink-0 w-7">
                            0{{ $rank + 1 }}
                        </span>
                        <div class="space-y-1 min-w-0">
                            <div class="flex items-center gap-1.5 text-[10px] text-gray-400">
                                <span class="font-extrabold text-[#008a24] uppercase">{{ $pop->category->nama ?? 'Berita' }}</span>
                                <span>·</span>
                                <span>{{ number_format($pop->dibaca) }} dibaca</span>
                            </div>
                            <h4 class="font-bold text-xs leading-snug line-clamp-2 text-gray-900 dark:text-white group-hover:text-[#008a24] transition-colors">
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
