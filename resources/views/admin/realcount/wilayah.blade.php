@extends('layouts.admin')

@section('title', 'Data Wilayah — Real Count')

@section('content')
<div class="space-y-5">

    @include('admin.realcount._header')
    @include('admin.realcount._tabs')

    @if(!$pilbup)
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Belum ada data pemilihan. Buat dulu di tab <strong>Pengaturan Pemilihan</strong>.
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">

            <!-- Form Tambah Wilayah -->
            <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
                <div>
                    <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Wilayah</h2>
                    <p class="text-xs text-gray-400">Data DPT per kecamatan/desa untuk {{ $pilbup->judul }}</p>
                </div>

                <form action="{{ route('admin.realcount.wilayah.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="pilbup_id" value="{{ $pilbup->id }}">

                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="kecamatan" required value="{{ old('kecamatan') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('kecamatan') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Desa/Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" name="desa" required value="{{ old('desa') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @error('desa') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">TPS</label>
                            <input type="number" name="tps" min="0" value="{{ old('tps', 0) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPT</label>
                            <input type="number" name="dpt" min="0" value="{{ old('dpt', 0) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPPh</label>
                            <input type="number" name="dpph" min="0" value="{{ old('dpph', 0) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPTb</label>
                            <input type="number" name="dptb" min="0" value="{{ old('dptb', 0) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Suara Tidak Sah</label>
                        <input type="number" name="ts" min="0" value="{{ old('ts', 0) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                        Simpan Wilayah
                    </button>
                </form>
            </div>

            <!-- Daftar Wilayah -->
            <div class="lg:col-span-3 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden h-fit">
                <div class="p-4 border-b border-gray-200 dark:border-zinc-800">
                    <form method="GET" class="flex items-center gap-2">
                        <input type="hidden" name="pilbup_id" value="{{ $pilbup->id }}">
                        <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari kecamatan atau desa..." class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24] w-64">
                        <button type="submit" class="px-3 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">Cari</button>
                        @if($cari)
                            <a href="{{ route('admin.realcount.wilayah', ['pilbup_id' => $pilbup->id]) }}" class="text-xs text-gray-500 hover:text-red-500 underline">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                            <tr>
                                <th class="px-3 py-3">Kecamatan</th>
                                <th class="px-3 py-3">Desa/Kelurahan</th>
                                <th class="px-3 py-3 text-center">TPS</th>
                                <th class="px-3 py-3 text-center">DPT</th>
                                <th class="px-3 py-3 text-center">DPPh</th>
                                <th class="px-3 py-3 text-center">DPTb</th>
                                <th class="px-3 py-3 text-center">Tdk Sah</th>
                                <th class="px-3 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                            @forelse($dpts as $d)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                    <td class="px-3 py-2.5 font-bold text-gray-900 dark:text-white">{{ $d->kecamatan }}</td>
                                    <td class="px-3 py-2.5 text-gray-700 dark:text-gray-300">{{ $d->desa }}</td>
                                    <td class="px-3 py-2.5 text-center">{{ number_format($d->tps) }}</td>
                                    <td class="px-3 py-2.5 text-center">{{ number_format($d->dpt) }}</td>
                                    <td class="px-3 py-2.5 text-center">{{ number_format($d->dpph) }}</td>
                                    <td class="px-3 py-2.5 text-center">{{ number_format($d->dptb) }}</td>
                                    <td class="px-3 py-2.5 text-center">{{ number_format($d->ts) }}</td>
                                    <td class="px-3 py-2.5 text-right">
                                        <div class="inline-flex items-center gap-1">
                                            <button type="button" onclick="bukaEditWilayah({{ Js::from($d->only(['id', 'kecamatan', 'desa', 'tps', 'dpt', 'dpph', 'dptb', 'ts'])) }})" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Edit</button>
                                            <form action="{{ route('admin.realcount.wilayah.destroy', $d) }}" method="POST" onsubmit="return confirm('Hapus data wilayah {{ $d->desa }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                                        {{ $cari ? 'Tidak ada wilayah yang cocok dengan pencarian.' : 'Belum ada data wilayah untuk pemilihan ini.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($totalWilayah && $dpts->total() > 0)
                            <tfoot class="bg-gray-50 dark:bg-zinc-800/60 font-black text-gray-900 dark:text-white border-t-2 border-gray-200 dark:border-zinc-700">
                                <tr>
                                    <td class="px-3 py-3" colspan="2">Total Keseluruhan</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($totalWilayah->tps) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($totalWilayah->dpt) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($totalWilayah->dpph) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($totalWilayah->dptb) }}</td>
                                    <td class="px-3 py-3 text-center">{{ number_format($totalWilayah->ts) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>

                @if($dpts->hasPages())
                    <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                        {{ $dpts->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>

<!-- Modal Edit Wilayah -->
<div id="modalEditWilayah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl w-full max-w-md">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Edit Data Wilayah</h3>
            <button type="button" onclick="tutupEditWilayah()" class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-lg leading-none">&times;</button>
        </div>

        <form id="formEditWilayah" method="POST" class="p-5 space-y-3">
            @csrf @method('PUT')
            <input type="hidden" name="pilbup_id" value="{{ $pilbup->id ?? '' }}">

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Kecamatan</label>
                <input type="text" id="editWilayahKecamatan" name="kecamatan" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Desa/Kelurahan</label>
                <input type="text" id="editWilayahDesa" name="desa" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">TPS</label>
                    <input type="number" id="editWilayahTps" name="tps" min="0" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPT</label>
                    <input type="number" id="editWilayahDpt" name="dpt" min="0" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPPh</label>
                    <input type="number" id="editWilayahDpph" name="dpph" min="0" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">DPTb</label>
                    <input type="number" id="editWilayahDptb" name="dptb" min="0" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Suara Tidak Sah</label>
                <input type="number" id="editWilayahTs" name="ts" min="0" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                <button type="button" onclick="tutupEditWilayah()" class="px-4 py-2 text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white text-xs font-bold rounded-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function bukaEditWilayah(d) {
        document.getElementById('formEditWilayah').action = `/admin/real-count/wilayah/${d.id}`;
        document.getElementById('editWilayahKecamatan').value = d.kecamatan;
        document.getElementById('editWilayahDesa').value = d.desa;
        document.getElementById('editWilayahTps').value = d.tps;
        document.getElementById('editWilayahDpt').value = d.dpt;
        document.getElementById('editWilayahDpph').value = d.dpph;
        document.getElementById('editWilayahDptb').value = d.dptb;
        document.getElementById('editWilayahTs').value = d.ts;
        document.getElementById('modalEditWilayah').classList.remove('hidden');
    }

    function tutupEditWilayah() {
        document.getElementById('modalEditWilayah').classList.add('hidden');
    }
</script>
@endpush
