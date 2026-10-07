@extends('layouts.admin')

@section('title', 'Moderasi Iklan Baris')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Search -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.iklan-baris.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <select name="status" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ $status === 'Menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui (Tayang)</option>
                <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                Filter
            </button>
            @if($status)
                <a href="{{ route('admin.iklan-baris.index') }}" class="px-3 py-2 text-xs text-gray-500 hover:text-red-500 underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('info.iklan') }}" target="_blank" class="text-xs font-semibold text-[#008a24] hover:underline flex items-center gap-1 shrink-0">
            Halaman Pasang Iklan Baris &rarr;
        </a>
    </div>

    <!-- Iklan Baris List Table -->
    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3.5">Kategori</th>
                        <th class="px-4 py-3.5">Judul & Isi Iklan</th>
                        <th class="px-4 py-3.5">Kontak Pengiklan</th>
                        <th class="px-4 py-3.5 text-center">Status</th>
                        <th class="px-4 py-3.5">Tanggal</th>
                        <th class="px-4 py-3.5 text-right">Aksi Moderasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($iklans as $ik)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                    {{ $ik->kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="max-w-md">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $ik->judul }}</div>
                                    <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $ik->konten }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono font-bold text-gray-700 dark:text-gray-300">
                                {{ $ik->kontak }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($ik->status === 'Disetujui')
                                    <span class="badge-status-ok">Disetujui</span>
                                @elseif($ik->status === 'Menunggu')
                                    <span class="badge-status-wt">Menunggu</span>
                                @else
                                    <span class="badge-status-no">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                {{ $ik->tanggal ? $ik->tanggal->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($ik->status !== 'Disetujui')
                                        <form action="{{ route('admin.iklan-baris.updateStatus', $ik) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-[10px] font-bold" title="Setujui">
                                                Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if($ik->status !== 'Ditolak')
                                        <form action="{{ route('admin.iklan-baris.updateStatus', $ik) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" class="px-2 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-[10px] font-bold" title="Tolak">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.iklan-baris.destroy', $ik) }}" method="POST" onsubmit="return confirm('Hapus iklan baris ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada iklan baris terdaftar.</td>
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
@endsection
