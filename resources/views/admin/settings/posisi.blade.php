@extends('layouts.admin')

@section('title', 'Posisi Iklan')

@section('content')
<div class="space-y-5">

    @include('admin.settings._tabs')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Tambah Posisi (1 Col) -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
            <div>
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Posisi Iklan</h2>
                <p class="text-xs text-gray-400">Master data slot iklan — dipakai sebagai pilihan posisi di menu Iklan Gambar</p>
            </div>

            <form action="{{ route('admin.iklan-posisi.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Posisi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Contoh: Header Top" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    @error('nama') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ukuran</label>
                    <input type="text" name="ukuran" placeholder="728x90" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                    <input type="text" name="keterangan" placeholder="Slot di bagian atas header" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                </div>

                <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Posisi
                </button>
            </form>
        </div>

        <!-- Tabel Posisi (2 Cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Posisi Iklan</h2>
                <span class="text-xs text-gray-400 font-semibold">{{ $posisis->count() }} Posisi</span>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Nama Posisi</th>
                            <th class="px-4 py-3">Ukuran</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($posisis as $p)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $p->nama }}</td>
                                <td class="px-4 py-3 font-mono text-gray-600 dark:text-gray-300">{{ $p->ukuran ?: '-' }}</td>
                                <td class="px-4 py-3 text-gray-500 truncate max-w-xs">{{ $p->keterangan ?: '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" onclick="openEditPosisiModal({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ addslashes($p->ukuran) }}', '{{ addslashes($p->keterangan) }}')" class="px-2 py-1 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.iklan-posisi.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus posisi ini?')">
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
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada posisi iklan. Tambahkan dulu agar menu Iklan Gambar punya pilihan posisi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Posisi Modal -->
<div id="editPosisiModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Posisi Iklan</h3>
            <button onclick="closeEditPosisiModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editPosisiForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Posisi</label>
                <input type="text" id="editPsNama" name="nama" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ukuran</label>
                <input type="text" id="editPsUkuran" name="ukuran" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-mono text-gray-900 dark:text-white focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                <input type="text" id="editPsKeterangan" name="keterangan" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditPosisiModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditPosisiModal(id, nama, ukuran, keterangan) {
        const modal = document.getElementById('editPosisiModal');
        document.getElementById('editPosisiForm').action = `/admin/iklan-posisi/${id}`;
        document.getElementById('editPsNama').value = nama;
        document.getElementById('editPsUkuran').value = ukuran;
        document.getElementById('editPsKeterangan').value = keterangan;
        modal.classList.remove('hidden');
    }
    function closeEditPosisiModal() {
        document.getElementById('editPosisiModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
