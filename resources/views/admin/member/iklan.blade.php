@extends('layouts.admin')

@section('title', 'Iklan Saya')

@php
    $inputClass = 'w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]';
    $labelClass = 'block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1';
    $badgeClass = [
        'Menunggu' => 'badge-status-wt',
        'Tayang' => 'badge-status-ok',
        'Disetujui' => 'badge-status-ok',
        'Ditolak' => 'badge-status-no',
        'Berakhir' => 'badge-status-wt',
        'Nonaktif' => 'badge-status-no',
    ];
@endphp

@section('content')
<div class="space-y-5">

    <div>
        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white">Iklan Saya</h2>
        <p class="text-xs text-gray-400">Iklan yang Anda kirim akan tayang setelah divalidasi admin.</p>
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 border-b border-gray-200 dark:border-zinc-800">
        @foreach(['gambar' => 'Iklan Gambar', 'teks' => 'Iklan Teks'] as $key => $label)
            <a href="{{ route('admin.iklan-saya.index', ['tab' => $key]) }}"
               class="px-4 py-2.5 text-xs font-bold border-b-2 -mb-px transition-colors {{ $tab === $key ? 'border-[#008a24] text-[#008a24]' : 'border-transparent text-gray-500 hover:text-gray-900 dark:hover:text-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit">
            @if($errors->any())
                <div class="mb-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-3 rounded-lg text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if($tab === 'gambar')
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white mb-4">Kirim Iklan Gambar</h3>

                <form action="{{ route('admin.iklan-saya.gambar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="{{ $labelClass }}">Judul Iklan</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Posisi</label>
                        <select name="posisi" required class="{{ $inputClass }}">
                            @foreach($posisis as $posisi)
                                <option value="{{ $posisi->nama }}" @selected(old('posisi') === $posisi->nama)>
                                    {{ $posisi->nama }}{{ $posisi->ukuran ? " ({$posisi->ukuran})" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Gambar (maks. 2 MB)</label>
                        <input type="file" name="gambar" accept="image/*" required class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Link Tujuan (opsional)</label>
                        <input type="url" name="link" value="{{ old('link') }}" placeholder="https://" class="{{ $inputClass }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelClass }}">Mulai</label>
                            <input type="date" name="mulai" value="{{ old('mulai', now()->toDateString()) }}" required class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Selesai</label>
                            <input type="date" name="selesai" value="{{ old('selesai', now()->addDays(30)->toDateString()) }}" required class="{{ $inputClass }}">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                        Kirim untuk Divalidasi
                    </button>
                </form>
            @else
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white mb-4">Kirim Iklan Teks</h3>

                <form action="{{ route('admin.iklan-saya.baris.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="{{ $labelClass }}">Kategori</label>
                        <select name="kategori" required class="{{ $inputClass }}">
                            @foreach($kategoriTeks as $kategori)
                                <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Isi Iklan</label>
                        <textarea name="isi" rows="5" required minlength="10" maxlength="500" class="{{ $inputClass }}">{{ old('isi') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                        Kirim untuk Divalidasi
                    </button>
                </form>
            @endif
        </div>

        <!-- Daftar iklan milik member -->
        <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            @if($tab === 'gambar')
                                <th class="px-4 py-3 w-16">Gambar</th>
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Posisi</th>
                                <th class="px-4 py-3">Periode</th>
                            @else
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Isi</th>
                                <th class="px-4 py-3">Tanggal</th>
                            @endif
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($iklans as $iklan)
                            <tr>
                                @if($tab === 'gambar')
                                    <td class="px-4 py-3">
                                        <img src="{{ asset($iklan->gambar) }}" alt="" class="w-12 h-8 rounded object-cover border border-gray-200 dark:border-zinc-700">
                                    </td>
                                    <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $iklan->judul }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $iklan->posisi }}</td>
                                    <td class="px-4 py-3 text-gray-400 whitespace-nowrap">
                                        {{ $iklan->mulai?->format('d/m/y') }} s/d {{ $iklan->selesai?->format('d/m/y') }}
                                    </td>
                                @else
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $iklan->kategori }}</td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white max-w-sm">{{ $iklan->isi }}</td>
                                    <td class="px-4 py-3 text-gray-400 whitespace-nowrap">{{ $iklan->tanggal?->format('d/m/Y') }}</td>
                                @endif
                                <td class="px-4 py-3 text-center">
                                    <span class="{{ $badgeClass[$iklan->status] ?? 'badge-status-wt' }}">{{ $iklan->status }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($iklan->status === 'Menunggu')
                                        <form action="{{ route($tab === 'gambar' ? 'admin.iklan-saya.gambar.destroy' : 'admin.iklan-saya.baris.destroy', $iklan) }}" method="POST" onsubmit="return confirm('Batalkan iklan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">Batalkan</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab === 'gambar' ? 6 : 5 }}" class="px-4 py-8 text-center text-gray-400">Belum ada iklan yang Anda kirim.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($iklans->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-zinc-800">{{ $iklans->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
