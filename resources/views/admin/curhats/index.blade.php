@extends('layouts.admin')

@section('title', 'Curhat Rakyat & Pengaduan Warga')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Search -->
    <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.curhats.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari pesan, nama pengirim, atau lokasi..." class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
            </div>

            <select name="status" class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24]">
                <option value="">Semua Status</option>
                <option value="Baru" {{ $status === 'Baru' ? 'selected' : '' }}>Baru Masuk</option>
                <option value="Tampil" {{ $status === 'Tampil' ? 'selected' : '' }}>Ditampilkan (Disetujui)</option>
                <option value="Disembunyikan" {{ $status === 'Disembunyikan' ? 'selected' : '' }}>Disembunyikan</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">
                Filter
            </button>
            @if($q || $status)
                <a href="{{ route('admin.curhats.index') }}" class="px-3 py-2 text-xs text-gray-500 hover:text-red-500 underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('curhat.index') }}" target="_blank" class="text-xs font-semibold text-[#008a24] hover:underline flex items-center gap-1 shrink-0">
            Halaman Curhat Publik &rarr;
        </a>
    </div>

    <!-- Curhat Grid Cards -->
    <div class="space-y-4">
        @forelse($curhats as $c)
            <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm p-5 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 dark:border-zinc-800 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950 text-[#008a24] font-bold text-xs flex items-center justify-center">
                            {{ substr($c->pengirim, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">{{ $c->pengirim }}</h4>
                            <div class="text-[10px] text-gray-400 flex items-center gap-2">
                                <span>Lokasi: {{ $c->lokasi ?: 'Indramayu' }}</span>
                                @if($c->kontak)
                                    <span>· Kontak: {{ $c->kontak }}</span>
                                @endif
                                <span>· {{ $c->created_at ? $c->created_at->diffForHumans() : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($c->status === 'Baru')
                            <span class="badge-status-wt">Baru Masuk</span>
                        @elseif($c->status === 'Tampil')
                            <span class="badge-status-ok">Tampil di Portal</span>
                        @else
                            <span class="badge-status-no">Disembunyikan</span>
                        @endif
                    </div>
                </div>

                <div class="text-xs text-gray-800 dark:text-gray-200 leading-relaxed bg-gray-50 dark:bg-zinc-900/60 p-3 rounded-lg border border-gray-100 dark:border-zinc-800">
                    "{{ $c->pesan }}"
                </div>

                <!-- Moderation Controls -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Ubah Status:</span>
                        
                        @if($c->status !== 'Tampil')
                            <form action="{{ route('admin.curhats.updateStatus', $c) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Tampil">
                                <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-[11px] font-semibold transition-colors">
                                    Setujui & Tampilkan
                                </button>
                            </form>
                        @endif

                        @if($c->status !== 'Disembunyikan')
                            <form action="{{ route('admin.curhats.updateStatus', $c) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Disembunyikan">
                                <button type="submit" class="px-2.5 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-[11px] font-semibold transition-colors">
                                    Sembunyikan
                                </button>
                            </form>
                        @endif
                    </div>

                    <form action="{{ route('admin.curhats.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus keluhan aspirasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-[#121914] p-8 rounded-xl border border-gray-200 dark:border-zinc-800 text-center text-gray-400 text-xs">
                Tidak ada aspirasi / curhat warga ditemukan.
            </div>
        @endforelse

        @if($curhats->hasPages())
            <div class="p-4 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800">
                {{ $curhats->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
