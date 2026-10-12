@extends('layouts.admin')

@section('title', 'Real Count Pilbup')

@section('content')
<div class="space-y-5">

    @include('admin.realcount._header')

    @if(!$pilbup)
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Belum ada data pemilihan. Buat dulu di tab <strong>Pengaturan Pemilihan</strong>.
        </div>
    @elseif($paslons->isEmpty())
        <div class="bg-white dark:bg-[#121914] p-10 rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm text-center text-sm text-gray-400">
            Tambahkan pasangan calon dulu di tab <strong>Pasangan Calon</strong> sebelum menginput suara.
        </div>
    @else
        <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-200 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Tabulasi Perolehan Suara per Wilayah</h3>
                    <p class="text-xs text-gray-400">Angka tersimpan otomatis begitu kolom suara selesai diisi</p>
                </div>

                <form method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="pilbup_id" value="{{ $pilbup->id }}">
                    <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari kecamatan atau desa..." class="text-xs px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-1 focus:ring-[#008a24] w-56">
                    <button type="submit" class="px-3 py-2 bg-gray-900 dark:bg-zinc-700 hover:bg-black text-white text-xs font-bold rounded-lg transition-colors">Cari</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-gray-50 dark:bg-zinc-800/60 text-gray-500 font-bold border-b border-gray-200 dark:border-zinc-800 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center w-10">No</th>
                            <th class="px-4 py-3">Kecamatan</th>
                            <th class="px-4 py-3">Desa / Kelurahan</th>
                            <th class="px-4 py-3 text-center">TPS</th>
                            @foreach($paslons as $p)
                                <th class="px-4 py-3 text-center" style="color: {{ $p->warna }}">
                                    <span class="inline-block w-2 h-2 rounded-full align-middle mr-1" style="background: {{ $p->warna }}"></span>
                                    {{ $p->no_urut }}. {{ Str::limit($p->nama, 18) }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3 text-center">Suara Sah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800" id="tabelSuaraBody">
                        @forelse($dpts as $idx => $d)
                            @php $suaraDesa = $suaraPerDpt->get($d->id, collect()); @endphp
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors" data-dpt="{{ $d->id }}">
                                <td class="px-4 py-3 text-center text-gray-400">{{ $dpts->firstItem() + $idx }}</td>
                                <td class="px-4 py-3 font-bold text-gray-900 dark:text-white">{{ $d->kecamatan }}</td>
                                <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">{{ $d->desa }}</td>
                                <td class="px-4 py-3 text-center font-bold text-gray-500">{{ number_format($d->tps) }}</td>

                                @foreach($paslons as $p)
                                    @php $nilai = (int) ($suaraDesa->firstWhere('paslon_id', $p->id)->suara ?? 0); @endphp
                                    <td class="px-3 py-2 text-center">
                                        <input type="number" min="0" value="{{ $nilai }}"
                                            class="input-suara w-20 px-2 py-1.5 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded text-center text-xs font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-[#008a24]"
                                            data-dpt="{{ $d->id }}" data-paslon="{{ $p->id }}"
                                            aria-label="Suara {{ $p->nama }} di {{ $d->desa }}">
                                    </td>
                                @endforeach

                                <td class="px-4 py-3 text-center font-black text-gray-900 dark:text-white total-suara">
                                    {{ number_format($suaraDesa->sum('suara')) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 5 + $paslons->count() }}" class="px-4 py-8 text-center text-gray-400">
                                    {{ $cari ? 'Tidak ada wilayah yang cocok dengan pencarian.' : 'Belum ada data wilayah. Tambahkan di tab Data Wilayah.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($dpts->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
                    {{ $dpts->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Suara disimpan otomatis lewat AJAX begitu admin meninggalkan kolom input (blur),
    // tanpa reload halaman — supaya input ratusan desa tetap cepat dan nyaman dipakai.
    document.getElementById('tabelSuaraBody')?.addEventListener('change', function (event) {
        const input = event.target.closest('.input-suara');
        if (!input) {
            return;
        }

        const nilai = Math.max(0, parseInt(input.value, 10) || 0);
        input.value = nilai;

        fetch('{{ route('admin.realcount.updateSuara') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                dpt_id: input.dataset.dpt,
                paslon_id: input.dataset.paslon,
                suara: nilai,
            }),
        })
            .then((res) => res.json())
            .then((hasil) => {
                if (!hasil.success) {
                    return;
                }
                const baris = input.closest('tr');
                baris.querySelector('.total-suara').textContent = new Intl.NumberFormat('id-ID').format(hasil.total);
            })
            .catch(() => alert('Gagal menyimpan suara. Periksa koneksi lalu coba lagi.'));
    });
</script>
@endpush
