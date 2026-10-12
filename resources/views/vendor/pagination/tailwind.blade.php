@if ($paginator->hasPages())
    @php
        // Bangun daftar nomor halaman secara manual (current ± 1, plus halaman
        // pertama & terakhir) memakai currentPage()/lastPage()/url(), karena
        // method elements() tidak tersedia di semua versi paginator Laravel.
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $onEachSide = 1;

        if ($lastPage <= 7) {
            $pageWindow = range(1, $lastPage);
        } else {
            $start = max($currentPage - $onEachSide, 2);
            $end = min($currentPage + $onEachSide, $lastPage - 1);

            $pageWindow = [1];

            if ($start > 2) {
                $pageWindow[] = '...';
            }

            for ($page = $start; $page <= $end; $page++) {
                $pageWindow[] = $page;
            }

            if ($end < $lastPage - 1) {
                $pageWindow[] = '...';
            }

            $pageWindow[] = $lastPage;
        }
    @endphp

    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">

        {{-- Ringkasan jumlah data --}}
        <p class="order-2 sm:order-1 text-gray-400">
            @if ($paginator->firstItem())
                Menampilkan
                <span class="font-bold text-gray-600 dark:text-gray-300">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-bold text-gray-600 dark:text-gray-300">{{ $paginator->total() }}</span>
                data
            @else
                {{ $paginator->count() }} data
            @endif
        </p>

        <div class="order-1 sm:order-2 flex items-center gap-1.5">

            {{-- Tautan Halaman Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-300 dark:text-zinc-700 cursor-not-allowed" aria-disabled="true" aria-label="Halaman sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-gray-300 hover:border-[#008a24] hover:text-[#008a24] transition-colors" aria-label="Halaman sebelumnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Di layar kecil: cukup tampilkan "halaman saat ini / total halaman" --}}
            <span class="sm:hidden px-2 font-bold text-gray-600 dark:text-gray-300 whitespace-nowrap">
                {{ $currentPage }} / {{ $lastPage }}
            </span>

            {{-- Di layar sm ke atas: tampilkan nomor halaman --}}
            <div class="hidden sm:flex items-center gap-1.5">
                @foreach ($pageWindow as $page)
                    {{-- Pemisah "..." --}}
                    @if ($page === '...')
                        <span class="flex items-center justify-center w-8 h-8 text-gray-300 dark:text-zinc-600">&hellip;</span>
                    @elseif ($page === $currentPage)
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#008a24] text-white font-bold" aria-current="page">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-600 dark:text-gray-300 hover:border-[#008a24] hover:text-[#008a24] transition-colors font-bold" aria-label="Ke halaman {{ $page }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Tautan Halaman Berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-gray-300 hover:border-[#008a24] hover:text-[#008a24] transition-colors" aria-label="Halaman berikutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-300 dark:text-zinc-700 cursor-not-allowed" aria-disabled="true" aria-label="Halaman berikutnya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
