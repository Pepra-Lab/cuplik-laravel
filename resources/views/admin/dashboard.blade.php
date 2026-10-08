@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Berita -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Total Berita</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalBerita) }}</h3>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="text-[11px] font-semibold text-[#008a24] hover:underline mt-2 inline-block">Kelola Berita &rarr;</a>
        </div>

        <!-- Total Pembaca -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Total Pembaca</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalDibaca) }}</h3>
            </div>
            <span class="text-[11px] text-gray-400 mt-2 inline-block">Akumulasi Hits</span>
        </div>

        <!-- Total Video -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Video Cuplik</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalVideo) }}</h3>
            </div>
            <a href="{{ route('admin.videos.index') }}" class="text-[11px] font-semibold text-[#008a24] hover:underline mt-2 inline-block">Lihat Video &rarr;</a>
        </div>

        <!-- Curhat Masuk -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Curhat Baru</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalCurhat) }}</h3>
            </div>
            <a href="{{ route('admin.curhats.index', ['status' => 'Baru']) }}" class="text-[11px] font-semibold text-amber-600 hover:underline mt-2 inline-block">Moderasi Pesan &rarr;</a>
        </div>

        <!-- Iklan Baris -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Iklan Baris</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalIklan) }}</h3>
            </div>
            <a href="{{ route('admin.iklan-baris.index') }}" class="text-[11px] font-semibold text-[#008a24] hover:underline mt-2 inline-block">Kelola Iklan &rarr;</a>
        </div>
    </div>

    <!-- Productivity Matrix Header & Filter -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 dark:border-zinc-800 pb-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-900 dark:text-white">Matriks Produktivitas Redaksi</h2>
                <p class="text-xs text-gray-400">Monitoring rekapitulasi output berita oleh tim editor dan jurnalis/penulis</p>
            </div>
            
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <select name="month" class="text-xs font-semibold px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <select name="year" class="text-xs font-semibold px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="px-3 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <!-- Editor Productivity -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#008a24]"></span>
                        Kinerja Editor
                    </h3>
                    <span class="text-[10px] text-gray-400">Bulan: {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}</span>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-zinc-800">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-100 dark:border-zinc-800">
                            <tr>
                                <th class="px-3 py-2.5">Nama Editor</th>
                                <th class="px-3 py-2.5">Peran</th>
                                <th class="px-3 py-2.5 text-center">Hari Ini</th>
                                <th class="px-3 py-2.5 text-center">Bulan Ini</th>
                                <th class="px-3 py-2.5 text-center">Tahun Ini</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($editorStats as $ed)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-3 py-2 font-bold text-gray-900 dark:text-white">{{ $ed['nama'] }}</td>
                                    <td class="px-3 py-2 text-gray-400">{{ $ed['peran'] }}</td>
                                    <td class="px-3 py-2 text-center font-bold text-[#008a24]">{{ $ed['harian'] }}</td>
                                    <td class="px-3 py-2 text-center font-bold text-gray-800 dark:text-gray-200">{{ $ed['bulanan'] }}</td>
                                    <td class="px-3 py-2 text-center font-semibold text-gray-500">{{ $ed['tahunan'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-center text-gray-400">Belum ada data editor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Penulis / Reporter Productivity -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        Kinerja Penulis & Reporter
                    </h3>
                    <span class="text-[10px] text-gray-400">Bulan: {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }} {{ $year }}</span>
                </div>
                <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-zinc-800">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-100 dark:border-zinc-800">
                            <tr>
                                <th class="px-3 py-2.5">Nama Penulis</th>
                                <th class="px-3 py-2.5">Peran</th>
                                <th class="px-3 py-2.5 text-center">Hari Ini</th>
                                <th class="px-3 py-2.5 text-center">Bulan Ini</th>
                                <th class="px-3 py-2.5 text-center">Tahun Ini</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($writerStats as $wr)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-3 py-2 font-bold text-gray-900 dark:text-white">{{ $wr['nama'] }}</td>
                                    <td class="px-3 py-2 text-gray-400">{{ $wr['peran'] }}</td>
                                    <td class="px-3 py-2 text-center font-bold text-blue-600">{{ $wr['harian'] }}</td>
                                    <td class="px-3 py-2 text-center font-bold text-gray-800 dark:text-gray-200">{{ $wr['bulanan'] }}</td>
                                    <td class="px-3 py-2 text-center font-semibold text-gray-500">{{ $wr['tahunan'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-4 text-center text-gray-400">Belum ada data penulis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Articles & Popular Articles Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Berita Terbaru -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Berita Terbaru Masuk</h3>
                <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-[#008a24] hover:underline">Semua Berita &rarr;</a>
            </div>
            <div class="space-y-3">
                @forelse($recentArticles as $art)
                    <div class="flex items-start justify-between gap-3 p-3 rounded-lg bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800/80">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-[#008a24]">
                                    {{ $art->category->nama ?? 'Umum' }}
                                </span>
                                <span class="text-[10px] text-gray-400">{{ $art->tanggal ? $art->tanggal->format('d M Y H:i') : '-' }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-1 hover:text-[#008a24] transition-colors">
                                <a href="{{ route('admin.articles.edit', $art) }}">{{ $art->judul }}</a>
                            </h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Penulis: {{ $art->penulis_nama ?? '-' }} · Editor: {{ $art->editor_nama ?? '-' }}</p>
                        </div>
                        <a href="{{ route('admin.articles.edit', $art) }}" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-white dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700 shrink-0">
                            Edit
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

        <!-- Berita Terpopuler -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Berita Paling Banyak Dibaca</h3>
                <span class="text-xs text-gray-400">Top 5 Hits</span>
            </div>
            <div class="space-y-3">
                @forelse($popularArticles as $art)
                    <div class="flex items-start justify-between gap-3 p-3 rounded-lg bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800/80">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950 text-blue-600">
                                    {{ $art->category->nama ?? 'Umum' }}
                                </span>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($art->dibaca) }} views</span>
                            </div>
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white line-clamp-1 hover:text-[#008a24] transition-colors">
                                <a href="{{ route('article.show', $art->slug) }}" target="_blank">{{ $art->judul }}</a>
                            </h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Penulis: {{ $art->penulis_nama ?? '-' }} · {{ $art->tanggal ? $art->tanggal->format('d M Y') : '-' }}</p>
                        </div>
                        <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-blue-600 bg-white dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700 shrink-0">
                            Lihat
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada statistik pembaca.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
