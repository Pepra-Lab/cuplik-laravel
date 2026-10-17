@extends('layouts.admin')

@section('title', 'Kategori Iklan Teks')

@section('content')
<div class="space-y-5">

    @include('admin.settings._tabs')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Tambah Kategori (1 Col) -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
            <div>
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Kategori Iklan Teks</h2>
                <p class="text-xs text-gray-400">Master data kategori — dipakai sebagai pilihan kategori saat member mengirim Iklan Teks</p>
            </div>

            <form action="{{ route('admin.iklan-kategori.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Contoh: Jual Beli" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    @error('nama') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Kategori
                </button>
            </form>
        </div>

        <!-- Tabel Kategori (2 Cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Kategori Iklan Teks</h2>
                <span class="text-xs text-gray-400 font-semibold">{{ $kategoris->count() }} Kategori</span>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Nama Kategori</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($kategoris as $k)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $k->nama }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" onclick="openEditKategoriModal({{ $k->id }}, '{{ addslashes($k->nama) }}')" class="px-2 py-1 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.iklan-kategori.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-8 text-center text-gray-400">Belum ada kategori iklan teks. Tambahkan dulu agar menu Iklan Teks punya pilihan kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Kategori Modal -->
<div id="editKategoriModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Kategori Iklan Teks</h3>
            <button onclick="closeEditKategoriModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editKategoriForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                <input type="text" id="editKtNama" name="nama" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditKategoriModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditKategoriModal(id, nama) {
        const modal = document.getElementById('editKategoriModal');
        document.getElementById('editKategoriForm').action = `/admin/iklan-kategori/${id}`;
        document.getElementById('editKtNama').value = nama;
        modal.classList.remove('hidden');
    }
    function closeEditKategoriModal() {
        document.getElementById('editKategoriModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
