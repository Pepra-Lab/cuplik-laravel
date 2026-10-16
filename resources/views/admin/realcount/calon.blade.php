@extends('layouts.admin')

@section('title', 'Pasangan Calon — Real Count')

@section('content')
<div class="space-y-5">

    @include('admin.realcount._header')

    @if(!$pilbup)
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Belum ada data pemilihan. Buat dulu di tab <strong>Pengaturan Pemilihan</strong>.
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Form Tambah Calon -->
            <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
                <div>
                    <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Pasangan Calon</h2>
                    <p class="text-xs text-gray-400">Untuk {{ $pilbup->judul }}</p>
                </div>

                <form action="{{ route('admin.realcount.calon.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="pilbup_id" value="{{ $pilbup->id }}">

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nomor Urut <span class="text-red-500">*</span></label>
                        <input type="number" name="no_urut" min="1" required value="{{ old('no_urut', $paslons->count() + 1) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('no_urut') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Paslon <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" required placeholder="Contoh: Sholihin - Ratna" value="{{ old('nama') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('nama') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Partai Pengusung</label>
                        <input type="text" name="usungan" value="{{ old('usungan') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Warna Grafik</label>
                        <input type="color" name="warna" value="{{ old('warna', '#008a24') }}" class="w-full h-9 px-1 py-1 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg cursor-pointer">
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                        Simpan Calon
                    </button>
                </form>
            </div>

            <!-- Daftar Calon -->
            <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden h-fit">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 text-center w-14">No</th>
                                <th class="px-4 py-3">Paslon</th>
                                <th class="px-4 py-3">Partai Pengusung</th>
                                <th class="px-4 py-3 text-center">Warna</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($paslons as $p)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-4 py-3 text-center font-black text-gray-900 dark:text-white">{{ $p->no_urut }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $p->nama }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $p->usungan ?: '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block w-5 h-5 rounded-full border border-gray-200 dark:border-zinc-700 align-middle" style="background: {{ $p->warna }}" title="{{ $p->warna }}"></span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button type="button" onclick="bukaEditCalon({{ Js::from($p->id) }}, {{ Js::from($p->no_urut) }}, {{ Js::from($p->nama) }}, {{ Js::from($p->usungan) }}, {{ Js::from($p->warna) }})" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.realcount.calon.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pasangan calon {{ $p->nama }}? Seluruh suara yang sudah tercatat untuk calon ini juga ikut terhapus.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada pasangan calon untuk pemilihan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Modal Edit Calon -->
<div id="modalEditCalon" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl w-full max-w-md">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Edit Pasangan Calon</h3>
            <button type="button" onclick="tutupEditCalon()" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-lg leading-none">&times;</button>
        </div>

        <form id="formEditCalon" method="POST" class="p-5 space-y-4">
            @csrf @method('PUT')
            <input type="hidden" name="pilbup_id" value="{{ $pilbup->id ?? '' }}">

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nomor Urut</label>
                <input type="number" id="editCalonNoUrut" name="no_urut" min="1" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Nama Paslon</label>
                <input type="text" id="editCalonNama" name="nama" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Partai Pengusung</label>
                <input type="text" id="editCalonUsungan" name="usungan" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Warna Grafik</label>
                <input type="color" id="editCalonWarna" name="warna" class="w-full h-9 px-1 py-1 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg cursor-pointer">
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                <button type="button" onclick="tutupEditCalon()" class="px-4 py-2 text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function bukaEditCalon(id, noUrut, nama, usungan, warna) {
        document.getElementById('formEditCalon').action = `/admin/real-count/calon/${id}`;
        document.getElementById('editCalonNoUrut').value = noUrut;
        document.getElementById('editCalonNama').value = nama;
        document.getElementById('editCalonUsungan').value = usungan ?? '';
        document.getElementById('editCalonWarna').value = warna;
        document.getElementById('modalEditCalon').classList.remove('hidden');
    }

    function tutupEditCalon() {
        document.getElementById('modalEditCalon').classList.add('hidden');
    }
</script>
@endpush
