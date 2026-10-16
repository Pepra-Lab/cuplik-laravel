<div class="flex items-center gap-1.5 overflow-x-auto border-b border-gray-200 dark:border-zinc-800 pb-px">
    @foreach(\App\Models\InfoPage::SLUGS as $slugTab => $labelTab)
        <a href="{{ route('admin.info-pages.edit', $slugTab) }}" class="shrink-0 px-3.5 py-2 text-xs font-bold rounded-t-lg border-b-2 -mb-px transition-colors {{ $page->slug === $slugTab ? 'border-[#008a24] text-[#008a24]' : 'border-transparent text-gray-500 hover:text-gray-800 dark:hover:text-gray-200' }}">
            {{ $labelTab }}
        </a>
    @endforeach
</div>
