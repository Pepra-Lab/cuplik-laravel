@extends('layouts.app')

@section('title', 'Pedoman Pemberitaan Media Siber — CuplikCom')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6">
            <span class="badge-cat-red mb-2">Kode Etik</span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                Pedoman Pemberitaan Media Siber
            </h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-6 shadow-sm space-y-4 text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
            <p>
                Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Keberadaan media siber di Indonesia juga merupakan bagian dari kemerdekaan berpendapat, berekspresi, dan pers.
            </p>
            <p>
                Media siber memiliki karakter khusus sehingga memerlukan pedoman agar pengelolaannya dapat dilaksanakan secara profesional, memenuhi fungsi, hak, dan kewajibannya sesuai <strong>Undang-Undang Nomor 40 Tahun 1999 tentang Pers</strong> dan Kode Etik Jurnalistik. Untuk itu Dewan Pers bersama organisasi pers dan masyarakat menyusun Pedoman Pemberitaan Media Siber.
            </p>
            <h3 class="font-bold text-base text-gray-900 dark:text-white mt-4">1. Ruang Lingkup</h3>
            <p>
                Media Siber adalah segala bentuk media yang menggunakan wahana internet dan melaksanakan kegiatan jurnalistik, serta memenuhi persyaratan Undang-Undang Pers dan Standar Perusahaan Pers yang ditetapkan Dewan Pers.
            </p>
            <h3 class="font-bold text-base text-gray-900 dark:text-white mt-4">2. Verifikasi dan Keberimbangan Berita</h3>
            <p>
                Pada prinsipnya setiap berita harus melalui verifikasi. Berita yang dapat merugikan pihak lain memerlukan verifikasi pada berita yang sama untuk memenuhi prinsip akurasi dan keberimbangan.
            </p>
            <h3 class="font-bold text-base text-gray-900 dark:text-white mt-4">3. Ralat, Koreksi, dan Hak Jawab</h3>
            <p>
                Ralat, koreksi, dan hak jawab mengacu pada Undang-Undang Pers, Kode Etik Jurnalistik, dan Pedoman Hak Jawab yang ditetapkan Dewan Pers.
            </p>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-4 space-y-8">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-2 mb-4">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-1">
                        <div class="w-1.5 h-4 bg-[#d60000] rounded-xs"></div>
                        <div class="w-1.5 h-4 bg-[#008a24] rounded-xs"></div>
                    </div>
                    <h3 class="text-sm font-black uppercase tracking-wider text-gray-900 dark:text-white">
                        Berita Terpopuler
                    </h3>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-zinc-800">
                @foreach($popularArticles as $rank => $pop)
                    <div class="py-3 first:pt-0 last:pb-0">
                        <a href="{{ route('article.show', $pop->slug) }}" class="flex gap-3 group">
                            <span class="text-2xl font-black text-gray-300 dark:text-zinc-700 group-hover:{{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} transition-colors leading-none">
                                0{{ $rank + 1 }}
                            </span>
                            <div>
                                <div class="text-[11px] text-gray-400 mb-1">
                                    <span class="font-extrabold {{ $rank % 2 === 0 ? 'text-[#d60000]' : 'text-[#008a24]' }} uppercase">{{ $pop->category->nama ?? 'Berita' }}</span>
                                    <span>·</span>
                                    <span>{{ number_format($pop->dibaca) }} dibaca</span>
                                </div>
                                <h4 class="text-xs font-bold leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-[#d60000] transition-colors">
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
