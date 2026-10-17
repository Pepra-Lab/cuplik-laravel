<div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-base font-extrabold text-gray-900 dark:text-white">{{ $pilbup->judul ?? 'Real Count Pilbup' }}</h2>
        <p class="text-xs text-gray-400">Pusat Tabulasi dan Rekapitulasi Suara Pilkada CuplikCom</p>
    </div>

    <div class="flex items-center gap-3">
        @if($pilbups->isNotEmpty())
            <form method="GET" class="flex items-center gap-2">
                <select name="pilbup_id" onchange="this.form.submit()" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 font-bold focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                    @foreach($pilbups as $pb)
                        <option value="{{ $pb->id }}" {{ $pilbup && $pilbup->id === $pb->id ? 'selected' : '' }}>
                            {{ $pb->judul }} ({{ $pb->tahun }}){{ $pb->status === 'Aktif' ? ' · Aktif' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif

        <a href="{{ route('realcount.index') }}" target="_blank" class="px-3 py-2 bg-emerald-50 dark:bg-emerald-950 text-[#008a24] hover:bg-emerald-100 rounded-lg text-xs font-bold transition-colors flex items-center gap-1 shrink-0">
            Lihat Real Count Publik &rarr;
        </a>
    </div>
</div>
