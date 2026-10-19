<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\Paslon;
use App\Models\Pilbup;
use App\Models\SuaraPilbup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRealCountController extends Controller
{
    /**
     * Tab "Tabulasi Suara": input perolehan suara per TPS/desa untuk pilbup
     * yang sedang dipilih. Bisa dicari dan dipaginasi karena jumlah
     * desa/kelurahan pada satu pilbup bisa sangat banyak.
     */
    public function index(Request $request): View
    {
        $pilbup = $this->pilbupTerpilih($request);
        $cari = trim((string) $request->query('cari', ''));

        $paslons = $pilbup ? $this->paslonPilbup($pilbup) : collect();

        $dptQuery = $pilbup ? Dpt::where('pilbup_id', $pilbup->id) : Dpt::whereRaw('1 = 0');

        if ($cari !== '') {
            $dptQuery->where(function ($q) use ($cari) {
                $q->where('kecamatan', 'ilike', "%{$cari}%")
                    ->orWhere('desa', 'ilike', "%{$cari}%");
            });
        }

        $dpts = $dptQuery->orderBy('kecamatan')->orderBy('desa')->paginate(15)->withQueryString();

        $suaraPerDpt = SuaraPilbup::whereIn('dpt_id', $dpts->pluck('id'))->get()->groupBy('dpt_id');

        return view('admin.realcount.index', [
            'tab' => 'suara',
            'pilbups' => Pilbup::orderByDesc('tahun')->get(),
            'pilbup' => $pilbup,
            'paslons' => $paslons,
            'dpts' => $dpts,
            'suaraPerDpt' => $suaraPerDpt,
            'cari' => $cari,
        ]);
    }

    public function calon(Request $request): View
    {
        $pilbup = $this->pilbupTerpilih($request);

        return view('admin.realcount.calon', [
            'tab' => 'calon',
            'pilbups' => Pilbup::orderByDesc('tahun')->get(),
            'pilbup' => $pilbup,
            'paslons' => $pilbup ? $this->paslonPilbup($pilbup) : collect(),
        ]);
    }

    public function wilayah(Request $request): View
    {
        $pilbup = $this->pilbupTerpilih($request);
        $cari = trim((string) $request->query('cari', ''));

        $dptQuery = $pilbup ? Dpt::where('pilbup_id', $pilbup->id) : Dpt::whereRaw('1 = 0');

        if ($cari !== '') {
            $dptQuery->where(function ($q) use ($cari) {
                $q->where('kecamatan', 'ilike', "%{$cari}%")
                    ->orWhere('desa', 'ilike', "%{$cari}%");
            });
        }

        $dpts = $dptQuery->orderBy('kecamatan')->orderBy('desa')->paginate(15)->withQueryString();

        $totalWilayah = $pilbup ? Dpt::where('pilbup_id', $pilbup->id)
            ->selectRaw('sum(tps) tps, sum(dpt) dpt, sum(dpph) dpph, sum(dptb) dptb, sum(ts) ts')
            ->first() : null;

        return view('admin.realcount.wilayah', [
            'tab' => 'wilayah',
            'pilbups' => Pilbup::orderByDesc('tahun')->get(),
            'pilbup' => $pilbup,
            'dpts' => $dpts,
            'cari' => $cari,
            'totalWilayah' => $totalWilayah,
        ]);
    }

    public function pengaturan(Request $request): View
    {
        return view('admin.realcount.pengaturan', [
            'tab' => 'pengaturan',
            'pilbup' => $this->pilbupTerpilih($request),
            'pilbups' => Pilbup::withCount(['paslons', 'dpts'])->orderByDesc('tahun')->get(),
        ]);
    }

    /**
     * Tab "Rekapitulasi": ringkasan hasil — persentase tiap paslon, progres
     * data yang sudah masuk, dan rincian per kecamatan. Dipakai juga sebagai
     * halaman cetak hasil sementara.
     */
    public function rekap(Request $request): View
    {
        $pilbup = $this->pilbupTerpilih($request);

        $kosong = [
            'tab' => 'rekap',
            'pilbups' => Pilbup::orderByDesc('tahun')->get(),
            'pilbup' => $pilbup,
            'paslons' => collect(),
            'totalTps' => 0,
            'tpsMasuk' => 0,
            'totalSuaraSah' => 0,
            'rekapPaslon' => [],
            'rekapKecamatan' => [],
        ];

        if (! $pilbup) {
            return view('admin.realcount.rekap', $kosong);
        }

        $paslons = $this->paslonPilbup($pilbup);
        $dpts = Dpt::where('pilbup_id', $pilbup->id)->get();
        $suara = SuaraPilbup::whereIn('dpt_id', $dpts->pluck('id'))->get()->groupBy('dpt_id');

        $suaraDesa = fn ($d, $paslonId) => (int) ($suara->get($d->id, collect())->firstWhere('paslon_id', $paslonId)->suara ?? 0);

        $rekapPaslon = $paslons->map(fn ($p) => [
            'paslon' => $p,
            'suara' => $dpts->sum(fn ($d) => $suaraDesa($d, $p->id)),
        ]);

        $totalSuaraSah = $rekapPaslon->sum('suara');
        $totalTps = (int) $dpts->sum('tps');

        // TPS dianggap "masuk" kalau desanya sudah punya suara tercatat (>0) untuk salah satu paslon.
        $tpsMasuk = (int) $dpts->filter(fn ($d) => $paslons->contains(fn ($p) => $suaraDesa($d, $p->id) > 0))->sum('tps');

        $rekapKecamatan = $dpts->groupBy('kecamatan')->map(function ($kecDpts, $kecamatan) use ($paslons, $suaraDesa) {
            $perPaslon = $paslons->mapWithKeys(fn ($p) => [$p->id => $kecDpts->sum(fn ($d) => $suaraDesa($d, $p->id))]);

            return [
                'kecamatan' => $kecamatan,
                'tps' => (int) $kecDpts->sum('tps'),
                'per_paslon' => $perPaslon,
                'total' => $perPaslon->sum(),
            ];
        })->values();

        return view('admin.realcount.rekap', [
            'tab' => 'rekap',
            'pilbups' => Pilbup::orderByDesc('tahun')->get(),
            'pilbup' => $pilbup,
            'paslons' => $paslons,
            'totalTps' => $totalTps,
            'tpsMasuk' => $tpsMasuk,
            'totalSuaraSah' => $totalSuaraSah,
            'rekapPaslon' => $rekapPaslon,
            'rekapKecamatan' => $rekapKecamatan,
        ]);
    }

    public function updateSuara(Request $request)
    {
        $request->validate([
            'dpt_id' => 'required|exists:dpts,id',
            'paslon_id' => 'required|exists:paslons,id',
            'suara' => 'required|integer|min:0',
        ]);

        SuaraPilbup::updateOrCreate(
            ['dpt_id' => $request->dpt_id, 'paslon_id' => $request->paslon_id],
            ['suara' => $request->suara]
        );

        $totalDesa = SuaraPilbup::where('dpt_id', $request->dpt_id)->sum('suara');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'total' => $totalDesa]);
        }

        return back()->with('success', 'Suara berhasil disimpan!');
    }

    // ----- CRUD Pilbup (Pengaturan Pemilihan) -----

    public function storePilbup(Request $request): RedirectResponse
    {
        $data = $this->validasiPilbup($request);
        Pilbup::create($data);

        return back()->with('success', 'Data pemilihan berhasil ditambahkan!');
    }

    public function updatePilbup(Request $request, Pilbup $pilbup): RedirectResponse
    {
        $pilbup->update($this->validasiPilbup($request));

        return back()->with('success', 'Data pemilihan berhasil diperbarui!');
    }

    public function destroyPilbup(Pilbup $pilbup): RedirectResponse
    {
        $pilbup->delete();

        return back()->with('success', 'Data pemilihan beserta seluruh calon, wilayah, dan suaranya berhasil dihapus!');
    }

    // ----- CRUD Paslon (Calon) -----

    public function storePaslon(Request $request): RedirectResponse
    {
        $data = $this->validasiPaslon($request);
        Paslon::create($data);

        return back()->with('success', 'Pasangan calon berhasil ditambahkan!');
    }

    public function updatePaslon(Request $request, Paslon $paslon): RedirectResponse
    {
        $paslon->update($this->validasiPaslon($request));

        return back()->with('success', 'Pasangan calon berhasil diperbarui!');
    }

    public function destroyPaslon(Paslon $paslon): RedirectResponse
    {
        $paslon->delete();

        return back()->with('success', 'Pasangan calon berhasil dihapus!');
    }

    // ----- CRUD Dpt (Data Wilayah) -----

    public function storeDpt(Request $request): RedirectResponse
    {
        $data = $this->validasiDpt($request);
        Dpt::create($data);

        return back()->with('success', 'Data wilayah berhasil ditambahkan!');
    }

    public function updateDpt(Request $request, Dpt $dpt): RedirectResponse
    {
        $dpt->update($this->validasiDpt($request));

        return back()->with('success', 'Data wilayah berhasil diperbarui!');
    }

    public function destroyDpt(Dpt $dpt): RedirectResponse
    {
        $dpt->delete();

        return back()->with('success', 'Data wilayah berhasil dihapus!');
    }

    // ----- Pembantu internal -----

    /**
     * Pilbup yang sedang aktif dikelola di CMS: dari query string kalau ada,
     * jatuh ke status "Aktif", lalu yang paling baru sebagai cadangan terakhir.
     */
    private function pilbupTerpilih(Request $request): ?Pilbup
    {
        $id = $request->query('pilbup_id');

        if ($id) {
            return Pilbup::find($id);
        }

        return Pilbup::where('status', 'Aktif')->first() ?? Pilbup::orderByDesc('tahun')->first();
    }

    private function paslonPilbup(Pilbup $pilbup)
    {
        return Paslon::where('pilbup_id', $pilbup->id)->orderBy('no_urut')->get();
    }

    private function validasiPilbup(Request $request): array
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        // Hanya boleh ada satu pemilihan berstatus Aktif pada satu waktu.
        if ($data['status'] === 'Aktif') {
            Pilbup::where('status', 'Aktif')->update(['status' => 'Selesai']);
        }

        return $data;
    }

    private function validasiPaslon(Request $request): array
    {
        return $request->validate([
            'pilbup_id' => 'required|exists:pilbups,id',
            'no_urut' => 'required|integer|min:1',
            'nama' => 'required|string|max:255',
            'usungan' => 'nullable|string|max:255',
            'warna' => 'required|string|max:20',
        ]);
    }

    private function validasiDpt(Request $request): array
    {
        return $request->validate([
            'pilbup_id' => 'required|exists:pilbups,id',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'tps' => 'required|integer|min:0',
            'dpt' => 'required|integer|min:0',
            'dpph' => 'required|integer|min:0',
            'dptb' => 'required|integer|min:0',
            'ts' => 'required|integer|min:0',
        ]);
    }
}
