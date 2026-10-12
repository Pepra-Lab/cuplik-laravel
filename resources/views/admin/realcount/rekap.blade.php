@extends('layouts.admin')

@section('title', 'Rekapitulasi — Real Count')

@section('content')
<div class="space-y-5">

    <div class="no-print">
        @include('admin.realcount._header')
    </div>

    @if(!$pilbup)
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Belum ada data pemilihan. Buat dulu di tab <strong>Pengaturan Pemilihan</strong>.
        </div>
    @elseif($paslons->isEmpty())
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Tambahkan pasangan calon dan data wilayah terlebih dahulu untuk melihat rekapitulasi.
        </div>
    @else
        @php
            $persenMasuk = $totalTps > 0 ? round(($tpsMasuk / $totalTps) * 100, 1) : 0;
        @endphp

        <div class="flex items-center justify-between no-print">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">{{ $pilbup->judul }}</h2>
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                Cetak Rekapitulasi
            </button>
        </div>

        <!-- Progres Data Masuk -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Data Masuk</span>
                <span class="text-xs font-black text-[#008a24]">{{ $persenMasuk }}% &middot; {{ number_format($tpsMasuk) }} dari {{ number_format($totalTps) }} TPS</span>
            </div>
            <div class="w-full h-2.5 bg-gray-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                <div class="h-full bg-[#008a24] rounded-full transition-all duration-700" style="width: {{ $persenMasuk }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

            <!-- Grafik Perolehan Suara -->
            <div class="lg:col-span-2 bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white mb-3">Grafik Perolehan Suara</h3>
                <canvas id="grafikSuara" height="240"></canvas>
            </div>

            <!-- Tabel Perolehan Suara -->
            <div class="lg:col-span-3 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Pasangan Calon</th>
                            <th class="px-4 py-3 text-right">Suara Sah</th>
                            <th class="px-4 py-3 text-right">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @foreach($rekapPaslon as $r)
                            @php $persen = $totalSuaraSah > 0 ? round(($r['suara'] / $totalSuaraSah) * 100, 2) : 0; @endphp
                            <tr>
                                <td class="px-4 py-3 font-black">{{ $r['paslon']->no_urut }}</td>
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                    <span class="inline-block w-2.5 h-2.5 rounded-full align-middle mr-1.5" style="background: {{ $r['paslon']->warna }}"></span>
                                    {{ $r['paslon']->nama }}
                                </td>
                                <td class="px-4 py-3 text-right font-bold">{{ number_format($r['suara']) }}</td>
                                <td class="px-4 py-3 text-right font-black" style="color: {{ $r['paslon']->warna }}">{{ $persen }}%</td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50 dark:bg-zinc-800/60 font-black">
                            <td class="px-4 py-3" colspan="2">Total Suara Sah</td>
                            <td class="px-4 py-3 text-right" colspan="2">{{ number_format($totalSuaraSah) }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!-- Rekap per Kecamatan -->
        <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800">
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Rekapitulasi per Kecamatan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Kecamatan</th>
                            <th class="px-4 py-3 text-center">TPS</th>
                            @foreach($paslons as $p)
                                <th class="px-4 py-3 text-right" style="color: {{ $p->warna }}">No. {{ $p->no_urut }}</th>
                            @endforeach
                            <th class="px-4 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @foreach($rekapKecamatan as $kec)
                            <tr>
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $kec['kecamatan'] }}</td>
                                <td class="px-4 py-3 text-center">{{ number_format($kec['tps']) }}</td>
                                @foreach($paslons as $p)
                                    <td class="px-4 py-3 text-right">{{ number_format($kec['per_paslon'][$p->id] ?? 0) }}</td>
                                @endforeach
                                <td class="px-4 py-3 text-right font-black">{{ number_format($kec['total']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection

@push('styles')
<style>
    @media print {
        .no-print, nav, aside { display: none !important; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const kanvasGrafik = document.getElementById('grafikSuara');

    if (kanvasGrafik) {
        new Chart(kanvasGrafik, {
            type: 'bar',
            data: {
                labels: {!! $rekapPaslon->pluck('paslon.nama')->map(fn($n) => Str::limit($n, 16))->toJson() !!},
                datasets: [{
                    label: 'Suara Sah',
                    data: {!! $rekapPaslon->pluck('suara')->toJson() !!},
                    backgroundColor: {!! $rekapPaslon->pluck('paslon.warna')->toJson() !!},
                    borderRadius: 6,
                }],
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            },
        });
    }
</script>
@endpush
