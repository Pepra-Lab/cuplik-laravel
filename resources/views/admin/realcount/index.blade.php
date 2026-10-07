@extends('layouts.admin')

@section('title', 'Real Count Pilbup')

@section('content')
<div class="space-y-6">

    <!-- Header & Selection -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-extrabold text-gray-900 dark:text-white">{{ $currentPilbup->nama ?? 'Real Count Pilbup Indramayu' }}</h2>
            <p class="text-xs text-gray-400">Pusat Tabulasi dan Rekapitulasi Suara Pilkada CuplikCom</p>
        </div>

        <div class="flex items-center gap-3">
            @if($pilbups->count() > 1)
                <form method="GET" action="{{ route('admin.realcount.index') }}" class="flex items-center gap-2">
                    <select name="pilbup_id" onchange="this.form.submit()" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 font-bold focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                        @foreach($pilbups as $pb)
                            <option value="{{ $pb->id }}" {{ $currentPilbup && $currentPilbup->id == $pb->id ? 'selected' : '' }}>{{ $pb->nama }} ({{ $pb->tahun }})</option>
                        @endforeach
                    </select>
                </form>
            @endif

            <a href="{{ route('realcount.index') }}" target="_blank" class="px-3 py-2 bg-emerald-50 dark:bg-emerald-950 text-[#008a24] hover:bg-emerald-100 rounded-lg text-xs font-bold transition-colors flex items-center gap-1 shrink-0">
                Lihat Real Count Publik &rarr;
            </a>
        </div>
    </div>

    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#121914] p-4 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total TPS Terdata</span>
            <h4 class="text-xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalTps) }} TPS</h4>
            <span class="text-[10px] text-gray-400">Tersebar di {{ $dpts->count() }} Desa / Kelurahan</span>
        </div>

        <div class="bg-white dark:bg-[#121914] p-4 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total DPT Terdaftar</span>
            <h4 class="text-xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalDpt) }}</h4>
            <span class="text-[10px] text-gray-400">Daftar Pemilih Tetap</span>
        </div>

        <div class="bg-white dark:bg-[#121914] p-4 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Suara Sah Masuk</span>
            <h4 class="text-xl font-black text-[#008a24] mt-1">{{ number_format($totalSuaraSah) }} Suara</h4>
            @php
                $partisipasi = $totalDpt > 0 ? round(($totalSuaraSah / $totalDpt) * 100, 2) : 0;
            @endphp
            <span class="text-[10px] text-emerald-600 font-bold">Partisipasi: {{ $partisipasi }}%</span>
        </div>

        <div class="bg-white dark:bg-[#121914] p-4 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Pasangan Calon</span>
            <h4 class="text-xl font-black text-gray-900 dark:text-white mt-1">{{ $paslons->count() }} Paslon</h4>
            <span class="text-[10px] text-gray-400">Kontestan Pilbup</span>
        </div>
    </div>

    <!-- Paslon Cards & Tabulation Standings -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($paslons as $paslon)
            @php
                $suaraPaslon = $paslonTotals[$paslon->id] ?? 0;
                $persen = $totalSuaraSah > 0 ? round(($suaraPaslon / $totalSuaraSah) * 100, 2) : 0;
            @endphp
            <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between relative overflow-hidden" style="border-top: 4px solid {{ $paslon->warna ?: '#008a24' }}">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-8 h-8 rounded-full bg-gray-900 text-white font-black text-sm flex items-center justify-center">
                            {{ $paslon->no_urut }}
                        </span>
                        <span class="text-lg font-black" style="color: {{ $paslon->warna ?: '#008a24' }}">{{ $persen }}%</span>
                    </div>

                    <h3 class="text-sm font-black text-gray-900 dark:text-white leading-tight">{{ $paslon->nama_paslon }}</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">Koalisi: {{ $paslon->partai_pengusung ?: '-' }}</p>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                    <span class="text-gray-400">Total Suara:</span>
                    <strong class="text-gray-900 dark:text-white text-sm">{{ number_format($suaraPaslon) }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Per-TPS / Per-Desa Vote Entry & Audit Table -->
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Tabulasi Perolehan Suara per Wilayah (TPS/Desa)</h3>
                <p class="text-xs text-gray-400">Perbarui perolehan suara paslon secara langsung pada kolom suara</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Kecamatan</th>
                        <th class="px-4 py-3">Desa / Kelurahan</th>
                        <th class="px-4 py-3 text-center">TPS</th>
                        <th class="px-4 py-3 text-center">DPT</th>
                        @foreach($paslons as $p)
                            <th class="px-4 py-3 text-center" style="color: {{ $p->warna ?: '#008a24' }}">
                                No. {{ $p->no_urut }} ({{ Str::limit($p->nama_paslon, 15) }})
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($dpts as $idx => $d)
                        @php
                            $dVotes = $suaras->get($d->id, collect());
                        @endphp
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3 text-center text-gray-400">{{ $idx + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $d->kecamatan }}</td>
                            <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">{{ $d->desa }}</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-500">{{ $d->tps }}</td>
                            <td class="px-4 py-3 text-center font-bold text-gray-800 dark:text-gray-200">{{ number_format($d->dpt) }}</td>
                            
                            @foreach($paslons as $p)
                                @php
                                    $pVote = $dVotes->firstWhere('paslon_id', $p->id);
                                    $val = $pVote ? $pVote->suara : 0;
                                @endphp
                                <td class="px-4 py-2 text-center">
                                    <form action="{{ route('admin.realcount.updateSuara') }}" method="POST" class="inline-flex items-center gap-1">
                                        @csrf
                                        <input type="hidden" name="dpt_id" value="{{ $d->id }}">
                                        <input type="hidden" name="paslon_id" value="{{ $p->id }}">
                                        <input type="number" name="suara" value="{{ $val }}" min="0" class="w-20 px-2 py-1 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded text-center text-xs font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                                        <button type="submit" class="p-1 bg-[#008a24] hover:bg-[#006f1c] text-white rounded text-[10px]" title="Simpan Suara">
                                            ✓
                                        </button>
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 5 + $paslons->count() }}" class="px-4 py-8 text-center text-gray-400">
                                Belum ada data DPT/Wilayah pada Pilbup ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
