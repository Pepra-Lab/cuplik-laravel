@extends('layouts.admin')

@section('title', 'Newsletter')

@section('content')
<div class="space-y-5">

    @include('admin.settings._tabs')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Pengaturan Newsletter (1 Col) -->
        <div class="bg-white dark:bg-[#121914] p-5 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm h-fit space-y-4">
            <div>
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Pengaturan Newsletter</h2>
                <p class="text-xs text-gray-400">Kontrol form langganan di frontend</p>
            </div>

            <form action="{{ route('admin.settings.newsletter.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <label class="flex items-center justify-between gap-3 px-3 py-2.5 bg-gray-50 dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-zinc-700">
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Form Langganan Aktif</span>
                    <input type="checkbox" name="newsletter_aktif" value="1" {{ $setting->newsletter_aktif ? 'checked' : '' }} class="w-4 h-4 accent-[#008a24]">
                </label>

                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Subjek Default Broadcast</label>
                    <input type="text" name="newsletter_subjek_default" value="{{ old('newsletter_subjek_default', $setting->newsletter_subjek_default) }}" placeholder="Update Terbaru dari Cuplik.com" class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>

                <button type="submit" class="w-full py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Pengaturan
                </button>
            </form>

            <a href="{{ route('admin.newsletter.export') }}" class="block text-center w-full py-2 bg-gray-100 dark:bg-zinc-800 hover:bg-gray-200 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-200 font-bold text-xs rounded-lg transition-colors">
                Ekspor CSV Subscriber
            </a>
        </div>

        <!-- Tabel Subscriber (2 Cols) -->
        <div class="lg:col-span-2 bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between gap-3 flex-wrap">
                <div>
                    <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Daftar Subscriber</h2>
                    <span class="text-xs text-gray-400 font-semibold">{{ $subscribers->total() }} Email Terdaftar</span>
                </div>
                <form action="{{ route('admin.newsletter.index') }}" method="GET">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari email..." class="px-3 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none">
                </form>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Tanggal Berlangganan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                        @forelse($subscribers as $s)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $s->email }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ optional($s->tanggal)->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <form action="{{ route('admin.newsletter.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus subscriber ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-xs font-semibold text-red-500 hover:text-red-700 bg-gray-50 dark:bg-zinc-800 rounded border border-gray-200 dark:border-zinc-700">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-400">Belum ada subscriber newsletter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscribers->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                    {{ $subscribers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
