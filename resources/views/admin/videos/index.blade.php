@extends('layouts.admin')

@section('title', 'Kelola Video Cuplik')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Video (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Tambah Video Baru</h2>
            <p class="text-xs text-gray-400">Publikasi video berita dari YouTube / media video</p>
        </div>

        <form action="{{ route('admin.videos.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Video <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="Contoh: Liputan Khusus Hasil Panen..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">URL YouTube / Video <span class="text-red-500">*</span></label>
                <input type="url" name="link" required placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                @error('link') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Durasi</label>
                    <input type="text" name="durasi" placeholder="Contoh: 04:20" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Tayang">Tayang</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal Publikasi</label>
                <input type="datetime-local" name="tanggal" value="{{ date('Y-m-d\TH:i') }}" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center">
                Simpan Video
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Video (2 Cols) -->
    <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
        <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Video Berita</h2>
            
            <form method="GET" action="{{ route('admin.videos.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari video..." class="px-3 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                <select name="status" class="px-2 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="">Semua</option>
                    <option value="Tayang" {{ $status === 'Tayang' ? 'selected' : '' }}>Tayang</option>
                    <option value="Draft" {{ $status === 'Draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-gray-900 dark:bg-zinc-700 text-white rounded-lg text-xs font-bold">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 w-16">Preview</th>
                        <th class="px-4 py-3">Judul Video</th>
                        <th class="px-4 py-3 text-center">Durasi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Ditonton</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($videos as $vid)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3">
                                <div class="w-14 h-9 bg-gray-900 rounded overflow-hidden relative group shrink-0">
                                    @if($vid->youtube_id)
                                        <img src="https://img.youtube.com/vi/{{ $vid->youtube_id }}/mqdefault.jpg" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[8px] text-gray-400">Video</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">
                                <a href="{{ route('video.show', $vid->slug) }}" target="_blank" class="hover:text-[#008a24] line-clamp-2">
                                    {{ $vid->judul }}
                                </a>
                                <a href="{{ $vid->link }}" target="_blank" class="text-[10px] text-blue-500 hover:underline flex items-center gap-1 mt-0.5">
                                    Buka link video &rarr;
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center font-mono text-gray-500">
                                {{ $vid->durasi ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($vid->status === 'Tayang')
                                    <span class="badge-status-ok">Tayang</span>
                                @else
                                    <span class="badge-status-no">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">
                                {{ number_format($vid->ditonton) }}
                            </td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                {{ $vid->tanggal ? $vid->tanggal->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openEditVideoModal({{ $vid->id }}, '{{ addslashes($vid->judul) }}', '{{ addslashes($vid->link) }}', '{{ $vid->durasi }}', '{{ $vid->tanggal ? $vid->tanggal->format('Y-m-d\TH:i') : '' }}', '{{ $vid->status }}')" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Video">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.videos.destroy', $vid) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Video">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada video terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                {{ $videos->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Edit Video Modal -->
<div id="editVideoModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Video</h3>
            <button onclick="closeEditVideoModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editVideoForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Video</label>
                <input type="text" id="editVidJudul" name="judul" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">URL YouTube / Video</label>
                <input type="url" id="editVidLink" name="link" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white font-mono focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Durasi</label>
                    <input type="text" id="editVidDurasi" name="durasi" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="editVidStatus" name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                        <option value="Tayang">Tayang</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                <input type="datetime-local" id="editVidTanggal" name="tanggal" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditVideoModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditVideoModal(id, judul, link, durasi, tanggal, status) {
        const modal = document.getElementById('editVideoModal');
        const form = document.getElementById('editVideoForm');
        form.action = `/admin/videos/${id}`;
        document.getElementById('editVidJudul').value = judul;
        document.getElementById('editVidLink').value = link;
        document.getElementById('editVidDurasi').value = durasi || '';
        document.getElementById('editVidTanggal').value = tanggal;
        document.getElementById('editVidStatus').value = status;
        modal.classList.remove('hidden');
    }

    function closeEditVideoModal() {
        document.getElementById('editVideoModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
