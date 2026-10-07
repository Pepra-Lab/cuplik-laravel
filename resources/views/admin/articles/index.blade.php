@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Search -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul, penulis, editor..." class="w-full pl-9 pr-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <select name="kategori_id" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->nama }}</option>
                @endforeach
            </select>

            <select name="status" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                <option value="">Semua Status</option>
                <option value="Terbit" {{ $status === 'Terbit' ? 'selected' : '' }}>Terbit</option>
                <option value="Review" {{ $status === 'Review' ? 'selected' : '' }}>Review</option>
                <option value="Draft" {{ $status === 'Draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                Filter
            </button>
            @if($q || $categoryId || $status)
                <a href="{{ route('admin.articles.index') }}" class="px-3 py-2 text-xs text-gray-500 hover:text-red-500 underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.articles.create') }}" class="flex items-center gap-2 px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg transition-colors shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tulis Berita Baru
        </a>
    </div>

    <!-- Article Table -->
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3.5 w-16">Foto</th>
                        <th class="px-4 py-3.5">Judul Berita</th>
                        <th class="px-4 py-3.5">Kategori</th>
                        <th class="px-4 py-3.5">Penulis / Editor</th>
                        <th class="px-4 py-3.5 text-center">Status</th>
                        <th class="px-4 py-3.5 text-center">Dibaca</th>
                        <th class="px-4 py-3.5">Tanggal</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($articles as $art)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-12 h-10 rounded bg-gray-100 dark:bg-zinc-800 overflow-hidden shrink-0 border border-gray-200 dark:border-zinc-700">
                                    @if($art->foto)
                                        <img src="{{ asset($art->foto) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px]">No Img</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="max-w-md">
                                    <a href="{{ route('admin.articles.edit', $art) }}" class="font-bold text-gray-900 dark:text-white hover:text-[#008a24] line-clamp-2">
                                        {{ $art->judul }}
                                    </a>
                                    @if($art->lead)
                                        <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">{{ $art->lead }}</p>
                                    @endif
                                    @if($art->tags->count() > 0)
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @foreach($art->tags->take(3) as $tg)
                                                <span class="text-[9px] bg-gray-100 dark:bg-zinc-800 text-gray-500 px-1.5 py-0.5 rounded">#{{ $tg->nama }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-[#008a24] border border-emerald-200 dark:border-emerald-800">
                                    {{ $art->category->nama ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                <div><strong class="text-gray-800 dark:text-gray-200">P:</strong> {{ $art->penulis_nama ?? '-' }}</div>
                                <div><strong class="text-gray-800 dark:text-gray-200">E:</strong> {{ $art->editor_nama ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($art->status === 'Terbit')
                                    <span class="badge-status-ok">Terbit</span>
                                @elseif($art->status === 'Review')
                                    <span class="badge-status-wt">Review</span>
                                @else
                                    <span class="badge-status-no">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">
                                {{ number_format($art->dibaca) }}
                            </td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                {{ $art->tanggal ? $art->tanggal->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Lihat di Web">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $art) }}" class="p-1.5 text-gray-400 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Berita">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $art) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Berita">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                                Tidak ada berita yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
