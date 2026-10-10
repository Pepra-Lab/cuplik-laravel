@extends('layouts.admin')

@section('title', 'Kelola Polling Publik')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Form Tambah Polling (1 Col) -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Buat Polling Baru</h2>
            <p class="text-xs text-gray-400">Jajak pendapat interaktif untuk pembaca portal</p>
        </div>

        <form action="{{ route('admin.polls.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pertanyaan Polling <span class="text-red-500">*</span></label>
                <textarea name="pertanyaan" rows="3" required placeholder="Contoh: Menurut Anda, apakah pembangunan infrastruktur di daerah sudah optimal?" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]"></textarea>
                @error('pertanyaan') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pilihan Jawaban <span class="text-red-500">*</span></label>

                <div id="pollOptionList" class="space-y-2">
                    @php $oldOpsi = old('opsi', ['', '']); @endphp
                    @foreach($oldOpsi as $i => $value)
                        <div class="flex items-center gap-2 poll-option-row">
                            <input type="text" name="opsi[]" value="{{ $value }}" placeholder="Pilihan jawaban {{ $i + 1 }}" class="flex-1 px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                            <button type="button" onclick="removePollOption(this)" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-400 hover:text-red-500 hover:border-red-300 transition-colors" title="Hapus pilihan">
                                &minus;
                            </button>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="addPollOption()" class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-[#008a24] hover:text-[#006f1c]">
                    <span class="w-5 h-5 flex items-center justify-center rounded-full border border-[#008a24] leading-none">+</span>
                    Tambah Pilihan
                </button>

                <span class="text-[10px] text-gray-400 block mt-1">Minimal 2 pilihan jawaban.</span>
                @error('opsi') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status Publikasi</label>
                <select name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="Aktif">Aktif (Tampilkan di Beranda & Polling Page)</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm flex items-center justify-center">
                Publikasikan Polling
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Polling (2 Cols) -->
    <div class="lg:col-span-2 space-y-4">
        @forelse($polls as $poll)
            @php
                $totalVotes = $poll->options->sum('suara');
            @endphp
            <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm p-5 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            @if($poll->status === 'Aktif')
                                <span class="badge-status-ok">Sedang Aktif</span>
                            @else
                                <span class="badge-status-no">Nonaktif</span>
                            @endif
                            <span class="text-[11px] text-gray-400">Total: {{ number_format($totalVotes) }} Suara Masuk</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $poll->pertanyaan }}</h3>
                    </div>

                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="openEditPollModal({{ $poll->id }}, '{{ addslashes($poll->pertanyaan) }}', '{{ $poll->status }}')" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-[#008a24] bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Edit Polling">
                            Edit
                        </button>
                        <form action="{{ route('admin.polls.destroy', $poll) }}" method="POST" onsubmit="return confirm('Hapus polling ini beserta semua pilihan dan suaranya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus Polling">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Options List with Progress -->
                <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-zinc-800">
                    @foreach($poll->options as $opt)
                        @php
                            $percentage = $totalVotes > 0 ? round(($opt->suara / $totalVotes) * 100, 1) : 0;
                        @endphp
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $opt->opsi }}</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $percentage }}% <span class="font-normal text-gray-400 text-[10px]">({{ $opt->suara }} suara)</span></span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-[#008a24] h-full rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-[#121914] p-8 rounded-xl border border-gray-200 dark:border-zinc-800 text-center text-gray-400 text-xs">
                Belum ada polling yang dibuat.
            </div>
        @endforelse

        @if($polls->hasPages())
            <div>{{ $polls->links() }}</div>
        @endif
    </div>

</div>

<!-- Edit Poll Modal -->
<div id="editPollModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-xl max-w-md w-full p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-zinc-800 pb-3">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Edit Pertanyaan Polling</h3>
            <button onclick="closeEditPollModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>

        <form id="editPollForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Pertanyaan Polling</label>
                <textarea id="editPollPertanyaan" name="pertanyaan" rows="3" required class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="editPollStatus" name="status" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditPollModal()" class="px-4 py-2 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white rounded-lg text-xs font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditPollModal(id, pertanyaan, status) {
        const modal = document.getElementById('editPollModal');
        const form = document.getElementById('editPollForm');
        form.action = `/admin/polls/${id}`;
        document.getElementById('editPollPertanyaan').value = pertanyaan;
        document.getElementById('editPollStatus').value = status;
        modal.classList.remove('hidden');
    }

    function closeEditPollModal() {
        document.getElementById('editPollModal').classList.add('hidden');
    }

    function addPollOption() {
        const list = document.getElementById('pollOptionList');
        const count = list.querySelectorAll('.poll-option-row').length + 1;

        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 poll-option-row';
        row.innerHTML = `
            <input type="text" name="opsi[]" placeholder="Pilihan jawaban ${count}" class="flex-1 px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            <button type="button" onclick="removePollOption(this)" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg border border-gray-200 dark:border-zinc-700 text-gray-400 hover:text-red-500 hover:border-red-300 transition-colors" title="Hapus pilihan">
                &minus;
            </button>
        `;

        list.appendChild(row);
        row.querySelector('input').focus();
    }

    function removePollOption(button) {
        const list = document.getElementById('pollOptionList');

        // Minimal 2 baris input tetap tersedia di form.
        if (list.querySelectorAll('.poll-option-row').length <= 2) {
            return;
        }

        button.closest('.poll-option-row').remove();
    }
</script>
@endpush
@endsection
