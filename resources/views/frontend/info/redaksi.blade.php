@extends('layouts.app')

@section('title', 'Susunan Redaksi & Manajemen — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
            <span class="badge-cat mb-2">Informasi Redaksi</span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Susunan Redaksi & Manajemen CuplikCom
            </h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-5 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
            <div>
                <p><strong>PT. Cuplik Media Center (CMC)</strong><br>
                Berdiri sejak 2009 · Legalitas SK Kepmenkumham RI Nomor: <strong>AHU-0039651.AH.01.01.Tahun 2019</strong><br>
                Anggota Resmi <strong>Serikat Media Siber Indonesia (SMSI)</strong></p>
            </div>

            <hr class="border-gray-200 dark:border-zinc-800">

            <div class="space-y-3">
                <p><strong>Pemimpin Redaksi / Penanggung Jawab:</strong> Ali Ma'nawi</p>
                <p><strong>Dewan Redaksi:</strong> Khusni Mubarok, Farhan Maksudi, Dewo, Ade Lukman, Mundirun, Rando Gunter, Anan Felicio</p>
                <p><strong>Reporter / Kontributor:</strong> Baebudin, Daman, Farhan Maksudi, Lina Maulidiyah, Bakrodin, Winanto, Maulana Yusuf Rismawan, Gustiawan, Dalani, Hasan Ayih, Ato Susanto, Karina JM, Haris Afandi, Papoh Gupron, Fitriyah Jewellery Farsi, Ahmad Hanafi</p>
            </div>

            <hr class="border-gray-200 dark:border-zinc-800">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                <div><strong>Biro Indramayu:</strong> Daman, Baebudin, Dulhalil, Adeng Widayah, Marsan, Nurdi, Ato Tolok</div>
                <div><strong>Biro Majalengka:</strong> Sunarto Aryodinoto, Fatkhul Amin</div>
                <div><strong>Biro Cirebon Raya:</strong> Ade Hamdani</div>
                <div><strong>Biro Bandung Raya & Sumedang:</strong> Tb Chep Zulfikar Natanegara</div>
                <div><strong>Biro Jabodetabek:</strong> Ade Lukman, Muhamad Riko Indrianto, Fanny Nurul Hotimah, Deny Sardika, Nabila Ebivalia</div>
                <div><strong>Biro Tegal Raya:</strong> Wurdiyanto</div>
                <div><strong>Biro D.I. Yogyakarta:</strong> Abdan Ghifari Atsqo</div>
                <div><strong>Biro Lampung:</strong> Ismail, M Ali Alnavian, Zul Halim</div>
            </div>

            <hr class="border-gray-200 dark:border-zinc-800">

            <div class="space-y-2 text-xs">
                <p><strong>Penasehat Hukum:</strong> Kantor Hukum Adi Iwan Mulyawan, SH. dan Rekan</p>
                <p><strong>Programmer & Designer:</strong> A Lubis Ghozali, M Ali Fikri</p>
                <p><strong>Iklan & Promosi:</strong> Pudin, Ahmad Hasan A</p>
                <p><strong>Administrasi & Keuangan:</strong> Fitriyani, Desi Amaliani</p>
            </div>

            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 rounded-lg text-xs space-y-1">
                <h4 class="font-bold text-[#008a24] text-sm mb-1">Alamat Kantor Redaksi & Tata Usaha</h4>
                <p>Jl. Samsu No. 42 Kelurahan Margadadi, Kabupaten Indramayu, Jawa Barat 45211</p>
                <p><strong>Telp:</strong> (0234) 7126806 · <strong>WhatsApp:</strong> 087727030115</p>
                <p><strong>Email Redaksi:</strong> cuplikcom@gmail.com | info@cuplik.com</p>
                <p><strong>Situs Web Resmi:</strong> www.cuplik.com | www.cuplik.id</p>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-8">
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
