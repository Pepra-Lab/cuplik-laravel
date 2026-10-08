@extends('layouts.app')

@section('title', 'Real Count Pilbup Indramayu — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Real Count Header -->
    <div class="bg-zinc-900 text-white rounded-2xl p-6 sm:p-8 border border-zinc-800 shadow-xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="bg-[#008a24] text-white px-2.5 py-1 rounded text-xs font-black uppercase tracking-wider mb-2 inline-block">
                    Live Quick Count & Real Count
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    {{ $currentPilbup?->judul ?: 'Pemilihan Kepala Daerah' }}
                </h1>
                <p class="text-xs text-gray-300 mt-1">
                    Pusat data tabulasi hasil perhitungan suara per TPS, desa, dan kecamatan se-Kabupaten Indramayu.
                </p>
            </div>

            <!-- Pilbup Selector -->
            @if($pilbups->count() > 1)
                <div>
                    <form method="GET" action="{{ route('realcount.index') }}">
                        <select name="pilbup_id" onchange="this.form.submit()" class="bg-zinc-800 border border-zinc-700 text-white text-xs rounded-lg px-3 py-2">
                            @foreach($pilbups as $pb)
                                <option value="{{ $pb->id }}" {{ $currentPilbup?->id == $pb->id ? 'selected' : '' }}>
                                    {{ $pb->judul }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-4 text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total DPT</span>
            <div class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalDpt) }}</div>
        </div>
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-4 text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total TPS</span>
            <div class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($totalTps) }}</div>
        </div>
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-4 text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Suara Sah Masuk</span>
            <div class="text-xl sm:text-2xl font-black text-[#008a24] mt-1">{{ number_format($totalSuaraSah) }}</div>
        </div>
        <div class="bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-4 text-center">
            <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Partisipasi Suara</span>
            <div class="text-xl sm:text-2xl font-black text-blue-600 mt-1">
                {{ $totalDpt > 0 ? number_format(($totalSuaraSah / $totalDpt) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Paslon Results Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($paslons as $paslon)
            @php
                $suara = $paslonTotals[$paslon->id] ?? 0;
                $pct = $totalSuaraSah > 0 ? round(($suara / $totalSuaraSah) * 100, 2) : 0;
            @endphp
            <div class="bg-white dark:bg-zinc-900 border-2 rounded-2xl p-5 shadow-sm space-y-4 relative overflow-hidden" style="border-color: {{ $paslon->warna }}">
                <div class="flex items-center justify-between">
                    <span class="w-8 h-8 rounded-full text-white font-black text-sm flex items-center justify-center shadow" style="background-color: {{ $paslon->warna }}">
                        {{ $paslon->no_urut }}
                    </span>
                    <span class="text-2xl font-black" style="color: {{ $paslon->warna }}">{{ $pct }}%</span>
                </div>

                <div>
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white leading-tight">
                        {{ $paslon->nama }}
                    </h3>
                    @if($paslon->usungan)
                        <p class="text-[11px] text-gray-400 mt-1 leading-snug">{{ $paslon->usungan }}</p>
                    @endif
                </div>

                <div class="space-y-1.5 pt-2 border-t border-gray-100 dark:border-zinc-800">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-gray-500">Perolehan Suara</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ number_format($suara) }}</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-zinc-800 h-2.5 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%; background-color: {{ $paslon->warna }}"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Breakdown per Kecamatan Table -->
    <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-2xl p-6 shadow-sm space-y-4">
        <h3 class="text-base font-black uppercase tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
            Rekapitulasi Perolehan Suara per Kecamatan
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 font-bold border-b border-gray-200 dark:border-zinc-700">
                        <th class="p-3">No</th>
                        <th class="p-3">Kecamatan</th>
                        <th class="p-3 text-center">TPS</th>
                        @foreach($paslons as $p)
                            <th class="p-3 text-right">
                                <span class="inline-block w-2.5 h-2.5 rounded-full mr-1" style="background-color: {{ $p->warna }}"></span>
                                {{ $p->no_urut }}. {{ $p->nama }}
                            </th>
                        @endforeach
                        <th class="p-3 text-right">Total Sah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @foreach($rekapKecamatan as $idx => $r)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="p-3 text-gray-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="p-3 font-bold text-gray-900 dark:text-white">{{ $r['kecamatan'] }}</td>
                            <td class="p-3 text-center font-medium">{{ $r['tps'] }}</td>
                            @foreach($paslons as $p)
                                @php
                                    $pVote = $r['suara_paslon'][$p->id] ?? 0;
                                    $pPct = $r['total_suara'] > 0 ? round(($pVote / $r['total_suara']) * 100, 1) : 0;
                                @endphp
                                <td class="p-3 text-right font-medium">
                                    {{ number_format($pVote) }}
                                    <span class="text-[10px] text-gray-400 ml-1">({{ $pPct }}%)</span>
                                </td>
                            @endforeach
                            <td class="p-3 text-right font-bold text-[#008a24]">{{ number_format($r['total_suara']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
