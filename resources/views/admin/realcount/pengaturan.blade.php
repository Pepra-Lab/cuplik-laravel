@extends('layouts.admin')

@section('title', 'Pengaturan Pemilihan — Real Count')

@section('content')
<div class="space-y-5">

    @include('admin.realcount._header')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Form Tambah Pemilihan -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
            <div>
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Pemilihan</h2>
                <p class="text-xs text-gray-400">Buat data pemilihan baru (mis. Pilbup periode berikutnya)</p>
            </div>

            <form action="{{ route('admin.realcount.pengaturan.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Pemilihan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Pemilihan Bupati dan Wakil Bupati Indramayu" value="{{ old('judul') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" required min="2000" max="2100" value="{{ old('tahun', now()->year) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    @error('tahun') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none">
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <span class="text-[10px] text-gray-400 block mt-1">Pemilihan berstatus Aktif akan otomatis tampil duluan di halaman publik. Hanya boleh satu yang aktif.</span>
                </div>

                <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Pemilihan
                </button>
            </form>
        </div>

        <!-- Daftar Pemilihan -->
        <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden h-fit">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Judul Pemilihan</th>
                            <th class="px-4 py-3 text-center">Tahun</th>
                            <th class="px-4 py-3 text-center">Calon</th>
                            <th class="px-4 py-3 text-center">Wilayah</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($pilbups as $pb)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $pb->judul }}</td>
                                <td class="px-4 py-3 text-center">{{ $pb->tahun }}</td>
                                <td class="px-4 py-3 text-center">{{ $pb->paslons_count }}</td>
                                <td class="px-4 py-3 text-center">{{ $pb->dpts_count }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($pb->status === 'Aktif')
                                        <span class="badge-status-ok">Aktif</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-zinc-800 text-gray-500">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button type="button" onclick="bukaEditPilbup({{ Js::from($pb->only(['id', 'judul', 'tahun', 'status'])) }})" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Edit</button>
                                        <form action="{{ route('admin.realcount.pengaturan.destroy', $pb) }}" method="POST" onsubmit="return confirm('Hapus pemilihan {{ $pb->judul }}? Semua data calon, wilayah, dan suara ikut terhapus permanen.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data pemilihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Edit Pemilihan -->
<div id="modalEditPilbup" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl w-full max-w-md">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Edit Pemilihan</h3>
            <button type="button" onclick="tutupEditPilbup()" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-lg leading-none">&times;</button>
        </div>

        <form id="formEditPilbup" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Pemilihan</label>
                <input type="text" id="editPilbupJudul" name="judul" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                <input type="number" id="editPilbupTahun" name="tahun" min="2000" max="2100" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="editPilbupStatus" name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="Aktif">Aktif</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                <button type="button" onclick="tutupEditPilbup()" class="px-4 py-2 text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function bukaEditPilbup(pb) {
        document.getElementById('formEditPilbup').action = `/admin/real-count/pengaturan/${pb.id}`;
        document.getElementById('editPilbupJudul').value = pb.judul;
        document.getElementById('editPilbupTahun').value = pb.tahun;
        document.getElementById('editPilbupStatus').value = pb.status;
        document.getElementById('modalEditPilbup').classList.remove('hidden');
    }

    function tutupEditPilbup() {
        document.getElementById('modalEditPilbup').classList.add('hidden');
    }
</script>
@endpush
