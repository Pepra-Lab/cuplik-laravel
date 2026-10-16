@php
    $tautanTab = [
        ['admin.realcount.index', 'Tabulasi Suara'],
        ['admin.realcount.calon', 'Pasangan Calon'],
        ['admin.realcount.wilayah', 'Data Wilayah'],
        ['admin.realcount.rekap', 'Rekapitulasi'],
        ['admin.realcount.pengaturan', 'Pengaturan Pemilihan'],
    ];
@endphp
<div class="flex items-center gap-1.5 overflow-x-auto border-b border-gray-200 dark:border-zinc-800 pb-px">
    @foreach($tautanTab as [$namaRoute, $label])
        <a href="{{ route($namaRoute, $pilbup ? ['pilbup_id' => $pilbup->id] : []) }}" class="shrink-0 px-3.5 py-2 text-xs font-bold rounded-t-lg border-b-2 -mb-px transition-colors {{ request()->routeIs($namaRoute) ? 'border-[#008a24] text-[#008a24]' : 'border-transparent text-gray-500 hover:text-gray-800 dark:hover:text-gray-200' }}">
            {{ $label }}
        </a>
    @endforeach
</div>
