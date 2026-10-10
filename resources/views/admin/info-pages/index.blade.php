@extends('layouts.admin')

@section('title', 'Halaman Info')

@section('content')
<div class="space-y-5">

    <div>
        <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Halaman Info</h2>
        <p class="text-xs text-gray-400">Konten statis yang tampil di kanal berita: disclaimer, pedoman pemberitaan, susunan redaksi, dan info iklan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($halaman as $page)
            <a href="{{ route('admin.info-pages.edit', $page->slug) }}" class="block bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm p-5 hover:border-[#008a24] transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <span class="badge-cat mb-2">{{ $page->badge ?: 'Halaman Info' }}</span>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mt-1">{{ $page->judul }}</h3>
                        <p class="text-xs text-gray-400 mt-1">/info/{{ $page->slug }}</p>
                    </div>
                    <span class="shrink-0 px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                        Edit
                    </span>
                </div>
            </a>
        @endforeach
    </div>

</div>
@endsection
