@php
    $tabs = [
        ['admin.settings.profil', 'Profil Situs'],
        ['admin.iklan-posisi.index', 'Posisi Iklan'],
    ];
@endphp
<div class="flex items-center gap-1.5 overflow-x-auto border-b border-gray-200 dark:border-zinc-800 pb-px">
    @foreach($tabs as [$routeName, $label])
        <a href="{{ route($routeName) }}" class="shrink-0 px-3.5 py-2 text-xs font-bold rounded-t-lg border-b-2 -mb-px transition-colors {{ request()->routeIs($routeName) ? 'border-[#008a24] text-[#008a24]' : 'border-transparent text-gray-500 hover:text-gray-800 dark:hover:text-gray-200' }}">
            {{ $label }}
        </a>
    @endforeach
</div>
