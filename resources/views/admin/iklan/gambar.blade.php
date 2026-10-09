@extends('layouts.admin')

@section('title', 'Kelola Iklan Gambar')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Iklan Gambar (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Pasang Slot Iklan Gambar</h2>
            <p class="text-xs text-gray-400">Atur space banner display periklanan portal</p>
        </div>

        <form action="{{ route('admin.iklan-gambar.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul / Pengiklan <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="Contoh: Banner Promo BJB, Iklan Diskon..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Posisi Slot <span class="text-red-500">*</span></label>
                    <select name="posisi" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        @forelse($posisis as $p)
                            <option value="{{ $p->nama }}">{{ $p->nama }}{{ $p->ukuran ? ' ('.$p->ukuran.')' : '' }}</option>
                        @empty
                            <option value="" disabled selected>Belum ada data posisi</option>
                        @endforelse
                    </select>
                    <a href="{{ route('admin.iklan-posisi.index') }}" class="text-[10px] text-[#008a24] hover:underline font-semibold">+ Kelola Posisi Iklan</a>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ukuran Banner</label>
                    <input type="text" name="ukuran" placeholder="728x90 px" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Path / URL Gambar</label>
                <input type="text" name="gambar" placeholder="assets/images/iklan/banner.jpg" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tautan / Link Tujuan (Redirect)</label>
                <input type="url" name="link" placeholder="https://pengiklan.com" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Mulai Tayang</label>
                    <input type="date" name="mulai" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Selesai Tayang</label>
                    <input type="date" name="selesai" value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="Tayang">Tayang</option>
                    <option value="Berakhir">Berakhir</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                Simpan Iklan
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Iklan Gambar (2 Cols) -->
    <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Slot Banner Display</h2>
            <span class="text-xs text-gray-400 font-semibold">{{ $iklans->total() }} Banner</span>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 w-16">Banner</th>
                        <th class="px-4 py-3">Judul Pengiklan</th>
                        <th class="px-4 py-3">Posisi</th>
                        <th class="px-4 py-3 text-center">Ukuran</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3">Periode</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($iklans as $ik)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-12 h-8 rounded bg-gray-100 dark:bg-zinc-800 overflow-hidden border border-gray-200 dark:border-zinc-700">
                                    @if($ik->gambar)
                                        <img src="{{ asset($ik->gambar) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-400">Ad</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                {{ $ik->judul }}
                                @if($ik->link)
                                    <div class="text-[10px] font-mono text-blue-500 font-normal truncate max-w-xs">{{ $ik->link }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 dark:bg-blue-950 text-blue-600">
                                    {{ $ik->posisi }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center font-mono text-gray-500">{{ $ik->ukuran ?: '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($ik->status === 'Tayang')
                                    <span class="badge-status-ok">Tayang</span>
                                @elseif($ik->status === 'Berakhir')
                                    <span class="badge-status-wt">Berakhir</span>
                                @else
                                    <span class="badge-status-no">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-[10px] whitespace-nowrap">
                                <div>{{ $ik->mulai ? $ik->mulai->format('d/m/y') : '∞' }} s/d</div>
                                <div>{{ $ik->selesai ? $ik->selesai->format('d/m/y') : '∞' }}</div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditIklanGambarModal({{ $ik->id }}, '{{ addslashes($ik->judul) }}', '{{ $ik->posisi }}', '{{ $ik->ukuran }}', '{{ addslashes($ik->link) }}', '{{ addslashes($ik->gambar) }}', '{{ $ik->mulai ? $ik->mulai->format('Y-m-d') : '' }}', '{{ $ik->selesai ? $ik->selesai->format('Y-m-d') : '' }}', '{{ $ik->status }}')" class="px-2 py-1 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Iklan">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.iklan-gambar.destroy', $ik) }}" method="POST" onsubmit="return confirm('Hapus slot iklan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Iklan">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada banner iklan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($iklans->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                {{ $iklans->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Edit Iklan Modal -->
<div id="editIklanModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Slot Iklan Gambar</h3>
            <button onclick="closeEditIklanGambarModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editIklanForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul / Pengiklan</label>
                <input type="text" id="editIkJudul" name="judul" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Posisi Slot</label>
                    <select id="editIkPosisi" name="posisi" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none">
                        @foreach($posisis as $p)
                            <option value="{{ $p->nama }}">{{ $p->nama }}{{ $p->ukuran ? ' ('.$p->ukuran.')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Ukuran Banner</label>
                    <input type="text" id="editIkUkuran" name="ukuran" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Path / URL Gambar</label>
                <input type="text" id="editIkGambar" name="gambar" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tautan / Link Tujuan</label>
                <input type="url" id="editIkLink" name="link" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Mulai Tayang</label>
                    <input type="date" id="editIkMulai" name="mulai" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Selesai Tayang</label>
                    <input type="date" id="editIkSelesai" name="selesai" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="editIkStatus" name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="Tayang">Tayang</option>
                    <option value="Berakhir">Berakhir</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditIklanGambarModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditIklanGambarModal(id, judul, posisi, ukuran, link, gambar, mulai, selesai, status) {
        const modal = document.getElementById('editIklanModal');
        const form = document.getElementById('editIklanForm');
        form.action = `/admin/iklan-gambar/${id}`;
        document.getElementById('editIkJudul').value = judul;
        document.getElementById('editIkPosisi').value = posisi;
        document.getElementById('editIkUkuran').value = ukuran || '';
        document.getElementById('editIkLink').value = link || '';
        document.getElementById('editIkGambar').value = gambar || '';
        document.getElementById('editIkMulai').value = mulai || '';
        document.getElementById('editIkSelesai').value = selesai || '';
        document.getElementById('editIkStatus').value = status;
        modal.classList.remove('hidden');
    }

    function closeEditIklanGambarModal() {
        document.getElementById('editIklanModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
