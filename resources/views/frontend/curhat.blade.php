@extends('layouts.app')

@section('title', 'Keluh Kesah & Suara Rakyat — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Header -->
        <div class="bg-emerald-50 dark:bg-zinc-900 border border-emerald-200 dark:border-zinc-800 rounded-xl p-6">
            <span class="badge-cat mb-2">Saluran Aspirasi</span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Keluh Kesah Rakyat
            </h1>
            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                Kanal khusus bagi masyarakat Indramayu, Cirebon, Majalengka, Lampung dan sekitarnya untuk menyampaikan unek-unek, keluhan fasilitas publik, dan masukan bagi pemerintah daerah.
            </p>
        </div>

        <!-- Submission Form Box -->
        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-[#008a24]">Sampaikan Keluhan Anda</h3>
            <form action="{{ route('curhat.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Nama / Inisial (opsional)</label>
                        <input type="text" name="pengirim" placeholder="Anonim / Guru PAUD / Nelayan..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Kecamatan / Desa / Kota</label>
                        <input type="text" name="lokasi" placeholder="mis. Bongas, Indramayu" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700 dark:text-gray-300 block mb-1">Isi Pesan Keluhan & Fakta Lapangan *</label>
                    <textarea name="pesan" rows="4" required placeholder="Tuliskan kendala jalan rusak, pelayanan puskesmas, bansos, pupuk subsidi, dll..." class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded px-3 py-2 text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]"></textarea>
                </div>
                <button type="submit" class="bg-[#008a24] hover:bg-[#006f1c] text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-colors">
                    Kirimkan Aspirasi Saya
                </button>
            </form>
        </div>

        <!-- Curhats Feed -->
        <div class="space-y-4">
            <h3 class="text-base font-bold uppercase tracking-wider text-gray-900 dark:text-white">Aspirasi Terpublikasi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($curhats as $curhat)
                    <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-xl p-5 shadow-sm space-y-3 flex flex-col justify-between">
                        <p class="text-xs text-gray-800 dark:text-gray-200 italic leading-relaxed">
                            "{{ $curhat->pesan }}"
                        </p>
                        <div class="flex items-center justify-between text-[11px] text-gray-400 pt-2 border-t border-gray-200/60 dark:border-zinc-800">
                            <span class="font-bold text-gray-900 dark:text-gray-100">
                                {{ $curhat->pengirim }} · <span class="text-[#008a24] font-medium">{{ $curhat->lokasi }}</span>
                            </span>
                            <span>{{ $curhat->time_ago }}</span>
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
@endsection
