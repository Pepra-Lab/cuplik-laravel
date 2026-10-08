@extends('layouts.admin')

@section('title', 'Tag & Submenu')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Tag (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Tag / Submenu</h2>
            <p class="text-xs text-gray-400">Buat topik hashtag atau sub-kanal berita</p>
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
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kategori Induk (Submenu)</label>
                <select name="category_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="">-- Tanpa Kategori Induk (Global Tag) --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tampilkan di Sub-Menu Navigasi</label>
                <select name="sub_tampil" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="Tidak">Tidak (Hanya sebagai Tag)</option>
                    <option value="Ya">Ya (Muncul di Sub-Navigasi Header)</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center">
                Simpan Tag
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Tag (2 Cols) -->
    <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Tag & Submenu</h2>
            <span class="text-xs text-gray-400 font-semibold">{{ $tags->count() }} Tag Terdaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Nama Tag</th>
                        <th class="px-4 py-3">Kategori Induk</th>
                        <th class="px-4 py-3 text-center">Jumlah Berita</th>
                        <th class="px-4 py-3 text-center">Sub-Menu</th>
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
                                <div class="text-[10px] font-mono text-gray-400 font-normal">/tag/{{ $tg->slug }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($tg->category)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300">
                                        {{ $tg->category->nama }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-gray-400 italic">Global Tag</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950 text-blue-600">
                                    {{ $tg->articles_count }} berita
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($tg->sub_tampil === 'Ya')
                                    <span class="badge-status-ok">Tampil</span>
                                @else
                                    <span class="badge-status-no">Tidak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditTagModal({{ $tg->id }}, '{{ addslashes($tg->nama) }}', '{{ $tg->slug }}', '{{ $tg->category_id }}', '{{ $tg->sub_tampil }}')" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Tag">
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
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada tag/submenu.</td>
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
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Tag / Submenu</h3>
            <button onclick="closeEditTagModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editTagForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Tag</label>
                <input type="text" id="editTagNama" name="nama" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Slug Kustom</label>
                <input type="text" id="editTagSlug" name="slug" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kategori Induk (Submenu)</label>
                <select id="editTagCatId" name="category_id" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="">-- Tanpa Kategori Induk (Global Tag) --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tampilkan di Sub-Menu Navigasi</label>
                <select id="editTagSubTampil" name="sub_tampil" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="Tidak">Tidak (Hanya sebagai Tag)</option>
                    <option value="Ya">Ya (Muncul di Sub-Navigasi Header)</option>
                </select>
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
    function openEditTagModal(id, nama, slug, catId, subTampil) {
        const modal = document.getElementById('editTagModal');
        const form = document.getElementById('editTagForm');
        form.action = `/admin/tags/${id}`;
        document.getElementById('editTagNama').value = nama;
        document.getElementById('editTagSlug').value = slug;
        document.getElementById('editTagCatId').value = catId || '';
        document.getElementById('editTagSubTampil').value = subTampil;
        modal.classList.remove('hidden');
    }

    function closeEditTagModal() {
        document.getElementById('editTagModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
