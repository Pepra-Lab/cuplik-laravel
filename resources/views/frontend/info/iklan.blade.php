@extends('layouts.app')

@section('title', 'Info Pemasangan Iklan & Advertorial — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
            <span class="badge-cat mb-2">Kerjasama Media</span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Info Pemasangan Iklan & Advertorial
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Jangkau ratusan ribu pembaca loyal, pengambil kebijakan, dan pelaku usaha di seluruh Indonesia.
            </p>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-6 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
            <p>
                CuplikCom (PT Cuplik Media Center) melayani kemitraan strategis periklanan digital, advertorial institusi pemerintah/swasta, publikasi siaran pers (press release), dan pemasangan banner promosi dengan penempatan strategis berkinerja tinggi.
            </p>

            <h3 class="font-extrabold text-base text-[#008a24] uppercase tracking-wide">
                Tarif Publikasi Artikel & Banner
            </h3>

            <div class="overflow-x-auto border border-gray-200 dark:border-zinc-700 rounded-lg">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 font-bold border-b border-gray-200 dark:border-zinc-700">
                        <tr>
                            <th class="p-3">Jenis Publikasi</th>
                            <th class="p-3">Penempatan / Posisi</th>
                            <th class="p-3">Periode</th>
                            <th class="p-3 text-right">Tarif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        <tr>
                            <td class="p-3 font-bold">Headline Utama Hero</td>
                            <td class="p-3">Banner Slider Beranda</td>
                            <td class="p-3">Per Bulan</td>
                            <td class="p-3 text-right font-bold text-[#008a24]">Rp 2.500.000</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold">Banner Header 728×90</td>
                            <td class="p-3">Semua Halaman (Header)</td>
                            <td class="p-3">Per Bulan</td>
                            <td class="p-3 text-right font-bold text-[#008a24]">Rp 2.000.000</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold">Banner Sidebar 300×250</td>
                            <td class="p-3">Kolom Kanan Beranda & Artikel</td>
                            <td class="p-3">Per Bulan</td>
                            <td class="p-3 text-right font-bold text-[#008a24]">Rp 1.500.000</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold">Advertorial / Rilis Pers</td>
                            <td class="p-3">Kanal Kategori & Terindeks Google</td>
                            <td class="p-3">Selamanya (Tayang)</td>
                            <td class="p-3 text-right font-bold text-[#008a24]">Rp 1.000.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-5 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-xl space-y-2">
                <h4 class="font-bold text-[#008a24] text-sm">Kontak Hotline Pemasaran & Pengiriman Materi:</h4>
                <p class="text-xs"><strong>WhatsApp / Hotline:</strong> 087727030115 (Bagian Iklan & Kerjasama)</p>
                <p class="text-xs"><strong>Email:</strong> cuplikcom@gmail.com / iklan@cuplik.com</p>
                <p class="text-xs text-gray-500">Kantor Redaksi: Jl. Samsu No. 42 Kelurahan Margadadi, Kabupaten Indramayu 45211</p>
            </div>
        </div>
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
