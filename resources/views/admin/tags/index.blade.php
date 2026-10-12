@extends('layouts.admin')

@section('title', 'Tag Berita')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Tag (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Tag Baru</h2>
            <p class="text-xs text-gray-400">Buat topik hashtag atau label berita</p>
        </div>

        <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Tag <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required placeholder="Contoh: Pilbup Indramayu, Pertamina..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('nama') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Slug Kustom (Opsional)</label>
                <input type="text" name="slug" placeholder="Otomatis digenerate jika kosong" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('slug') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center">
                Simpan Tag
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Tag (2 Cols) -->
    <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Tag Berita</h2>
            <span class="text-xs text-gray-400 font-semibold">{{ $tags->count() }} Tag Terdaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Nama Tag</th>
                        <th class="px-4 py-3">Slug URL</th>
                        <th class="px-4 py-3 text-center">Jumlah Berita</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($tags as $index => $tg)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3 text-center text-gray-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                <a href="{{ route('tag.show', $tg->slug) }}" target="_blank" class="hover:text-[#008a24]">
                                    #{{ $tg->nama }}
                                </a>
                            </td>
                            <td class="px-4 py-3 font-mono text-gray-400 text-[11px]">
                                /tag/{{ $tg->slug }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950 text-blue-600">
                                    {{ $tg->articles_count }} berita
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditTagModal({{ $tg->id }}, '{{ addslashes($tg->nama) }}', '{{ $tg->slug }}')" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Tag">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.tags.destroy', $tg) }}" method="POST" onsubmit="return confirm('Hapus tag ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Tag">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada tag berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Edit Tag Modal -->
<div id="editTagModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Tag</h3>
            <button onclick="closeEditTagModal()" class="text-gray-400 hover:text-gray-600 text-lg leading-none">&times;</button>
        </div>

        <form id="editTagForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Tag <span class="text-red-500">*</span></label>
                <input type="text" id="editTagNama" name="nama" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Slug Kustom</label>
                <input type="text" id="editTagSlug" name="slug" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditTagModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditTagModal(id, nama, slug) {
        const modal = document.getElementById('editTagModal');
        const form = document.getElementById('editTagForm');
        form.action = `/admin/tags/${id}`;
        document.getElementById('editTagNama').value = nama;
        document.getElementById('editTagSlug').value = slug;
        modal.classList.remove('hidden');
    }

    function closeEditTagModal() {
        document.getElementById('editTagModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
